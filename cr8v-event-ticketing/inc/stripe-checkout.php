<?php
/**
 * Server-side Stripe Hosted Checkout session creation and free RSVP handler.
 *
 * All pricing and totals are computed on the server from the saved tier definitions.
 * The Stripe secret key is read only from the CRUX_STRIPE_SECRET_KEY constant in wp-config.php.
 *
 * Timing contract (do not change one without the others):
 *   Stripe session lifetime  = CR8V_TIX_STRIPE_SESSION_TTL (31 min; Stripe requires >= 30 min
 *                              from the moment its server receives the request)
 *   Stock hold lifetime      = CR8V_TIX_HOLD_TTL (35 min). The hold must outlive the Stripe
 *                              session, otherwise stock can be released and resold while a
 *                              buyer can still pay.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'CR8V_TIX_STRIPE_SESSION_TTL' ) ) {
	define( 'CR8V_TIX_STRIPE_SESSION_TTL', 1860 );
}
if ( ! defined( 'CR8V_TIX_HOLD_TTL' ) ) {
	define( 'CR8V_TIX_HOLD_TTL', 2100 );
}
if ( ! defined( 'CR8V_TIX_MAX_TICKETS_PER_ORDER' ) ) {
	define( 'CR8V_TIX_MAX_TICKETS_PER_ORDER', 20 );
}

/**
 * Register REST API route for checkout session creation.
 */
function cr8v_tix_register_checkout_rest_route() {
	register_rest_route(
		'cr8v-ticketing/v1',
		'/checkout',
		array(
			'methods'             => 'POST',
			'callback'            => 'cr8v_tix_handle_checkout_request',
			'permission_callback' => '__return_true', // Public booking endpoint; protected by rate limits and server-side validation.
		)
	);
}
add_action( 'rest_api_init', 'cr8v_tix_register_checkout_rest_route' );

/**
 * Small helper for JSON error responses.
 */
function cr8v_tix_checkout_error( $message, $status ) {
	return new WP_REST_Response( array( 'success' => false, 'message' => $message ), $status );
}

/**
 * Create the private order post and its base meta.
 *
 * @return int|WP_Error Order post ID.
 */
function cr8v_tix_create_order( $event_id, $name, $email, $phone, $total_pence, $status, $clean_items, $reservation_token ) {
	$order_id = wp_insert_post(
		array(
			'post_title'  => sprintf( 'Order #%s - %s', substr( $reservation_token, 4, 8 ), $name ),
			'post_type'   => 'event_order',
			'post_status' => 'publish',
			'post_author' => 0,
		),
		true
	);
	if ( is_wp_error( $order_id ) || ! $order_id ) {
		return new WP_Error( 'order_failed', 'Could not create order.' );
	}

	update_post_meta( $order_id, '_cr8v_order_event_id', $event_id );
	update_post_meta( $order_id, '_cr8v_order_customer_name', $name );
	update_post_meta( $order_id, '_cr8v_order_customer_email', $email );
	update_post_meta( $order_id, '_cr8v_order_customer_phone', $phone );
	update_post_meta( $order_id, '_cr8v_order_total_pence', $total_pence );
	update_post_meta( $order_id, '_cr8v_order_currency', 'GBP' );
	update_post_meta( $order_id, '_cr8v_order_status', $status );
	update_post_meta( $order_id, '_cr8v_order_items', $clean_items );
	update_post_meta( $order_id, '_cr8v_order_token', $reservation_token );

	return (int) $order_id;
}

/**
 * Process checkout request.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function cr8v_tix_handle_checkout_request( WP_REST_Request $request ) {
	// 1. Per-IP rate limit (bot card testing, RSVP exhaustion): 15 requests per 5 minutes.
	$ip       = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0' ) );
	$rate_key = 'cr8v_rate_' . md5( $ip );
	$attempts = (int) get_transient( $rate_key );
	if ( $attempts >= 15 ) {
		return cr8v_tix_checkout_error( __( 'Too many requests. Please wait a few minutes before trying again.', 'cr8v-event-ticketing' ), 429 );
	}
	set_transient( $rate_key, $attempts + 1, 300 );

	// 2. Honeypot: real visitors never fill the hidden "website" field.
	if ( '' !== trim( (string) $request->get_param( 'website' ) ) ) {
		return cr8v_tix_checkout_error( __( 'We could not process this request.', 'cr8v-event-ticketing' ), 400 );
	}

	// 3. Event must be published.
	$event_id = absint( $request->get_param( 'event_id' ) );
	$event    = get_post( $event_id );
	if ( ! $event || 'event' !== $event->post_type || 'publish' !== $event->post_status ) {
		return cr8v_tix_checkout_error( __( 'The specified event is not currently available for booking.', 'cr8v-event-ticketing' ), 400 );
	}

	// 3b. No bookings for events that have already happened (the event date is end-of-day inclusive).
	$event_date = (string) get_post_meta( $event_id, '_cr8v_event_date', true );
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $event_date ) && $event_date < wp_date( 'Y-m-d' ) ) {
		return cr8v_tix_checkout_error( __( 'This event has already taken place, so tickets are no longer available.', 'cr8v-event-ticketing' ), 400 );
	}

	// 4. Customer details.
	$name  = mb_substr( sanitize_text_field( (string) $request->get_param( 'customer_name' ) ), 0, 100 );
	$email = sanitize_email( (string) $request->get_param( 'customer_email' ) );
	$phone = mb_substr( sanitize_text_field( (string) $request->get_param( 'customer_phone' ) ), 0, 30 );

	if ( '' === $name || ! is_email( $email ) ) {
		return cr8v_tix_checkout_error( __( 'Please provide a valid full name and email address.', 'cr8v-event-ticketing' ), 400 );
	}

	// 5. Items: merge repeated tiers, validate against saved tiers, compute totals server-side.
	$requested_items = $request->get_param( 'items' );
	if ( ! is_array( $requested_items ) || empty( $requested_items ) ) {
		return cr8v_tix_checkout_error( __( 'Please select at least one ticket.', 'cr8v-event-ticketing' ), 400 );
	}

	$tier_map = array();
	foreach ( cr8v_tix_get_event_tiers( $event_id, false ) as $t ) {
		$tier_map[ $t['id'] ] = $t;
	}

	$wanted = array();
	foreach ( $requested_items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$tid = sanitize_key( $item['tier_id'] ?? '' );
		$qty = absint( $item['quantity'] ?? 0 );
		if ( $qty > 0 && isset( $tier_map[ $tid ] ) ) {
			$wanted[ $tid ] = ( $wanted[ $tid ] ?? 0 ) + $qty;
		}
	}

	$clean_items   = array();
	$total_pence   = 0;
	$total_tickets = 0;
	foreach ( $wanted as $tid => $qty ) {
		$t_def            = $tier_map[ $tid ];
		$unit_price_pence = (int) $t_def['price_pence'];
		$max_per          = isset( $t_def['max_per_order'] ) ? (int) $t_def['max_per_order'] : 10;
		if ( $qty > $max_per ) {
			return cr8v_tix_checkout_error(
				sprintf( __( 'Maximum %1$d tickets allowed for %2$s.', 'cr8v-event-ticketing' ), $max_per, $t_def['name'] ),
				400
			);
		}
		$clean_items[] = array(
			'tier_id'          => $tid,
			'tier_name'        => $t_def['name'],
			'quantity'         => $qty,
			'unit_price_pence' => $unit_price_pence,
			'total_pence'      => $unit_price_pence * $qty,
		);
		$total_pence   += $unit_price_pence * $qty;
		$total_tickets += $qty;
	}

	if ( empty( $clean_items ) ) {
		return cr8v_tix_checkout_error( __( 'No valid ticket items were selected.', 'cr8v-event-ticketing' ), 400 );
	}
	if ( $total_tickets > CR8V_TIX_MAX_TICKETS_PER_ORDER ) {
		return cr8v_tix_checkout_error(
			sprintf( __( 'You can book up to %d tickets in one order.', 'cr8v-event-ticketing' ), CR8V_TIX_MAX_TICKETS_PER_ORDER ),
			400
		);
	}
	// Stripe cannot charge less than 30p.
	if ( $total_pence > 0 && $total_pence < 30 ) {
		return cr8v_tix_checkout_error( __( 'The minimum card payment is £0.30.', 'cr8v-event-ticketing' ), 400 );
	}

	// 6. Free RSVPs skip Stripe, so limit them per email and event (3 per hour).
	if ( 0 === $total_pence ) {
		$free_key  = 'cr8v_free_' . md5( strtolower( $email ) . '|' . $event_id );
		$free_used = (int) get_transient( $free_key );
		if ( $free_used >= 3 ) {
			return cr8v_tix_checkout_error( __( 'This email address has already made several bookings for this event. Please try again later.', 'cr8v-event-ticketing' ), 429 );
		}
		set_transient( $free_key, $free_used + 1, HOUR_IN_SECONDS );
	}

	// 7. Paid orders need the key before we take stock.
	if ( $total_pence > 0 && ( ! defined( 'CRUX_STRIPE_SECRET_KEY' ) || '' === (string) CRUX_STRIPE_SECRET_KEY ) ) {
		return cr8v_tix_checkout_error( __( 'Online payment is not available yet. Please contact us to book.', 'cr8v-event-ticketing' ), 503 );
	}

	// 8. Atomic stock reservation (serialised per event; hold outlives the Stripe session).
	$reservation_token  = 'res_' . bin2hex( random_bytes( 16 ) );
	$reservation_result = cr8v_tix_atomic_reserve_stock( $event_id, $clean_items, $reservation_token, CR8V_TIX_HOLD_TTL );
	if ( is_wp_error( $reservation_result ) ) {
		return cr8v_tix_checkout_error( $reservation_result->get_error_message(), 409 );
	}

	// 9. Free RSVP: complete immediately.
	if ( 0 === $total_pence ) {
		$order_id = cr8v_tix_create_order( $event_id, $name, $email, $phone, 0, 'completed', $clean_items, $reservation_token );
		if ( is_wp_error( $order_id ) ) {
			cr8v_tix_release_reservation( $reservation_token );
			return cr8v_tix_checkout_error( __( 'Failed to generate RSVP order. Please try again.', 'cr8v-event-ticketing' ), 500 );
		}

		cr8v_tix_issue_tickets( $order_id, $clean_items, $name );
		cr8v_tix_complete_reservation( $reservation_token, $order_id );
		do_action( 'cr8v_tix_order_completed', $order_id );

		return new WP_REST_Response(
			array(
				'success'      => true,
				'is_free'      => true,
				'redirect_url' => home_url( '/booking-confirmation/?order_token=' . rawurlencode( $reservation_token ) ),
			),
			200
		);
	}

	// 10. Paid order: pending order, then Stripe Checkout Session.
	$order_id = cr8v_tix_create_order( $event_id, $name, $email, $phone, $total_pence, 'pending', $clean_items, $reservation_token );
	if ( is_wp_error( $order_id ) ) {
		cr8v_tix_release_reservation( $reservation_token );
		return cr8v_tix_checkout_error( __( 'Could not initialize order record.', 'cr8v-event-ticketing' ), 500 );
	}

	$stripe_params = array();
	$line_idx      = 0;
	foreach ( $clean_items as $c_item ) {
		if ( $c_item['unit_price_pence'] <= 0 ) {
			continue; // Free tiers in a mixed order are not charged and are not Stripe line items.
		}
		$stripe_params[ "line_items[{$line_idx}][price_data][currency]" ]                 = 'gbp';
		$stripe_params[ "line_items[{$line_idx}][price_data][unit_amount]" ]              = $c_item['unit_price_pence'];
		$stripe_params[ "line_items[{$line_idx}][price_data][product_data][name]" ]       = mb_substr( sprintf( '%s - %s', $event->post_title, $c_item['tier_name'] ), 0, 250 );
		$stripe_params[ "line_items[{$line_idx}][quantity]" ]                             = $c_item['quantity'];
		$line_idx++;
	}

	$stripe_params += array(
		'mode'                => 'payment',
		// Cards only (includes Apple Pay and Google Pay): money is confirmed instantly, so the
		// stock hold and the fulfilment logic never have to wait days for a delayed method.
		'payment_method_types[0]' => 'card',
		'customer_email'      => $email,
		'client_reference_id' => (string) $order_id,
		'expires_at'          => time() + CR8V_TIX_STRIPE_SESSION_TTL,
		'success_url'         => home_url( '/booking-confirmation/?session_id={CHECKOUT_SESSION_ID}' ),
		'cancel_url'          => get_permalink( $event_id ),
		'metadata[event_id]'  => (string) $event_id,
		'metadata[order_id]'  => (string) $order_id,
		'metadata[res_token]' => $reservation_token,
	);

	$response = wp_remote_post(
		'https://api.stripe.com/v1/checkout/sessions',
		array(
			'headers' => array(
				'Authorization'   => 'Bearer ' . CRUX_STRIPE_SECRET_KEY,
				'Content-Type'    => 'application/x-www-form-urlencoded',
				'Idempotency-Key' => $reservation_token, // A retried request cannot create a second session.
			),
			'body'    => $stripe_params,
			'timeout' => 20,
		)
	);

	if ( is_wp_error( $response ) ) {
		error_log( '[cr8v-ticketing] Stripe request failed: ' . $response->get_error_message() );
		cr8v_tix_release_reservation( $reservation_token );
		update_post_meta( $order_id, '_cr8v_order_status', 'failed' );
		return cr8v_tix_checkout_error( __( 'Network error connecting to the payment gateway. Please try again.', 'cr8v-event-ticketing' ), 502 );
	}

	$res_body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( empty( $res_body['url'] ) || empty( $res_body['id'] ) ) {
		// Log the real reason for the owner; show the customer a generic message.
		error_log( '[cr8v-ticketing] Stripe session not created: ' . wp_json_encode( $res_body['error'] ?? 'unknown' ) );
		cr8v_tix_release_reservation( $reservation_token );
		update_post_meta( $order_id, '_cr8v_order_status', 'failed' );
		return cr8v_tix_checkout_error( __( 'Could not start the payment. Please try again or contact us.', 'cr8v-event-ticketing' ), 502 );
	}

	$stripe_session_id = sanitize_text_field( $res_body['id'] );
	update_post_meta( $order_id, '_cr8v_order_stripe_session_id', $stripe_session_id );

	global $wpdb;
	$linked = $wpdb->update(
		cr8v_tix_reservations_table(),
		array( 'session_id' => $stripe_session_id, 'order_id' => $order_id ),
		array( 'session_id' => $reservation_token )
	);
	if ( false === $linked ) {
		error_log( '[cr8v-ticketing] Could not link reservation to Stripe session ' . $stripe_session_id );
		cr8v_tix_release_reservation( $reservation_token );
		update_post_meta( $order_id, '_cr8v_order_status', 'failed' );
		return cr8v_tix_checkout_error( __( 'Could not start the payment. Please try again.', 'cr8v-event-ticketing' ), 500 );
	}

	return new WP_REST_Response(
		array(
			'success'      => true,
			'is_free'      => false,
			'session_id'   => $stripe_session_id,
			'redirect_url' => esc_url_raw( $res_body['url'] ),
		),
		200
	);
}
