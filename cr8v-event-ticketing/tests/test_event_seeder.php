<?php
/**
 * Event seeder and editability tests.
 *
 * Proves, for the Crux Nxtion theme:
 *  1. A fresh install gets all eight events COMPLETE (every field, Featured Image, Gallery).
 *  2. The seeder never overwrites the client's edits, never recreates a deleted event, and is idempotent.
 *  3. EVERY piece of content shown on an event page can be changed from the admin: each field is given a unique
 *     value through WordPress's own save routine (edit_post, what the Update button runs) and must then appear
 *     on the public page.
 *  4. The real events on this site are complete and their text was not altered.
 *
 *   php cr8v-event-ticketing/tests/test_event_seeder.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';
global $wpdb;

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}

$P    = 'zz-seedtest-';
$data = crux_event_seed_data();
$made = array();

echo "== 1. Fresh install creates every event completely\n";
$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
wp_set_current_user( $admins[0]->ID );
$report = crux_seed_events( null, $P );
t( 'eight events created', 8 === count( array_filter( $report, function ( $s ) { return 'created' === $s; } ) ), wp_json_encode( $report ) );

$map_ok = true;
foreach ( $data as $ev ) {
	foreach ( array_merge( array( $ev['hero_blob'] ), $ev['gallery_blobs'] ) as $b ) {
		if ( ! crux_blob_attachment_id( $b ) ) { $map_ok = false; echo "      missing Media Library image for blob $b ({$ev['slug']})\n"; }
	}
}
t( 'every hero and gallery image of every event exists in the Media Library', $map_ok );

foreach ( $data as $ev ) {
	$post = get_page_by_path( $P . $ev['slug'], OBJECT, 'event' );
	$made[ $ev['slug'] ] = $post ? $post->ID : 0;
	if ( ! $post ) { t( "event {$ev['slug']} exists", false ); continue; }
	$id = $post->ID;
	$m  = function ( $k ) use ( $id ) { return (string) get_post_meta( $id, '_cr8v_event_' . $k, true ); };
	$complete = $post->post_title === $ev['title'] && $post->post_excerpt === $ev['excerpt'] && $post->post_content === $ev['content']
		&& $m( 'date' ) === $ev['date'] && $m( 'time' ) === $ev['time'] && $m( 'venue' ) === $ev['venue'] && $m( 'location' ) === $ev['country']
		&& $m( 'category' ) === $ev['category'] && $m( 'short_title' ) === $ev['short_title'] && $m( 'eventbrite' ) === $ev['booking_url']
		&& $m( 'badge_style' ) === $ev['badge_style'] && 'publish' === $post->post_status;
	t( "{$ev['slug']}: title, summary, description, date, time, venue, country, category, short title, booking link and colour are all stored", $complete );
	$gal = array_filter( array_map( 'absint', explode( ',', $m( 'gallery_ids' ) ) ) );
	t( "{$ev['slug']}: Featured Image and a Gallery of " . count( $ev['gallery_blobs'] ) . " Media Library images are attached (visible and editable in the admin)", has_post_thumbnail( $id ) && count( $gal ) === count( $ev['gallery_blobs'] ) );
}

echo "== 2. Idempotent, never overwrites, never resurrects\n";
$again = crux_seed_events( null, $P );
t( 'a second run changes nothing', 8 === count( array_filter( $again, function ( $s ) { return 'unchanged' === $s; } ) ), wp_json_encode( $again ) );
$count_before = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='event' AND post_name LIKE '{$P}%'" );
t( 'no duplicate posts after the second run', 8 === $count_before, (string) $count_before );

$a = $made['ankara-festival'];
wp_update_post( array( 'ID' => $a, 'post_title' => 'Client Edited Title', 'post_excerpt' => 'Client wrote this summary.' ) );
update_post_meta( $a, '_cr8v_event_venue', 'Client Venue' );
delete_post_meta( $a, '_crux_seed_version' );
crux_seed_events( null, $P );
$pa = get_post( $a );
t( "the client's title, summary and venue survive a re-run, even without the seed marker", 'Client Edited Title' === $pa->post_title && 'Client wrote this summary.' === $pa->post_excerpt && 'Client Venue' === get_post_meta( $a, '_cr8v_event_venue', true ) );

delete_post_meta( $a, '_cr8v_event_category' );
delete_post_meta( $a, '_crux_event_category' );
crux_seed_events( null, $P );
t( 'a field that is EMPTY is completed again', '' !== get_post_meta( $a, '_cr8v_event_category', true ) );

$gone = $made['yagi-awards'];
wp_trash_post( $gone );
$rep = crux_seed_events( null, $P );
t( 'an event the client moved to the trash is not recreated', 'skipped (trashed)' === $rep[ $P . 'yagi-awards' ] && 'trash' === get_post_status( $gone ) );
wp_untrash_post( $gone );
wp_publish_post( $gone );

echo "== 2b. Old web addresses are renamed, not duplicated\n";
$old_id = wp_insert_post( array( 'post_type' => 'event', 'post_status' => 'publish', 'post_title' => 'Old Lasgidi', 'post_name' => $P . 'old-lasgidi-address' ) );
$mini   = array( array_merge( $data[2], array( 'slug' => 'brand-new-address', 'old_slugs' => array( 'old-lasgidi-address' ) ) ) );
crux_seed_events( $mini, $P );
$renamed = get_post( $old_id );
t( 'a post found under the old address is renamed to the clean one (and completed)', $P . 'brand-new-address' === $renamed->post_name && '' !== $renamed->post_excerpt );
$made['renamed'] = $old_id;

echo "== 3. EVERY field on the event page is editable from the admin\n";
$id    = $made['dance-out-2023'];
$post  = get_post( $id );
$atts  = array();
foreach ( $data as $ev ) { $atts[] = crux_blob_attachment_id( $ev['hero_blob'] ); }
$atts  = array_values( array_unique( array_filter( $atts ) ) );
$hero2 = $atts[1];
$gal2  = array( $atts[2], $atts[3] );
$tok   = 'ZZtoken' . substr( md5( 'x' ), 0, 6 );
$new   = array(
	'title'       => "Edited Title $tok",
	'short_title' => "ShortTitle$tok",
	'category'    => "Category$tok",
	'date'        => '2031-02-03',
	'time'        => "Time $tok",
	'venue'       => "Venue $tok",
	'country'     => "Country $tok",
	'excerpt'     => "Summary $tok edited in the admin.",
	'content'     => "Description $tok edited in the admin.",
	'booking'     => 'https://example.test/book-' . $tok,
	'badge'       => 'purple',
);

$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array(
	'post_ID'                => $id,
	'post_type'              => 'event',
	'post_status'            => 'publish',
	'post_title'             => $new['title'],
	'content'                => $new['content'],
	'excerpt'                => $new['excerpt'],
	'_thumbnail_id'          => $hero2,
	'cr8v_tix_nonce'         => wp_create_nonce( 'cr8v_tix_save_event' ),
	'cr8v_event_date'        => $new['date'],
	'cr8v_event_time'        => $new['time'],
	'cr8v_event_venue'       => $new['venue'],
	'cr8v_event_location'    => $new['country'],
	'cr8v_event_category'    => $new['category'],
	'cr8v_event_short_title' => $new['short_title'],
	'cr8v_event_eventbrite'  => $new['booking'],
	'cr8v_event_badge_style' => $new['badge'],
	'cr8v_event_gallery_ids' => implode( ',', $gal2 ),
);
$saved = edit_post();
t( 'the admin save routine (edit_post, as run by the Update button) accepts the edit', (int) $saved === (int) $id );
$_POST = array();
$_SERVER['REQUEST_METHOD'] = 'GET';

// Public page, rendered through the real template.
$GLOBALS['wp_query']->query( array( 'post_type' => 'event', 'name' => $P . 'dance-out-2023' ) );
$_SERVER['REQUEST_URI'] = '/event/' . $P . 'dance-out-2023/';
wp_set_current_user( 0 );
ob_start();
include get_template_directory() . '/single-event.php';
$html = ob_get_clean();

$date_fmt = wp_date( 'l, j F Y', ( new DateTimeImmutable( '2031-02-03', wp_timezone() ) )->getTimestamp(), wp_timezone() );
$checks = array(
	'title'                  => false !== strpos( $html, esc_html( mb_strtoupper( $new['title'], 'UTF-8' ) ) ),
	'short title'            => false !== strpos( $html, esc_html( $new['short_title'] ) ),
	'category'               => false !== strpos( $html, esc_html( $new['category'] ) ),
	'date'                   => false !== strpos( $html, esc_html( $date_fmt ) ),
	'time'                   => false !== strpos( $html, esc_html( $new['time'] ) ),
	'venue'                  => false !== strpos( $html, esc_html( $new['venue'] ) ),
	'country'                => false !== strpos( $html, esc_html( $new['country'] ) ),
	'summary (Excerpt)'      => false !== strpos( $html, esc_html( $new['excerpt'] ) ),
	'description (editor)'   => false !== strpos( $html, esc_html( $new['content'] ) ),
	'booking link'           => false !== strpos( $html, esc_url( $new['booking'] ) ),
	'Featured Image (hero)'  => false !== strpos( $html, esc_url( wp_get_attachment_image_url( $hero2, 'large' ) ) ),
	'Gallery image 1'        => false !== strpos( $html, esc_url( wp_get_attachment_image_url( $gal2[0], 'large' ) ) ),
	'Gallery image 2'        => false !== strpos( $html, esc_url( wp_get_attachment_image_url( $gal2[1], 'large' ) ) ),
);
foreach ( $checks as $label => $ok ) { t( "edit the $label in the admin -> it changes on the public event page", $ok ); }
$ed = crux_get_event_data( $id );
t( 'edit the ticket colour in the admin -> it changes on the event cards', '#8C7AE6' === $ed['badge_bg'] );
t( 'the old text is gone from the page (nothing is served from a hidden copy)', false === strpos( $html, esc_html( $data[3]['excerpt'] ) ) && false === strpos( $html, esc_html( $data[3]['content'] ) ) );

echo "== 3b. Clearing a field really clears it (no old value comes back)\n";
wp_set_current_user( $admins[0]->ID );
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array( 'post_ID' => $id, 'post_type' => 'event', 'post_status' => 'publish', 'post_title' => $new['title'], 'content' => $new['content'], 'excerpt' => '', '_thumbnail_id' => $hero2,
	'cr8v_tix_nonce' => wp_create_nonce( 'cr8v_tix_save_event' ), 'cr8v_event_date' => $new['date'], 'cr8v_event_time' => '', 'cr8v_event_venue' => $new['venue'], 'cr8v_event_location' => $new['country'],
	'cr8v_event_category' => $new['category'], 'cr8v_event_short_title' => $new['short_title'], 'cr8v_event_eventbrite' => '', 'cr8v_event_badge_style' => 'red', 'cr8v_event_gallery_ids' => '' );
edit_post();
$_POST = array(); $_SERVER['REQUEST_METHOD'] = 'GET';
$ed2 = crux_get_event_data( $id );
t( 'a cleared time stays empty', '' === $ed2['time_str'] );
t( 'a cleared summary stays empty', '' === $ed2['desc_1'] );
t( 'a cleared booking link stays empty', '' === $ed2['eventbrite'] );
t( 'a cleared gallery falls back to the original photos, not to nothing', count( $ed2['gallery_urls'] ) >= 1 );

echo "== 3c. The admin Event Details box shows every field with its current value\n";
$post = get_post( $made['ankara-festival'] );
update_post_meta( $post->ID, '_cr8v_event_venue', 'Box Venue' );
ob_start();
cr8v_tix_render_meta_box( $post );
$box = ob_get_clean();
foreach ( array( 'cr8v_event_date', 'cr8v_event_time', 'cr8v_event_venue', 'cr8v_event_location', 'cr8v_event_category', 'cr8v_event_short_title', 'cr8v_event_eventbrite', 'cr8v_event_badge_style', 'cr8v_event_gallery_ids' ) as $field ) {
	t( "Event Details box contains the field $field", false !== strpos( $box, 'name="' . $field . '"' ) );
}
t( 'Event Details box is filled with the stored value (venue)', false !== strpos( $box, 'value="Box Venue"' ) );
t( 'Event Details box shows the gallery thumbnails', substr_count( $box, '<img' ) >= 3 );
$cpt = get_post_type_object( 'event' );
if ( function_exists( 'cr8v_render_event_studio_meta_box' ) ) {
	// Shared events plugin active: summary and description are fields of the Studio box, the editor is hidden.
	ob_start();
	cr8v_render_event_studio_meta_box( $post );
	$studio = ob_get_clean();
	t( 'the event editor offers Title and Featured Image, and the Studio box offers Summary and Description', post_type_supports( 'event', 'title' ) && post_type_supports( 'event', 'thumbnail' ) && false !== strpos( $studio, 'name="cr8v_event_excerpt"' ) && false !== strpos( $studio, 'name="cr8v_event_scope"' ) );
} else {
	t( 'the event editor offers Title, Description, Summary (Excerpt) and Featured Image', post_type_supports( 'event', 'title' ) && post_type_supports( 'event', 'editor' ) && post_type_supports( 'event', 'excerpt' ) && post_type_supports( 'event', 'thumbnail' ) );
}

echo "== 4. The real events on this site\n";
$baseline = array( 13029 => array( 178, 399 ), 13030 => array( 172, 395 ), 13031 => array( 156, 359 ), 13032 => array( 164, 298 ), 13033 => array( 180, 382 ), 13034 => array( 153, 350 ), 13035 => array( 160, 359 ), 13036 => array( 132, 297 ) );
$real_ok = true; $txt_ok = true; $listed = 0;
foreach ( $data as $ev ) {
	$rp = get_page_by_path( $ev['slug'], OBJECT, 'event' );
	if ( ! $rp ) { $real_ok = false; echo "      real event {$ev['slug']} missing\n"; continue; }
	$listed++;
	$gal = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $rp->ID, '_cr8v_event_gallery_ids', true ) ) ) );
	if ( ! has_post_thumbnail( $rp->ID ) || count( $gal ) !== count( $ev['gallery_blobs'] ) || '' === $rp->post_excerpt || '' === $rp->post_content ) { $real_ok = false; echo "      real event {$ev['slug']} incomplete\n"; }
	if ( isset( $baseline[ $rp->ID ] ) && ( strlen( $rp->post_excerpt ) !== $baseline[ $rp->ID ][0] || strlen( $rp->post_content ) !== $baseline[ $rp->ID ][1] ) ) { $txt_ok = false; echo "      real event {$ev['slug']} text length changed\n"; }
}
t( 'all eight real events exist and have summary, description, Featured Image and every gallery photo in the admin', $real_ok && 8 === $listed );
t( "the real events' existing text was not altered by the seeder", $txt_ok );

echo "== Cleanup\n";
foreach ( $made as $pid ) { if ( $pid ) { wp_delete_post( $pid, true ); } }
$left = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='event' AND post_name LIKE '{$P}%'" );
t( 'no test events left behind', 0 === $left, (string) $left );
$_POST = array(); $_GET = array();
wp_set_current_user( 0 );
echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
