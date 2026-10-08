<?php
/**
 * Crux Nxtion - Event seeder.
 *
 * Puts the eight existing Crux events into WordPress as real `event` posts, with EVERY piece of content in a
 * field the client can edit from the admin:
 *   title, short title, category, date, time, venue, country, summary (Excerpt), description (editor),
 *   booking link, ticket colour, Featured Image and Gallery images (Media Library).
 *
 * Rules (the client's edits always win):
 *   - A missing event is created.
 *   - An existing event only gets its EMPTY fields filled; text the client wrote is never replaced.
 *   - An event the client moved to the trash is left alone and never recreated.
 *   - Images are attached from the Media Library when the theme's images have been imported. Until then the
 *     page falls back to the theme's own copy of the photo, so nothing is ever blank.
 *   - Old web addresses (for example `lasgidi-mainland-party-ijgb-edition`) are renamed to the clean address;
 *     WordPress then redirects the old one.
 *
 * The data file `event-seed-data.php` is read only here, never when a page is shown.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CRUX_EVENT_SEED_VERSION', 3 );

/**
 * The original event content.
 */
function crux_event_seed_data() {
	static $data = null;
	if ( null === $data ) {
		$data = require get_template_directory() . '/inc/event-seed-data.php';
	}
	return $data;
}

/**
 * Media Library attachment ID for a design image ("blob") ID, or 0 when it has not been imported.
 */
function crux_blob_attachment_id( $blob ) {
	$map = get_option( 'crux_media_blob_map', array() );
	$id  = isset( $map[ strtolower( trim( (string) $blob ) ) ] ) ? (int) $map[ strtolower( trim( (string) $blob ) ) ] : 0;
	return ( $id && 'attachment' === get_post_type( $id ) ) ? $id : 0;
}

/**
 * True when neither the current nor the legacy copy of an event field holds a value.
 */
function crux_seed_field_empty( $post_id, $key ) {
	return '' === (string) get_post_meta( $post_id, '_cr8v_event_' . $key, true )
		&& '' === (string) get_post_meta( $post_id, '_crux_event_' . $key, true );
}

/**
 * True when the client has moved this event to the trash. WordPress renames a trashed post's address to
 * `<slug>__trashed`, so looking the clean address up finds nothing and the seeder would otherwise create the
 * event all over again.
 */
function crux_seed_event_is_trashed( $slug ) {
	global $wpdb;
	return (bool) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'event' AND post_status = 'trash' AND post_name IN ( %s, %s ) LIMIT 1",
			$slug,
			$slug . '__trashed'
		)
	);
}
/**
 * Seed the events.
 *
 * @param array|null $events Event rows (defaults to the bundled data).
 * @param string     $prefix Prefix for slugs; only used by tests so they never touch real events.
 * @return array Slug => 'created' | 'completed' | 'unchanged' | 'skipped (trashed)'.
 */
function crux_seed_events( $events = null, $prefix = '' ) {
	if ( ! post_type_exists( 'event' ) ) {
		return array();
	}
	$events = null === $events ? crux_event_seed_data() : $events;
	$report = array();

	foreach ( $events as $ev ) {
		$slug = $prefix . $ev['slug'];
		$post = get_page_by_path( $slug, OBJECT, 'event' );

		// Found under an old address? Move it to the clean one.
		if ( ! $post && ! empty( $ev['old_slugs'] ) ) {
			foreach ( $ev['old_slugs'] as $old ) {
				$old_post = get_page_by_path( $prefix . $old, OBJECT, 'event' );
				if ( $old_post && 'trash' !== $old_post->post_status ) {
					wp_update_post( array( 'ID' => $old_post->ID, 'post_name' => $slug ) );
					$post = get_post( $old_post->ID );
					break;
				}
			}
		}

		if ( ( $post && 'trash' === $post->post_status ) || ( ! $post && crux_seed_event_is_trashed( $slug ) ) ) {
			$report[ $slug ] = 'skipped (trashed)';
			continue;
		}

		$state = 'unchanged';
		if ( ! $post ) {
			$post_id = wp_insert_post(
				array(
					'post_type'    => 'event',
					'post_status'  => 'publish',
					'post_title'   => $ev['title'],
					'post_name'    => $slug,
					'post_excerpt' => $ev['excerpt'],
					'post_content' => $ev['content'],
				),
				true
			);
			if ( is_wp_error( $post_id ) || ! $post_id ) {
				continue;
			}
			$state = 'created';
			$post  = get_post( $post_id );
		}
		$id = $post->ID;

		// Summary and description: fill only if empty.
		$update = array();
		if ( '' === trim( (string) $post->post_excerpt ) && '' !== $ev['excerpt'] ) {
			$update['post_excerpt'] = $ev['excerpt'];
		}
		if ( '' === trim( (string) $post->post_content ) && '' !== $ev['content'] ) {
			$update['post_content'] = $ev['content'];
		}
		if ( $update ) {
			wp_update_post( array_merge( array( 'ID' => $id ), $update ) );
			$state = ( 'created' === $state ) ? 'created' : 'completed';
		}

		// Plain fields: fill only if empty.
		$fields = array(
			'date'        => $ev['date'],
			'time'        => $ev['time'],
			'venue'       => $ev['venue'],
			'location'    => $ev['country'],
			'category'    => $ev['category'],
			'short_title' => $ev['short_title'],
			'eventbrite'  => $ev['booking_url'],
		);
		foreach ( $fields as $key => $value ) {
			if ( '' !== (string) $value && crux_seed_field_empty( $id, $key ) ) {
				update_post_meta( $id, '_cr8v_event_' . $key, $value );
				$state = ( 'created' === $state ) ? 'created' : 'completed';
			}
		}
		if ( '' === (string) get_post_meta( $id, '_cr8v_event_badge_style', true ) && '' === (string) get_post_meta( $id, '_cr8v_event_badge_bg', true ) ) {
			update_post_meta( $id, '_cr8v_event_badge_style', $ev['badge_style'] );
		}

		// Photos: the theme's own copy stays as a fallback until the Media Library copy exists.
		if ( '' === (string) get_post_meta( $id, '_cr8v_event_hero_blob', true ) ) {
			update_post_meta( $id, '_cr8v_event_hero_blob', $ev['hero_blob'] );
		}
		if ( ! get_post_meta( $id, '_cr8v_event_gallery', true ) ) {
			update_post_meta( $id, '_cr8v_event_gallery', $ev['gallery_blobs'] );
		}
		if ( crux_seed_event_images( $id, $ev ) ) {
			$state = ( 'created' === $state ) ? 'created' : 'completed';
		}

		update_post_meta( $id, '_crux_seed_version', CRUX_EVENT_SEED_VERSION );
		$report[ $slug ] = $state;
	}

	return $report;
}

/**
 * Attach the Featured Image and Gallery from the Media Library, once, when they are available.
 * After they are attached the marker `_crux_seed_images` stops this from ever running again for that
 * event, so a client who later removes or replaces a photo is never overruled.
 *
 * @return bool True when something was attached.
 */
function crux_seed_event_images( $post_id, $ev ) {
	if ( get_post_meta( $post_id, '_crux_seed_images', true ) ) {
		return false;
	}

	$did  = false;
	$hero = crux_blob_attachment_id( $ev['hero_blob'] );
	if ( $hero && ! has_post_thumbnail( $post_id ) ) {
		set_post_thumbnail( $post_id, $hero );
		$did = true;
	}

	if ( '' === trim( (string) get_post_meta( $post_id, '_cr8v_event_gallery_ids', true ) ) ) {
		$ids = array();
		foreach ( (array) $ev['gallery_blobs'] as $blob ) {
			$att = crux_blob_attachment_id( $blob );
			if ( $att ) {
				$ids[] = $att;
			}
		}
		if ( $ids ) {
			update_post_meta( $post_id, '_cr8v_event_gallery_ids', implode( ',', array_slice( $ids, 0, 12 ) ) );
			$did = true;
		}
	}

	if ( $hero && '' !== trim( (string) get_post_meta( $post_id, '_cr8v_event_gallery_ids', true ) ) ) {
		update_post_meta( $post_id, '_crux_seed_images', 1 );
	}
	return $did;
}

/**
 * Run once per install. Creating the posts is fast and safe on any request; the slow Media Library import
 * only ever runs from wp-admin.
 */
function crux_maybe_seed_events() {
	if ( '1' === get_option( 'crux_events_seed_done_v3' ) || ! post_type_exists( 'event' ) ) {
		return;
	}
	if ( get_transient( 'crux_events_seed_lock' ) ) {
		return;
	}
	set_transient( 'crux_events_seed_lock', 1, 60 );

	if ( is_admin() && empty( get_option( 'crux_media_blob_map', array() ) ) && function_exists( 'crux_sync_all_media_to_library' ) ) {
		if ( function_exists( 'set_time_limit' ) ) {
			@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		}
		crux_sync_all_media_to_library();
	}

	crux_seed_events();

	// Finished once every event has its Media Library photos (or after the images could not be found).
	$pending = 0;
	foreach ( crux_event_seed_data() as $ev ) {
		$post = get_page_by_path( $ev['slug'], OBJECT, 'event' );
		if ( $post && 'trash' !== $post->post_status && ! get_post_meta( $post->ID, '_crux_seed_images', true ) ) {
			$pending++;
		}
	}
	if ( 0 === $pending || is_admin() ) {
		update_option( 'crux_events_seed_done_v3', '1' );
	}
	delete_transient( 'crux_events_seed_lock' );
}
add_action( 'init', 'crux_maybe_seed_events', 30 );
add_action( 'admin_init', 'crux_maybe_seed_events', 30 );
