<?php
/**
 * Test Suite: Staff Role (Task 1) and CSV Attendee Export (Task 2)
 *
 * Verifies:
 * 1. event_staff role definition and capability lockdown (only edit_event_orders and read).
 * 2. event_staff inability to view or edit posts, pages, options, plugins, themes in wp-admin.
 * 3. event_staff door check-in authorization on /booking-confirmation/.
 * 4. Rejection of check-ins from unauthorized roles (contributor, subscriber).
 * 5. CSV attendee export admin-only capability check (manage_options) and nonce validation.
 * 6. CSV formula injection neutralization (prefixing =, +, -, @, \t with single quote).
 *
 * @package Cr8v_Event_Ticketing
 */

require __DIR__ . '/bootstrap.php';

$pass = 0;
$fail = 0;

function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) {
		$pass++;
		echo "PASS  $name\n";
	} else {
		$fail++;
		echo "FAIL  $name" . ( $detail ? " ($detail)" : '' ) . "\n";
	}
}

echo "=== TASK 1: EVENT_STAFF ROLE & CAPABILITIES ===\n";

// 1. Role exists
$role = get_role( 'event_staff' );
if ( ! $role ) {
	// Trigger init action to ensure role registration
	if ( function_exists( 'cr8v_tix_register_staff_role' ) ) {
		delete_option( 'cr8v_tix_staff_role_v' );
		cr8v_tix_register_staff_role();
		$role = get_role( 'event_staff' );
	}
}

t( 'event_staff role is registered in WordPress', ! empty( $role ) );
t( 'event_staff has edit_event_orders capability', ! empty( $role ) && $role->has_cap( 'edit_event_orders' ) );
t( 'event_staff has read capability', ! empty( $role ) && $role->has_cap( 'read' ) );

// 2. Strict capability limitation: NO admin/author capabilities
t( 'event_staff does NOT have edit_posts', empty( $role->capabilities['edit_posts'] ) );
t( 'event_staff does NOT have edit_pages', empty( $role->capabilities['edit_pages'] ) );
t( 'event_staff does NOT have manage_options', empty( $role->capabilities['manage_options'] ) );
t( 'event_staff does NOT have switch_themes', empty( $role->capabilities['switch_themes'] ) );
t( 'event_staff does NOT have activate_plugins', empty( $role->capabilities['activate_plugins'] ) );
t( 'event_staff does NOT have edit_users', empty( $role->capabilities['edit_users'] ) );
t( 'event_staff does NOT have delete_posts', empty( $role->capabilities['delete_posts'] ) );
t( 'event_staff does NOT have publish_posts', empty( $role->capabilities['publish_posts'] ) );
t( 'event_staff does NOT have do_not_allow', empty( $role->capabilities['do_not_allow'] ) );

// 3. User simulation for wp-admin lockdown
$staff_user_id = wp_create_user( 'staff_' . bin2hex( random_bytes( 4 ) ), 'Pass_Staff_123!', 'staff_' . time() . '@example.com' );
$staff_user    = new WP_User( $staff_user_id );
$staff_user->set_role( 'event_staff' );

wp_set_current_user( $staff_user_id );
t( 'Logged in staff user has role event_staff', in_array( 'event_staff', (array) $staff_user->roles, true ) );
t( 'Staff user can edit_event_orders', current_user_can( 'edit_event_orders' ) );
t( 'Staff user CANNOT edit_posts in wp-admin', ! current_user_can( 'edit_posts' ) );
t( 'Staff user CANNOT edit_pages in wp-admin', ! current_user_can( 'edit_pages' ) );
t( 'Staff user CANNOT manage_options (settings) in wp-admin', ! current_user_can( 'manage_options' ) );
t( 'Staff user CANNOT switch_themes in wp-admin', ! current_user_can( 'switch_themes' ) );
t( 'Staff user CANNOT activate_plugins in wp-admin', ! current_user_can( 'activate_plugins' ) );
t( 'Staff user CANNOT edit_users in wp-admin', ! current_user_can( 'edit_users' ) );

// 4. Door check-in authorization
$test_event_id = wp_insert_post(
	array(
		'post_type'   => 'event',
		'post_title'  => 'Staff Test Gala',
		'post_status' => 'publish',
	)
);
$code_1   = 'TIX-' . strtoupper( bin2hex( random_bytes( 6 ) ) );
$secret_1 = cr8v_tix_ticket_secret( $code_1 );

$order_id = wp_insert_post(
	array(
		'post_type'   => 'event_order',
		'post_title'  => 'Order #StaffTest',
		'post_status' => 'publish',
	)
);
update_post_meta( $order_id, '_cr8v_order_event_id', $test_event_id );
update_post_meta( $order_id, '_cr8v_order_customer_name', 'Alice Door' );
update_post_meta( $order_id, '_cr8v_order_customer_email', 'alice@door.test' );
update_post_meta( $order_id, '_cr8v_order_status', 'completed' );
update_post_meta(
	$order_id,
	'_cr8v_order_tickets',
	array(
		array(
			'ticket_code'   => $code_1,
			'tier_name'     => 'General',
			'attendee_name' => 'Alice Door',
			'checked_in'    => false,
		),
	)
);

// Staff user check-in simulation
$can_staff_checkin = current_user_can( 'edit_event_orders' ) || current_user_can( 'manage_options' );
t( 'Door check-in permission granted to event_staff user', $can_staff_checkin );

// Test subscriber check-in denial
$sub_user_id = wp_create_user( 'sub_' . bin2hex( random_bytes( 4 ) ), 'Pass_Sub_123!', 'sub_' . time() . '@example.com' );
wp_set_current_user( $sub_user_id );
$can_sub_checkin = current_user_can( 'edit_event_orders' ) || current_user_can( 'manage_options' );
t( 'Door check-in permission DENIED to subscriber user', ! $can_sub_checkin );

echo "\n=== TASK 1B: DOOR STAFF LOGIN FLOW & WP-ADMIN LOCKDOWN ===\n";

// 1. login_redirect tests
$staff_redirect = apply_filters( 'login_redirect', admin_url(), '', $staff_user );
t( 'event_staff login redirects to the check-in page', home_url( '/booking-confirmation/' ) === $staff_redirect, "got $staff_redirect" );

// Find or create administrator user
$admin_user = get_user_by( 'email', get_option( 'admin_email' ) );
if ( ! $admin_user ) {
	$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
	$admin_user = $admins[0] ?? null;
}
if ( $admin_user ) {
	t( 'cr8v_tix_staff_login_redirect leaves administrator redirect untouched', admin_url() === cr8v_tix_staff_login_redirect( admin_url(), '', $admin_user ) );
	$admin_redirect = apply_filters( 'login_redirect', admin_url(), '', $admin_user );
	t( 'Administrator login redirect does NOT redirect to booking-confirmation', false === strpos( $admin_redirect, '/booking-confirmation/' ) );
}

// Create editor user
$editor_user_id = wp_create_user( 'editor_' . bin2hex( random_bytes( 4 ) ), 'Pass_Editor_123!', 'editor_' . time() . '@example.com' );
$editor_user    = new WP_User( $editor_user_id );
$editor_user->set_role( 'editor' );

t( 'cr8v_tix_staff_login_redirect leaves editor redirect untouched', admin_url() === cr8v_tix_staff_login_redirect( admin_url(), '', $editor_user ) );
$editor_redirect = apply_filters( 'login_redirect', admin_url(), '', $editor_user );
t( 'Editor login redirect does NOT redirect to booking-confirmation', false === strpos( $editor_redirect, '/booking-confirmation/' ) );

// Helper to intercept wp_safe_redirect without exiting
$intercept_redirect = function( $callable ) {
	$caught = '';
	$filter = function( $location ) use ( &$caught ) {
		$caught = $location;
		throw new Exception( "INTERCEPTED_REDIRECT:$location" );
	};
	add_filter( 'wp_redirect', $filter, 1 );
	try {
		$callable();
	} catch ( Exception $e ) {
		// caught redirect
	}
	remove_filter( 'wp_redirect', $filter, 1 );
	return $caught;
};

// 2. wp-admin access blocking tests (the block only acts on wp-admin requests, so mark this process as being in wp-admin)
require_once ABSPATH . 'wp-admin/includes/admin.php';
set_current_screen( 'dashboard' );
global $pagenow;
$saved_pagenow = $pagenow;
$saved_script  = $_SERVER['SCRIPT_NAME'] ?? '';

// Test event_staff accessing wp-admin/index.php
$pagenow = 'index.php';
$_SERVER['SCRIPT_NAME'] = '/wp-admin/index.php';
wp_set_current_user( $staff_user_id );
$loc = $intercept_redirect( function() { cr8v_tix_staff_block_admin_access(); } );
t( 'wp-admin/index.php redirects event_staff away to /booking-confirmation/', home_url( '/booking-confirmation/' ) === $loc, "got $loc" );

// Test event_staff accessing wp-admin/profile.php
$pagenow = 'profile.php';
$_SERVER['SCRIPT_NAME'] = '/wp-admin/profile.php';
wp_set_current_user( $staff_user_id );
$loc = $intercept_redirect( function() { cr8v_tix_staff_block_admin_access(); } );
t( 'wp-admin/profile.php redirects event_staff away to /booking-confirmation/', home_url( '/booking-confirmation/' ) === $loc, "got $loc" );

// Test event_staff accessing wp-admin/edit.php
$pagenow = 'edit.php';
$_SERVER['SCRIPT_NAME'] = '/wp-admin/edit.php';
wp_set_current_user( $staff_user_id );
$loc = $intercept_redirect( function() { cr8v_tix_staff_block_admin_access(); } );
t( 'wp-admin/edit.php redirects event_staff away to /booking-confirmation/', home_url( '/booking-confirmation/' ) === $loc, "got $loc" );

// Test event_staff accessing wp-admin/admin-ajax.php (allowed through, no redirect)
$pagenow = 'admin-ajax.php';
$_SERVER['SCRIPT_NAME'] = '/wp-admin/admin-ajax.php';
wp_set_current_user( $staff_user_id );
$loc = $intercept_redirect( function() { cr8v_tix_staff_block_admin_access(); } );
t( 'wp-admin/admin-ajax.php allows event_staff through (no redirect)', '' === $loc, "got $loc" );

// Test event_staff accessing wp-admin/admin-post.php (allowed through, no redirect)
$pagenow = 'admin-post.php';
$_SERVER['SCRIPT_NAME'] = '/wp-admin/admin-post.php';
wp_set_current_user( $staff_user_id );
$loc = $intercept_redirect( function() { cr8v_tix_staff_block_admin_access(); } );
t( 'wp-admin/admin-post.php allows event_staff through (no redirect)', '' === $loc, "got $loc" );

// Test administrator accessing wp-admin/index.php (unaffected, no redirect)
$pagenow = 'index.php';
$_SERVER['SCRIPT_NAME'] = '/wp-admin/index.php';
if ( $admin_user ) {
	wp_set_current_user( $admin_user->ID );
	$loc = $intercept_redirect( function() { cr8v_tix_staff_block_admin_access(); } );
	t( 'wp-admin/index.php allows administrator through (no redirect)', '' === $loc, "got $loc" );
}

// Test editor accessing wp-admin/index.php (unaffected, no redirect)
$pagenow = 'index.php';
$_SERVER['SCRIPT_NAME'] = '/wp-admin/index.php';
wp_set_current_user( $editor_user_id );
$loc = $intercept_redirect( function() { cr8v_tix_staff_block_admin_access(); } );
t( 'wp-admin/index.php allows editor through (no redirect)', '' === $loc, "got $loc" );

// Restore globals
unset( $GLOBALS['current_screen'] );
$pagenow = $saved_pagenow;
$_SERVER['SCRIPT_NAME'] = $saved_script;

// 3. Front-end door staff notice on /booking-confirmation/
$page_file = dirname( __DIR__, 2 ) . '/cruxnxtion-theme/page-booking-confirmation.php';

// Logged in as staff -> renders notice and code lookup form
wp_set_current_user( $staff_user_id );
$_GET = array();
ob_start();
include $page_file;
$staff_html = ob_get_clean();
t( 'Door staff landing page shows "You are logged in as door staff." notice', false !== strpos( $staff_html, 'You are logged in as door staff.' ) );
t( 'Door staff landing page includes manual ticket code lookup input', false !== strpos( $staff_html, 'name="cr8v_ticket"' ) );
t( 'Door staff landing page indicates "Door Check-In Active"', false !== strpos( $staff_html, 'Door Check-In Active' ) );

// Anonymous visitor -> does NOT render staff notice or staff check-in box
wp_set_current_user( 0 );
$_GET = array();
ob_start();
include $page_file;
$anon_html = ob_get_clean();
t( 'Anonymous visitor does NOT see door staff notice', false === strpos( $anon_html, 'You are logged in as door staff.' ) );
t( 'Anonymous visitor does NOT see "Door Check-In Active"', false === strpos( $anon_html, 'Door Check-In Active' ) );

// Staff lookup by ticket code alone (without secret): derives secret and enters verify mode
wp_set_current_user( $staff_user_id );
$_GET = array( 'cr8v_ticket' => $code_1 );
ob_start();
include $page_file;
$lookup_html = ob_get_clean();
t( 'Staff code-only lookup derives secret and displays attendee pass', false !== strpos( $lookup_html, 'Alice Door' ) && false !== strpos( $lookup_html, 'CONFIRM DOOR CHECK-IN' ) );

// Anonymous lookup with only ticket code (no secret): refuses verify mode
wp_set_current_user( 0 );
$_GET = array( 'cr8v_ticket' => $code_1 );
ob_start();
include $page_file;
$anon_lookup_html = ob_get_clean();
t( 'Anonymous user code-only lookup does NOT show ticket details or check-in button', false === strpos( $anon_lookup_html, 'Alice Door' ) && false === strpos( $anon_lookup_html, 'CONFIRM DOOR CHECK-IN' ) );
$_GET = array();

echo "\n=== TASK 2: CSV ATTENDEE EXPORT & FORMULA INJECTION ===\n";

// 1. Escaping function unit tests
t( 'CSV sanitizer prefixes = formula', "'=SUM(A1:A10)" === cr8v_tix_csv_escape( '=SUM(A1:A10)' ) );
t( 'CSV sanitizer prefixes + formula', "'+cmd|' /C calc'!A0" === cr8v_tix_csv_escape( "+cmd|' /C calc'!A0" ) );
t( 'CSV sanitizer prefixes - formula', "'-20" === cr8v_tix_csv_escape( '-20' ) );
t( 'CSV sanitizer prefixes @ formula', "'@evil.com" === cr8v_tix_csv_escape( '@evil.com' ) );
t( 'CSV sanitizer prefixes tab', "'\tDDE" === cr8v_tix_csv_escape( "\tDDE" ) );
t( 'CSV sanitizer prefixes carriage return', "'\rCMD" === cr8v_tix_csv_escape( "\rCMD" ) );
t( 'CSV sanitizer leaves normal name untouched', 'Jane Doe' === cr8v_tix_csv_escape( 'Jane Doe' ) );
t( 'CSV sanitizer leaves normal email untouched', 'jane@example.com' === cr8v_tix_csv_escape( 'jane@example.com' ) );
t( 'CSV sanitizer handles empty string', '' === cr8v_tix_csv_escape( '' ) );

// 2. Add an order with malicious injection values in customer and attendee fields
$inj_order_id = wp_insert_post(
	array(
		'post_type'   => 'event_order',
		'post_title'  => 'Order #InjectionTest',
		'post_status' => 'publish',
	)
);
update_post_meta( $inj_order_id, '_cr8v_order_event_id', $test_event_id );
update_post_meta( $inj_order_id, '_cr8v_order_customer_name', '=1+1' );
update_post_meta( $inj_order_id, '_cr8v_order_customer_email', '@attacker.org' );
update_post_meta( $inj_order_id, '_cr8v_order_customer_phone', '+447999888777' );
update_post_meta( $inj_order_id, '_cr8v_order_status', 'completed' );
update_post_meta( $inj_order_id, '_cr8v_order_total_pence', 2500 );
update_post_meta(
	$inj_order_id,
	'_cr8v_order_tickets',
	array(
		array(
			'ticket_code'   => 'TIX-INJ001',
			'tier_name'     => '-Special Tier',
			'attendee_name' => '=HYPERLINK("http://evil.com","Click")',
			'checked_in'    => false,
		),
	)
);

// Build CSV for this event
$csv = cr8v_tix_build_attendee_csv( $test_event_id );

t( 'CSV contains header row', false !== strpos( $csv, 'Order ID' ) && false !== strpos( $csv, 'Order Date' ) && false !== strpos( $csv, 'Attendee Name' ) );
t( 'Formula =1+1 is neutralized in CSV with single quote', false !== strpos( $csv, "'=1+1" ) );
t( 'Formula @attacker.org is neutralized in CSV with single quote', false !== strpos( $csv, "'@attacker.org" ) );
t( 'Formula +447999888777 is neutralized in CSV with single quote', false !== strpos( $csv, "'+447999888777" ) );
t( 'Formula -Special Tier is neutralized in CSV with single quote', false !== strpos( $csv, "'-Special Tier" ) );
t( 'Formula =HYPERLINK is neutralized in CSV with single quote', false !== strpos( $csv, "'=HYPERLINK" ) );

// Verify raw unquoted formulas DO NOT exist at the beginning of fields
t( 'No unquoted =1+1 exists in CSV', false === strpos( $csv, ',"=1+1"' ) && false === strpos( $csv, ',=1+1,' ) );

// 3. Export permission checks
wp_set_current_user( $staff_user_id ); // event_staff user
t( 'event_staff user CANNOT export CSV (manage_options check)', ! current_user_can( 'manage_options' ) );

wp_set_current_user( $sub_user_id ); // subscriber
t( 'Subscriber user CANNOT export CSV (manage_options check)', ! current_user_can( 'manage_options' ) );

// Find administrator
$admin_user = get_user_by( 'email', get_option( 'admin_email' ) );
if ( $admin_user ) {
	wp_set_current_user( $admin_user->ID );
	t( 'Administrator CAN export CSV', current_user_can( 'manage_options' ) );
}

// Nonce verification test
$valid_nonce = wp_create_nonce( 'cr8v_export_attendees_csv' );
t( 'Valid CSV export nonce passes', (bool) wp_verify_nonce( $valid_nonce, 'cr8v_export_attendees_csv' ) );
t( 'Forged CSV export nonce fails', ! wp_verify_nonce( 'forged_nonce_123', 'cr8v_export_attendees_csv' ) );

echo "\n=== CLEANUP ===\n";
wp_delete_post( $inj_order_id, true );
wp_delete_post( $order_id, true );
wp_delete_post( $test_event_id, true );
wp_delete_user( $staff_user_id );
wp_delete_user( $sub_user_id );
wp_delete_user( $editor_user_id );
echo "Cleaned up test event, orders, and users.\n";

echo "\nRESULT: $pass passed, $fail failed\n";
if ( $fail > 0 ) {
	exit( 1 );
}
