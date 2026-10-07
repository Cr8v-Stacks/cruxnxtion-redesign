<?php
/**
 * Crux Nxtion - Event Engine (database only)
 *
 * Reads events from the `event` post type. The WordPress admin is the single
 * source of truth: a trashed, draft or deleted event does not render, and a
 * new event appears as soon as it is published. Field editing lives in the
 * `cr8v-event-ticketing` plugin (Event Details meta box, `_cr8v_event_*` keys).
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Badge presets. Free-form colours are never read from the database, so a bad
 * value cannot reach an inline style attribute.
 */
function crux_event_badge_presets() {
	return array(
		'blue'   => array( 'bg' => '#002671', 'color' => '#FFFFFF' ),
		'red'    => array( 'bg' => '#BA0000', 'color' => '#FFFFFF' ),
		'purple' => array( 'bg' => '#8C7AE6', 'color' => '#10142E' ),
	);
}

/**
 * Read an event field: `_cr8v_event_{key}` first, then the legacy `_crux_event_{key}`.
 */
function crux_event_meta( $post_id, $key ) {
	$value = get_post_meta( $post_id, '_cr8v_event_' . $key, true );
	if ( '' === $value || null === $value || false === $value ) {
		$value = get_post_meta( $post_id, '_crux_event_' . $key, true );
	}
	return is_scalar( $value ) ? (string) $value : '';
}

/**
 * Resolve the badge colours for an event from a preset name or, for legacy
 * seeded posts, from the stored background hex (matched against the presets).
 */
function crux_event_resolve_badge( $post_id ) {
	$presets = crux_event_badge_presets();
	$style   = sanitize_key( crux_event_meta( $post_id, 'badge_style' ) );
	if ( isset( $presets[ $style ] ) ) {
		return $presets[ $style ];
	}
	$legacy_bg = strtoupper( (string) get_post_meta( $post_id, '_cr8v_event_badge_bg', true ) );
	foreach ( $presets as $preset ) {
		if ( strtoupper( $preset['bg'] ) === $legacy_bg ) {
			return $preset;
		}
	}
	return $presets['blue'];
}

/**
 * Event IDs to hide on this install only (development databases that share
 * posts with another brand). Define CRUX_EVENTS_EXCLUDE_IDS in wp-config.php,
 * e.g. define( 'CRUX_EVENTS_EXCLUDE_IDS', '1625,1626' ). Production: leave unset.
 */
function crux_event_excluded_ids() {
	if ( ! defined( 'CRUX_EVENTS_EXCLUDE_IDS' ) ) {
		return array();
	}
	return array_filter( array_map( 'absint', explode( ',', (string) CRUX_EVENTS_EXCLUDE_IDS ) ) );
}

/**
 * Parse a stored Y-m-d date in the site timezone. Returns a DateTimeImmutable or null.
 */
function crux_event_parse_date( $raw ) {
	$raw = trim( (string) $raw );
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $raw ) ) {
		return null;
	}
	$dt = DateTimeImmutable::createFromFormat( '!Y-m-d', $raw, wp_timezone() );
	return ( $dt && $dt->format( 'Y-m-d' ) === $raw ) ? $dt : null;
}

/**
 * Resolve the hero image URL: featured image, else legacy design blob, else a neutral blob.
 */
function crux_event_hero_url( $post_id ) {
	$thumb = get_the_post_thumbnail_url( $post_id, 'large' );
	if ( $thumb ) {
		return $thumb;
	}
	$blob = sanitize_key( get_post_meta( $post_id, '_cr8v_event_hero_blob', true ) );
	if ( '' === $blob ) {
		$blob = 'c5afda4fc4e4d4b0682377d6eb272c90';
	}
	return crux_get_blob_url( $blob );
}

/**
 * Resolve gallery image URLs: Media Library IDs, else legacy design blob IDs.
 */
function crux_event_gallery_urls( $post_id ) {
	$urls = array();
	$ids  = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post_id, '_cr8v_event_gallery_ids', true ) ) ) );
	foreach ( $ids as $att_id ) {
		$url = wp_get_attachment_image_url( $att_id, 'large' );
		if ( $url ) {
			$urls[] = $url;
		}
	}
	if ( $urls ) {
		return $urls;
	}
	$legacy = get_post_meta( $post_id, '_cr8v_event_gallery', true );
	foreach ( (array) $legacy as $blob ) {
		$blob = sanitize_key( $blob );
		if ( '' !== $blob ) {
			$urls[] = crux_get_blob_url( $blob );
		}
	}
	return $urls;
}

/**
 * Build the structured data array for one published event post.
 */
function crux_event_build_data( $post ) {
	$id    = $post->ID;
	$date  = crux_event_parse_date( crux_event_meta( $id, 'date' ) );
	$badge = crux_event_resolve_badge( $id );

	$rotations = array( '1deg', '-1deg', '0.8deg', '-0.6deg' );
	$rotation  = crux_event_meta( $id, 'rotation' );
	if ( ! preg_match( '/^-?\d(\.\d)?deg$/', $rotation ) ) {
		$rotation = $rotations[ $id % 4 ];
	}

	$booking = esc_url_raw( crux_event_meta( $id, 'eventbrite' ), array( 'http', 'https' ) );
	$venue   = crux_event_meta( $id, 'venue' );

	return array(
		'id'               => $id,
		'slug'             => $post->post_name,
		'permalink'        => get_permalink( $id ),
		'title'            => mb_strtoupper( $post->post_title, 'UTF-8' ),
		'short_title'      => crux_event_meta( $id, 'short_title' ) ?: $post->post_title,
		'category'         => crux_event_meta( $id, 'category' ),
		'date_raw'         => $date ? $date->format( 'Y-m-d' ) : '',
		'year'             => $date ? $date->format( 'Y' ) : '',
		'date_badge_day'   => $date ? $date->format( 'd' ) : '',
		'date_badge_month' => $date ? mb_strtoupper( wp_date( 'M', $date->getTimestamp(), wp_timezone() ) ) : '',
		'date_str'         => $date ? wp_date( 'l, j F Y', $date->getTimestamp(), wp_timezone() ) : '',
		'time_str'         => crux_event_meta( $id, 'time' ),
		'location'         => $venue,
		'country'          => crux_event_meta( $id, 'location' ),
		'desc_1'           => $post->post_excerpt,
		'desc_2'           => wp_strip_all_tags( $post->post_content ),
		'hero_url'         => crux_event_hero_url( $id ),
		'gallery_urls'     => crux_event_gallery_urls( $id ),
		'eventbrite'       => $booking,
		'badge_bg'         => $badge['bg'],
		'badge_color'      => $badge['color'],
		'rotation'         => $rotation,
		'is_past'          => $date ? ( $date->getTimestamp() < strtotime( 'today', current_time( 'timestamp' ) ) ) : false,
	);
}

/**
 * Resolve one event by slug, post ID or WP_Post. Returns null unless the event
 * is a published `event` post, so unknown, draft and trashed events 404.
 */
function crux_get_event_data( $identifier = null ) {
	$post = null;
	if ( $identifier instanceof WP_Post ) {
		$post = $identifier;
	} elseif ( is_numeric( $identifier ) ) {
		$post = get_post( (int) $identifier );
	} elseif ( is_string( $identifier ) && '' !== $identifier ) {
		$post = get_page_by_path( sanitize_title( $identifier ), OBJECT, 'event' );
	}

	if ( ! $post || 'event' !== $post->post_type ) {
		return null;
	}
	// Visitors only see published events. Editors may preview their own drafts.
	if ( 'publish' !== $post->post_status && ! ( is_user_logged_in() && current_user_can( 'edit_post', $post->ID ) ) ) {
		return null;
	}
	if ( in_array( (int) $post->ID, crux_event_excluded_ids(), true ) ) {
		return null;
	}
	return crux_event_build_data( $post );
}

/**
 * Query events, newest first by default.
 *
 * @param array $args {
 *     @type string $scope          'all' (default), 'upcoming' (soonest first) or 'past' (latest first).
 *     @type int    $posts_per_page Default -1.
 * }
 * @return array Slug-keyed array of event data. Empty when there are no events.
 */
function crux_get_all_events( $args = array() ) {
	$args  = wp_parse_args( $args, array( 'scope' => 'all', 'posts_per_page' => -1 ) );
	$scope = in_array( $args['scope'], array( 'all', 'upcoming', 'past' ), true ) ? $args['scope'] : 'all';
	$today = wp_date( 'Y-m-d' );

	$date_clause = array( 'key' => '_cr8v_event_date', 'compare' => 'EXISTS', 'type' => 'DATE' );
	$order       = 'DESC';

	if ( 'upcoming' === $scope ) {
		$date_clause = array( 'key' => '_cr8v_event_date', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' );
		$order       = 'ASC';
	} elseif ( 'past' === $scope ) {
		$date_clause = array( 'key' => '_cr8v_event_date', 'value' => $today, 'compare' => '<', 'type' => 'DATE' );
	}

	// 'all' also lists events that have no date yet (they sort last); 'upcoming' and 'past' need a date.
	$meta_query = array( 'relation' => 'OR', 'ev_date' => $date_clause );
	if ( 'all' === $scope ) {
		$meta_query['ev_none'] = array( 'key' => '_cr8v_event_date', 'compare' => 'NOT EXISTS' );
	}

	$query = new WP_Query( array(
		'post_type'           => 'event',
		'post_status'         => 'publish',
		'posts_per_page'      => (int) $args['posts_per_page'],
		'post__not_in'        => crux_event_excluded_ids(),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'meta_query'          => $meta_query,
		'orderby'             => array( 'ev_date' => $order, 'title' => 'ASC' ),
	) );

	$events = array();
	foreach ( $query->posts as $post ) {
		$events[ $post->post_name ] = crux_event_build_data( $post );
	}
	return $events;
}
