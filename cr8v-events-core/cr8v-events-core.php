<?php
/**
 * Plugin Name: Cr8v Events & Gallery Core
 * Plugin URI: https://cr8vstacks.com/dev-playground/
 * Description: Core data engine providing Custom Post Types ('event' and 'gallery_item'), custom meta fields, past-event calendar calculation logic, and dynamic .ics file generation for Cr8v Stacks themes.
 * Version: 1.0.4
 * Author: Cr8v Stacks
 * Author URI: https://cr8vstacks.com/dev-playground/
 * Text Domain: cr8v-events-core
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! defined( 'CR8V_EVENTS_CORE_VERSION' ) ) {
	define( 'CR8V_EVENTS_CORE_VERSION', '1.0.4' );
}
if ( ! defined( 'CR8V_EVENTS_CORE_DIR' ) ) {
	define( 'CR8V_EVENTS_CORE_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'CR8V_EVENTS_CORE_URL' ) ) {
	define( 'CR8V_EVENTS_CORE_URL', plugin_dir_url( __FILE__ ) );
}

// Load Submodules
require_once CR8V_EVENTS_CORE_DIR . 'inc/cpt-events.php';
require_once CR8V_EVENTS_CORE_DIR . 'inc/cpt-gallery.php';
require_once CR8V_EVENTS_CORE_DIR . 'inc/cpt-inquiries.php';
require_once CR8V_EVENTS_CORE_DIR . 'inc/meta-boxes.php';
require_once CR8V_EVENTS_CORE_DIR . 'inc/calendar-ics.php';
require_once CR8V_EVENTS_CORE_DIR . 'inc/media-cleaner.php';

/**
 * Flush rewrite rules on activation
 */
if ( ! function_exists( 'cr8v_events_core_activate' ) ) {
	function cr8v_events_core_activate() {
		if ( function_exists( 'cr8v_register_events_cpt' ) ) {
			cr8v_register_events_cpt();
		}
		if ( function_exists( 'cr8v_register_gallery_cpt' ) ) {
			cr8v_register_gallery_cpt();
		}
		if ( function_exists( 'cr8v_register_inquiries_cpt' ) ) {
			cr8v_register_inquiries_cpt();
		}
		flush_rewrite_rules();
	}
	register_activation_hook( __FILE__, 'cr8v_events_core_activate' );
}

/**
 * Flush rewrite rules on deactivation
 */
if ( ! function_exists( 'cr8v_events_core_deactivate' ) ) {
	function cr8v_events_core_deactivate() {
		flush_rewrite_rules();
	}
	register_deactivation_hook( __FILE__, 'cr8v_events_core_deactivate' );
}
