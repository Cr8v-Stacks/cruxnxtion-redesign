<?php
/**
 * Coexistence test, step E3/E4 of EVENTS_CONVERGENCE_PLAN.md.
 *
 * Proves the shared events plugin (cr8v-events-core) and the Crux Nxtion plugin (now the Crux enquiry module only)
 * can be active together without colliding, and that Crux keeps what is Crux's:
 *  1. The event post type comes from the shared plugin, with Crux's web address (/event/<name>/) and no /events/ archive.
 *  2. The gallery post type and categories come from the shared plugin; existing gallery items are untouched.
 *  3. The shared plugin's own "Project Inquiries" menu is switched off for Crux.
 *  4. The Crux enquiry form still stores the enquiry and emails it.
 *
 * The shared plugin cannot be activated in the live database by a test, so it is loaded in this process after
 * WordPress has started, in the order WordPress would run it (shared first, then Crux).
 *
 *   php cr8v-event-ticketing/tests/test_events_coexist.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';
// When the plugin is already active on this site it is loaded; otherwise load it here.
if ( ! function_exists( 'cr8v_register_events_cpt' ) ) {
	require_once dirname( __DIR__, 2 ) . '/cr8v-events-core/cr8v-events-core.php';
}
global $wpdb;

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}

$gallery_before = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='gallery_item'" );

echo "== 1. One event post type, owned by the shared plugin, with Crux addresses\n";
unregister_post_type( 'event' );
unregister_post_type( 'gallery_item' );
cr8v_register_events_cpt();      // shared plugin runs first (init priority 0)
cr8v_register_gallery_cpt();
crux_core_register_cpts();       // Crux plugin runs afterwards (init priority 10) and must not overwrite them
cr8v_events_maybe_hide_default_editor();
$ev = get_post_type_object( 'event' );
t( 'the event post type is the shared one (Studio labels)', 'Add New Event' === $ev->labels->add_new_item && 'Event Poster Artwork' === $ev->labels->featured_image );
t( 'Crux web address kept: /event/<name>/', 'event' === $ev->rewrite['slug'] );
t( 'no /events/ archive that would take over the Events page', false === $ev->has_archive );
t( 'event categories exist', taxonomy_exists( 'event_category' ) );
t( 'default editor and Excerpt box are hidden for events', ! post_type_supports( 'event', 'editor' ) && ! post_type_supports( 'event', 'excerpt' ) );
add_post_type_support( 'event', array( 'editor', 'excerpt' ) );

echo "== 2. Gallery\n";
$g = get_post_type_object( 'gallery_item' );
t( 'the gallery post type is the shared one with its categories', taxonomy_exists( 'gallery_category' ) && 'gallery-item' === $g->rewrite['slug'] );
t( 'existing gallery items are all still there', $gallery_before === (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='gallery_item'" ) );

echo "== 3. Menus\n";
$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
wp_set_current_user( $admins[0]->ID );
global $menu, $submenu;
$menu = $submenu = array();
cr8v_register_inquiries_admin_menu();
$found = false;
foreach ( (array) $menu as $m ) { if ( isset( $m[2] ) && 'cr8v-inquiries' === $m[2] ) { $found = true; } }
t( 'the shared plugin\'s Project Inquiries menu is not added on Crux', ! $found );
add_filter( 'cr8v_events_enable_inquiries_menu', '__return_true', 99 );
$menu = array();
cr8v_register_inquiries_admin_menu();
foreach ( (array) $menu as $m ) { if ( isset( $m[2] ) && 'cr8v-inquiries' === $m[2] ) { $found = true; } }
t( 'it still appears for a site that has not switched it off', $found );
remove_filter( 'cr8v_events_enable_inquiries_menu', '__return_true', 99 );

echo "== 4. The Crux enquiry form still works\n";
t( 'the Crux enquiry post type exists', post_type_exists( 'inquiry' ) );
t( 'the form action is wired', false !== has_action( 'wp_ajax_nopriv_crux_submit_inquiry' ) );
$before = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='inquiry'" );
$mail   = array();
add_filter( 'pre_wp_mail', function ( $null, $atts ) use ( &$mail ) { $mail[] = $atts; return true; }, 10, 2 );
add_filter( 'wp_doing_ajax', '__return_true' );
add_filter( 'wp_die_ajax_handler', function () { return function () { throw new RuntimeException( 'ajax-done' ); }; } );
$_POST = array(
	'security' => wp_create_nonce( 'crux_inquiry_nonce' ), 'form_timestamp' => time() - 60,
	'name' => 'ZZ Coexist Test', 'email' => 'zz_coexist@example.com', 'phone' => '0700', 'message' => 'Coexistence test brief',
	'services' => array( 'Event planning' ), 'selected_tabs' => 'events', 'ev_type' => 'Gala', 'ev_date' => '2027-01-01', 'ev_guests' => '120', 'ev_venue' => 'Sheffield',
);
$_SERVER['REQUEST_METHOD'] = 'POST';
ob_start();
try { crux_ajax_submit_inquiry(); } catch ( RuntimeException $e ) {}
$out = ob_get_clean();
$_POST = array();
$_SERVER['REQUEST_METHOD'] = 'GET';
$after = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='inquiry'" );
t( 'the form reports success', false !== strpos( $out, '"success":true' ), $out );
t( 'exactly one enquiry was stored', $after === $before + 1 );
$stored = get_posts( array( 'post_type' => 'inquiry', 'numberposts' => 1, 'orderby' => 'ID', 'order' => 'DESC' ) );
$sid    = $stored ? $stored[0]->ID : 0;
t( 'it carries the contact details and the event specifics', $sid && 'zz_coexist@example.com' === get_post_meta( $sid, '_crux_email', true ) && 'Gala' === get_post_meta( $sid, '_crux_ev_type', true ) && '2027-01-01' === get_post_meta( $sid, '_crux_ev_date', true ) );
t( 'the team and the client were both emailed', count( $mail ) >= 2 );

echo "== Cleanup\n";
if ( $sid && 'ZZ Coexist Test' === get_post_meta( $sid, '_crux_name', true ) ) { wp_delete_post( $sid, true ); }
$ip = $_SERVER['REMOTE_ADDR'];
delete_transient( 'crux_sub_rate_' . md5( $ip ) );
t( 'no test enquiry left behind', $before === (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='inquiry'" ) );
wp_set_current_user( 0 );
echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
