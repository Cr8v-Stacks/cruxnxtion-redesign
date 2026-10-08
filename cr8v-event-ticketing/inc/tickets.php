<?php
/**
 * Ticket issuing and verification.
 *
 * Each ticket has a public code (TIX-XXXXXXXXXXXX) and a secret. The secret is derived
 * from the code with an HMAC keyed by the site's auth salt, so it can be recomputed to
 * build the emailed QR link and to verify a scan, without storing the secret itself.
 * Nobody can forge a secret without the salt, and the code alone is not enough.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Derive the secret for a ticket code.
 */
function cr8v_tix_ticket_secret( $ticket_code ) {
	return substr( hash_hmac( 'sha256', (string) $ticket_code, wp_salt( 'auth' ) ), 0, 32 );
}

/**
 * Constant-time check of a code and secret pair.
 */
function cr8v_tix_verify_ticket_secret( $ticket_code, $secret ) {
	return hash_equals( cr8v_tix_ticket_secret( $ticket_code ), (string) $secret );
}

/**
 * Issue one ticket per purchased seat. Safe to call twice: existing tickets are kept.
 *
 * @param int    $order_id Order post ID.
 * @param array  $items    Order items: tier_id, tier_name, quantity.
 * @param string $attendee Attendee name.
 * @return array Tickets stored on the order.
 */
function cr8v_tix_issue_tickets( $order_id, $items, $attendee ) {
	$existing = get_post_meta( $order_id, '_cr8v_order_tickets', true );
	if ( is_array( $existing ) && ! empty( $existing ) ) {
		return $existing;
	}

	$issued = array();
	foreach ( (array) $items as $item ) {
		$qty = absint( $item['quantity'] ?? 0 );
		for ( $i = 0; $i < $qty; $i++ ) {
			$code     = 'TIX-' . strtoupper( bin2hex( random_bytes( 6 ) ) );
			$issued[] = array(
				'ticket_code'   => $code,
				'token_hash'    => hash( 'sha256', cr8v_tix_ticket_secret( $code ) ),
				'tier_id'       => sanitize_key( $item['tier_id'] ?? '' ),
				'tier_name'     => sanitize_text_field( $item['tier_name'] ?? 'General Admission' ),
				'attendee_name' => $attendee,
				'checked_in'    => false,
				'checked_in_at' => '',
				'void'          => false,
			);
		}
	}

	update_post_meta( $order_id, '_cr8v_order_tickets', $issued );
	return $issued;
}

/**
 * Void every ticket on an order (full refund or chargeback).
 */
function cr8v_tix_void_order_tickets( $order_id ) {
	$tickets = get_post_meta( $order_id, '_cr8v_order_tickets', true );
	if ( ! is_array( $tickets ) ) {
		return;
	}
	foreach ( $tickets as $i => $tix ) {
		$tickets[ $i ]['void'] = true;
	}
	update_post_meta( $order_id, '_cr8v_order_tickets', $tickets );
}

/**
 * Normalise a typed or scanned ticket code: remove spaces, upper-case, and accept only the real
 * format TIX- followed by 12 hexadecimal characters. Returns '' for anything else, so partial
 * text such as "TIX" can never match a ticket.
 */
function cr8v_tix_normalize_ticket_code( $raw ) {
	$code = strtoupper( preg_replace( '/\s+/', '', (string) $raw ) );
	return preg_match( '/^TIX-[A-F0-9]{12}$/', $code ) ? $code : '';
}

/**
 * Find the order and ticket for an exact ticket code.
 *
 * A valid secret only proves the code was typed or scanned correctly; it does not prove the
 * ticket exists (door staff can look a code up without a secret). Anything that shows a pass
 * as valid must call this first.
 *
 * @param string $raw_code Code as typed or scanned.
 * @return array|null array( 'order_id' => int, 'ticket' => array, 'code' => string ), or null.
 */
function cr8v_tix_find_ticket( $raw_code ) {
	$code = cr8v_tix_normalize_ticket_code( $raw_code );
	if ( '' === $code ) {
		return null;
	}

	global $wpdb;
	$order_id = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_cr8v_order_tickets' AND meta_value LIKE %s LIMIT 1",
			'%' . $wpdb->esc_like( '"' . $code . '"' ) . '%'
		)
	);
	if ( ! $order_id ) {
		return null;
	}

	$tickets = get_post_meta( $order_id, '_cr8v_order_tickets', true );
	if ( is_array( $tickets ) ) {
		foreach ( $tickets as $ticket ) {
			if ( ( $ticket['ticket_code'] ?? '' ) === $code ) {
				return array( 'order_id' => $order_id, 'ticket' => $ticket, 'code' => $code );
			}
		}
	}
	return null;
}

/**
 * Short-lived signed door check-in flag window in seconds (PRG).
 */
if ( ! defined( 'CR8V_TIX_CHECKIN_FLAG_TTL' ) ) {
	define( 'CR8V_TIX_CHECKIN_FLAG_TTL', 60 );
}

/**
 * Generate a short-lived cryptographic HMAC token for door check-in PRG flag.
 *
 * @param string $ticket_code Normalized ticket code.
 * @param int    $staff_id    Staff user ID who performed the check-in.
 * @param int    $time        Timestamp of the check-in action.
 * @return string 32-character hex token.
 */
function cr8v_tix_generate_checkin_token( $ticket_code, $staff_id, $time ) {
	return substr( hash_hmac( 'sha256', "checkin_{$ticket_code}_{$staff_id}_{$time}", wp_salt( 'nonce' ) ), 0, 32 );
}

/**
 * Verify door check-in PRG token.
 * Must match staff ID, ticket code, valid signature, and not expired (<= TTL).
 *
 * @param string $ticket_code Normalized ticket code.
 * @param int    $staff_id    Staff user ID from request.
 * @param int    $time        Timestamp from request.
 * @param string $token       Token signature from request.
 * @return bool True if valid, not expired, and requested by same logged-in staff user.
 */
function cr8v_tix_verify_checkin_token( $ticket_code, $staff_id, $time, $token ) {
	if ( ! current_user_can( 'edit_event_orders' ) && ! current_user_can( 'manage_options' ) ) {
		return false;
	}

	$current_uid = get_current_user_id();
	if ( ! $current_uid || (int) $staff_id !== $current_uid ) {
		return false;
	}

	$ttl = (int) apply_filters( 'cr8v_tix_checkin_flag_ttl', CR8V_TIX_CHECKIN_FLAG_TTL, $ticket_code, $staff_id );
	if ( $ttl <= 0 ) {
		$ttl = 60;
	}

	$now  = time();
	$time = (int) $time;
	if ( $time <= 0 || ( $now - $time ) > $ttl || $time > ( $now + 5 ) ) {
		return false;
	}

	if ( empty( $ticket_code ) || empty( $token ) ) {
		return false;
	}

	$expected = cr8v_tix_generate_checkin_token( $ticket_code, $current_uid, $time );
	return hash_equals( $expected, (string) $token );
}

