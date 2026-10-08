<?php
/**
 * Shared events plugin (cr8v-events-core) tests, step E1 of EVENTS_CONVERGENCE_PLAN.md.
 *
 * The plugin cannot be active next to crux-nxtion-core (same post type), so this suite loads its editor box and
 * helpers directly and drives them through WordPress's own save routine.
 *
 *  1. The date helper only accepts a real calendar date.
 *  2. The Studio box offers a date picker for exact dates and keeps the text box for loose values.
 *  3. The three new optional fields (short title, country, ticket colour) save, clear and reject bad input.
 *  4. Everything the box saved before still saves exactly as before (Red Cap and Black and White Crafts rely on it).
 *  5. Opening and saving an event with a loose date such as "2026" never changes that date.
 *  6. The ticketing plugin's Event Details box steps aside when the Studio box is present.
 *
 *   php cr8v-event-ticketing/tests/test_events_core.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once dirname( __DIR__, 2 ) . '/cr8v-events-core/inc/cpt-events.php';
require_once dirname( __DIR__, 2 ) . '/cr8v-events-core/inc/meta-boxes.php';

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}

$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
wp_set_current_user( $admins[0]->ID );

/** Save an event the way the Update button does: post the box's fields with its nonce, then run the save. */
function ec_save( $id, array $fields ) {
	$_POST = array_merge( array( 'cr8v_event_meta_nonce' => wp_create_nonce( 'cr8v_save_event_meta' ) ), wp_slash( $fields ) );
	cr8v_save_custom_meta( $id );
	$_POST = array();
}
function ec_box( $id ) {
	ob_start();
	cr8v_render_event_studio_meta_box( get_post( $id ) );
	return ob_get_clean();
}
function ec_meta( $id, $k ) { return get_post_meta( $id, '_cr8v_event_' . $k, true ); }

echo "== 1. Date helper\n";
t( 'a real date is accepted', '2026-03-14' === cr8v_event_iso_date( '2026-03-14' ) );
t( 'a bare year is not an exact date', null === cr8v_event_iso_date( '2026' ) );
t( 'free text is not an exact date', null === cr8v_event_iso_date( 'Spring 2026' ) );
t( 'an impossible date is refused', null === cr8v_event_iso_date( '2026-02-30' ) );
t( 'empty is refused', null === cr8v_event_iso_date( '' ) );

$exact = wp_insert_post( array( 'post_type' => 'event', 'post_status' => 'publish', 'post_title' => 'ZZ core test exact' ) );
$loose = wp_insert_post( array( 'post_type' => 'event', 'post_status' => 'publish', 'post_title' => 'ZZ core test loose' ) );
update_post_meta( $exact, '_cr8v_event_date', '2026-03-14' );
update_post_meta( $loose, '_cr8v_event_date', '2026' );

echo "== 2. Editor box\n";
$html_exact = ec_box( $exact );
$html_loose = ec_box( $loose );
t( 'an exact date gets a date picker', (bool) preg_match( '/<input type="date" id="cr8v_event_date"/', $html_exact ) );
t( 'a loose date keeps the text box so nothing is lost', (bool) preg_match( '/<input type="text" id="cr8v_event_date"[^>]*value="2026"/', $html_loose ) );
t( 'a new event gets a date picker', (bool) preg_match( '/<input type="date" id="cr8v_event_date"/', ec_box( wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ core test new', 'post_status' => 'draft' ) ) ) ) );
foreach ( array( 'cr8v_event_short_title', 'cr8v_event_location', 'cr8v_event_badge_style' ) as $f ) {
	t( "box offers the field $f", false !== strpos( $html_exact, 'name="' . $f . '"' ) );
}
foreach ( array( 'cr8v_event_time', 'cr8v_event_venue', 'cr8v_event_kicker', 'cr8v_event_capacity', 'cr8v_event_lead_prod', 'cr8v_event_excerpt', 'cr8v_event_scope', 'cr8v_spec_audio', 'cr8v_spec_lighting', 'cr8v_spec_staging', 'cr8v_spec_crew', 'cr8v_event_cta_txt', 'cr8v_event_cta_url', 'cr8v_event_gallery_ids' ) as $f ) {
	t( "existing field still in the box: $f", false !== strpos( $html_exact, 'name="' . $f . '"' ) );
}

echo "== 3. New optional fields\n";
ec_save( $exact, array( 'cr8v_event_date' => '2026-03-14', 'cr8v_event_short_title' => 'Short ZZ', 'cr8v_event_location' => 'United Kingdom', 'cr8v_event_badge_style' => 'purple' ) );
t( 'short title saved', 'Short ZZ' === ec_meta( $exact, 'short_title' ) );
t( 'country saved', 'United Kingdom' === ec_meta( $exact, 'location' ) );
t( 'ticket colour saved', 'purple' === ec_meta( $exact, 'badge_style' ) );
ec_save( $exact, array( 'cr8v_event_short_title' => '', 'cr8v_event_location' => '', 'cr8v_event_badge_style' => '' ) );
t( 'clearing short title removes it', '' === ec_meta( $exact, 'short_title' ) && ! metadata_exists( 'post', $exact, '_cr8v_event_short_title' ) );
t( 'clearing country removes it', ! metadata_exists( 'post', $exact, '_cr8v_event_location' ) );
t( 'choosing Default removes the colour', ! metadata_exists( 'post', $exact, '_cr8v_event_badge_style' ) );
ec_save( $exact, array( 'cr8v_event_badge_style' => 'javascript:alert(1)' ) );
t( 'an unknown colour is not stored', ! metadata_exists( 'post', $exact, '_cr8v_event_badge_style' ) );
ec_save( $exact, array( 'cr8v_event_short_title' => '<b>Bold</b> ' . str_repeat( 'x', 200 ) ) );
t( 'short title is stripped of markup and capped at 80 characters', 80 === mb_strlen( ec_meta( $exact, 'short_title' ) ) && false === strpos( ec_meta( $exact, 'short_title' ), '<' ) );
ec_save( $exact, array( 'cr8v_event_location' => 'Nigeria' ) );
t( 'saving only one optional field leaves the others alone', 'Nigeria' === ec_meta( $exact, 'location' ) && 80 === mb_strlen( ec_meta( $exact, 'short_title' ) ) );

echo "== 4. Existing fields save exactly as before\n";
$legacy = array(
	'cr8v_event_date' => '2024-02-24', 'cr8v_event_time' => '18:00 - 23:30 BST', 'cr8v_event_venue' => 'Somerset House, Strand, London',
	'cr8v_event_kicker' => 'Live Concert', 'cr8v_event_capacity' => '1,200 Attendees', 'cr8v_event_lead_prod' => 'Technical Staging',
	'cr8v_event_excerpt' => "Line one.\nLine two.", 'cr8v_event_scope' => "Scope text.\nSecond paragraph.",
	'cr8v_spec_audio' => 'Array A', 'cr8v_spec_lighting' => 'Rig B', 'cr8v_spec_staging' => 'Deck C', 'cr8v_spec_crew' => '24 crew',
	'cr8v_event_cta_txt' => 'Commission', 'cr8v_event_cta_url' => '/contact/', 'cr8v_event_gallery_ids' => '11,22',
);
ec_save( $exact, $legacy );
$all = true;
foreach ( $legacy as $k => $v ) {
	if ( (string) get_post_meta( $exact, '_' . $k, true ) !== $v ) { $all = false; echo "      differs: $k\n"; }
}
t( 'all fifteen existing fields round-trip unchanged', $all );

echo "== 5. A loose date survives open and save\n";
ec_save( $loose, array( 'cr8v_event_date' => '2026', 'cr8v_event_venue' => 'Lagos' ) );
t( 'a bare year stays a bare year', '2026' === ec_meta( $loose, 'date' ) );
ec_save( $loose, array( 'cr8v_event_date' => '2026-09-05' ) );
t( 'it can be replaced by an exact date', '2026-09-05' === ec_meta( $loose, 'date' ) && null !== cr8v_event_iso_date( ec_meta( $loose, 'date' ) ) );
$_POST = array( 'cr8v_event_date' => '1999', 'cr8v_event_short_title' => 'No nonce' );
cr8v_save_custom_meta( $loose );
$_POST = array();
t( 'a save without the box nonce changes nothing', '2026-09-05' === ec_meta( $loose, 'date' ) && 'No nonce' !== ec_meta( $loose, 'short_title' ) );

echo "== 6. Ticketing box steps aside\n";
global $wp_meta_boxes;
$wp_meta_boxes = array();
cr8v_tix_add_meta_box();
t( 'Event Details box is not added next to the Studio box', empty( $wp_meta_boxes['event']['normal']['high']['cr8v_event_details'] ) );

foreach ( array( $exact, $loose ) as $id ) { wp_delete_post( $id, true ); }
foreach ( get_posts( array( 'post_type' => 'event', 'post_status' => 'any', 'title' => 'ZZ core test new', 'numberposts' => -1, 'fields' => 'ids' ) ) as $id ) { wp_delete_post( $id, true ); }
$left = get_posts( array( 'post_type' => 'event', 'post_status' => 'any', 's' => 'ZZ core test', 'numberposts' => -1, 'fields' => 'ids' ) );
t( 'test events cleaned up', 0 === count( $left ) );

echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
