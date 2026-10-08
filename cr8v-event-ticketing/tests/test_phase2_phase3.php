<?php
/**
 * Automated test suite for Phase 2 & Phase 3.
 *
 * Verifies:
 * 1. Checkout REST validation, honeypot rejection, server-side pricing.
 * 2. Free RSVP booking, order completion, ticket issue, email trigger.
 * 3. /booking-confirmation/ rendering: order_token vs bare session_id privacy.
 * 4. QR secret verification & door check-in capability.
 * 5. .ics iCalendar generation.
 *
 * Run via:
 * php cr8v-event-ticketing/tests/test_phase2_phase3.php
 */

// Load WordPress
$wp_load = dirname( __DIR__, 4 ) . '/wp-load.php';
if ( ! file_exists( $wp_load ) ) {
	$wp_load = 'C:/Users/user/Local Sites/dev-playground/app/public/wp-load.php';
}
require_once $wp_load;

echo "=== STARTING PHASE 2 & 3 AUTOMATED VERIFICATION ===\n\n";

$pass_count = 0;
$fail_count = 0;

function assert_test( $condition, $message ) {
	global $pass_count, $fail_count;
	if ( $condition ) {
		echo " [PASS] {$message}\n";
		$pass_count++;
	} else {
		echo "![FAIL] {$message}\n";
		$fail_count++;
	}
}

// -----------------------------------------------------------------------------
// SETUP TEST EVENT WITH TIERS
// -----------------------------------------------------------------------------
$test_event_id = wp_insert_post(
	array(
		'post_title'   => 'Antigravity Test Gala 2026',
		'post_name'    => 'antigravity-test-gala-2026',
		'post_type'    => 'event',
		'post_status'  => 'publish',
		'post_content' => 'An automated test event for ticketing verification.',
	)
);

update_post_meta( $test_event_id, '_cr8v_event_date', '2026-11-20' );
update_post_meta( $test_event_id, '_cr8v_event_time', '20:00 - Late' );
update_post_meta( $test_event_id, '_cr8v_event_venue', 'Crux Arena' );
update_post_meta( $test_event_id, '_cr8v_event_location', 'Sheffield, UK' );

$tiers = array(
	array(
		'id'            => 'tier_free',
		'name'          => 'Complimentary Guest RSVP',
		'price_pence'   => 0,
		'capacity'      => 50,
		'max_per_order' => 4,
		'description'   => 'Free general admission pass',
	),
	array(
		'id'            => 'tier_vip',
		'name'          => 'VIP Balcony Pass',
		'price_pence'   => 4500, // £45.00
		'capacity'      => 20,
		'max_per_order' => 4,
		'description'   => 'VIP entry with glass of champagne',
	),
);
update_post_meta( $test_event_id, '_cr8v_event_ticket_tiers', $tiers );

echo "1. Created Test Event ID: {$test_event_id} with 2 tiers (Free RSVP & VIP £45.00)\n\n";

// -----------------------------------------------------------------------------
// TEST 1: CHECKOUT REST - HONEYPOT PROTECTION
// -----------------------------------------------------------------------------
echo "--- TEST 1: Honeypot Protection ---\n";
$req = new WP_REST_Request( 'POST', '/cr8v-ticketing/v1/checkout' );
$req->set_body_params(
	array(
		'event_id'       => $test_event_id,
		'customer_name'  => 'Bot Tester',
		'customer_email' => 'bot@example.com',
		'customer_phone' => '07000000000',
		'website'        => 'http://spambot.com', // Filled honeypot
		'items'          => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ),
	)
);
$res = rest_do_request( $req );
assert_test( 400 === $res->get_status(), 'Honeypot filled request rejected with HTTP 400' );

// -----------------------------------------------------------------------------
// TEST 2: CHECKOUT REST - EMPTY ITEMS VALIDATION
// -----------------------------------------------------------------------------
echo "\n--- TEST 2: Empty Items Validation ---\n";
$req = new WP_REST_Request( 'POST', '/cr8v-ticketing/v1/checkout' );
$req->set_body_params(
	array(
		'event_id'       => $test_event_id,
		'customer_name'  => 'Jane Doe',
		'customer_email' => 'jane@example.com',
		'customer_phone' => '07123456789',
		'website'        => '',
		'items'          => array(),
	)
);
$res = rest_do_request( $req );
assert_test( 400 === $res->get_status(), 'Empty items request rejected with HTTP 400' );

// -----------------------------------------------------------------------------
// TEST 3: CHECKOUT REST - SERVER-SIDE PRICING ENFORCEMENT
// -----------------------------------------------------------------------------
echo "\n--- TEST 3: Free RSVP Checkout Flow ---\n";
$req = new WP_REST_Request( 'POST', '/cr8v-ticketing/v1/checkout' );
$req->set_body_params(
	array(
		'event_id'       => $test_event_id,
		'customer_name'  => 'Jane Doe',
		'customer_email' => 'jane.doe.test' . time() . '@example.com',
		'customer_phone' => '07123456789',
		'website'        => '',
		'items'          => array(
			array(
				'tier_id'  => 'tier_free',
				'quantity' => 2,
				'price'    => 99999, // Injected client price must be strictly ignored!
			),
		),
	)
);
$res = rest_do_request( $req );
$data = $res->get_data();
assert_test( 200 === $res->get_status(), 'Free RSVP request succeeded with HTTP 200' );
assert_test( ! empty( $data['is_free'] ), 'Response indicates is_free = true' );
assert_test( ! empty( $data['redirect_url'] ) && str_contains( $data['redirect_url'], 'order_token=' ), 'Redirect URL contains order_token' );

// Extract token
parse_str( parse_url( $data['redirect_url'], PHP_URL_QUERY ), $url_params );
$order_token = $url_params['order_token'] ?? '';
assert_test( ! empty( $order_token ), "Retrieved order_token: {$order_token}" );

// -----------------------------------------------------------------------------
// TEST 4: VERIFY ORDER & CRYPTOGRAPHIC TICKETS IN DATABASE
// -----------------------------------------------------------------------------
echo "\n--- TEST 4: Database Order & Tickets Verification ---\n";
$found = get_posts(
	array(
		'post_type'   => 'event_order',
		'post_status' => 'publish',
		'meta_key'    => '_cr8v_order_token',
		'meta_value'  => $order_token,
	)
);
assert_test( 1 === count( $found ), 'Order record located in database' );
$test_order_id = $found[0]->ID;

$order_status = get_post_meta( $test_order_id, '_cr8v_order_status', true );
assert_test( 'completed' === $order_status, "Order status is 'completed'" );

$issued_tix = get_post_meta( $test_order_id, '_cr8v_order_tickets', true );
assert_test( is_array( $issued_tix ) && 2 === count( $issued_tix ), 'Exactly 2 individual tickets issued' );

$first_tix = $issued_tix[0] ?? array();
$tix_code  = $first_tix['ticket_code'] ?? '';
assert_test( str_starts_with( $tix_code, 'TIX-' ), "Ticket code has canonical format: {$tix_code}" );

$derived_secret = cr8v_tix_ticket_secret( $tix_code );
assert_test( 32 === strlen( $derived_secret ), "Derived HMAC secret is 32 chars: {$derived_secret}" );
assert_test( cr8v_tix_verify_ticket_secret( $tix_code, $derived_secret ), 'cr8v_tix_verify_ticket_secret() passes constant-time verification' );
assert_test( ! cr8v_tix_verify_ticket_secret( $tix_code, 'wrong_secret_1234' ), 'cr8v_tix_verify_ticket_secret() rejects forged secret' );

// -----------------------------------------------------------------------------
// TEST 5: CONFIRMATION EMAIL & .ICS DISPATCH
// -----------------------------------------------------------------------------
echo "\n--- TEST 5: Confirmation Email Hook & .ICS Generation ---\n";
$email_sent = get_post_meta( $test_order_id, '_cr8v_order_email_sent', true );
assert_test( ! empty( $email_sent ), "Confirmation email sent timestamp recorded: {$email_sent}" );

$ics_content = cr8v_tix_build_event_ics( $test_event_id );
assert_test( str_contains( $ics_content, 'BEGIN:VCALENDAR' ) && str_contains( $ics_content, 'END:VCALENDAR' ), 'Valid iCalendar (.ics) format generated' );
assert_test( str_contains( $ics_content, 'SUMMARY:Antigravity Test Gala 2026' ), '.ics contains unescaped event title' );

// -----------------------------------------------------------------------------
// TEST 6: /booking-confirmation/ PAGE PRIVACY & GATING TESTS
// -----------------------------------------------------------------------------
echo "\n--- TEST 6: Booking Confirmation Page Access Control ---\n";

$confirmation_template = get_template_directory() . '/page-booking-confirmation.php';

// A. Verified access with order_token
$_GET = array( 'order_token' => $order_token );
ob_start();
include $confirmation_template;
$html_token = ob_get_clean();

assert_test( str_contains( $html_token, 'ORDER CONFIRMED &amp; ISSUED' ) || str_contains( $html_token, 'ORDER CONFIRMED & ISSUED' ), 'Page with order_token shows confirmed order header' );
assert_test( str_contains( $html_token, $tix_code ), 'Page with order_token displays verified ticket code' );
assert_test( str_contains( $html_token, 'cr8v_ticket=' ), 'Page with order_token displays QR verification link' );

// B. Bare session_id access (Must NOT show tickets!)
$fake_session = 'cs_test_' . bin2hex( random_bytes( 12 ) );
update_post_meta( $test_order_id, '_cr8v_order_stripe_session_id', $fake_session );

$_GET = array( 'session_id' => $fake_session );
ob_start();
include $confirmation_template;
$html_session = ob_get_clean();

assert_test( str_contains( $html_session, 'PAYMENT RECEIVED' ) && str_contains( $html_session, 'BOOKING CONFIRMED' ), 'Page with bare session_id shows payment received notice' );
assert_test( ! str_contains( $html_session, $tix_code ), 'SECURITY CHECK: Page with bare session_id does NOT contain ticket code' );
assert_test( ! str_contains( $html_session, 'cr8v_ticket=' ), 'SECURITY CHECK: Page with bare session_id does NOT contain QR verification link' );
assert_test( str_contains( $html_session, 'scannable QR codes are never displayed directly on payment return links' ), 'Security explanation banner is present' );

// C. Ticket QR scan verification view
$_GET = array(
	'cr8v_ticket' => $tix_code,
	'tix_secret'  => $derived_secret,
);
ob_start();
include $confirmation_template;
$html_qr = ob_get_clean();

assert_test( str_contains( $html_qr, 'OFFICIAL VERIFIED PASS' ), 'QR scan link shows verified pass status' );
assert_test( str_contains( $html_qr, 'VALID FOR ENTRY' ), 'Shows entry validity' );

// D. Forged QR scan rejection
$_GET = array(
	'cr8v_ticket' => $tix_code,
	'tix_secret'  => 'fake_forged_secret_abc123',
);
ob_start();
include $confirmation_template;
$html_fake_qr = ob_get_clean();

assert_test( str_contains( $html_fake_qr, 'INVALID TICKET TOKEN' ), 'Forged secret produces invalid ticket alert' );

// -----------------------------------------------------------------------------
// TEST 7: STAFF DOOR CHECK-IN VIA POST ACTION
// -----------------------------------------------------------------------------
echo "\n--- TEST 7: Staff Door Check-In Action ---\n";
// Set current user as administrator
wp_set_current_user( 1 ); // Admin user
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array(
	'cr8v_do_checkin'      => '1',
	'ticket_code'          => $tix_code,
	'ticket_secret'        => $derived_secret,
	'order_id'             => $test_order_id,
	'_cr8v_checkin_nonce'  => wp_create_nonce( 'cr8v_checkin_' . $tix_code ),
);
$_GET = array(
	'cr8v_ticket' => $tix_code,
	'tix_secret'  => $derived_secret,
);

// A successful check-in answers with a 303 redirect (post-redirect-get). Capture it as a browser would, then
// load the Location with a GET to get the page the steward sees.
$redirect_seen = array( 'url' => '', 'status' => 0 );
$grab_redirect = function ( $location, $status ) use ( &$redirect_seen ) {
	$redirect_seen = array( 'url' => $location, 'status' => $status );
	throw new RuntimeException( 'redirect captured' );
};
add_filter( 'wp_redirect', $grab_redirect, 1, 2 );
ob_start();
try {
	include $confirmation_template;
} catch ( RuntimeException $e ) {
	// Expected: the page redirected.
}
ob_end_clean();
remove_filter( 'wp_redirect', $grab_redirect, 1 );

assert_test( 303 === $redirect_seen['status'], 'Check-in POST answers with a 303 redirect' );

parse_str( (string) parse_url( $redirect_seen['url'], PHP_URL_QUERY ), $prg_params );
$_SERVER['REQUEST_METHOD'] = 'GET';
$_POST = array();
$_GET  = $prg_params;
ob_start();
include $confirmation_template;
$html_checkedin = ob_get_clean();

assert_test( str_contains( $html_checkedin, 'Attendee successfully CHECKED IN' ), 'Check-in POST action reports success' );

// Check updated DB state
$updated_tix = get_post_meta( $test_order_id, '_cr8v_order_tickets', true );
assert_test( ! empty( $updated_tix[0]['checked_in'] ), 'Ticket checked_in flag set to true in database' );
assert_test( ! empty( $updated_tix[0]['checked_in_at'] ), 'Ticket checked_in_at timestamp recorded' );

// -----------------------------------------------------------------------------
// CLEANUP
// -----------------------------------------------------------------------------
wp_delete_post( $test_order_id, true );
wp_delete_post( $test_event_id, true );
echo "\nCleaned up test event and order.\n";

echo "\n======================================================\n";
echo "SUMMARY: {$pass_count} PASSED, {$fail_count} FAILED\n";
echo "======================================================\n";

if ( 0 === $fail_count ) {
	echo "\nALL PHASE 2 & PHASE 3 VERIFICATIONS PASSED 100%!\n";
} else {
	exit( 1 );
}
