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
$staff_user_id = wp_create_user( 'mobstaff_' . bin2hex( random_bytes( 4 ) ), wp_generate_password( 24 ), 'mobstaff_' . time() . '@example.com' );
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

// The page now answers a successful check-in with a 303 redirect (post-redirect-get). Capture it the way a
// browser would receive it, then load the Location with a GET to get the page the steward actually sees.
$first_redirect = array( 'url' => '', 'status' => 0 );
$capture_first  = function ( $location, $status ) use ( &$first_redirect ) {
	$first_redirect = array( 'url' => $location, 'status' => $status );
	throw new RuntimeException( 'redirect captured' );
};
add_filter( 'wp_redirect', $capture_first, 1, 2 );
ob_start();
try {
	include $page_file;
} catch ( RuntimeException $e ) {
	// Expected: the page redirected.
}
ob_end_clean();
remove_filter( 'wp_redirect', $capture_first, 1 );

t( 'Check-in POST answers with a 303 redirect (so a refresh cannot re-submit the form)', 303 === $first_redirect['status'] && false !== strpos( $first_redirect['url'], $code_1 ) );

parse_str( (string) parse_url( $first_redirect['url'], PHP_URL_QUERY ), $first_params );
$_SERVER['REQUEST_METHOD'] = 'GET';
$_POST = array();
$_GET  = $first_params;
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

// 4. Post-Redirect-Get (PRG) 303 redirect & signed flag verification
$code_2   = 'TIX-' . strtoupper( bin2hex( random_bytes( 6 ) ) );
$secret_2 = cr8v_tix_ticket_secret( $code_2 );

$order_tickets   = get_post_meta( $order_id, '_cr8v_order_tickets', true );
$order_tickets[] = array(
	'ticket_code'   => $code_2,
	'tier_name'     => 'General Admission',
	'attendee_name' => 'Elena VIP Friend',
	'checked_in'    => false,
);
update_post_meta( $order_id, '_cr8v_order_tickets', $order_tickets );

// 4A. Check-in POST issues 303 redirect with signed flag
wp_set_current_user( $staff_user_id );
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array(
	'cr8v_do_checkin'     => '1',
	'ticket_code'         => $code_2,
	'ticket_secret'       => $secret_2,
	'order_id'            => $order_id,
	'_cr8v_checkin_nonce' => wp_create_nonce( 'cr8v_checkin_' . $code_2 ),
);
$_GET = array( 'cr8v_ticket' => $code_2 );

// Capture the redirect with a filter that throws, so the page's own exit is never reached. The page
// carries no test-only switches.
$captured_redirect = array( 'url' => '', 'status' => 0 );
$capture_redirect  = function ( $location, $status ) use ( &$captured_redirect ) {
	$captured_redirect = array( 'url' => $location, 'status' => $status );
	throw new RuntimeException( 'redirect captured' );
};
add_filter( 'wp_redirect', $capture_redirect, 1, 2 );

ob_start();
try {
	include $page_file;
} catch ( RuntimeException $e ) {
	// Expected: the page redirected.
}
ob_end_clean();

remove_filter( 'wp_redirect', $capture_redirect, 1 );

t( 'Check-in POST issues HTTP 303 See Other redirect', 303 === $captured_redirect['status'] );
t( 'Check-in POST redirect URL points to ticket with ?checked=1', false !== strpos( $captured_redirect['url'], 'checked=1' ) && false !== strpos( $captured_redirect['url'], $code_2 ) );
t( 'Check-in POST redirect URL includes chk_staff parameter', false !== strpos( $captured_redirect['url'], 'chk_staff=' . $staff_user_id ) );
t( 'Check-in POST redirect URL includes chk_time parameter', false !== strpos( $captured_redirect['url'], 'chk_time=' ) );
t( 'Check-in POST redirect URL includes chk_token parameter', false !== strpos( $captured_redirect['url'], 'chk_token=' ) );

$query_str = (string) parse_url( $captured_redirect['url'], PHP_URL_QUERY );
parse_str( $query_str, $redirect_params );

// 4B. The green card renders from the flag for that staff user (GET request)
$_SERVER['REQUEST_METHOD'] = 'GET';
$_POST = array();
$_GET  = $redirect_params;
ob_start();
include $page_file;
$prg_get_html = ob_get_clean();

t( 'PRG GET displays large green CHECKED IN confirmation for staff', false !== strpos( $prg_get_html, 'CHECKED IN' ) );
t( 'PRG GET displays DOOR CHECK-IN SUCCESSFUL eyebrow', false !== strpos( $prg_get_html, 'DOOR CHECK-IN SUCCESSFUL' ) );
t( 'PRG GET displays attendee name', false !== strpos( $prg_get_html, 'Elena VIP Friend' ) );
t( 'PRG GET displays ticket tier', false !== strpos( $prg_get_html, 'General Admission' ) );
t( 'PRG GET displays gate status ADMITTED • PASS VERIFIED', false !== strpos( $prg_get_html, 'ADMITTED • PASS VERIFIED' ) );
t( 'PRG GET does NOT display ALREADY CHECKED IN warning', false === strpos( $prg_get_html, 'ALREADY CHECKED IN' ) );
t( 'PRG GET does NOT display DO NOT ADMIT warning', false === strpos( $prg_get_html, 'DO NOT ADMIT' ) );

// 4C. Refreshing GET within 60s keeps green CHECKED IN confirmation
$_GET = $redirect_params;
ob_start();
include $page_file;
$refresh_html = ob_get_clean();
t( 'Refreshing GET within 60s keeps green CHECKED IN confirmation', false !== strpos( $refresh_html, 'CHECKED IN' ) && false !== strpos( $refresh_html, 'DOOR CHECK-IN SUCCESSFUL' ) );

// 4D. Another staff user requesting the flag does NOT get the green card
$staff_user_2_id = wp_create_user( 'staff2_' . bin2hex( random_bytes( 4 ) ), wp_generate_password( 24 ), 'staff2_' . time() . '@example.com' );
$staff_user_2    = new WP_User( $staff_user_2_id );
$staff_user_2->set_role( 'event_staff' );

wp_set_current_user( $staff_user_2_id );
$_GET = $redirect_params;
ob_start();
include $page_file;
$staff2_html = ob_get_clean();

t( 'Another staff user requesting flag does NOT see DOOR CHECK-IN SUCCESSFUL', false === strpos( $staff2_html, 'DOOR CHECK-IN SUCCESSFUL' ) );
t( 'Another staff user sees ALREADY CHECKED IN warning instead', false !== strpos( $staff2_html, 'ALREADY CHECKED IN' ) );
t( 'Another staff user sees DO NOT ADMIT warning', false !== strpos( $staff2_html, 'DO NOT ADMIT' ) );

// 4E. A visitor requesting the flag does NOT get the green card
wp_set_current_user( 0 );
$_GET = $redirect_params;
ob_start();
include $page_file;
$visitor_html = ob_get_clean();

t( 'Visitor with flag does NOT see DOOR CHECK-IN SUCCESSFUL', false === strpos( $visitor_html, 'DOOR CHECK-IN SUCCESSFUL' ) );
t( 'Visitor with flag does NOT see ADMITTED • PASS VERIFIED', false === strpos( $visitor_html, 'ADMITTED • PASS VERIFIED' ) );
t( 'Visitor with flag sees TICKET ALREADY USED notice', false !== strpos( $visitor_html, 'TICKET ALREADY USED' ) );
t( 'Visitor with flag never sees Scan next button', false === strpos( $visitor_html, 'Scan next' ) );

// 4F. Expired flag (> 60s) does NOT get the green card
wp_set_current_user( $staff_user_id );
$expired_time  = time() - 65;
$expired_token = cr8v_tix_generate_checkin_token( $code_2, $staff_user_id, $expired_time );
$_GET = array(
	'cr8v_ticket' => $code_2,
	'checked'     => '1',
	'chk_staff'   => $staff_user_id,
	'chk_time'    => $expired_time,
	'chk_token'   => $expired_token,
);
ob_start();
include $page_file;
$expired_html = ob_get_clean();

t( 'Expired flag (>60s) does NOT see DOOR CHECK-IN SUCCESSFUL', false === strpos( $expired_html, 'DOOR CHECK-IN SUCCESSFUL' ) );
t( 'Expired flag falls through to ALREADY CHECKED IN amber card', false !== strpos( $expired_html, 'ALREADY CHECKED IN' ) );
t( 'Expired flag displays DO NOT ADMIT warning', false !== strpos( $expired_html, 'DO NOT ADMIT' ) );

// 4G. Forged flag does NOT get the green card
$_GET = array(
	'cr8v_ticket' => $code_2,
	'checked'     => '1',
	'chk_staff'   => $staff_user_id,
	'chk_time'    => time(),
	'chk_token'   => 'forged_token_000000000000000000',
);
ob_start();
include $page_file;
$forged_html = ob_get_clean();

t( 'Forged flag does NOT see DOOR CHECK-IN SUCCESSFUL', false === strpos( $forged_html, 'DOOR CHECK-IN SUCCESSFUL' ) );
t( 'Forged flag falls through to ALREADY CHECKED IN amber card', false !== strpos( $forged_html, 'ALREADY CHECKED IN' ) );

// 4H. Bare ?checked=1 without token does NOT get the green card
$_GET = array(
	'cr8v_ticket' => $code_2,
	'checked'     => '1',
);
ob_start();
include $page_file;
$bare_html = ob_get_clean();

t( 'Bare ?checked=1 without token does NOT see DOOR CHECK-IN SUCCESSFUL', false === strpos( $bare_html, 'DOOR CHECK-IN SUCCESSFUL' ) );
t( 'Bare ?checked=1 falls through to ALREADY CHECKED IN amber card', false !== strpos( $bare_html, 'ALREADY CHECKED IN' ) );

// 5. Already checked in state (re-visiting the checked-in ticket)
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

// 6. Not-found state (staff enters non-existent ticket code)
$_GET = array( 'cr8v_ticket' => 'TIX-000000000000' );
ob_start();
include $page_file;
$notfound_html = ob_get_clean();

t( 'Not-found ticket displays TICKET NOT FOUND heading', false !== strpos( $notfound_html, 'TICKET NOT FOUND' ) );
t( 'Not-found ticket displays DO NOT ADMIT warning', false !== strpos( $notfound_html, 'DO NOT ADMIT' ) );
t( 'Not-found ticket displays unmistakable Reason banner', false !== strpos( $notfound_html, 'Reason:' ) && false !== strpos( $notfound_html, 'No ticket with code' ) );
t( 'Not-found ticket displays prominent "Scan next" button', false !== strpos( $notfound_html, 'Scan next' ) );
t( 'Not-found ticket does NOT display check-in button or verified pass', false === strpos( $notfound_html, 'CONFIRM DOOR CHECK-IN' ) && false === strpos( $notfound_html, 'OFFICIAL VERIFIED PASS' ) );

// 7. Check-in flag TTL constant and filter
echo "\n=== 7. CHECK-IN FLAG TTL CONSTANT & FILTER ===\n";
t( 'CR8V_TIX_CHECKIN_FLAG_TTL is defined and defaults to 60', defined( 'CR8V_TIX_CHECKIN_FLAG_TTL' ) && 60 === CR8V_TIX_CHECKIN_FLAG_TTL );

wp_set_current_user( $staff_user_id );
$custom_ttl_cb = function( $ttl, $t_code, $s_id ) {
	return 120;
};
add_filter( 'cr8v_tix_checkin_flag_ttl', $custom_ttl_cb, 10, 3 );
$token_90 = cr8v_tix_generate_checkin_token( $code_2, $staff_user_id, time() - 90 );
$valid_filtered = cr8v_tix_verify_checkin_token( $code_2, $staff_user_id, time() - 90, $token_90 );
remove_filter( 'cr8v_tix_checkin_flag_ttl', $custom_ttl_cb, 10 );
$invalid_unfiltered = cr8v_tix_verify_checkin_token( $code_2, $staff_user_id, time() - 90, $token_90 );

t( 'cr8v_tix_checkin_flag_ttl filter allows extending token TTL', true === $valid_filtered );
t( 'Default 60s TTL rejects token older than 60s without filter', false === $invalid_unfiltered );
$zero_cb = function () { return 0; };
add_filter( 'cr8v_tix_checkin_flag_ttl', $zero_cb );
$tok_30 = cr8v_tix_generate_checkin_token( $code_2, $staff_user_id, time() - 30 );
$tok_90b = cr8v_tix_generate_checkin_token( $code_2, $staff_user_id, time() - 90 );
$ok_30  = cr8v_tix_verify_checkin_token( $code_2, $staff_user_id, time() - 30, $tok_30 );
$bad_90 = cr8v_tix_verify_checkin_token( $code_2, $staff_user_id, time() - 90, $tok_90b );
remove_filter( 'cr8v_tix_checkin_flag_ttl', $zero_cb );
t( 'a filter returning 0 falls back to the 60 second default (30s token ok, 90s token rejected)', true === $ok_30 && false === $bad_90 );
$future_tok = cr8v_tix_generate_checkin_token( $code_2, $staff_user_id, time() + 600 );
t( 'a token timestamped in the future is rejected', false === cr8v_tix_verify_checkin_token( $code_2, $staff_user_id, time() + 600, $future_tok ) );
t( 'the check-in token functions live in the plugin, not the theme template', false !== strpos( (string) ( new ReflectionFunction( 'cr8v_tix_verify_checkin_token' ) )->getFileName(), 'cr8v-event-ticketing' ) );

// 8. Real HTTP response headers on /booking-confirmation/
echo "\n=== 8. REAL HTTP SECURITY & NO-CACHE HEADERS ===\n";
$hdr_file   = wp_tempnam();
$dev_null   = ( DIRECTORY_SEPARATOR === '\\' ) ? 'NUL' : '/dev/null';
$curl_bin   = ( DIRECTORY_SEPARATOR === '\\' ) ? 'curl.exe' : 'curl';
$target_url = home_url( '/booking-confirmation/' );
shell_exec( $curl_bin . ' -s -D ' . escapeshellarg( $hdr_file ) . ' -o ' . $dev_null . ' ' . escapeshellarg( $target_url ) );
$dumped_headers = ( file_exists( $hdr_file ) ) ? (string) file_get_contents( $hdr_file ) : '';
if ( file_exists( $hdr_file ) ) {
	@unlink( $hdr_file );
}

t( 'Real HTTP /booking-confirmation/ answers 200 (not an error page that happens to carry the headers)', (bool) preg_match( '#^HTTP/\S+\s+200\b#m', $dumped_headers ), "got headers:\n$dumped_headers" );
t( 'Real HTTP /booking-confirmation/ serves a Cache-Control header containing no-store', (bool) preg_match( '/^Cache-Control:[^\r\n]*\bno-store\b/mi', $dumped_headers ), "got headers:\n$dumped_headers" );
t( 'Real HTTP /booking-confirmation/ serves an X-Robots-Tag header containing noindex', (bool) preg_match( '/^X-Robots-Tag:[^\r\n]*\bnoindex\b/mi', $dumped_headers ), "got headers:\n$dumped_headers" );
t( 'Real HTTP /booking-confirmation/ serves a Referrer-Policy header of no-referrer', (bool) preg_match( '/^Referrer-Policy:\s*no-referrer\s*$/mi', $dumped_headers ), "got headers:\n$dumped_headers" );
// The same must hold on a token URL (the page that actually shows tickets), not just the bare page.
$hdr_file2 = wp_tempnam();
shell_exec( $curl_bin . ' -s -D ' . escapeshellarg( $hdr_file2 ) . ' -o ' . $dev_null . ' ' . escapeshellarg( home_url( '/booking-confirmation/?order_token=res_doesnotexist' ) ) );
$dumped_headers2 = file_exists( $hdr_file2 ) ? (string) file_get_contents( $hdr_file2 ) : '';
if ( file_exists( $hdr_file2 ) ) { @unlink( $hdr_file2 ); }
t( 'Real HTTP token URL also sends no-store, noindex and no-referrer', (bool) preg_match( '/^Cache-Control:[^\r\n]*\bno-store\b/mi', $dumped_headers2 ) && (bool) preg_match( '/^X-Robots-Tag:[^\r\n]*\bnoindex\b/mi', $dumped_headers2 ) && (bool) preg_match( '/^Referrer-Policy:\s*no-referrer\s*$/mi', $dumped_headers2 ), "got headers:\n$dumped_headers2" );

// Cleanup
wp_delete_post( $order_id, true );
wp_delete_post( $test_event_id, true );
wp_delete_user( $staff_user_id );
wp_delete_user( $staff_user_2_id );

echo "\n=== CLEANUP ===\nCleaned up test event, order, and staff users.\n";
echo "RESULT: $pass passed, $fail failed\n";
exit( $fail > 0 ? 1 : 0 );
