<?php
/**
 * Sign-in and account hardening for the accounts that matter here: administrators and door staff.
 *
 * What protects a staff member from becoming an administrator is the role itself: `event_staff` holds only
 * `read` and `edit_event_orders`, so WordPress refuses every promote, user-edit, plugin, theme and settings
 * action on the server, whatever page or API the request comes through. This file closes the weaknesses that
 * WordPress leaves open around the sign-in itself:
 *
 *  1. Usernames are not listed to visitors (REST users list, ?author=N probing).
 *  2. XML-RPC, which allows password guessing in bulk, is switched off.
 *  3. Repeated wrong passwords lock that username from that address for 15 minutes.
 *  4. The sign-in form no longer says whether the username or the password was wrong.
 *
 * Each protection can be turned off with its filter (return false), for a site that really needs it.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'CR8V_SEC_LOGIN_MAX_FAILS' ) ) {
	define( 'CR8V_SEC_LOGIN_MAX_FAILS', 5 );
}
if ( ! defined( 'CR8V_SEC_LOGIN_LOCK_SECONDS' ) ) {
	define( 'CR8V_SEC_LOGIN_LOCK_SECONDS', 900 );
}

/**
 * 1a. Visitors cannot list users through the REST API. Signed-in users (the editor needs it) still can.
 */
function cr8v_sec_hide_rest_users( $endpoints ) {
	if ( ! apply_filters( 'cr8v_sec_hide_user_list', true ) || is_user_logged_in() ) {
		return $endpoints;
	}
	foreach ( array_keys( $endpoints ) as $route ) {
		if ( 0 === strpos( $route, '/wp/v2/users' ) ) {
			unset( $endpoints[ $route ] );
		}
	}
	return $endpoints;
}
add_filter( 'rest_endpoints', 'cr8v_sec_hide_rest_users' );

/**
 * 1b. ?author=1, ?author=2 ... redirected to the author's address and revealed the username.
 */
function cr8v_sec_block_author_probe() {
	if ( is_admin() || is_user_logged_in() || ! apply_filters( 'cr8v_sec_hide_user_list', true ) ) {
		return;
	}
	if ( isset( $_GET['author'] ) && '' !== (string) $_GET['author'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'parse_request', 'cr8v_sec_block_author_probe', 1 );

/**
 * 2. XML-RPC is off unless a site explicitly needs it (some mobile apps and plugins do).
 */
function cr8v_sec_xmlrpc_enabled( $enabled ) {
	return apply_filters( 'cr8v_sec_disable_xmlrpc', true ) ? false : $enabled;
}
add_filter( 'xmlrpc_enabled', 'cr8v_sec_xmlrpc_enabled', 99 );

/**
 * 3. Lock a username, from one address only, after repeated wrong passwords. Keying on username AND address
 * means a stranger guessing at the administrator's name cannot lock the real administrator out from theirs.
 */
function cr8v_sec_login_key( $username ) {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? (string) $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
	return 'cr8v_login_' . md5( strtolower( trim( (string) $username ) ) . '|' . $ip );
}

function cr8v_sec_is_locked( $username ) {
	$state = get_transient( cr8v_sec_login_key( $username ) );
	return is_array( $state ) && ! empty( $state['until'] ) && $state['until'] > time();
}

function cr8v_sec_check_lock( $user, $username, $password ) {
	if ( '' === (string) $username || ! apply_filters( 'cr8v_sec_login_lockout', true ) ) {
		return $user;
	}
	if ( cr8v_sec_is_locked( $username ) ) {
		return new WP_Error(
			'cr8v_locked',
			__( 'Too many failed sign-in attempts. Please wait 15 minutes and try again.', 'cr8v-event-ticketing' )
		);
	}
	return $user;
}
// Priority 99, not early: WordPress's own username and password check runs at 20 and would turn an early error into a
// successful sign-in. This must run last so a locked account stays locked even with the right password.
add_filter( 'authenticate', 'cr8v_sec_check_lock', 99, 3 );

function cr8v_sec_record_failure( $username ) {
	if ( '' === (string) $username || ! apply_filters( 'cr8v_sec_login_lockout', true ) || cr8v_sec_is_locked( $username ) ) {
		return; // Attempts made while locked do not extend the lock.
	}
	$key   = cr8v_sec_login_key( $username );
	$state = get_transient( $key );
	$count = ( is_array( $state ) && isset( $state['count'] ) ? (int) $state['count'] : 0 ) + 1;
	$until = $count >= CR8V_SEC_LOGIN_MAX_FAILS ? time() + CR8V_SEC_LOGIN_LOCK_SECONDS : 0;
	set_transient( $key, array( 'count' => $count, 'until' => $until ), CR8V_SEC_LOGIN_LOCK_SECONDS * 2 );
}
add_action( 'wp_login_failed', 'cr8v_sec_record_failure', 10, 1 );

function cr8v_sec_clear_failures( $user_login ) {
	delete_transient( cr8v_sec_login_key( $user_login ) );
}
add_action( 'wp_login', 'cr8v_sec_clear_failures', 10, 1 );

/**
 * 4. One message for "no such user" and "wrong password", so the form cannot be used to find real usernames.
 * The lockout message is kept, because it is the same for every name.
 */
function cr8v_sec_generic_login_error( $error ) {
	if ( ! apply_filters( 'cr8v_sec_generic_login_error', true ) ) {
		return $error;
	}
	global $errors;
	if ( is_wp_error( $errors ) ) {
		$codes = $errors->get_error_codes();
		if ( in_array( 'cr8v_locked', $codes, true ) ) {
			return $error;
		}
		if ( array_intersect( $codes, array( 'invalid_username', 'incorrect_password', 'invalid_email' ) ) ) {
			return __( '<strong>Error:</strong> The username or password is incorrect.', 'cr8v-event-ticketing' );
		}
	}
	return $error;
}
add_filter( 'login_errors', 'cr8v_sec_generic_login_error' );
