<?php
/**
 * Convergence test, step E2 of EVENTS_CONVERGENCE_PLAN.md: Crux events edited in the shared plugin's Studio box.
 *
 *  1. An event created the original way (seeder) reads the same as before.
 *  2. Opening it in the Studio box and pressing Update loses NOTHING: the whole page data is identical afterwards.
 *  3. Every field of the Studio box, edited through WordPress's own save routine (edit_post), changes the public
 *     Crux event page.
 *  4. A cleared field stays cleared.
 *  5. The default editor and Excerpt box are hidden once the shared plugin runs on this theme.
 *
 *   php cr8v-event-ticketing/tests/test_events_convergence.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once dirname( __DIR__, 2 ) . '/cr8v-events-core/inc/cpt-events.php';
require_once dirname( __DIR__, 2 ) . '/cr8v-events-core/inc/meta-boxes.php';
global $wpdb;

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}

$P    = 'zz-conv-';
$data = crux_event_seed_data();
$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
wp_set_current_user( $admins[0]->ID );
crux_seed_events( array( $data[3] ), $P );
$post = get_page_by_path( $P . $data[3]['slug'], OBJECT, 'event' );
$id   = $post->ID;
$ev   = $data[3];

/** Press Update in the Studio box with the given field values on top of what the box currently shows. */
function conv_update( $id, array $over = array(), array $remove = array() ) {
	$post = get_post( $id );
	ob_start();
	cr8v_render_event_studio_meta_box( $post );
	$html = ob_get_clean();
	// Read every field the box shows, as the browser would post it.
	$fields = array();
	if ( preg_match_all( '/<(input|textarea|select)\b[^>]*\bname="([^"]+)"[^>]*>/s', $html, $mm, PREG_SET_ORDER ) ) {
		foreach ( $mm as $m ) {
			$name = $m[2];
			if ( 'textarea' === $m[1] ) {
				preg_match( '/<textarea[^>]*name="' . preg_quote( $name, '/' ) . '"[^>]*>(.*?)<\/textarea>/s', $html, $tm );
				$fields[ $name ] = html_entity_decode( $tm[1] ?? '', ENT_QUOTES );
			} elseif ( 'select' === $m[1] ) {
				preg_match( '/<select[^>]*name="' . preg_quote( $name, '/' ) . '"[^>]*>(.*?)<\/select>/s', $html, $sm );
				$fields[ $name ] = '';
				if ( preg_match( '/<option value="([^"]*)"\s+selected/', $sm[1] ?? '', $om ) ) { $fields[ $name ] = $om[1]; }
			} else {
				preg_match( '/value="([^"]*)"/', $m[0], $vm );
				$fields[ $name ] = html_entity_decode( $vm[1] ?? '', ENT_QUOTES );
			}
		}
	}
	$fields = array_merge( $fields, $over );
	foreach ( $remove as $r ) { $fields[ $r ] = ''; }
	$_SERVER['REQUEST_METHOD'] = 'POST';
	$_POST = wp_slash( array_merge( array( 'post_ID' => $id, 'post_type' => 'event', 'post_status' => 'publish', 'post_title' => $post->post_title ), $fields ) );
	$r = edit_post();
	$_POST = array();
	$_SERVER['REQUEST_METHOD'] = 'GET';
	return (int) $r;
}

echo "== 1. Original events read as before\n";
$before = crux_get_event_data( $id );
t( 'summary, description, category and booking link come from the original fields', $ev['excerpt'] === $before['desc_1'] && wp_strip_all_tags( $ev['content'] ) === $before['desc_2'] && $ev['category'] === $before['category'] && $ev['booking_url'] === $before['eventbrite'] );

echo "== 2. Open in the Studio box and press Update: nothing is lost\n";
$box_html = ( function () use ( $post ) { ob_start(); cr8v_render_event_studio_meta_box( $post ); return ob_get_clean(); } )();
t( 'the box shows the summary, description, category and booking link of the original event', false !== strpos( $box_html, esc_textarea( $ev['excerpt'] ) ) && false !== strpos( $box_html, esc_attr( $ev['category'] ) ) && false !== strpos( $box_html, esc_attr( $ev['booking_url'] ) ) );
t( 'the box offers the short title, country and colour already stored', false !== strpos( $box_html, esc_attr( $ev['short_title'] ) ) && false !== strpos( $box_html, esc_attr( $ev['country'] ) ) );
t( 'the update is accepted', $id === conv_update( $id ) );
$after = crux_get_event_data( $id );
$diff  = array();
foreach ( $before as $k => $v ) { if ( $after[ $k ] !== $v ) { $diff[] = $k; } }
t( 'every value of the event page data is identical after Update', ! $diff, 'changed: ' . implode( ',', $diff ) );
t( 'the poster (Featured Image) and gallery are unchanged', $before['hero_url'] === $after['hero_url'] && $before['gallery_urls'] === $after['gallery_urls'] );

echo "== 3. Every Studio field changes the public page\n";
$atts = array();
foreach ( $data as $e ) { $atts[] = crux_blob_attachment_id( $e['hero_blob'] ); }
$atts = array_values( array_unique( array_filter( $atts ) ) );
$hero = $atts[1];
$gal  = array( $atts[2], $atts[3] );
$tok  = 'ZZconv' . substr( md5( 'y' ), 0, 6 );
$new  = array(
	'title' => "Studio Title $tok", 'short' => "Short$tok", 'kicker' => "Kicker$tok", 'date' => '2032-04-05', 'time' => "Time $tok",
	'venue' => "Venue $tok", 'country' => "Country $tok", 'excerpt' => "Summary $tok from the Studio box.", 'scope' => "Scope $tok from the Studio box.",
	'cta' => 'https://example.test/studio-' . $tok,
);
wp_update_post( array( 'ID' => $id, 'post_title' => $new['title'] ) );
conv_update( $id, array(
	'cr8v_event_short_title' => $new['short'], 'cr8v_event_kicker' => $new['kicker'], 'cr8v_event_date' => $new['date'], 'cr8v_event_time' => $new['time'],
	'cr8v_event_venue' => $new['venue'], 'cr8v_event_location' => $new['country'], 'cr8v_event_excerpt' => $new['excerpt'], 'cr8v_event_scope' => $new['scope'],
	'cr8v_event_cta_url' => $new['cta'], 'cr8v_event_badge_style' => 'purple', 'cr8v_event_image_id' => $hero, 'cr8v_event_gallery_ids' => implode( ',', $gal ),
) );
$GLOBALS['wp_query']->query( array( 'post_type' => 'event', 'name' => $P . $ev['slug'] ) );
$_SERVER['REQUEST_URI'] = '/event/' . $P . $ev['slug'] . '/';
wp_set_current_user( 0 );
ob_start();
include get_template_directory() . '/single-event.php';
$html = ob_get_clean();
$date_fmt = wp_date( 'l, j F Y', ( new DateTimeImmutable( $new['date'], wp_timezone() ) )->getTimestamp(), wp_timezone() );
$checks = array(
	'title' => false !== strpos( $html, esc_html( mb_strtoupper( $new['title'], 'UTF-8' ) ) ),
	'short title' => false !== strpos( $html, esc_html( $new['short'] ) ),
	'category / header tag' => false !== strpos( $html, esc_html( $new['kicker'] ) ),
	'date' => false !== strpos( $html, esc_html( $date_fmt ) ),
	'time' => false !== strpos( $html, esc_html( $new['time'] ) ),
	'venue' => false !== strpos( $html, esc_html( $new['venue'] ) ),
	'country' => false !== strpos( $html, esc_html( $new['country'] ) ),
	'summary' => false !== strpos( $html, esc_html( $new['excerpt'] ) ),
	'description' => false !== strpos( $html, esc_html( $new['scope'] ) ),
	'booking link' => false !== strpos( $html, esc_url( $new['cta'] ) ),
	'poster' => false !== strpos( $html, esc_url( wp_get_attachment_image_url( $hero, 'large' ) ) ),
	'gallery image 1' => false !== strpos( $html, esc_url( wp_get_attachment_image_url( $gal[0], 'large' ) ) ),
	'gallery image 2' => false !== strpos( $html, esc_url( wp_get_attachment_image_url( $gal[1], 'large' ) ) ),
);
foreach ( $checks as $label => $ok ) { t( "edit the $label in the Studio box -> it changes on the public event page", $ok ); }
t( 'edit the ticket colour in the Studio box -> it changes on the event cards', '#8C7AE6' === crux_get_event_data( $id )['badge_bg'] );
t( 'the old summary and description are gone from the page', false === strpos( $html, esc_html( $ev['excerpt'] ) ) && false === strpos( $html, esc_html( wp_strip_all_tags( $ev['content'] ) ) ) );

echo "== 4. A cleared field stays cleared\n";
wp_set_current_user( $admins[0]->ID );
conv_update( $id, array( 'cr8v_event_excerpt' => '', 'cr8v_event_cta_url' => '', 'cr8v_event_kicker' => '', 'cr8v_event_time' => '' ) );
$c = crux_get_event_data( $id );
t( 'cleared summary stays empty (the original summary does not come back)', '' === $c['desc_1'] );
t( 'cleared booking link stays empty', '' === $c['eventbrite'] );
t( 'cleared category stays empty', '' === $c['category'] );
t( 'cleared time stays empty', '' === $c['time_str'] );
t( 'description is still the edited one', wp_strip_all_tags( $new['scope'] ) === $c['desc_2'] );

echo "== 5. One place to edit\n";
t( 'the theme asks the shared plugin to hide the default editor and Excerpt box', true === apply_filters( 'cr8v_events_hide_default_editor', false ) );
cr8v_events_maybe_hide_default_editor();
t( 'event posts no longer offer the default editor or Excerpt box', ! post_type_supports( 'event', 'editor' ) && ! post_type_supports( 'event', 'excerpt' ) );
add_post_type_support( 'event', array( 'editor', 'excerpt' ) );

echo "== Cleanup\n";
wp_delete_post( $id, true );
$left = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='event' AND post_name LIKE '{$P}%'" );
t( 'no test events left behind', 0 === $left, (string) $left );
wp_set_current_user( 0 );
echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
