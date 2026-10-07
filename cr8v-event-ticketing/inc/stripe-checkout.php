<?php
/**
 * Server-side Stripe Hosted Checkout Session creation & Free RSVP handler.
 *
 * All pricing and line item totals are computed strictly on the server.
 * Stripe secret key is read only from the `CRUX_STRIPE_SECRET_KEY` constant in wp-config.php.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
			'permission_callback' => '__return_true', // Rate-limited public endpoint
		)
	);
}
add_action( 'rest_api_init', 'cr8v_tix_register_checkout_rest_route' );

/**
 * Process checkout request.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function cr8v_tix_handle_checkout_request( WP_REST_Request $request ) {
	// 1. IP Rate Limiting (Prevent bot card testing and RSVP exhaustion)
	$ip = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1' );
	$rate_key = 'cr8v_rate_' . md5( $ip );
	$attempts = (int) get_transient( $rate_key );
	if ( $attempts > 15 ) {
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => __( 'Too many requests. Please wait a few minutes before trying again.', 'cr8v-event-ticketing' ),
			),
			429
		);
	}
	set_transient( $rate_key, $attempts + 1, 300 ); // 15 attempts per 5 minutes

	// 2. Validate Event
	$event_id = absint( $request->get_param( 'event_id' ) );
	$event    = get_post( $event_id );
	if ( ! $event || 'event' !== $event->post_type || 'publish' !== $event->post_status ) {
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => __( 'The specified event is not currently available for booking.', 'cr8v-event-ticketing' ),
			),
			400
		);
	}

	// 3. Customer Info Validation
	$name  = sanitize_text_field( $request->get_param( 'customer_name' ) );
	$email = sanitize_email( $request->get_param( 'customer_email' ) );
	$phone = sanitize_text_field( $request->get_param( 'customer_phone' ) );

	if ( empty( $name ) || ! is_email( $email ) ) {
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => __( 'Please provide a valid full name and email address.', 'cr8v-event-ticketing' ),
			),
			400
		);
	}

	// 4. Validate Ticket Tiers & Compute Server-Side Totals
	$requested_items = $request->get_param( 'items' );
	if ( ! is_array( $requested_items ) || empty( $requested_items ) ) {
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => __( 'Please select at least one ticket.', 'cr8v-event-ticketing' ),
			),
			400
		);
	}

	$all_tiers = cr8v_tix_get_event_tiers( $event_id, false );
	$tier_map  = array();
	foreach ( $all_tiers as $t ) {
		$tier_map[ $t['id'] ] = $t;
	}

	$clean_items   = array();
	$total_pence   = 0;
	$total_tickets = 0;

	foreach ( $requested_items as $item ) {
		$tid = sanitize_key( $item['tier_id'] ?? '' );
		$qty = absint( $item['quantity'] ?? 0 );

		if ( $qty <= 0 || ! isset( $tier_map[ $tid ] ) ) {
			continue;
		}

		$t_def = $tier_map[ $tid ];
		$unit_price_pence = (int) $t_def['price_pence'];
		$line_total_pence = $unit_price_pence * $qty;

		$clean_items[] = array(
			'tier_id'          => $tid,
			'tier_name'        => $t_def['name'],
			'quantity'         => $qty,
			'unit_price_pence' => $unit_price_pence,
			'total_pence'      => $line_total_pence,
		);

		$total_pence   += $line_total_pence;
		$total_tickets += $qty;
	}

	if ( empty( $clean_items ) ) {
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => __( 'No valid ticket items were selected.', 'cr8v-event-ticketing' ),
			),
			400
		);
	}

	// 5. Generate unique reservation reference token
	$reservation_token = 'res_' . bin2hex( random_bytes( 16 ) );

	// 6. Atomic Stock Reservation (30 minute hold)
	$reservation_result = cr8v_tix_atomic_reserve_stock( $event_id, $clean_items, $reservation_token, 1800 );
	if ( is_wp_error( $reservation_result ) ) {
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => $reservation_result->get_error_message(),
			),
			409 // Conflict / capacity limit
		);
	}

	// 7. Handle Free RSVP Events (total_pence === 0)
	if ( 0 === $total_pence ) {
		$order_id = wp_insert_post(
			array(
				'post_title'   => sprintf( 'Order #%s - %s', substr( $reservation_token, 4, 8 ), $name ),
				'post_type'    => 'event_order',
				'post_status'  => 'publish',
				'post_author'  => 1,
			)
		);

		if ( ! $order_id || is_wp_error( $order_id ) ) {
			cr8v_tix_release_reservation( $reservation_token );
			return new WP_REST_Response(
				array(
					'success' => false,
					'message' => __( 'Failed to generate RSVP order. Please try again.', 'cr8v-event-ticketing' ),
				),
				500
			);
		}

		// Store Order Meta
		update_post_meta( $order_id, '_cr8v_order_event_id', $event_id );
		update_post_meta( $order_id, '_cr8v_order_customer_name', $name );
		update_post_meta( $order_id, '_cr8v_order_customer_email', $email );
		update_post_meta( $order_id, '_cr8v_order_customer_phone', $phone );
		update_post_meta( $order_id, '_cr8v_order_total_pence', 0 );
		update_post_meta( $order_id, '_cr8v_order_currency', 'GBP' );
		update_post_meta( $order_id, '_cr8v_order_status', 'completed' );
		update_post_meta( $order_id, '_cr8v_order_items', $clean_items );
		update_post_meta( $order_id, '_cr8v_order_token', $reservation_token );

		// Issue Individual Cryptographic Tickets
		$issued_tickets = array();
		foreach ( $clean_items as $c_item ) {
			for ( $i = 0; $i < $c_item['quantity']; $i++ ) {
				$tix_code   = 'TIX-' . strtoupper( bin2hex( random_bytes( 6 ) ) );
				$tix_secret = bin2hex( random_bytes( 16 ) );
				$issued_tickets[] = array(
					'ticket_code'    => $tix_code,
					'token_hash'     => hash( 'sha256', $tix_secret ),
					'tier_id'        => $c_item['tier_id'],
					'tier_name'      => $c_item['tier_name'],
					'attendee_name'  => $name,
					'checked_in'     => false,
					'checked_in_at'  => '',
				);
			}
		}
		update_post_meta( $order_id, '_cr8v_order_tickets', $issued_tickets );

		// Mark reservation complete
		cr8v_tix_complete_reservation( $reservation_token, $order_id );

		return new WP_REST_Response(
			array(
				'success'      => true,
				'is_free'      => true,
				'redirect_url' => home_url( '/booking-confirmation/?order_token=' . $reservation_token ),
			),
			200
		);
	}

	// 8. Handle Paid Orders via Stripe Hosted Checkout
	if ( ! defined( 'CRUX_STRIPE_SECRET_KEY' ) || empty( CRUX_STRIPE_SECRET_KEY ) ) {
		cr8v_tix_release_reservation( $reservation_token );
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => __( 'Stripe payment gateway is not yet configured on this installation. Please contact support.', 'cr8v-event-ticketing' ),
			),
			503
		);
	}

	// Create pending Order post
	$order_id = wp_insert_post(
		array(
			'post_title'   => sprintf( 'Order #%s - %s', substr( $reservation_token, 4, 8 ), $name ),
			'post_type'    => 'event_order',
			'post_status'  => 'publish',
			'post_author'  => 1,
		)
	);

	if ( ! $order_id || is_wp_error( $order_id ) ) {
		cr8v_tix_release_reservation( $reservation_token );
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => __( 'Could not initialize order record.', 'cr8v-event-ticketing' ),
			),
			500
		);
	}

	update_post_meta( $order_id, '_cr8v_order_event_id', $event_id );
	update_post_meta( $order_id, '_cr8v_order_customer_name', $name );
	update_post_meta( $order_id, '_cr8v_order_customer_email', $email );
	update_post_meta( $order_id, '_cr8v_order_customer_phone', $phone );
	update_post_meta( $order_id, '_cr8v_order_total_pence', $total_pence );
	update_post_meta( $order_id, '_cr8v_order_currency', 'GBP' );
	update_post_meta( $order_id, '_cr8v_order_status', 'pending' );
	update_post_meta( $order_id, '_cr8v_order_items', $clean_items );
	update_post_meta( $order_id, '_cr8v_order_token', $reservation_token );

	// Build Stripe Checkout Session line items
	$line_items = array();
	$item_idx = 0;
	foreach ( $clean_items as $c_item ) {
		$line_items[ "line_items[{$item_idx}][price_data][currency]" ] = 'gbp';
		$line_items[ "line_items[{$item_idx}][price_data][unit_amount]" ] = $c_item['unit_price_pence'];
		$line_items[ "line_items[{$item_idx}][price_data][product_data][name]" ] = sprintf( '%s - %s', $event->post_title, $c_item['tier_name'] );
		$line_items[ "line_items[{$item_idx}][quantity]" ] = $c_item['quantity'];
		$item_idx++;
	}

	$stripe_params = array_merge(
		$line_items,
		array(
			'mode'                   => 'payment',
			'customer_email'         => $email,
			'client_reference_id'    => (string) $order_id,
			'expires_at'             => time() + 1800, // 30 minutes expiry
			'success_url'            => home_url( '/booking-confirmation/?session_id={CHECKOUT_SESSION_ID}' ),
			'cancel_url'             => get_permalink( $event_id ),
			'metadata[event_id]'     => (string) $event_id,
			'metadata[order_id]'     => (string) $order_id,
			'metadata[res_token]'    => $reservation_token,
			'metadata[customer_name]'=> $name,
		)
	);

	// Send request to Stripe API
	$response = wp_remote_post(
		'https://api.stripe.com/v1/checkout/sessions',
		array(
			'method'  => 'POST',
			'headers' => array(
				'Authorization' => 'Bearer ' . CRUX_STRIPE_SECRET_KEY,
				'Content-Type'  => 'application/x-www-form-urlencoded',
			),
			'body'    => $stripe_params,
			'timeout' => 20,
		)
	);

	if ( is_wp_error( $response ) ) {
		cr8v_tix_release_reservation( $reservation_token );
		update_post_meta( $order_id, '_cr8v_order_status', 'failed' );
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => __( 'Network error connecting to payment gateway. Please try again.', 'cr8v-event-ticketing' ),
			),
			502
		);
	}

	$res_body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( empty( $res_body['url'] ) || empty( $res_body['id'] ) ) {
		cr8v_tix_release_reservation( $reservation_token );
		update_post_meta( $order_id, '_cr8v_order_status', 'failed' );
		$err_msg = $res_body['error']['message'] ?? __( 'Could not create payment session.', 'cr8v-event-ticketing' );
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => $err_msg,
			),
			400
		);
	}

	// Link Stripe session to Order and Reservation
	$stripe_session_id = sanitize_text_field( $res_body['id'] );
	update_post_meta( $order_id, '_cr8v_order_stripe_session_id', $stripe_session_id );

	global $wpdb;
	$res_table = cr8v_tix_reservations_table();
	$wpdb->update(
		$res_table,
		array( 'session_id' => $stripe_session_id, 'order_id' => $order_id ),
		array( 'session_id' => $reservation_token )
	);

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
