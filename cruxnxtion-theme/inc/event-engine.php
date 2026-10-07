<?php
/**
 * Crux Nxtion - Dynamic Event Engine & Query Helpers
 *
 * Provides centralized data-driven event queries and metadata resolution
 * across single-event.php, page-events.php, archive-event.php, and front-page.php.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Master Fallback Event Catalog (site.json & design reference)
 * Used as default metadata fallback if any specific meta field is empty.
 */
function crux_get_event_catalog() {
	return array(
		'dance-out-2023' => array(
			'title'            => 'DANCE OUT 2023 WITH CRUX NXTION EVENTS',
			'short_title'      => 'Dance OUT 2023',
			'category'         => 'Dance Night',
			'date_badge_day'   => '16',
			'date_badge_month' => 'DEC',
			'date_str'         => 'Saturday, 16 December 2023',
			'time_str'         => '10:00 PM — Late',
			'date_raw'         => '2023-12-16',
			'location'         => 'Sheffield',
			'country'          => 'United Kingdom',
			'hero_image'       => 'b094675514894aa0d8e7dd735d187b22',
			'desc_1'           => 'Get ready to groove and move like never before with Dance Out 2023! This electrifying night is set to ignite the dance floor and send you home with a story to tell.',
			'desc_2'           => 'Tickets and full details are on Eventbrite. Want a night like this for your own crowd? Our crew plans, books and runs it end to end.',
			'gallery'          => array( 'c5afda4fc4e4d4b0682377d6eb272c90', '1d5292715423e2e83b56b3330a94b3b8', 'c5afda4fc4e4d4b0682377d6eb272c90' ),
			'eventbrite'       => 'https://www.eventbrite.co.uk/e/dance-out-2023-with-crux-nxtion-events-tickets-769718547897',
			'badge_bg'         => '#002671',
			'badge_color'      => '#FFFFFF',
			'rotation'         => '1deg',
		),
		'becoming-mr-mrs-crux-pt-3' => array(
			'title'            => 'BECOMING MR & MRS CRUX PT.3',
			'short_title'      => 'Becoming Mr & Mrs Crux Pt.3',
			'category'         => 'Couples & Wedding Showcase',
			'date_badge_day'   => '23',
			'date_badge_month' => 'APR',
			'date_str'         => 'Wednesday, 23 April 2025',
			'time_str'         => '14:00 — Late',
			'date_raw'         => '2025-04-23',
			'location'         => 'Sheffield & Destination UK',
			'country'          => 'United Kingdom',
			'hero_image'       => '2f9f2834d9f0829e887b03bccc208656',
			'desc_1'           => 'The premier cultural and luxury wedding experience by Crux Nxtion. A celebration of love, exquisite event styling, vibrant guest coordination, and world-class live entertainment.',
			'desc_2'           => 'Tickets and full details are on Eventbrite. Planning a high-profile luxury wedding, cultural ceremony, or anniversary celebration? Our specialized team delivers bespoke decor, production, and seamless day-of management.',
			'gallery'          => array( '53df70ef86c4b1d32979af070d98a399', '2f9f2834d9f0829e887b03bccc208656', 'a15ea8703f82f1d0f8577325e8d85a3b' ),
			'eventbrite'       => 'https://www.eventbrite.co.uk/',
			'badge_bg'         => '#002671',
			'badge_color'      => '#FFFFFF',
			'rotation'         => '-1deg',
		),
		'lasgidi-mainland-party' => array(
			'title'            => 'LASGIDI MAINLAND PARTY (IJGB EDITION)',
			'short_title'      => 'LASGIDI Mainland Party',
			'category'         => 'Nightlife & Cultural Party',
			'date_badge_day'   => '25',
			'date_badge_month' => 'JAN',
			'date_str'         => 'Saturday, 25 January 2025',
			'time_str'         => '10:00 PM — Late',
			'date_raw'         => '2025-01-25',
			'location'         => 'Sheffield',
			'country'          => 'United Kingdom',
			'hero_image'       => 'a15ea8703f82f1d0f8577325e8d85a3b',
			'desc_1'           => 'Bringing authentic Mainland energy straight to the UK club scene. Packed rooms, high-energy Afrobeats, Amapiano, and top DJs keeping the floor moving until the early hours.',
			'desc_2'           => 'Tickets and full details are on Eventbrite. Looking to curate an unforgettable nightlife experience, college party, or club takeover? Crux Nxtion handles venue sourcing, talent booking, security, and full-scale promotion.',
			'gallery'          => array( '1d5292715423e2e83b56b3330a94b3b8', 'b094675514894aa0d8e7dd735d187b22', 'c5afda4fc4e4d4b0682377d6eb272c90' ),
			'eventbrite'       => 'https://www.eventbrite.co.uk/e/lasgidi-mainland-party-ijgb-edition-tickets-1134178371039',
			'badge_bg'         => '#BA0000',
			'badge_color'      => '#FFFFFF',
			'rotation'         => '0.8deg',
		),
		'ankara-festival' => array(
			'title'            => 'ANKARA FESTIVAL UK',
			'short_title'      => 'Ankara Festival',
			'category'         => 'Cultural Festival',
			'date_badge_day'   => '30',
			'date_badge_month' => 'NOV',
			'date_str'         => 'Saturday, 30 November 2024',
			'time_str'         => '14:00 — Late',
			'date_raw'         => '2024-11-30',
			'location'         => 'Sheffield',
			'country'          => 'United Kingdom',
			'hero_image'       => '11316a3d9c4317e3d5b7f755df227497',
			'desc_1'           => 'A vibrant celebration of African heritage, runway fashion, culinary delights, and live musical performances uniting communities across Yorkshire and the UK.',
			'desc_2'           => 'Tickets and full details are on Eventbrite. Crux Nxtion produces large-scale community festivals, multi-vendor marketplaces, and indoor/outdoor cultural exhibitions with complete staging and licensing.',
			'gallery'          => array( '11316a3d9c4317e3d5b7f755df227497', '99a3c292f4b3a38d253144801b4a9ae3', 'c5afda4fc4e4d4b0682377d6eb272c90' ),
			'eventbrite'       => 'https://www.eventbrite.co.uk/e/ankara-festival-tickets-1070427991939',
			'badge_bg'         => '#8C7AE6',
			'badge_color'      => '#10142E',
			'rotation'         => '-0.6deg',
		),
		'yagi-awards' => array(
			'title'            => 'YAGI AWARDS UK',
			'short_title'      => 'YAGI Awards',
			'category'         => 'Awards Gala',
			'date_badge_day'   => '28',
			'date_badge_month' => 'APR',
			'date_str'         => 'Friday, 28 April 2023',
			'time_str'         => '14:30 — Evening',
			'date_raw'         => '2023-04-28',
			'location'         => 'Sheffield',
			'country'          => 'United Kingdom',
			'hero_image'       => 'fa3286e8f930ebdb28b28c54198542fa',
			'desc_1'           => 'Recognizing outstanding achievements and rising stars across entertainment, leadership, and culture. An elegant red carpet ceremony with banquet dining and prestige keynote honors.',
			'desc_2'           => 'Tickets and full details are on Eventbrite. Planning a corporate awards night, charity gala, or recognition ceremony? Crux Nxtion provides red carpet production, awards logistics, and VIP hospitality.',
			'gallery'          => array( 'fa3286e8f930ebdb28b28c54198542fa', '4795dc48859e2b9d81b42757c6317d14', 'c5afda4fc4e4d4b0682377d6eb272c90' ),
			'eventbrite'       => 'https://www.eventbrite.co.uk/e/yagi-awards-tickets-623479482917',
			'badge_bg'         => '#BA0000',
			'badge_color'      => '#FFFFFF',
			'rotation'         => '-1deg',
		),
		'millennials-vs-gen-z' => array(
			'title'            => 'MILLENNIALS VS GEN Z',
			'short_title'      => 'Millennials vs Gen Z',
			'category'         => 'Games Night',
			'date_badge_day'   => '29',
			'date_badge_month' => 'JAN',
			'date_str'         => 'Sunday, 29 January 2023',
			'time_str'         => '17:00 — Late',
			'date_raw'         => '2023-01-29',
			'location'         => 'Sheffield',
			'country'          => 'United Kingdom',
			'hero_image'       => '317371ca97a92f79584d7ff4bae33069',
			'desc_1'           => 'The ultimate trivia, games, karaoke, and banter clash between generations. Interactive team challenges with non-stop laughter and audience participation.',
			'desc_2'           => 'Tickets and full details are on Eventbrite. We curate customized team-building games, corporate social mixers, and community trivia nights designed to break the ice and build genuine connections.',
			'gallery'          => array( '317371ca97a92f79584d7ff4bae33069', 'c5afda4fc4e4d4b0682377d6eb272c90', '1d5292715423e2e83b56b3330a94b3b8' ),
			'eventbrite'       => 'https://www.eventbrite.co.uk/e/millenials-vs-gen-z-tickets-494953558417',
			'badge_bg'         => '#8C7AE6',
			'badge_color'      => '#10142E',
			'rotation'         => '0.8deg',
		),
		'the-wedding-party' => array(
			'title'            => 'THE WEDDING PARTY',
			'short_title'      => 'The Wedding Party',
			'category'         => 'Wedding Showcase',
			'date_badge_day'   => '27',
			'date_badge_month' => 'AUG',
			'date_str'         => 'Saturday, 27 August 2022',
			'time_str'         => '15:00 — Late',
			'date_raw'         => '2022-08-27',
			'location'         => 'Sheffield',
			'country'          => 'United Kingdom',
			'hero_image'       => '53df70ef86c4b1d32979af070d98a399',
			'desc_1'           => 'A magical wedding reception bringing together families and friends for an unforgettable feast, heartfelt toasts, and an electric after-party on the dance floor.',
			'desc_2'           => 'Tickets and full details are on Eventbrite. Let Crux Nxtion take the stress out of your wedding planning. We coordinate decor, catering, photography, sound, and the master of ceremonies seamlessly.',
			'gallery'          => array( '53df70ef86c4b1d32979af070d98a399', '2f9f2834d9f0829e887b03bccc208656', 'c5afda4fc4e4d4b0682377d6eb272c90' ),
			'eventbrite'       => 'https://www.eventbrite.co.uk/e/the-wedding-party-tickets-356808492807',
			'badge_bg'         => '#002671',
			'badge_color'      => '#FFFFFF',
			'rotation'         => '-0.6deg',
		),
		'crux-nxtion-hangout' => array(
			'title'            => 'CRUX NXTION HANGOUT OUT',
			'short_title'      => 'Crux Nxtion Hangout',
			'category'         => 'Social Mixer',
			'date_badge_day'   => '25',
			'date_badge_month' => 'SEP',
			'date_str'         => 'Saturday, 25 September 2021',
			'time_str'         => '18:00 — Late',
			'date_raw'         => '2021-09-25',
			'location'         => 'Sheffield',
			'country'          => 'United Kingdom',
			'hero_image'       => '352a5c10108a75b7cb713fd1433b8b36',
			'desc_1'           => 'An intimate gathering for networking, good music, drinks, and lively discussions with creative minds and entrepreneurs in Sheffield.',
			'desc_2'           => 'Tickets and full details are on Eventbrite. We organize private mixers, brand launch parties, and influencer meetups crafted with an authentic, relaxed atmosphere.',
			'gallery'          => array( '352a5c10108a75b7cb713fd1433b8b36', 'c5afda4fc4e4d4b0682377d6eb272c90', '1d5292715423e2e83b56b3330a94b3b8' ),
			'eventbrite'       => 'https://www.eventbrite.co.uk/e/crux-nxtion-hangout-out-tickets-168482853751',
			'badge_bg'         => '#BA0000',
			'badge_color'      => '#FFFFFF',
			'rotation'         => '1deg',
		),
	);
}

/**
 * 2. Resolve Single Event Data (by Post ID, Post Object, or Slug)
 *
 * @param int|WP_Post|string|null $identifier Optional post ID, object, or slug.
 * @return array|null Complete structured event data array or null if not found.
 */
function crux_get_event_data( $identifier = null ) {
	$catalog = crux_get_event_catalog();
	$post = null;

	// Resolve post object
	if ( is_a( $identifier, 'WP_Post' ) ) {
		$post = $identifier;
	} elseif ( is_numeric( $identifier ) ) {
		$post = get_post( (int) $identifier );
	} elseif ( is_string( $identifier ) && ! empty( $identifier ) ) {
		$slug = sanitize_title( $identifier );
		$post = get_page_by_path( $slug, OBJECT, 'event' );
		if ( ! $post && isset( $catalog[ $slug ] ) ) {
			// Found in catalog by slug
			$cat_data = $catalog[ $slug ];
			$cat_data['slug'] = $slug;
			$cat_data['id'] = 0;
			return $cat_data;
		}
	} else {
		// Detect from current WordPress loop or global post
		global $post;
		if ( ! $post || $post->post_type !== 'event' ) {
			// Check URL slug
			$req_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$parts = array_filter( explode( '/', trim( parse_url( $req_uri, PHP_URL_PATH ), '/' ) ) );
			$slug = end( $parts );
			if ( $slug ) {
				$post = get_page_by_path( $slug, OBJECT, 'event' );
				if ( ! $post && isset( $catalog[ $slug ] ) ) {
					$cat_data = $catalog[ $slug ];
					$cat_data['slug'] = $slug;
					$cat_data['id'] = 0;
					return $cat_data;
				}
			}
		}
	}

	if ( ! $post || $post->post_status !== 'publish' ) {
		return null;
	}

	$slug = $post->post_name;
	$defaults = isset( $catalog[ $slug ] ) ? $catalog[ $slug ] : array();

	// Read fields with _cr8v_* primary and _crux_* fallback
	$date_raw = get_post_meta( $post->ID, '_cr8v_event_date', true ) ?: get_post_meta( $post->ID, '_crux_event_date', true ) ?: ( $defaults['date_raw'] ?? '' );
	$time_str = get_post_meta( $post->ID, '_cr8v_event_time', true ) ?: get_post_meta( $post->ID, '_crux_event_time', true ) ?: ( $defaults['time_str'] ?? 'Evening — Late' );
	$venue    = get_post_meta( $post->ID, '_cr8v_event_venue', true ) ?: get_post_meta( $post->ID, '_crux_event_venue', true ) ?: ( $defaults['location'] ?? 'Sheffield' );
	$country  = get_post_meta( $post->ID, '_cr8v_event_location', true ) ?: ( $defaults['country'] ?? 'United Kingdom' );
	$category = get_post_meta( $post->ID, '_cr8v_event_category', true ) ?: get_post_meta( $post->ID, '_crux_event_category', true ) ?: ( $defaults['category'] ?? 'Crux Event' );
	$short_title = get_post_meta( $post->ID, '_cr8v_event_short_title', true ) ?: ( $defaults['short_title'] ?? $post->post_title );
	$hero_blob = get_post_meta( $post->ID, '_cr8v_event_hero_blob', true ) ?: ( $defaults['hero_image'] ?? 'b094675514894aa0d8e7dd735d187b22' );
	$gallery   = get_post_meta( $post->ID, '_cr8v_event_gallery', true ) ?: ( $defaults['gallery'] ?? array( 'c5afda4fc4e4d4b0682377d6eb272c90', '1d5292715423e2e83b56b3330a94b3b8', 'c5afda4fc4e4d4b0682377d6eb272c90' ) );
	$eventbrite = get_post_meta( $post->ID, '_cr8v_event_eventbrite', true ) ?: get_post_meta( $post->ID, '_crux_event_eventbrite', true ) ?: ( $defaults['eventbrite'] ?? '' );
	$badge_bg   = get_post_meta( $post->ID, '_cr8v_event_badge_bg', true ) ?: ( $defaults['badge_bg'] ?? '#002671' );
	$badge_col  = get_post_meta( $post->ID, '_cr8v_event_badge_color', true ) ?: ( $defaults['badge_color'] ?? '#FFFFFF' );
	$rotation   = get_post_meta( $post->ID, '_cr8v_event_rotation', true ) ?: ( $defaults['rotation'] ?? '0deg' );

	// Date formatting
	$ts = ! empty( $date_raw ) ? strtotime( $date_raw ) : time();
	$badge_day   = date( 'd', $ts );
	$badge_month = strtoupper( date( 'M', $ts ) );
	$date_str    = date( 'l, j F Y', $ts );

	// Excerpts & content
	$desc_1 = $post->post_excerpt ?: ( $defaults['desc_1'] ?? 'Get ready to groove and move like never before. An electrifying experience curated and produced by Crux Nxtion Events.' );
	$desc_2 = $post->post_content ? wp_strip_all_tags( $post->post_content ) : ( $defaults['desc_2'] ?? 'Tickets and full details are on Eventbrite. Want a night like this for your own crowd? Our crew plans, books and runs it end to end.' );

	return array(
		'id'               => $post->ID,
		'slug'             => $slug,
		'title'            => strtoupper( $post->post_title ),
		'short_title'      => $short_title,
		'category'         => $category,
		'date_badge_day'   => $badge_day,
		'date_badge_month' => $badge_month,
		'date_str'         => $date_str,
		'time_str'         => $time_str,
		'date_raw'         => $date_raw,
		'location'         => $venue,
		'country'          => $country,
		'hero_image'       => $hero_blob,
		'desc_1'           => $desc_1,
		'desc_2'           => $desc_2,
		'gallery'          => is_array( $gallery ) ? $gallery : array( $gallery ),
		'eventbrite'       => $eventbrite,
		'badge_bg'         => $badge_bg,
		'badge_color'      => $badge_col,
		'rotation'         => $rotation,
		'permalink'        => get_permalink( $post->ID ),
	);
}

/**
 * 3. Query All Events (Ordered by menu_order & date)
 *
 * @param array $args Optional WP_Query parameters.
 * @return array Array of structured event data items.
 */
function crux_get_all_events( $args = array() ) {
	$defaults = array(
		'post_type'      => 'event',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);

	$query_args = wp_parse_args( $args, $defaults );
	$query = new WP_Query( $query_args );

	$catalog = crux_get_event_catalog();
	$events = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_obj = get_post();
			// In shared database environments, ensure event belongs to Crux Nxtion
			if ( isset( $catalog[ $post_obj->post_name ] ) || get_post_meta( $post_obj->ID, '_cr8v_event_hero_blob', true ) || get_post_meta( $post_obj->ID, '_crux_event_date', true ) ) {
				$ev = crux_get_event_data( $post_obj );
				if ( $ev ) {
					$events[ $ev['slug'] ] = $ev;
				}
			}
		}
		wp_reset_postdata();
	}

	// Fallback guarantee: if DB events are empty, load catalog
	if ( empty( $events ) ) {
		$catalog = crux_get_event_catalog();
		foreach ( $catalog as $slug => $item ) {
			$item['slug'] = $slug;
			$item['id']   = 0;
			$item['permalink'] = home_url( '/event/' . $slug . '/' );
			$events[ $slug ] = $item;
		}
	}

	return $events;
}
