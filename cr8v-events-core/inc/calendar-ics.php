<?php
/**
 * Dynamic Calendar & Past-Event Helper Functions
 *
 * @package Cr8v_Events_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if an event has passed
 *
 * @param int $post_id
 * @return bool
 */
if ( ! function_exists( 'cr8v_is_event_past' ) ) {
	function cr8v_is_event_past( $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$event_date = get_post_meta( $post_id, '_cr8v_event_date', true );
		if ( empty( $event_date ) ) {
			return false;
		}

		$trimmed = trim( (string) $event_date );

		// If purely 4-digit year (e.g. "2026"), compare year against current year
		if ( preg_match( '/^\d{4}$/', $trimmed ) ) {
			$event_year = intval( $trimmed );
			$current_year = intval( current_time( 'Y' ) );
			return ( $event_year < $current_year );
		}

		// If Year-Month without day (e.g. "2026-08", "2024-12")
		if ( preg_match( '/^\d{4}-\d{2}$/', $trimmed ) ) {
			$ts = strtotime( $trimmed . '-01' );
			if ( $ts ) {
				$end_of_month = strtotime( date( 'Y-m-t 23:59:59', $ts ) );
				return ( $end_of_month < current_time( 'timestamp' ) );
			}
		}

		$event_timestamp = strtotime( $trimmed . ' 23:59:59' );
		if ( ! $event_timestamp ) {
			return false;
		}

		$current_timestamp = current_time( 'timestamp' );
		return ( $event_timestamp < $current_timestamp );
	}
}

/**
 * Format event date into military/editorial pill format (e.g. '18 JUL 2026' or '2026')
 *
 * @param int $post_id
 * @return string
 */
if ( ! function_exists( 'cr8v_get_event_formatted_date' ) ) {
	function cr8v_get_event_formatted_date( $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$event_date = get_post_meta( $post_id, '_cr8v_event_date', true );
		if ( empty( $event_date ) ) {
			return '';
		}

		$trimmed = trim( (string) $event_date );

		// 1. Pure 4-digit year (e.g. "2026", "2021", "2023")
		if ( preg_match( '/^\d{4}$/', $trimmed ) ) {
			return $trimmed;
		}

		// 2. Year-Month without day (e.g. "2026-05")
		if ( preg_match( '/^\d{4}-\d{2}$/', $trimmed ) ) {
			$ts = strtotime( $trimmed . '-01' );
			return $ts ? strtoupper( date( 'M Y', $ts ) ) : $trimmed;
		}

		// 3. Check for year-only precision flag
		$year_only = get_post_meta( $post_id, '_cr8v_event_year_only', true );
		if ( $year_only ) {
			$ts = strtotime( $trimmed );
			return $ts ? date( 'Y', $ts ) : $trimmed;
		}

		// 4. Standard full ISO date (YYYY-MM-DD)
		$timestamp = strtotime( $trimmed );
		if ( $timestamp ) {
			return strtoupper( date( 'd M Y', $timestamp ) );
		}

		return $trimmed;
	}
}

/**
 * Render the Calendar Sync button (active vs grayed-out disabled)
 *
 * @param int $post_id
 * @param array $args
 */
if ( ! function_exists( 'cr8v_render_calendar_button' ) ) {
	function cr8v_render_calendar_button( $post_id = null, $args = array() ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$is_past = cr8v_is_event_past( $post_id );
		$extra_styles = isset( $args['style'] ) ? 'style="' . esc_attr( $args['style'] ) . '"' : '';

		if ( $is_past ) {
			// Grayed-out, disabled, non-clickable button
			?>
			<button class="bwc-btn bwc-btn-disabled" disabled <?php echo $extra_styles; ?> title="<?php esc_attr_e( 'This event has concluded', 'cr8v-events-core' ); ?>">
				<i class="fa-solid fa-calendar-check"></i> <?php _e( 'Event Concluded', 'cr8v-events-core' ); ?>
			</button>
			<?php
		} else {
			// Active calendar sync button triggering .ics download
			$download_url = add_query_arg( array(
				'cr8v_action' => 'download_ics',
				'event_id'    => $post_id,
				'nonce'       => wp_create_nonce( 'cr8v_ics_' . $post_id ),
			), home_url( '/' ) );
			?>
			<a href="<?php echo esc_url( $download_url ); ?>" class="bwc-btn bwc-btn-dark" <?php echo $extra_styles; ?>>
				<i class="fa-solid fa-calendar-plus"></i> <?php _e( 'Calendar Sync', 'cr8v-events-core' ); ?>
			</a>
			<?php
		}
	}
}

if ( ! function_exists( 'cr8v_get_add_to_calendar_button' ) ) {
	function cr8v_get_add_to_calendar_button( $post_id = null, $args = array() ) {
		if ( function_exists( 'cr8v_render_calendar_button' ) ) {
			ob_start();
			cr8v_render_calendar_button( $post_id, $args );
			return ob_get_clean();
		}
		return '';
	}
}

/**
 * Handle ICS file generation and download
 */
if ( ! function_exists( 'cr8v_handle_ics_download' ) ) {
	function cr8v_handle_ics_download() {
		if ( isset( $_GET['cr8v_action'] ) && $_GET['cr8v_action'] === 'download_ics' && isset( $_GET['event_id'] ) ) {
			$event_id = intval( $_GET['event_id'] );
			$nonce    = isset( $_GET['nonce'] ) ? sanitize_text_field( $_GET['nonce'] ) : '';

			if ( ! wp_verify_nonce( $nonce, 'cr8v_ics_' . $event_id ) ) {
				wp_die( __( 'Security check failed.', 'cr8v-events-core' ) );
			}

			$event = get_post( $event_id );
			if ( ! $event || $event->post_type !== 'event' ) {
				wp_die( __( 'Event not found.', 'cr8v-events-core' ) );
			}

			$title       = $event->post_title;
			$description = wp_strip_all_tags( $event->post_content );
			$venue       = get_post_meta( $event_id, '_cr8v_event_venue', true );
			$date_str    = get_post_meta( $event_id, '_cr8v_event_date', true );

			if ( empty( $date_str ) ) {
				wp_die( __( 'Event date missing.', 'cr8v-events-core' ) );
			}

			$dtstart = date( 'Ymd\THis', strtotime( $date_str . ' 18:00:00' ) );
			$dtend   = date( 'Ymd\THis', strtotime( $date_str . ' 23:30:00' ) );
			$dtstamp = gmdate( 'Ymd\THis\Z' );
			$uid     = 'event-' . $event_id . '@' . parse_url( home_url(), PHP_URL_HOST );

			header( 'Content-Type: text/calendar; charset=utf-8' );
			header( 'Content-Disposition: attachment; filename="event-' . $event_id . '.ics"' );

			echo "BEGIN:VCALENDAR\r\n";
			echo "VERSION:2.0\r\n";
			echo "PRODID:-//Cr8v Stacks//Events Core//EN\r\n";
			echo "CALSCALE:GREGORIAN\r\n";
			echo "METHOD:PUBLISH\r\n";
			echo "BEGIN:VEVENT\r\n";
			echo "UID:" . $uid . "\r\n";
			echo "DTSTAMP:" . $dtstamp . "\r\n";
			echo "DTSTART:" . $dtstart . "\r\n";
			echo "DTEND:" . $dtend . "\r\n";
			echo "SUMMARY:" . esc_attr( $title ) . "\r\n";
			echo "DESCRIPTION:" . esc_attr( $description ) . "\r\n";
			echo "LOCATION:" . esc_attr( $venue ) . "\r\n";
			echo "STATUS:CONFIRMED\r\n";
			echo "END:VEVENT\r\n";
			echo "END:VCALENDAR\r\n";
			exit;
		}
	}
	add_action( 'template_redirect', 'cr8v_handle_ics_download' );
}
