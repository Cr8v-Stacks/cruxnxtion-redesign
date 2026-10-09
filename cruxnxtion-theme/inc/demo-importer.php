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

	// B. Menus (header, consultancy header, footer) from the original links.
	crux_seed_menus();

	// C. The eight existing events, complete with description, photos and every editable field.
	// See inc/event-seeder.php: it only creates what is missing and never overwrites the client's edits.
	if ( function_exists( 'crux_seed_events' ) ) {
		crux_seed_events();
	}
}

/**
 * Create the Main menu, Consultancy menu and Footer menu from the original links and assign them to their locations.
 * A location that already has a menu is never touched, so the client's own menus always win.
 */
function crux_seed_menus() {
	if ( ! function_exists( 'crux_nav_fallback' ) ) {
		return;
	}
	$locations = get_nav_menu_locations();
	$plan      = array(
		'primary'     => array( 'Main menu', crux_nav_fallback( 'desktop', 'events', 'events' ) ),
		'consultancy' => array( 'Consultancy menu', crux_nav_fallback( 'desktop', 'consultancy', 'consultancy' ) ),
		'footer'      => array( 'Footer menu', crux_nav_fallback( 'footer', 'events', 'events' ) ),
	);
	foreach ( $plan as $location => $def ) {
		if ( ! empty( $locations[ $location ] ) ) {
			continue;
		}
		$existing = wp_get_nav_menu_object( $def[0] );
		$menu_id  = $existing ? (int) $existing->term_id : (int) wp_create_nav_menu( $def[0] );
		if ( ! $menu_id || is_wp_error( $menu_id ) ) {
			continue;
		}
		if ( ! $existing ) {
			foreach ( $def[1] as $i => $it ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'    => $it['label'],
						'menu-item-url'      => home_url( $it['path'] ),
						'menu-item-type'     => 'custom',
						'menu-item-status'   => 'publish',
						'menu-item-position' => $i + 1,
					)
				);
			}
		}
		$locations[ $location ] = $menu_id;
	}
	set_theme_mod( 'nav_menu_locations', $locations );
}
