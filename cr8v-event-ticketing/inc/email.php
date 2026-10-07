<?php
/**
 * Automated HTML order confirmation email dispatcher with .ics calendar attachment.
 *
 * Triggered automatically on `cr8v_tix_order_completed`.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Send order confirmation email with scannable ticket details and calendar invitation.
 *
 * @param int  $order_id     Post ID of the completed event_order.
 * @param bool $force_resend Whether to bypass the single-dispatch idempotency check.
 * @return bool True if mail was sent, false otherwise.
 */
function cr8v_tix_send_order_confirmation_email( $order_id, $force_resend = false ) {
	$order = get_post( $order_id );
	if ( ! $order || 'event_order' !== $order->post_type ) {
		return false;
	}

	$status = get_post_meta( $order_id, '_cr8v_order_status', true );
	if ( 'completed' !== $status ) {
		return false; // Only completed orders receive confirmed ticket passes.
	}

	// Idempotency: avoid sending duplicate emails unless explicitly requested by staff.
	if ( ! $force_resend && get_post_meta( $order_id, '_cr8v_order_email_sent', true ) ) {
		return true;
	}

	$customer_email = sanitize_email( (string) get_post_meta( $order_id, '_cr8v_order_customer_email', true ) );
	if ( empty( $customer_email ) || ! is_email( $customer_email ) ) {
		error_log( "[cr8v-ticketing] Cannot send confirmation email for order {$order_id}: invalid customer email." );
		return false;
	}

	$customer_name  = sanitize_text_field( (string) get_post_meta( $order_id, '_cr8v_order_customer_name', true ) ) ?: 'Valued Guest';
	$total_pence    = (int) get_post_meta( $order_id, '_cr8v_order_total_pence', true );
	$total_str      = 0 === $total_pence ? 'Free RSVP' : '£' . number_format( $total_pence / 100, 2 );
	$order_token    = sanitize_text_field( (string) get_post_meta( $order_id, '_cr8v_order_token', true ) );
	$tickets        = get_post_meta( $order_id, '_cr8v_order_tickets', true );
	$event_id       = (int) get_post_meta( $order_id, '_cr8v_order_event_id', true );

	$event = get_post( $event_id );
	$event_title = $event ? sanitize_text_field( $event->post_title ) : 'Crux Nxtion Event';

	$date_raw = (string) get_post_meta( $event_id, '_cr8v_event_date', true );
	$time_str = sanitize_text_field( (string) get_post_meta( $event_id, '_cr8v_event_time', true ) ) ?: 'Doors Open 19:00';
	$venue    = sanitize_text_field( (string) get_post_meta( $event_id, '_cr8v_event_venue', true ) );
	$country  = sanitize_text_field( (string) get_post_meta( $event_id, '_cr8v_event_location', true ) );
	$location = trim( $venue . ( ( $venue && $country ) ? ', ' : '' ) . $country );

	$formatted_date = $date_raw;
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date_raw ) ) {
		$formatted_date = wp_date( 'l, j F Y', strtotime( $date_raw ) );
	}

	// Build Web Portal link for full order
	$portal_url = home_url( '/booking-confirmation/?order_token=' . rawurlencode( $order_token ) );

	// Build .ics attachment
	$attachments = array();
	$temp_ics    = '';
	if ( function_exists( 'cr8v_tix_build_event_ics' ) ) {
		$ics_data = cr8v_tix_build_event_ics( $event_id );
		if ( ! empty( $ics_data ) ) {
			$upload_dir = wp_upload_dir();
			$cal_dir    = trailingslashit( $upload_dir['basedir'] ) . 'cr8v-cal-temp';
			wp_mkdir_p( $cal_dir );
			$temp_ics = trailingslashit( $cal_dir ) . 'event-' . $event_id . '-' . substr( md5( $order_token ), 0, 8 ) . '.ics';
			file_put_contents( $temp_ics, $ics_data );
			if ( file_exists( $temp_ics ) ) {
				$attachments[] = $temp_ics;
			}
		}
	}

	// Build ticket pass HTML items
	$ticket_rows_html = '';
	if ( is_array( $tickets ) && ! empty( $tickets ) ) {
		foreach ( $tickets as $tix ) {
			$code     = sanitize_text_field( $tix['ticket_code'] ?? '' );
			$secret   = function_exists( 'cr8v_tix_ticket_secret' ) ? cr8v_tix_ticket_secret( $code ) : '';
			$tier     = sanitize_text_field( $tix['tier_name'] ?? 'General Admission' );
			$attendee = sanitize_text_field( $tix['attendee_name'] ?? $customer_name );

			$qr_link = add_query_arg(
				array(
					'cr8v_ticket' => $code,
					'tix_secret'  => $secret,
				),
				home_url( '/booking-confirmation/' )
			);

			$ticket_rows_html .= '
			<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#111838; border:1px solid #1E2B5E; border-radius:8px; margin-bottom:14px; overflow:hidden;">
				<tr>
					<td style="padding:16px 20px;">
						<div style="font-size:11px; font-weight:700; color:#5B8DEF; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;">' . esc_html( $tier ) . '</div>
						<div style="font-size:18px; font-weight:700; color:#F4F5FA; margin-bottom:4px;">' . esc_html( $attendee ) . '</div>
						<div style="font-size:13px; color:#A3A9C8; font-family:monospace; margin-bottom:12px;">Pass Code: <strong style="color:#FFFFFF;">' . esc_html( $code ) . '</strong></div>
						<div>
							<a href="' . esc_url( $qr_link ) . '" style="display:inline-block; background:#BA0000; color:#FFFFFF; font-size:12px; font-weight:700; text-decoration:none; padding:8px 16px; border-radius:4px; text-transform:uppercase; letter-spacing:0.5px;">View Digital Pass &amp; QR Code &rarr;</a>
						</div>
					</td>
				</tr>
			</table>';
		}
	}

	$order_ref = strtoupper( substr( $order_token, 4, 8 ) );
	$subject   = sprintf( 'Your Tickets: %s (Order #%s)', $event_title, $order_ref );

	// Clean, responsive email template styled with Crux dark editorial aesthetic
	$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>' . esc_html( $subject ) . '</title>
</head>
<body style="margin:0; padding:0; background:#0A0F26; font-family:\'Space Grotesk\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; color:#F4F5FA;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#0A0F26; min-height:100vh; padding:30px 15px;">
	<tr>
		<td align="center">
			<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; background:#0E1432; border:1px solid #1E2B5E; border-radius:12px; overflow:hidden; text-align:left;">
				<!-- Header -->
				<tr>
					<td style="padding:28px 32px; background:#0A0F26; border-bottom:1px solid #1E2B5E;">
						<div style="font-size:12px; font-weight:800; letter-spacing:2px; color:#5B8DEF; text-transform:uppercase;">CRUX NXTION EVENTS</div>
						<h1 style="margin:8px 0 0 0; font-size:24px; color:#FFFFFF; font-weight:700;">Booking Confirmation</h1>
					</td>
				</tr>

				<!-- Content Body -->
				<tr>
					<td style="padding:32px;">
						<p style="font-size:15px; color:#D5D9EA; line-height:1.6; margin-top:0;">Hello ' . esc_html( $customer_name ) . ',</p>
						<p style="font-size:15px; color:#D5D9EA; line-height:1.6;">Thank you for your booking! Your tickets for <strong>' . esc_html( $event_title ) . '</strong> are confirmed. Your digital passes are listed below, and your calendar invitation (.ics) is attached to this email.</p>

						<!-- Event Snapshot -->
						<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#111838; border:1px solid #1E2B5E; border-radius:8px; margin:22px 0; padding:18px 22px;">
							<tr>
								<td style="font-size:13.5px; line-height:1.8; color:#D5D9EA;">
									<strong style="color:#5B8DEF; text-transform:uppercase; font-size:11px; letter-spacing:1px; display:block; margin-bottom:4px;">EVENT SUMMARY</strong>
									<span style="font-size:16px; font-weight:700; color:#FFFFFF; display:block; margin-bottom:6px;">' . esc_html( $event_title ) . '</span>
									<strong>Date:</strong> ' . esc_html( $formatted_date ) . '<br>
									<strong>Time:</strong> ' . esc_html( $time_str ) . '<br>
									<strong>Venue:</strong> ' . esc_html( $location ?: 'Crux Nxtion Venue' ) . '<br>
									<strong>Order Ref:</strong> #' . esc_html( $order_ref ) . ' &bull; <strong>Total:</strong> ' . esc_html( $total_str ) . '
								</td>
							</tr>
						</table>

						<!-- Ticket Passes -->
						<h2 style="font-size:16px; font-weight:700; color:#F4F5FA; text-transform:uppercase; letter-spacing:1px; margin:28px 0 14px 0;">YOUR TICKET PASSES</h2>
						' . $ticket_rows_html . '

						<!-- Web Portal Access -->
						<div style="margin-top:28px; padding-top:20px; border-top:1px solid #1E2B5E; text-align:center;">
							<p style="font-size:13.5px; color:#A3A9C8; margin-bottom:14px;">Access your live tickets, printable pass, and QR codes anytime online:</p>
							<a href="' . esc_url( $portal_url ) . '" style="display:inline-block; background:#002671; border:1px solid #5B8DEF; color:#FFFFFF; font-size:13px; font-weight:700; text-decoration:none; padding:12px 24px; border-radius:6px; letter-spacing:0.5px;">View Online Ticket Pass &rarr;</a>
						</div>
					</td>
				</tr>

				<!-- Footer -->
				<tr>
					<td style="padding:22px 32px; background:#0A0F26; border-top:1px solid #1E2B5E; font-size:12px; color:#7A82A8; text-align:center; line-height:1.6;">
						Crux Nxtion &bull; Premium Events &amp; Culture<br>
						Questions or support? Reach us at <a href="mailto:infoandsales@cruxnxtion.co.uk" style="color:#5B8DEF; text-decoration:none;">infoandsales@cruxnxtion.co.uk</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>';

	$from_name  = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) ?: 'Crux Nxtion Events';
	$from_email = 'infoandsales@cruxnxtion.co.uk';

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		sprintf( 'From: %s <%s>', $from_name, $from_email ),
	);

	$sent = wp_mail( $customer_email, $subject, $html, $headers, $attachments );

	// Clean up temp ics file
	if ( $temp_ics && file_exists( $temp_ics ) ) {
		unlink( $temp_ics );
	}

	if ( $sent ) {
		update_post_meta( $order_id, '_cr8v_order_email_sent', current_time( 'mysql' ) );
		return true;
	} else {
		error_log( "[cr8v-ticketing] wp_mail failed to dispatch confirmation for order {$order_id} to {$customer_email}." );
		return false;
	}
}
add_action( 'cr8v_tix_order_completed', 'cr8v_tix_send_order_confirmation_email', 10, 1 );

/**
 * Handle admin manual resend request from order edit screen.
 */
function cr8v_tix_handle_admin_resend_email() {
	if ( ! isset( $_POST['cr8v_resend_order_email'], $_POST['order_id'], $_POST['_cr8v_resend_nonce'] ) ) {
		return;
	}

	$order_id = absint( $_POST['order_id'] );
	if ( ! current_user_can( 'edit_event_orders' ) && ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Unauthorized access.', 'cr8v-event-ticketing' ), 403 );
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_cr8v_resend_nonce'] ) ), 'cr8v_resend_order_' . $order_id ) ) {
		wp_die( esc_html__( 'Invalid security token.', 'cr8v-event-ticketing' ), 403 );
	}

	$result = cr8v_tix_send_order_confirmation_email( $order_id, true );

	$redirect = add_query_arg(
		array(
			'post'   => $order_id,
			'action' => 'edit',
			'email_sent' => $result ? '1' : '0',
		),
		admin_url( 'post.php' )
	);

	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'admin_init', 'cr8v_tix_handle_admin_resend_email' );
