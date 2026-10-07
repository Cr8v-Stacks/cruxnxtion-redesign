<?php
/**
 * Stripe webhook listener: raw-body signature validation, atomic idempotency, state transitions.
 *
 * Rules this file follows:
 * - Never trust the browser redirect: orders are completed only from signed webhook events.
 * - The signature is checked against the raw request body, with a timestamp tolerance and a
 *   constant-time comparison.
 * - Idempotency: an event ID is claimed with a UNIQUE insert before processing. If processing
 *   fails, the claim is removed and a 5xx is returned so Stripe retries. A claim is never kept
 *   for an event that was not fully processed.
 * - A session is only fulfilled when Stripe says it is paid and the amount and currency match
 *   the order we stored.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register REST API route for Stripe Webhooks.
 */
function cr8v_tix_register_webhook_rest_route() {
	register_rest_route(
		'cr8v-ticketing/v1',
		'/stripe-webhook',
		array(
			'methods'             => 'POST',
			'callback'            => 'cr8v_tix_handle_stripe_webhook',
			'permission_callback' => '__return_true', // Authenticated by the Stripe-Signature HMAC.
		)
	);
}
add_action( 'rest_api_init', 'cr8v_tix_register_webhook_rest_route' );

/**
 * Verify Stripe webhook signature header.
 *
 * @param string $raw_body   Raw body payload.
 * @param string $sig_header Stripe-Signature header string.
 * @param string $secret     Webhook signing secret.
 * @param int    $tolerance  Time tolerance in seconds.
 * @param int    $now        Current Unix time (injectable for tests).
 * @return true|WP_Error
 */
function cr8v_tix_verify_stripe_signature( $raw_body, $sig_header, $secret, $tolerance = 300, $now = null ) {
	if ( empty( $sig_header ) || empty( $secret ) || '' === (string) $raw_body ) {
		return new WP_Error( 'missing_signature', 'Missing webhook signature, secret or body.' );
	}

	$timestamp  = null;
	$signatures = array();
	foreach ( explode( ',', (string) $sig_header ) as $item ) {
		$parts = explode( '=', trim( $item ), 2 );
		if ( 2 !== count( $parts ) ) {
			continue;
		}
		if ( 't' === $parts[0] ) {
			$timestamp = (int) $parts[1];
		} elseif ( 'v1' === $parts[0] ) {
			$signatures[] = $parts[1];
		}
	}

	if ( ! $timestamp || empty( $signatures ) ) {
		return new WP_Error( 'invalid_header', 'Malformed Stripe-Signature header.' );
	}

	$now = null === $now ? time() : (int) $now;
	if ( abs( $now - $timestamp ) > $tolerance ) {
		return new WP_Error( 'timestamp_out_of_tolerance', 'Webhook timestamp exceeds tolerance.' );
	}

	$expected = hash_hmac( 'sha256', $timestamp . '.' . $raw_body, $secret );
	foreach ( $signatures as $sig ) {
		if ( hash_equals( $expected, $sig ) ) {
			return true;
		}
	}

	return new WP_Error( 'signature_mismatch', 'Webhook signature mismatch.' );
}

/**
 * Find the order a Stripe object belongs to. The session ID stored on the order must match,
 * so a payload cannot be used to complete an unrelated order.
 *
 * @param array $obj Stripe checkout.session object.
 * @return int Order post ID, or 0.
 */
function cr8v_tix_find_order_for_session( $obj ) {
	$session_id = sanitize_text_field( $obj['id'] ?? '' );
	if ( '' === $session_id ) {
		return 0;
	}

	$order_id = absint( $obj['metadata']['order_id'] ?? 0 );
	if ( ! $order_id ) {
		$order_id = absint( $obj['client_reference_id'] ?? 0 );
	}

	if ( $order_id ) {
		$post = get_post( $order_id );
		if ( $post && 'event_order' === $post->post_type
			&& get_post_meta( $order_id, '_cr8v_order_stripe_session_id', true ) === $session_id ) {
			return $order_id;
		}
	}

	$found = get_posts(
		array(
			'post_type'      => 'event_order',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_cr8v_order_stripe_session_id',
			'meta_value'     => $session_id,
		)
	);
	return $found ? (int) $found[0] : 0;
}

/**
 * Find an order by Stripe payment intent.
 */
function cr8v_tix_find_order_for_payment_intent( $payment_intent ) {
	$payment_intent = sanitize_text_field( (string) $payment_intent );
	if ( '' === $payment_intent ) {
		return 0;
	}
	$found = get_posts(
		array(
			'post_type'      => 'event_order',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_cr8v_order_stripe_payment_intent',
			'meta_value'     => $payment_intent,
		)
	);
	return $found ? (int) $found[0] : 0;
}

/**
 * Fulfil a paid checkout session: verify it, mark the order completed, confirm the stock
 * hold and issue tickets. Runs at most once per order.
 */
function cr8v_tix_fulfil_paid_session( $obj ) {
	$order_id = cr8v_tix_find_order_for_session( $obj );
	if ( ! $order_id ) {
		error_log( '[cr8v-ticketing] Paid session ' . ( $obj['id'] ?? '?' ) . ' has no matching order.' );
		return;
	}

	$status = get_post_meta( $order_id, '_cr8v_order_status', true );
	if ( in_array( $status, array( 'completed', 'refunded', 'partially_refunded', 'disputed' ), true ) ) {
		return; // Already fulfilled.
	}

	// The amount and currency Stripe collected must match what we stored for this order.
	$expected = (int) get_post_meta( $order_id, '_cr8v_order_total_pence', true );
	$charged  = (int) ( $obj['amount_total'] ?? -1 );
	$currency = strtolower( (string) ( $obj['currency'] ?? '' ) );
	if ( $charged !== $expected || 'gbp' !== $currency ) {
		update_post_meta( $order_id, '_cr8v_order_status', 'needs_review' );
		update_post_meta( $order_id, '_cr8v_order_note', sprintf( 'Amount mismatch: expected %d GBP pence, Stripe reported %d %s.', $expected, $charged, strtoupper( $currency ) ) );
		error_log( "[cr8v-ticketing] Order {$order_id} amount mismatch (expected {$expected}, got {$charged} {$currency})." );
		return;
	}

	$pi = sanitize_text_field( (string) ( $obj['payment_intent'] ?? '' ) );
	if ( $pi ) {
		update_post_meta( $order_id, '_cr8v_order_stripe_payment_intent', $pi );
	}

	$confirmed = cr8v_tix_complete_reservation( sanitize_text_field( $obj['id'] ), $order_id );
	if ( 0 === $confirmed ) {
		// Paid, but no stock hold exists to confirm. Do not lose the sale: flag it for a human.
		update_post_meta( $order_id, '_cr8v_order_note', 'Paid, but the stock reservation was missing. Check capacity and refund if oversold.' );
		error_log( "[cr8v-ticketing] Order {$order_id} paid without a reservation row." );
	}

	update_post_meta( $order_id, '_cr8v_order_status', 'completed' );

	cr8v_tix_issue_tickets(
		$order_id,
		get_post_meta( $order_id, '_cr8v_order_items', true ),
		get_post_meta( $order_id, '_cr8v_order_customer_name', true )
	);

	do_action( 'cr8v_tix_order_completed', $order_id );
}

/**
 * Apply one verified Stripe event. Throws on a temporary failure so the caller can ask Stripe to retry.
 */
function cr8v_tix_process_stripe_event( $event_type, $obj ) {
	switch ( $event_type ) {
		case 'checkout.session.completed':
			if ( 'paid' === ( $obj['payment_status'] ?? '' ) ) {
				cr8v_tix_fulfil_paid_session( $obj );
			} else {
				// Delayed payment method: money has not arrived yet. Keep the hold, wait for async events.
				$order_id = cr8v_tix_find_order_for_session( $obj );
				if ( $order_id ) {
					update_post_meta( $order_id, '_cr8v_order_status', 'awaiting_payment' );
				}
			}
			break;

		case 'checkout.session.async_payment_succeeded':
			cr8v_tix_fulfil_paid_session( $obj );
			break;

		case 'checkout.session.expired':
		case 'checkout.session.async_payment_failed':
			$session_id = sanitize_text_field( $obj['id'] ?? '' );
			if ( $session_id ) {
				cr8v_tix_release_reservation( $session_id );
				$order_id = cr8v_tix_find_order_for_session( $obj );
				if ( $order_id && 'completed' !== get_post_meta( $order_id, '_cr8v_order_status', true ) ) {
					update_post_meta( $order_id, '_cr8v_order_status', 'checkout.session.expired' === $event_type ? 'cancelled' : 'failed' );
				}
			}
			break;

		case 'charge.refunded':
			$order_id = cr8v_tix_find_order_for_payment_intent( $obj['payment_intent'] ?? '' );
			if ( $order_id ) {
				$full = (int) ( $obj['amount_refunded'] ?? 0 ) >= (int) ( $obj['amount'] ?? PHP_INT_MAX );
				update_post_meta( $order_id, '_cr8v_order_status', $full ? 'refunded' : 'partially_refunded' );
				if ( $full ) {
					cr8v_tix_void_order_tickets( $order_id );
				}
			}
			break;

		case 'charge.dispute.created':
			$order_id = cr8v_tix_find_order_for_payment_intent( $obj['payment_intent'] ?? '' );
			if ( $order_id ) {
				update_post_meta( $order_id, '_cr8v_order_status', 'disputed' );
				cr8v_tix_void_order_tickets( $order_id );
			}
			break;
	}
}

/**
 * Main webhook handler.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function cr8v_tix_handle_stripe_webhook( WP_REST_Request $request ) {
	if ( ! defined( 'CRUX_STRIPE_WEBHOOK_SECRET' ) || '' === (string) CRUX_STRIPE_WEBHOOK_SECRET ) {
		return new WP_REST_Response( array( 'error' => 'Webhook secret not configured.' ), 500 );
	}

	$raw_body = $request->get_body();
	$verified = cr8v_tix_verify_stripe_signature( $raw_body, $request->get_header( 'stripe_signature' ), CRUX_STRIPE_WEBHOOK_SECRET, 300 );
	if ( is_wp_error( $verified ) ) {
		return new WP_REST_Response( array( 'error' => $verified->get_error_message() ), 400 );
	}

	$event = json_decode( $raw_body, true );
	if ( ! is_array( $event ) || empty( $event['id'] ) || empty( $event['type'] ) ) {
		return new WP_REST_Response( array( 'error' => 'Invalid JSON payload.' ), 400 );
	}

	$stripe_event_id = sanitize_text_field( $event['id'] );
	$event_type      = sanitize_text_field( $event['type'] );
	$obj             = is_array( $event['data']['object'] ?? null ) ? $event['data']['object'] : array();

	// Claim the event atomically. The UNIQUE key makes a concurrent duplicate fail the insert.
	global $wpdb;
	$table = cr8v_tix_webhooks_table();
	$wpdb->suppress_errors( true );
	$claimed = $wpdb->insert(
		$table,
		array(
			'stripe_event_id' => $stripe_event_id,
			'event_type'      => $event_type,
			'processed_at'    => current_time( 'mysql', true ),
			// Only the object ID. Never store the payload: it contains customer personal data.
			'payload_summary' => sanitize_text_field( $obj['id'] ?? '' ),
		)
	);
	$wpdb->suppress_errors( false );

	if ( ! $claimed ) {
		return new WP_REST_Response( array( 'status' => 'already_processed' ), 200 );
	}

	try {
		cr8v_tix_process_stripe_event( $event_type, $obj );
	} catch ( Throwable $e ) {
		// Release the claim so Stripe's retry is processed instead of being ignored.
		$wpdb->delete( $table, array( 'stripe_event_id' => $stripe_event_id ) );
		error_log( '[cr8v-ticketing] Webhook ' . $event_type . ' failed: ' . $e->getMessage() );
		return new WP_REST_Response( array( 'error' => 'Processing failed, please retry.' ), 500 );
	}

	return new WP_REST_Response( array( 'received' => true ), 200 );
}
