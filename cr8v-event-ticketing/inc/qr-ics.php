<?php
/**
 * QR code generator (pure PHP SVG) and ICS calendar event generator.
 *
 * Privacy guarantee: 100% server-side, zero external API requests.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build one iCalendar text property: escape per RFC 5545 (a raw line break in a value would let
 * event text inject extra calendar fields) and fold lines longer than 75 octets.
 */
function cr8v_tix_ics_line( $name, $value ) {
	$value = str_replace(
		array( '\\', ';', ',', "\r\n", "\n", "\r" ),
		array( '\\\\', '\\;', '\\,', '\\n', '\\n', '\\n' ),
		(string) $value
	);

	$line   = $name . ':' . $value;
	$folded = '';
	$limit  = 75;
	while ( strlen( $line ) > $limit ) {
		$cut = $limit;
		// Do not split inside a multi-byte UTF-8 character.
		while ( $cut > 0 && ( ord( $line[ $cut ] ) & 0xC0 ) === 0x80 ) {
			$cut--;
		}
		$folded .= substr( $line, 0, $cut ) . "\r\n ";
		$line    = substr( $line, $cut );
		$limit   = 74; // Continuation lines start with one space.
	}
	return $folded . $line;
}

/**
 * Generate iCalendar (.ics) content for an event.
 *
 * @param int $event_id Event post ID.
 * @return string ICS format string.
 */
function cr8v_tix_build_event_ics( $event_id ) {
	$event = get_post( $event_id );
	if ( ! $event || 'event' !== $event->post_type ) {
		return '';
	}
	// The download link is public, so it must not reveal drafts, private or trashed events.
	if ( 'publish' !== $event->post_status && ! current_user_can( 'edit_post', $event_id ) ) {
		return '';
	}

	$title       = wp_specialchars_decode( sanitize_text_field( $event->post_title ), ENT_QUOTES );
	$description = wp_specialchars_decode( wp_strip_all_tags( $event->post_excerpt ?: $event->post_content ), ENT_QUOTES );
	$venue       = sanitize_text_field( (string) get_post_meta( $event_id, '_cr8v_event_venue', true ) );
	$country     = sanitize_text_field( (string) get_post_meta( $event_id, '_cr8v_event_location', true ) );
	$location    = trim( $venue . ( ( $venue && $country ) ? ', ' : '' ) . $country );
	$date_raw    = (string) get_post_meta( $event_id, '_cr8v_event_date', true );

	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date_raw ) ) {
		$date_raw = current_time( 'Y-m-d' );
	}

	$tz = wp_timezone();
	$dt_start = new DateTimeImmutable( $date_raw . ' 19:00:00', $tz );
	$dt_end   = $dt_start->modify( '+4 hours' );

	$dtstart_utc = $dt_start->setTimezone( new DateTimeZone( 'UTC' ) )->format( 'Ymd\THis\Z' );
	$dtend_utc   = $dt_end->setTimezone( new DateTimeZone( 'UTC' ) )->format( 'Ymd\THis\Z' );
	$dtstamp_utc = gmdate( 'Ymd\THis\Z' );

	$host = parse_url( home_url(), PHP_URL_HOST ) ?: 'cruxnxtion.co.uk';
	$uid  = "event-{$event_id}-" . md5( $title ) . "@{$host}";

	$eol = "\r\n";
	$ics  = "BEGIN:VCALENDAR" . $eol;
	$ics .= "VERSION:2.0" . $eol;
	$ics .= "PRODID:-//Cr8v Stacks//Event Ticketing Engine//EN" . $eol;
	$ics .= "CALSCALE:GREGORIAN" . $eol;
	$ics .= "METHOD:PUBLISH" . $eol;
	$ics .= "BEGIN:VEVENT" . $eol;
	$ics .= "UID:" . $uid . $eol;
	$ics .= "DTSTAMP:" . $dtstamp_utc . $eol;
	$ics .= "DTSTART:" . $dtstart_utc . $eol;
	$ics .= "DTEND:" . $dtend_utc . $eol;
	$ics .= cr8v_tix_ics_line( 'SUMMARY', $title ) . $eol;
	$ics .= cr8v_tix_ics_line( 'DESCRIPTION', mb_substr( $description, 0, 250 ) ) . $eol;
	$ics .= cr8v_tix_ics_line( 'LOCATION', $location ) . $eol;
	$ics .= "STATUS:CONFIRMED" . $eol;
	$ics .= "END:VEVENT" . $eol;
	$ics .= "END:VCALENDAR" . $eol;

	return $ics;
}

/**
 * Generate verification QR link for a ticket code and its derived HMAC secret.
 *
 * @param string $ticket_code Public ticket code (TIX-XXXXXXXXXXXX).
 * @return string Full URL with verification parameters.
 */
function cr8v_tix_ticket_qr_link( $ticket_code ) {
	$secret = function_exists( 'cr8v_tix_ticket_secret' ) ? cr8v_tix_ticket_secret( $ticket_code ) : '';
	return add_query_arg(
		array(
			'cr8v_ticket' => sanitize_text_field( $ticket_code ),
			'tix_secret'  => $secret,
		),
		home_url( '/booking-confirmation/' )
	);
}

/**
 * Handle direct ICS calendar download requests.
 */
function cr8v_tix_handle_ics_download() {
	if ( isset( $_GET['cr8v_tix_download_ics'] ) && isset( $_GET['event_id'] ) ) {
		$event_id = absint( $_GET['event_id'] );
		$ics = cr8v_tix_build_event_ics( $event_id );
		if ( empty( $ics ) ) {
			wp_die( esc_html__( 'Event calendar not available.', 'cr8v-event-ticketing' ), 404 );
		}

		header( 'Content-Type: text/calendar; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="event-' . $event_id . '.ics"' );
		header( 'Cache-Control: no-cache, no-store, must-revalidate' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
		echo $ics;
		exit;
	}
}
add_action( 'template_redirect', 'cr8v_tix_handle_ics_download' );


/**
 * Generate a scannable QR code as a standalone SVG (real ISO 18004 symbol, no external requests).
 *
 * @param string $data URL or text to encode (up to roughly 210 bytes).
 * @param int    $size Rendered width/height in pixels.
 * @return string SVG markup, or an empty string if the data is too long to encode.
 */
function cr8v_tix_render_svg_qr( $data, $size = 180 ) {
	return Cr8v_Qr::svg( (string) $data, (int) $size );
}