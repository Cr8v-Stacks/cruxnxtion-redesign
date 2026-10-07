<?php
/**
 * Database schema and atomic reservation tables for Cr8v Event Ticketing.
 *
 * Implements dedicated tables for:
 * 1. Ticket stock reservations with expiry (prevents overselling race conditions)
 * 2. Webhook idempotency tracking (prevents duplicate event processing)
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the table name for ticket reservations.
 *
 * @return string
 */
function cr8v_tix_reservations_table() {
	global $wpdb;
	return $wpdb->prefix . 'cr8v_ticket_reservations';
}

/**
 * Get the table name for processed webhooks.
 *
 * @return string
 */
function cr8v_tix_webhooks_table() {
	global $wpdb;
	return $wpdb->prefix . 'cr8v_processed_webhooks';
}

/**
 * Create or upgrade custom database tables using dbDelta.
 */
function cr8v_tix_install_tables() {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
	$res_table       = cr8v_tix_reservations_table();
	$webhooks_table  = cr8v_tix_webhooks_table();

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	// 1. Stock Reservations Table
	$sql_reservations = "CREATE TABLE {$res_table} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		event_id bigint(20) unsigned NOT NULL,
		tier_id varchar(40) NOT NULL,
		session_id varchar(128) NOT NULL,
		order_id bigint(20) unsigned NOT NULL DEFAULT 0,
		quantity int(10) unsigned NOT NULL DEFAULT 1,
		status varchar(20) NOT NULL DEFAULT 'reserved',
		created_at datetime NOT NULL,
		expires_at datetime NOT NULL,
		PRIMARY KEY  (id),
		KEY event_tier (event_id, tier_id),
		KEY session_id (session_id),
		KEY status_expires (status, expires_at)
	) {$charset_collate};";

	dbDelta( $sql_reservations );

	// 2. Webhook Idempotency Table
	$sql_webhooks = "CREATE TABLE {$webhooks_table} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		stripe_event_id varchar(128) NOT NULL,
		event_type varchar(64) NOT NULL,
		processed_at datetime NOT NULL,
		payload_summary text NULL,
		PRIMARY KEY  (id),
		UNIQUE KEY stripe_event_id (stripe_event_id)
	) {$charset_collate};";

	dbDelta( $sql_webhooks );

	update_option( 'cr8v_ticketing_db_version', '1.0.0' );
}

/**
 * Check if tables need installation or upgrade on plugin load.
 */
function cr8v_tix_check_db_installed() {
	if ( get_option( 'cr8v_ticketing_db_version' ) !== '1.0.0' ) {
		cr8v_tix_install_tables();
	}
}
add_action( 'plugins_loaded', 'cr8v_tix_check_db_installed', 15 );

/**
 * Sweep and release expired reservations.
 * Called automatically prior to availability checks and via hourly cron.
 *
 * @return int Number of reservations marked expired.
 */
function cr8v_tix_cleanup_expired_reservations() {
	global $wpdb;
	$table = cr8v_tix_reservations_table();
	$now   = current_time( 'mysql', true );

	$updated = $wpdb->query(
		$wpdb->prepare(
			"UPDATE {$table} 
			 SET status = 'expired' 
			 WHERE status = 'reserved' AND expires_at < %s",
			$now
		)
	);

	return (int) $updated;
}

/**
 * Schedule hourly cron job to cleanup expired reservations.
 */
function cr8v_tix_schedule_cleanup_cron() {
	if ( ! wp_next_scheduled( 'cr8v_tix_cleanup_cron_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'cr8v_tix_cleanup_cron_event' );
	}
}
add_action( 'init', 'cr8v_tix_schedule_cleanup_cron' );
add_action( 'cr8v_tix_cleanup_cron_event', 'cr8v_tix_cleanup_expired_reservations' );
