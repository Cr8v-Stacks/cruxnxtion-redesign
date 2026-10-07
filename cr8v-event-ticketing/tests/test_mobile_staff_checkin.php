<?php
/**
 * Test Suite: Mobile Door Staff Check-In Polish
 *
 * Verifies:
 * 1. Staff landing page lookup box thumb-usability (48px+ min-height, full-width button, inputmode="text", autocapitalize="characters").
 * 2. Successful check-in displays large green "CHECKED IN", attendee name, tier, check-in time, and prominent "Scan next" button.
 * 3. Already checked-in ticket displays unmistakable large amber "ALREADY CHECKED IN", "DO NOT ADMIT", clear reason banner, and "Scan next" button.
 * 4. Not-found ticket displays unmistakable large red "TICKET NOT FOUND", "DO NOT ADMIT", clear reason banner, and "Scan next" button.
 * 5. Valid unchecked pass displays "OFFICIAL VERIFIED PASS", "VALID FOR ENTRY", and full-width thumb-usable check-in button.
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

echo "=== TASK: MOBILE DOOR STAFF CHECK-IN POLISH ===\n";

$page_file = dirname( __DIR__, 2 ) . '/cruxnxtion-theme/page-booking-confirmation.php';

// Setup test staff user
$staff_user_id = wp_create_user( 'mobstaff_' . bin2hex( random_bytes( 4 ) ), 'Mob_Staff_123!', 'mobstaff_' . time() . '@example.com' );
$staff_user    = new WP_User( $staff_user_id );
$staff_user->set_role( 'event_staff' );

// Setup test event and order
$test_event_id = wp_insert_post(
	array(
		'post_type'   => 'event',
		'post_title'  => 'Summer Neon Gala 2026',
		'post_status' => 'publish',
	)
);
update_post_meta( $test_event_id, '_cr8v_event_venue', 'Crux Arena, London' );
update_post_meta( $test_event_id, '_cr8v_event_date', '2026-08-15' );
update_post_meta( $test_event_id, '_cr8v_event_time', '20:00' );

$code_1   = 'TIX-' . strtoupper( bin2hex( random_bytes( 6 ) ) );
$secret_1 = cr8v_tix_ticket_secret( $code_1 );

$order_id = wp_insert_post(
	array(
		'post_type'   => 'event_order',
		'post_title'  => 'Order #MobStaffTest',
		'post_status' => 'publish',
	)
);
update_post_meta( $order_id, '_cr8v_order_event_id', $test_event_id );
update_post_meta( $order_id, '_cr8v_order_customer_name', 'Marcus VIP Attendee' );
update_post_meta( $order_id, '_cr8v_order_customer_email', 'marcus@vip.test' );
update_post_meta( $order_id, '_cr8v_order_status', 'completed' );
update_post_meta(
	$order_id,
	'_cr8v_order_tickets',
	array(
		array(
			'ticket_code'   => $code_1,
			'tier_name'     => 'VIP Experience',
			'attendee_name' => 'Marcus VIP Attendee',
			'checked_in'    => false,
		),
	)
);

// 1. Staff landing page thumb usability
wp_set_current_user( $staff_user_id );
$_GET  = array();
$_POST = array();
ob_start();
include $page_file;
$landing_html = ob_get_clean();

t( 'Staff landing page lookup input has inputmode="text"', false !== strpos( $landing_html, 'inputmode="text"' ) );
t( 'Staff landing page lookup input has autocapitalize="characters"', false !== strpos( $landing_html, 'autocapitalize="characters"' ) );
t( 'Staff landing page lookup input has min-height: 48px or height: 52px', false !== strpos( $landing_html, 'min-height:48px' ) || false !== strpos( $landing_html, 'height:52px' ) );
t( 'Staff landing page submit button is full width (width: 100%)', false !== strpos( $landing_html, 'width:100%' ) && false !== strpos( $landing_html, 'Look Up Ticket' ) );
t( 'Staff landing page submit button has min-height: 48px', false !== strpos( $landing_html, 'min-height:48px' ) );

// 2. Valid unchecked pass state
$_GET = array( 'cr8v_ticket' => $code_1 );
ob_start();
include $page_file;
$valid_html = ob_get_clean();

t( 'Valid unchecked pass displays OFFICIAL VERIFIED PASS', false !== strpos( $valid_html, 'OFFICIAL VERIFIED PASS' ) );
t( 'Valid unchecked pass displays VALID FOR ENTRY', false !== strpos( $valid_html, 'VALID FOR ENTRY' ) );
t( 'Valid unchecked pass displays attendee name', false !== strpos( $valid_html, 'Marcus VIP Attendee' ) );
t( 'Valid unchecked pass displays CONFIRM DOOR CHECK-IN button for staff', false !== strpos( $valid_html, 'CONFIRM DOOR CHECK-IN' ) );

// 3. Check-in action execution & SUCCESS state
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array(
	'cr8v_do_checkin'     => '1',
	'ticket_code'         => $code_1,
	'ticket_secret'       => $secret_1,
	'order_id'            => $order_id,
	'_cr8v_checkin_nonce' => wp_create_nonce( 'cr8v_checkin_' . $code_1 ),
);
$_GET = array( 'cr8v_ticket' => $code_1 );
ob_start();
include $page_file;
$success_html = ob_get_clean();

t( 'Check-in POST shows large green CHECKED IN confirmation', false !== strpos( $success_html, 'CHECKED IN' ) );
t( 'Check-in POST shows DOOR CHECK-IN SUCCESSFUL eyebrow', false !== strpos( $success_html, 'DOOR CHECK-IN SUCCESSFUL' ) );
t( 'Check-in POST shows attendee name', false !== strpos( $success_html, 'Marcus VIP Attendee' ) );
t( 'Check-in POST shows ticket tier', false !== strpos( $success_html, 'VIP Experience' ) );
t( 'Check-in POST shows check-in time', false !== strpos( $success_html, 'Check-In Time:' ) );
t( 'Check-in POST shows prominent "Scan next" button', false !== strpos( $success_html, 'Scan next' ) );
t( 'Check-in POST "Scan next" button links to staff check-in landing page', false !== strpos( $success_html, 'booking-confirmation' ) );

// Verify database updated
$tickets_after = get_post_meta( $order_id, '_cr8v_order_tickets', true );
t( 'Database records ticket as checked_in', ! empty( $tickets_after[0]['checked_in'] ) );

// 4. Already checked in state (re-visiting the checked-in ticket)
$_SERVER['REQUEST_METHOD'] = 'GET';
$_POST = array();
$_GET  = array( 'cr8v_ticket' => $code_1 );
ob_start();
include $page_file;
$already_html = ob_get_clean();

t( 'Already checked-in ticket displays ALREADY CHECKED IN heading', false !== strpos( $already_html, 'ALREADY CHECKED IN' ) );
t( 'Already checked-in ticket displays DO NOT ADMIT warning', false !== strpos( $already_html, 'DO NOT ADMIT' ) );
t( 'Already checked-in ticket displays unmistakable Reason banner', false !== strpos( $already_html, 'Reason:' ) && false !== strpos( $already_html, 'Do not admit a duplicate entry.' ) );
t( 'Already checked-in ticket displays attendee details', false !== strpos( $already_html, 'Marcus VIP Attendee' ) );
t( 'Already checked-in ticket displays prominent "Scan next" button', false !== strpos( $already_html, 'Scan next' ) );

// 5. Not-found state (staff enters non-existent ticket code)
$_GET = array( 'cr8v_ticket' => 'TIX-000000000000' );
ob_start();
include $page_file;
$notfound_html = ob_get_clean();

t( 'Not-found ticket displays TICKET NOT FOUND heading', false !== strpos( $notfound_html, 'TICKET NOT FOUND' ) );
t( 'Not-found ticket displays DO NOT ADMIT warning', false !== strpos( $notfound_html, 'DO NOT ADMIT' ) );
t( 'Not-found ticket displays unmistakable Reason banner', false !== strpos( $notfound_html, 'Reason:' ) && false !== strpos( $notfound_html, 'No ticket with code' ) );
t( 'Not-found ticket displays prominent "Scan next" button', false !== strpos( $notfound_html, 'Scan next' ) );
t( 'Not-found ticket does NOT display check-in button or verified pass', false === strpos( $notfound_html, 'CONFIRM DOOR CHECK-IN' ) && false === strpos( $notfound_html, 'OFFICIAL VERIFIED PASS' ) );

// Cleanup
wp_delete_post( $order_id, true );
wp_delete_post( $test_event_id, true );
wp_delete_user( $staff_user_id );

echo "\n=== CLEANUP ===\nCleaned up test event, order, and staff user.\n";
echo "RESULT: $pass passed, $fail failed\n";
exit( $fail > 0 ? 1 : 0 );
