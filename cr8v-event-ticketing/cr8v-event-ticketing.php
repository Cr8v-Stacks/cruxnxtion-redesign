<?php
/**
 * Plugin Name: Cr8v Event Ticketing
 * Description: Shared event management and ticketing engine for the Cr8v Stacks event sites (Crux Nxtion, Red Cap Entertainment, Black and White Crafts). Adds the Event Details editor to the existing `event` post type. It never registers the post type itself, so it works with whichever core plugin owns it. Ticketing and Stripe checkout are added in later phases.
 * Version: 0.1.0
 * Author: Cr8v Stacks
 * Author URI: https://cr8vstacks.com/
 * Text Domain: cr8v-event-ticketing
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CR8V_TICKETING_VERSION', '0.1.0' );
define( 'CR8V_TICKETING_DIR', plugin_dir_path( __FILE__ ) );
define( 'CR8V_TICKETING_URL', plugin_dir_url( __FILE__ ) );

require_once CR8V_TICKETING_DIR . 'inc/event-fields.php';
