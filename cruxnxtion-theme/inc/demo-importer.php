<?php
/**
 * Crux Nxtion - Automated Demo Content & Page Seeder
 * Populates real Pages, Events, and Menus in WordPress DB
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Automatic Seeder on Theme Switch & First Load
 */
function crux_maybe_auto_seed_pages() {
	if ( get_option( 'crux_pages_auto_seeded_v2' ) ) {
		return;
	}
	crux_seed_all_content( false );
	update_option( 'crux_pages_auto_seeded_v2', 1 );
}
add_action( 'init', 'crux_maybe_auto_seed_pages', 20 );
add_action( 'after_switch_theme', 'crux_maybe_auto_seed_pages' );

/**
 * 2. Manual 1-Click Trigger from Admin
 */
function crux_handle_manual_demo_seed() {
	if ( ! isset( $_GET['crux_action'] ) || $_GET['crux_action'] !== 'seed_demo_content' ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions.', 'cruxnxtion' ) );
	}

	check_admin_referer( 'crux_seed_demo_nonce' );

	crux_seed_all_content( true );

	wp_safe_redirect( admin_url( 'edit.php?post_type=page&crux_seeded=1' ) );
	exit;
}
add_action( 'admin_init', 'crux_handle_manual_demo_seed' );

/**
 * 3. Core Content Seeder Engine
 */
function crux_seed_all_content( $force = false ) {
	// A. Create Core Pages
	$pages = array(
		'home'                 => array( 'title' => 'Home', 'template' => '' ),
		'consultancy'          => array( 'title' => 'Business Consultancy', 'template' => 'page-consultancy.php' ),
		'services'             => array( 'title' => 'Services', 'template' => 'page-services.php' ),
		'services-consultancy' => array( 'title' => 'Consultancy Services', 'template' => 'page-services-consultancy.php' ),
		'events'               => array( 'title' => 'Events', 'template' => 'page-events.php' ),
		'past-events'          => array( 'title' => 'Past Events Archive', 'template' => 'page-events-archive.php' ),
		'gallery'              => array( 'title' => 'Gallery', 'template' => 'page-gallery.php' ),
		'about'                => array( 'title' => 'About Us', 'template' => 'page-about.php' ),
		'founder'              => array( 'title' => 'Founder Story', 'template' => 'page-founder.php' ),
		'contact'              => array( 'title' => 'Contact Us', 'template' => 'page-contact.php' ),
		'faq'                  => array( 'title' => 'FAQ & Enquiries', 'template' => 'page-faq.php' ),
		'sponsors'             => array( 'title' => 'Sponsors & Partners', 'template' => 'page-sponsors.php' ),
		'blog'                 => array( 'title' => 'Journal & Insights', 'template' => '' ),
		'privacy-policy'       => array( 'title' => 'Privacy Policy', 'template' => '' ),
		'cookie-policy'        => array( 'title' => 'Cookie Policy', 'template' => '' ),
		'terms-conditions'     => array( 'title' => 'Terms & Conditions', 'template' => '' ),
	);

	$page_ids = array();
	foreach ( $pages as $slug => $pinfo ) {
		$existing = get_page_by_path( $slug );
		if ( ! $existing ) {
			$pid = wp_insert_post( array(
				'post_title'   => $pinfo['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
			) );
		} else {
			$pid = $existing->ID;
		}

		if ( $pid && ! is_wp_error( $pid ) ) {
			$page_ids[ $slug ] = $pid;
			if ( ! empty( $pinfo['template'] ) ) {
				update_post_meta( $pid, '_wp_page_template', $pinfo['template'] );
			}
		}
	}

	// Set Front Page and Blog Page
	if ( isset( $page_ids['home'] ) && isset( $page_ids['blog'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['home'] );
		update_option( 'page_for_posts', $page_ids['blog'] );
	}

	// B. Seed 8 Confirmed Events from site.json
	$events = array(
		array(
			'title'      => 'Becoming Mr & Mrs Crux Pt.3',
			'slug'       => 'becoming-mr-mrs-crux-pt-3',
			'date'       => '2025-04-23',
			'time'       => '15:00',
			'venue'      => 'Sheffield, UK',
			'eventbrite' => 'https://www.eventbrite.co.uk/',
			'category'   => 'Weddings & Celebrations',
		),
		array(
			'title'      => 'LASGIDI Mainland Party (IJGB Edition)',
			'slug'       => 'lasgidi-mainland-party-ijgb-edition',
			'date'       => '2025-01-25',
			'time'       => '21:00',
			'venue'      => 'Sheffield, UK',
			'eventbrite' => 'https://www.eventbrite.co.uk/e/lasgidi-mainland-party-ijgb-edition-tickets-1134178371039',
			'category'   => 'Club & Nightlife',
		),
		array(
			'title'      => 'Ankara Festival',
			'slug'       => 'ankara-festival',
			'date'       => '2024-11-30',
			'time'       => '14:00',
			'venue'      => 'Sheffield, UK',
			'eventbrite' => 'https://www.eventbrite.co.uk/e/ankara-festival-tickets-1070427991939',
			'category'   => 'Cultural Festivals',
		),
		array(
			'title'      => 'Dance OUT 2023 With Crux Nxtion Events',
			'slug'       => 'dance-out-2023',
			'date'       => '2023-12-16',
			'time'       => '20:00',
			'venue'      => 'Sheffield, UK',
			'eventbrite' => 'https://www.eventbrite.co.uk/e/dance-out-2023-with-crux-nxtion-events-tickets-769718547897',
			'category'   => 'Concerts & Shows',
		),
		array(
			'title'      => 'YAGI Awards',
			'slug'       => 'yagi-awards',
			'date'       => '2023-04-28',
			'time'       => '14:30',
			'venue'      => 'Sheffield, UK',
			'eventbrite' => 'https://www.eventbrite.co.uk/e/yagi-awards-tickets-623479482917',
			'category'   => 'Awards & Galas',
		),
		array(
			'title'      => 'Millennials vs Gen Z',
			'slug'       => 'millennials-vs-gen-z',
			'date'       => '2023-01-29',
			'time'       => '17:00',
			'venue'      => 'Sheffield, UK',
			'eventbrite' => 'https://www.eventbrite.co.uk/e/millenials-vs-gen-z-tickets-494953558417',
			'category'   => 'Social Activations',
		),
		array(
			'title'      => 'The Wedding Party',
			'slug'       => 'the-wedding-party',
			'date'       => '2022-08-27',
			'time'       => '15:00',
			'venue'      => 'Sheffield, UK',
			'eventbrite' => 'https://www.eventbrite.co.uk/e/the-wedding-party-tickets-356808492807',
			'category'   => 'Weddings & Celebrations',
		),
		array(
			'title'      => 'Crux Nxtion Hangout Out',
			'slug'       => 'crux-nxtion-hangout-out',
			'date'       => '2021-09-25',
			'time'       => '18:00',
			'venue'      => 'Sheffield, UK',
			'eventbrite' => 'https://www.eventbrite.co.uk/e/crux-nxtion-hangout-out-tickets-168482853751',
			'category'   => 'Community Hangouts',
		),
	);

	foreach ( $events as $ev ) {
		$existing_ev = get_page_by_path( $ev['slug'], OBJECT, 'event' );
		if ( ! $existing_ev ) {
			$ev_id = wp_insert_post( array(
				'post_title'   => $ev['title'],
				'post_name'    => $ev['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'event',
			) );

			if ( $ev_id && ! is_wp_error( $ev_id ) ) {
				update_post_meta( $ev_id, '_crux_event_date', $ev['date'] );
				update_post_meta( $ev_id, '_crux_event_time', $ev['time'] );
				update_post_meta( $ev_id, '_crux_event_venue', $ev['venue'] );
				update_post_meta( $ev_id, '_crux_event_eventbrite', $ev['eventbrite'] );
				update_post_meta( $ev_id, '_crux_event_category', $ev['category'] );
			}
		}
	}
}
