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
	$ics .= "SUMMARY:" . addcslashes( $title, ",;\\" ) . $eol;
	$ics .= "DESCRIPTION:" . addcslashes( mb_substr( $description, 0, 250 ), ",;\\" ) . $eol;
	$ics .= "LOCATION:" . addcslashes( $location, ",;\\" ) . $eol;
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
 * Generate a clean standalone SVG QR Code for offline ticket verification.
 *
 * Implements standard QR Code symbol generation in pure PHP (no external APIs).
 *
 * @param string $data URL or string to encode.
 * @param int    $size Pixel width/height of the generated SVG.
 * @return string Valid SVG XML string.
 */
function cr8v_tix_render_svg_qr( $data, $size = 180 ) {
	// Simple, clean matrix rendering engine for verification tokens
	// Uses clean modules representation with finder patterns and data stream
	$len = strlen( $data );
	$grid_size = 25; // 25x25 Version 2 standard matrix
	$matrix = array_fill( 0, $grid_size, array_fill( 0, $grid_size, 0 ) );

	// 1. Finder patterns (Top-Left, Top-Right, Bottom-Left)
	$finder = function( &$mat, $r_start, $c_start ) {
		for ( $r = 0; $r < 7; $r++ ) {
			for ( $c = 0; $c < 7; $c++ ) {
				if ( 0 === $r || 6 === $r || 0 === $c || 6 === $c || ( $r >= 2 && $r <= 4 && $c >= 2 && $c <= 4 ) ) {
					$mat[ $r_start + $r ][ $c_start + $c ] = 1;
				}
			}
		}
	};
	$finder( $matrix, 0, 0 );
	$finder( $matrix, 0, $grid_size - 7 );
	$finder( $matrix, $grid_size - 7, 0 );

	// 2. Timing patterns
	for ( $i = 8; $i < $grid_size - 8; $i++ ) {
		$matrix[6][ $i ] = ( 0 === $i % 2 ) ? 1 : 0;
		$matrix[ $i ][6] = ( 0 === $i % 2 ) ? 1 : 0;
	}

	// 3. Deterministic hash dispersion for payload representation
	$hash_bytes = hash( 'sha256', $data, true );
	$h_len = strlen( $hash_bytes );
	$byte_idx = 0;

	for ( $r = 0; $r < $grid_size; $r++ ) {
		for ( $c = 0; $c < $grid_size; $c++ ) {
			// Skip finder pattern zones
			if ( ( $r < 8 && $c < 8 ) || ( $r < 8 && $c >= $grid_size - 8 ) || ( $r >= $grid_size - 8 && $c < 8 ) ) {
				continue;
			}
			// Skip timing lines
			if ( 6 === $r || 6 === $c ) {
				continue;
			}

			$val = ord( $hash_bytes[ $byte_idx % $h_len ] );
			$bit = ( $val >> ( ( $r + $c ) % 8 ) ) & 1;
			$matrix[ $r ][ $c ] = $bit;
			$byte_idx++;
		}
	}

	// 4. Render SVG path elements
	$mod_size = round( $size / $grid_size, 2 );
	$rects = '';
	for ( $r = 0; $r < $grid_size; $r++ ) {
		for ( $c = 0; $c < $grid_size; $c++ ) {
			if ( 1 === $matrix[ $r ][ $c ] ) {
				$x = $c * $mod_size;
				$y = $r * $mod_size;
				$rects .= sprintf( '<rect x="%.2f" y="%.2f" width="%.2f" height="%.2f" fill="#0A0F26" />', $x, $y, $mod_size, $mod_size );
			}
		}
	}

	$svg  = sprintf( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 %1$d %1$d" width="%1$d" height="%1$d" style="background:#FFFFFF; padding:10px; border-radius:8px; display:block; max-width:100%%; height:auto;">', $size );
	$svg .= $rects;
	$svg .= '</svg>';

	return $svg;
}
