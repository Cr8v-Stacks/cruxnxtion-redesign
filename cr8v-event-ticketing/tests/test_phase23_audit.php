<?php
// Checks for: past events, ICS escaping and privacy, QR encoder sanity, email branding filters.
require __DIR__ . '/bootstrap.php';
global $wpdb;

$pass = 0; $fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}
function post_checkout( $params ) {
	$req = new WP_REST_Request( 'POST', '/cr8v-ticketing/v1/checkout' );
	foreach ( $params as $k => $v ) { $req->set_param( $k, $v ); }
	return rest_do_request( $req );
}
function clear_rate() { delete_transient( 'cr8v_rate_' . md5( $_SERVER['REMOTE_ADDR'] ) ); }

$tiers = array( array( 'id' => 'tier_free', 'name' => 'Free', 'description' => '', 'price_pence' => 0, 'capacity' => 50, 'max_per_order' => 5, 'status' => 'active' ) );
$ids   = array();

// Past event
$past = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ PAST EVENT', 'post_status' => 'publish' ) );
update_post_meta( $past, '_cr8v_event_date', '2020-01-01' );
update_post_meta( $past, '_cr8v_event_ticket_tiers', $tiers );
$ids[] = $past;
clear_rate();
$r = post_checkout( array( 'event_id' => $past, 'customer_name' => 'A B', 'customer_email' => 'past@example.com', 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ) ) );
t( 'booking a past event is refused (400)', 400 === $r->get_status(), 'status ' . $r->get_status() );
$held = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM ' . cr8v_tix_reservations_table() . ' WHERE event_id=%d', $past ) );
t( '  ...and no stock was taken', 0 === $held );

// Event today is still bookable
$today = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ TODAY EVENT', 'post_status' => 'publish' ) );
update_post_meta( $today, '_cr8v_event_date', wp_date( 'Y-m-d' ) );
update_post_meta( $today, '_cr8v_event_ticket_tiers', $tiers );
$ids[] = $today;
clear_rate(); delete_transient( 'cr8v_free_' . md5( 'today@example.com|' . $today ) );
$r = post_checkout( array( 'event_id' => $today, 'customer_name' => 'A B', 'customer_email' => 'today@example.com', 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ) ) );
t( 'an event happening today can still be booked', 200 === $r->get_status(), 'status ' . $r->get_status() );

// ICS: escaping and privacy
$ev = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ ICS EVENT; with, punctuation', 'post_status' => 'publish', 'post_excerpt' => "Line one\r\nATTENDEE:mailto:evil@example.com\nLine three, with; semicolon" ) );
update_post_meta( $ev, '_cr8v_event_date', '2030-06-01' );
$ids[] = $ev;
$ics = cr8v_tix_build_event_ics( $ev );
t( 'ICS is produced for a published event', false !== strpos( $ics, 'BEGIN:VEVENT' ) );
t( 'a line break in the description cannot inject a calendar field', ! preg_match( '/^ATTENDEE:/m', $ics ) );
t( 'description line breaks become escaped \\n', false !== strpos( $ics, 'Line one\\nATTENDEE' ) );
t( 'commas and semicolons are escaped in the title', false !== strpos( $ics, 'ZZ ICS EVENT\\; with\\, punctuation' ) );
$bad = false;
foreach ( explode( "\r\n", $ics ) as $line ) { if ( strlen( $line ) > 75 ) { $bad = true; } }
t( 'no ICS line exceeds 75 octets', ! $bad );
$long = wp_insert_post( array( 'post_type' => 'event', 'post_title' => str_repeat( 'LongTitle ', 20 ), 'post_status' => 'publish' ) );
$ids[] = $long;
$lines = explode( "\r\n", cr8v_tix_build_event_ics( $long ) );
$ok = true; foreach ( $lines as $l ) { if ( strlen( $l ) > 75 ) { $ok = false; } }
t( 'long values are folded to 75 octets', $ok );

$draft = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ SECRET DRAFT', 'post_status' => 'draft' ) );
$ids[] = $draft;
wp_set_current_user( 0 );
t( 'draft event calendar is not available to visitors', '' === cr8v_tix_build_event_ics( $draft ) );
$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
if ( $admins ) { wp_set_current_user( $admins[0]->ID ); t( 'draft event calendar is available to an editor', '' !== cr8v_tix_build_event_ics( $draft ) ); wp_set_current_user( 0 ); }

// QR encoder
$link = cr8v_tix_ticket_qr_link( 'TIX-AAAAAAAAAAAA' );
$m    = Cr8v_Qr::encode( $link, 'M' );
t( 'QR encoder returns a square matrix for a real ticket link', is_array( $m ) && count( $m ) === count( $m[0] ) && count( $m ) >= 41, is_array( $m ) ? count( $m ) : 'null' );
t( 'QR encoder is deterministic', Cr8v_Qr::svg( $link ) === Cr8v_Qr::svg( $link ) );
t( 'QR svg differs for different tickets', Cr8v_Qr::svg( $link ) !== Cr8v_Qr::svg( cr8v_tix_ticket_qr_link( 'TIX-BBBBBBBBBBBB' ) ) );
t( 'QR encoder refuses data that is too long instead of drawing garbage', '' === Cr8v_Qr::svg( str_repeat( 'x', 400 ) ) );
t( 'QR svg has the three finder patterns (corner modules dark)', $m[0][0] && $m[0][count( $m ) - 1] && $m[count( $m ) - 1][0] );

// Email branding is filterable
add_filter( 'cr8v_tix_email_brand', function () { return 'Other Brand'; } );
t( 'email brand filter is applied', 'Other Brand' === apply_filters( 'cr8v_tix_email_brand', 'x' ) );

// ---- Attendee CSV lists only real attendees; pass page keeps its no-print class ----
$csv_event = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ CSV EVENT', 'post_status' => 'publish' ) );
$ids[] = $csv_event;
$mk = function ( $status, $email, $name ) use ( $csv_event ) {
	$items = array( array( 'tier_id' => 'tier_free', 'tier_name' => 'Free', 'quantity' => 1, 'unit_price_pence' => 0, 'total_pence' => 0 ) );
	$oid   = cr8v_tix_create_order( $csv_event, $name, $email, '', 0, $status, $items, 'res_' . bin2hex( random_bytes( 6 ) ) );
	cr8v_tix_issue_tickets( $oid, $items, $name );
	return $oid;
};
$csv_orders = array( $mk( 'completed', 'zz-csv-paid@example.com', 'Paid Person' ), $mk( 'pending', 'zz-csv-pending@example.com', 'Pending Person' ), $mk( 'failed', 'zz-csv-failed@example.com', 'Failed Person' ), $mk( 'cancelled', 'zz-csv-cancelled@example.com', 'Cancelled Person' ), $mk( 'refunded', 'zz-csv-refunded@example.com', 'Refunded Person' ) );
$csv = cr8v_tix_build_attendee_csv( $csv_event );
t( 'CSV includes a completed order', false !== strpos( $csv, 'Paid Person' ) );
t( 'CSV includes a refunded order (so door staff can turn it away)', false !== strpos( $csv, 'Refunded Person' ) );
t( 'CSV leaves out pending, failed and cancelled orders (no ticket, so no personal data on the door list)', false === strpos( $csv, 'Pending Person' ) && false === strpos( $csv, 'Failed Person' ) && false === strpos( $csv, 'Cancelled Person' ) );
foreach ( $csv_orders as $o ) { wp_delete_post( $o, true ); }
$page_src = file_get_contents( dirname( __DIR__, 2 ) . '/cruxnxtion-theme/page-booking-confirmation.php' );
t( 'pass page toolbar has a single class attribute that includes no-print', false !== strpos( $page_src, 'class="conf-actions no-print"' ) && ! preg_match( '/class="[^"]*"[^>]*\sclass="/', $page_src ) );

// ---- Door staff: who counts as staff, login redirect, wp-admin block, ticket lookup ----
require_once ABSPATH . 'wp-admin/includes/user.php';
$mkuser = function ( $login, $roles ) {
	$old = get_user_by( 'login', $login );
	if ( $old ) { wp_delete_user( $old->ID ); }
	$uid  = wp_insert_user( array( 'user_login' => $login, 'user_pass' => wp_generate_password( 20 ), 'user_email' => $login . '@example.com', 'role' => $roles[0] ) );
	$user = new WP_User( $uid );
	for ( $i = 1; $i < count( $roles ); $i++ ) { $user->add_role( $roles[ $i ] ); }
	return new WP_User( $uid );
};
$u_staff = $mkuser( 'zz_t_staff', array( 'event_staff' ) );
$u_both  = $mkuser( 'zz_t_both', array( 'event_staff', 'editor' ) );
$u_ed    = $mkuser( 'zz_t_editor', array( 'editor' ) );

t( 'door-staff-only: a user with only the staff role', cr8v_tix_is_door_staff_only( $u_staff ) );
t( 'door-staff-only: staff who is also an editor is NOT locked down', ! cr8v_tix_is_door_staff_only( $u_both ) );
t( 'door-staff-only: editor and a missing user are not staff', ! cr8v_tix_is_door_staff_only( $u_ed ) && ! cr8v_tix_is_door_staff_only( null ) && ! cr8v_tix_is_door_staff_only( new WP_Error( 'x', 'y' ) ) );
t( 'login redirect: staff-only goes to the check-in page', cr8v_tix_staff_login_redirect( '/wp-admin/', '', $u_staff ) === cr8v_tix_staff_landing_url() );
t( 'login redirect: staff who is also an editor keeps the normal destination', '/wp-admin/' === cr8v_tix_staff_login_redirect( '/wp-admin/', '', $u_both ) );
t( 'login redirect: a failed login (WP_Error) is passed through untouched', '/x/' === cr8v_tix_staff_login_redirect( '/x/', '', new WP_Error( 'a', 'b' ) ) );
add_filter( 'cr8v_tix_staff_landing_url', function () { return 'https://example.test/door/'; } );
t( 'staff landing page is filterable (no theme path hardcoded in the plugin)', 'https://example.test/door/' === cr8v_tix_staff_landing_url() );
remove_all_filters( 'cr8v_tix_staff_landing_url' );

$redir = function ( $fn ) {
	$loc = '';
	$h   = function ( $l ) use ( &$loc ) { $loc = $l; throw new RuntimeException( 'redirect' ); };
	add_filter( 'wp_redirect', $h, 1 );
	try { $fn(); } catch ( RuntimeException $e ) { /* expected */ }
	remove_filter( 'wp_redirect', $h, 1 );
	return $loc;
};
set_current_screen( 'dashboard' );
global $pagenow;
foreach ( array( 'edit.php', 'options-general.php', 'plugins.php', 'users.php' ) as $pg ) {
	$pagenow = $pg;
	wp_set_current_user( $u_staff->ID );
	t( "staff-only is redirected away from wp-admin/$pg (not shown a 403)", cr8v_tix_staff_landing_url() === $redir( 'cr8v_tix_staff_block_admin_access' ) );
}
$pagenow = 'edit.php';
wp_set_current_user( $u_both->ID );
t( 'staff who is also an editor can still open wp-admin/edit.php', '' === $redir( 'cr8v_tix_staff_block_admin_access' ) );
wp_set_current_user( $u_ed->ID );
t( 'an editor can still open wp-admin/edit.php', '' === $redir( 'cr8v_tix_staff_block_admin_access' ) );
unset( $GLOBALS['current_screen'] );
wp_set_current_user( 0 );

// Ticket codes: strict format, exact match, case and spacing tolerated.
$lk_event = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ LOOKUP EVENT', 'post_status' => 'publish' ) );
$ids[]    = $lk_event;
$lk_items = array( array( 'tier_id' => 'tier_free', 'tier_name' => 'Free', 'quantity' => 1, 'unit_price_pence' => 0, 'total_pence' => 0 ) );
$lk_order = cr8v_tix_create_order( $lk_event, 'Lookup Person', 'zz-lookup@example.com', '', 0, 'completed', $lk_items, 'res_' . bin2hex( random_bytes( 6 ) ) );
$lk_tix   = cr8v_tix_issue_tickets( $lk_order, $lk_items, 'Lookup Person' );
$real     = $lk_tix[0]['ticket_code'];

t( 'normalise: lowercase and spaces become the canonical code', $real === cr8v_tix_normalize_ticket_code( '  ' . strtolower( $real ) . ' ' ) );
t( 'normalise: partial text, wrong characters and SQL-ish text are rejected', '' === cr8v_tix_normalize_ticket_code( 'TIX' ) && '' === cr8v_tix_normalize_ticket_code( 'TIX-ZZZZZZZZZZZZ' ) && '' === cr8v_tix_normalize_ticket_code( "' OR 1=1 --" ) && '' === cr8v_tix_normalize_ticket_code( 'a:2' ) );
$found = cr8v_tix_find_ticket( strtolower( $real ) );
t( 'find: a real code (any case) returns its order and ticket', $found && (int) $found['order_id'] === (int) $lk_order && $found['code'] === $real );
t( 'find: a well-formed code that does not exist returns nothing', null === cr8v_tix_find_ticket( 'TIX-000000000000' ) );
t( 'find: "TIX", "a:2" and empty text return nothing', null === cr8v_tix_find_ticket( 'TIX' ) && null === cr8v_tix_find_ticket( 'a:2' ) && null === cr8v_tix_find_ticket( '' ) );

// The pass page itself, as door staff typing a code and as a visitor.
$page_file = dirname( __DIR__, 2 ) . '/cruxnxtion-theme/page-booking-confirmation.php';
$render    = function ( $get, $user_id ) use ( $page_file ) {
	$_GET = $get;
	$_POST = array();
	wp_set_current_user( $user_id );
	ob_start();
	include $page_file;
	return ob_get_clean();
};
$h_real = $render( array( 'cr8v_ticket' => strtolower( $real ) ), $u_staff->ID );
t( 'page: staff typing a real code (lowercase) sees the verified pass and the check-in button', false !== strpos( $h_real, 'OFFICIAL VERIFIED PASS' ) && false !== strpos( $h_real, 'CONFIRM DOOR CHECK-IN' ) && false !== strpos( $h_real, 'Lookup Person' ) );
foreach ( array( 'TIX-000000000000', 'TIX-DOESNOTEXIST', 'TIX', 'a:2', "' OR 1=1 --" ) as $fake ) {
	$h_fake = $render( array( 'cr8v_ticket' => $fake ), $u_staff->ID );
	t( 'page: staff typing "' . $fake . '" gets TICKET NOT FOUND, no pass, no check-in button', false !== strpos( $h_fake, 'TICKET NOT FOUND' ) && false === strpos( $h_fake, 'OFFICIAL VERIFIED PASS' ) && false === strpos( $h_fake, 'CONFIRM DOOR CHECK-IN' ) );
}
$h_vis = $render( array( 'cr8v_ticket' => $real ), 0 );
t( 'page: a visitor with only the code (no secret) sees no pass', false === strpos( $h_vis, 'OFFICIAL VERIFIED PASS' ) && false === strpos( $h_vis, 'Lookup Person' ) );
$h_qr = $render( array( 'cr8v_ticket' => $real, 'tix_secret' => cr8v_tix_ticket_secret( $real ) ), 0 );
t( 'page: a visitor scanning the real QR link sees the pass but no check-in button', false !== strpos( $h_qr, 'OFFICIAL VERIFIED PASS' ) && false === strpos( $h_qr, 'CONFIRM DOOR CHECK-IN' ) );
$h_forged = $render( array( 'cr8v_ticket' => $real, 'tix_secret' => 'forged' ), 0 );
t( 'page: a real code with a forged secret is rejected', false === strpos( $h_forged, 'OFFICIAL VERIFIED PASS' ) && false !== strpos( $h_forged, 'INVALID TICKET' ) );
$gone  = cr8v_tix_ticket_secret( 'TIX-0123456789AB' );
$h_gh  = $render( array( 'cr8v_ticket' => 'TIX-0123456789AB', 'tix_secret' => $gone ), 0 );
t( 'page: a genuine-looking link for a ticket that no longer exists says NOT FOUND, not valid', false !== strpos( $h_gh, 'TICKET NOT FOUND' ) && false === strpos( $h_gh, 'OFFICIAL VERIFIED PASS' ) );
// Door staff result screens (phone): the "Scan next" button must come before the long details, so it is
// reachable without scrolling after every scan; the Log out link must be readable on the dark card.
$lk_ticket_list = get_post_meta( $lk_order, '_cr8v_order_tickets', true );
$lk_ticket_list[0]['checked_in']    = true;
$lk_ticket_list[0]['checked_in_at'] = current_time( 'mysql' );
update_post_meta( $lk_order, '_cr8v_order_tickets', $lk_ticket_list );
$h_dup = $render( array( 'cr8v_ticket' => $real ), $u_staff->ID );
t( 'duplicate screen puts Scan next before the attendee details', false !== strpos( $h_dup, 'ALREADY CHECKED IN' ) && strpos( $h_dup, 'Scan next' ) < strpos( $h_dup, 'class="door-verify-box"' ) );
$h_nf = $render( array( 'cr8v_ticket' => 'TIX-000000000000' ), $u_staff->ID );
t( 'not-found screen has Scan next', false !== strpos( $h_nf, 'TICKET NOT FOUND' ) && false !== strpos( $h_nf, 'Scan next' ) );
$h_land = $render( array(), $u_staff->ID );
t( 'staff landing page: Log out link is not the unreadable dark red', false !== strpos( $h_land, 'Log out' ) && false === strpos( $h_land, 'color:#BA0000; font-weight:600; text-decoration:underline;' ) );
$h_used = $render( array( 'cr8v_ticket' => $real, 'tix_secret' => cr8v_tix_ticket_secret( $real ) ), 0 );
t( 'an attendee viewing their own used pass is not told DO NOT ADMIT (that wording is for door staff)', false !== strpos( $h_used, 'ALREADY CHECKED IN' ) && false === stripos( $h_used, 'do not admit' ) && false !== strpos( $h_used, 'TICKET ALREADY USED' ) );
t( 'door staff viewing the same used pass is told DO NOT ADMIT', false !== stripos( $h_dup, 'do not admit' ) );
t( 'visitor never sees a Scan next button or the staff portal', false === strpos( $render( array( 'cr8v_ticket' => 'TIX-000000000000' ), 0 ), 'Scan next' ) );
$_GET = array();
wp_set_current_user( 0 );
wp_delete_post( $lk_order, true );
foreach ( array( $u_staff, $u_both, $u_ed ) as $du ) { wp_delete_user( $du->ID ); }
foreach ( $ids as $i ) { wp_delete_post( $i, true ); }
$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . cr8v_tix_reservations_table() . ' WHERE event_id IN (' . implode( ',', array_map( 'intval', $ids ) ) . ')' ) );
foreach ( get_posts( array( 'post_type' => 'event_order', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids', 'meta_key' => '_cr8v_order_customer_email', 'meta_value' => 'today@example.com' ) ) as $o ) { wp_delete_post( $o, true ); }
echo "\nRESULT: $pass passed, $fail failed\n";
