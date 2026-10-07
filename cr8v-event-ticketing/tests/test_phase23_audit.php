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

foreach ( $ids as $i ) { wp_delete_post( $i, true ); }
$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . cr8v_tix_reservations_table() . ' WHERE event_id IN (' . implode( ',', array_map( 'intval', $ids ) ) . ')' ) );
foreach ( get_posts( array( 'post_type' => 'event_order', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids', 'meta_key' => '_cr8v_order_customer_email', 'meta_value' => 'today@example.com' ) ) as $o ) { wp_delete_post( $o, true ); }
echo "\nRESULT: $pass passed, $fail failed\n";
