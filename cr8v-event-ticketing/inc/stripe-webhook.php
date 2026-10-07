<?php
/**
 * Stripe Webhook listener with raw-body signature validation, idempotency, and state transitions.
 *
 * Implements strict security:
 * - Raw request body HMAC-SHA256 signature verification
 * - 300-second timestamp tolerance check with constant-time hash_equals
 * - Database idempotency tracking to prevent double-charging or duplicate processing
 * - Stock release on expired checkout sessions
 * - Cryptographic ticket token generation on completed payments
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
			'permission_callback' => '__return_true', // Verified via HMAC header
		)
	);
}
add_action( 'rest_api_init', 'cr8v_tix_register_webhook_rest_route' );

/**
 * Verify Stripe webhook signature header.
 *
 * @param string $raw_body Raw body payload.
 * @param string $sig_header Stripe-Signature header string.
 * @param string $secret Webhook secret key.
 * @param int    $tolerance Time tolerance in seconds (default 300).
 * @return true|WP_Error
 */
function cr8v_tix_verify_stripe_signature( $raw_body, $sig_header, $secret, $tolerance = 300 ) {
	if ( empty( $sig_header ) || empty( $secret ) ) {
		return new WP_Error( 'missing_signature', __( 'Missing webhook signature or secret key.', 'cr8v-event-ticketing' ) );
	}

	$timestamp = null;
	$signatures = array();

	// Parse header e.g. "t=1492774577,v1=5257a869e7ecebeda32affa62cdca3fa51cad7e77a0e56ff536d0ce8e108d8bd"
	$items = explode( ',', $sig_header );
	foreach ( $items as $item ) {
		$parts = explode( '=', trim( $item ), 2 );
		if ( 2 === count( $parts ) ) {
			if ( 't' === $parts[0] ) {
				$timestamp = (int) $parts[1];
			} elseif ( 'v1' === $parts[0] ) {
				$signatures[] = $parts[1];
			}
		}
	}

	if ( ! $timestamp || empty( $signatures ) ) {
		return new WP_Error( 'invalid_header', __( 'Malformed Stripe-Signature header.', 'cr8v-event-ticketing' ) );
	}

	// Timestamp tolerance check
	if ( abs( time() - $timestamp ) > $tolerance ) {
		return new WP_Error( 'timestamp_out_of_tolerance', __( 'Webhook timestamp exceeds tolerance.', 'cr8v-event-ticketing' ) );
	}

	// Compute expected HMAC-SHA256 signature
	$signed_payload   = $timestamp . '.' . $raw_body;
	$expected_signature = hash_hmac( 'sha256', $signed_payload, $secret );

	$valid = false;
	foreach ( $signatures as $sig ) {
		if ( hash_equals( $expected_signature, $sig ) ) {
			$valid = true;
			break;
		}
	}

	if ( ! $valid ) {
		return new WP_Error( 'signature_mismatch', __( 'Webhook signature mismatch.', 'cr8v-event-ticketing' ) );
	}

	return true;
}

/**
 * Main Webhook Handler.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function cr8v_tix_handle_stripe_webhook( WP_REST_Request $request ) {
	$raw_body   = $request->get_body();
	$sig_header = $request->get_header( 'stripe_signature' );

	if ( ! defined( 'CRUX_STRIPE_WEBHOOK_SECRET' ) || empty( CRUX_STRIPE_WEBHOOK_SECRET ) ) {
		return new WP_REST_Response( array( 'error' => 'Webhook secret not configured in wp-config.php' ), 500 );
	}

	// 1. Signature Verification
	$verified = cr8v_tix_verify_stripe_signature( $raw_body, $sig_header, CRUX_STRIPE_WEBHOOK_SECRET, 300 );
	if ( is_wp_error( $verified ) ) {
		return new WP_REST_Response( array( 'error' => $verified->get_error_message() ), 400 );
	}

	$event = json_decode( $raw_body, true );
	if ( ! is_array( $event ) || empty( $event['id'] ) || empty( $event['type'] ) ) {
		return new WP_REST_Response( array( 'error' => 'Invalid JSON payload' ), 400 );
	}

	$stripe_event_id = sanitize_text_field( $event['id'] );
	$event_type      = sanitize_text_field( $event['type'] );

	// 2. Idempotency Check
	global $wpdb;
	$webhooks_table = cr8v_tix_webhooks_table();
	$already = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT id FROM {$webhooks_table} WHERE stripe_event_id = %s",
			$stripe_event_id
		)
	);

	if ( $already ) {
		// Event was already processed safely
		return new WP_REST_Response( array( 'status' => 'already_processed' ), 200 );
	}

	// Record in Idempotency Table
	$wpdb->insert(
		$webhooks_table,
		array(
			'stripe_event_id' => $stripe_event_id,
			'event_type'      => $event_type,
			'processed_at'    => current_time( 'mysql', true ),
			'payload_summary' => mb_substr( wp_json_encode( $event['data']['object'] ?? array() ), 0, 1000 ),
		)
	);

	$data_obj = $event['data']['object'] ?? array();

	// 3. Handle Event Types
	switch ( $event_type ) {
		case 'checkout.session.completed':
			$session_id = sanitize_text_field( $data_obj['id'] ?? '' );
			$order_id   = (int) ( $data_obj['metadata']['order_id'] ?? ( $data_obj['client_reference_id'] ?? 0 ) );
			$payment_pi = sanitize_text_field( $data_obj['payment_intent'] ?? '' );

			if ( ! $order_id && $session_id ) {
				// Query order by session_id meta
				$order_posts = get_posts(
					array(
						'post_type'      => 'event_order',
						'posts_per_page' => 1,
						'meta_key'       => '_cr8v_order_stripe_session_id',
						'meta_value'     => $session_id,
					)
				);
				if ( ! empty( $order_posts ) ) {
					$order_id = $order_posts[0]->ID;
				}
			}

			if ( $order_id ) {
				update_post_meta( $order_id, '_cr8v_order_status', 'completed' );
				if ( $payment_pi ) {
					update_post_meta( $order_id, '_cr8v_order_stripe_payment_intent', $payment_pi );
				}

				// Mark reservation as completed
				cr8v_tix_complete_reservation( $session_id, $order_id );

				// Generate individual cryptographic tickets if not already generated
				$existing_tickets = get_post_meta( $order_id, '_cr8v_order_tickets', true );
				if ( empty( $existing_tickets ) ) {
					$items        = get_post_meta( $order_id, '_cr8v_order_items', true ) ?: array();
					$cust_name    = get_post_meta( $order_id, '_cr8v_order_customer_name', true );
					$issued_tix   = array();

					foreach ( $items as $it ) {
						$qty = (int) ( $it['quantity'] ?? 1 );
						for ( $i = 0; $i < $qty; $i++ ) {
							$tix_code   = 'TIX-' . strtoupper( bin2hex( random_bytes( 6 ) ) );
							$tix_secret = bin2hex( random_bytes( 16 ) );
							$issued_tix[] = array(
								'ticket_code'   => $tix_code,
								'token_hash'    => hash( 'sha256', $tix_secret ),
								'tier_id'       => $it['tier_id'] ?? '',
								'tier_name'     => $it['tier_name'] ?? 'General Admission',
								'attendee_name' => $cust_name,
								'checked_in'    => false,
								'checked_in_at' => '',
							);
						}
					}
					update_post_meta( $order_id, '_cr8v_order_tickets', $issued_tix );
				}

				// Hook for confirmation email (Phase 4)
				do_action( 'cr8v_tix_order_completed', $order_id );
			}
			break;

		case 'checkout.session.expired':
			$session_id = sanitize_text_field( $data_obj['id'] ?? '' );
			if ( $session_id ) {
				// Instantly release reserved stock back to availability pool
				cr8v_tix_release_reservation( $session_id );

				$order_posts = get_posts(
					array(
						'post_type'      => 'event_order',
						'posts_per_page' => 1,
						'meta_key'       => '_cr8v_order_stripe_session_id',
						'meta_value'     => $session_id,
					)
				);
				if ( ! empty( $order_posts ) ) {
					update_post_meta( $order_posts[0]->ID, '_cr8v_order_status', 'cancelled' );
				}
			}
			break;

		case 'checkout.session.async_payment_failed':
			$session_id = sanitize_text_field( $data_obj['id'] ?? '' );
			if ( $session_id ) {
				cr8v_tix_release_reservation( $session_id );
				$order_posts = get_posts(
					array(
						'post_type'      => 'event_order',
						'posts_per_page' => 1,
						'meta_key'       => '_cr8v_order_stripe_session_id',
						'meta_value'     => $session_id,
					)
				);
				if ( ! empty( $order_posts ) ) {
					update_post_meta( $order_posts[0]->ID, '_cr8v_order_status', 'failed' );
				}
			}
			break;

		case 'charge.refunded':
			$pi_id = sanitize_text_field( $data_obj['payment_intent'] ?? '' );
			if ( $pi_id ) {
				$order_posts = get_posts(
					array(
						'post_type'      => 'event_order',
						'posts_per_page' => 1,
						'meta_key'       => '_cr8v_order_stripe_payment_intent',
						'meta_value'     => $pi_id,
					)
				);
				if ( ! empty( $order_posts ) ) {
					update_post_meta( $order_posts[0]->ID, '_cr8v_order_status', 'refunded' );
				}
			}
			break;
	}

	return new WP_REST_Response( array( 'received' => true ), 200 );
}
