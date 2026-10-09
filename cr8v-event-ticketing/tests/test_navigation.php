<?php
/**
 * Navigation tests: WordPress menus drive the header, drawer and footer, with the original links as the fallback.
 *
 *  1. With no menu assigned the original links are shown.
 *  2. The demo importer creates the three menus from the original links, assigns them, never overwrites a client's menu
 *     and is safe to run twice.
 *  3. With menus assigned, editing a menu changes the live pages: rename, remove and reorder an entry, remove Services.
 *  4. The highlighted link follows the page in menu mode.
 *  5. The site's menus and theme settings are exactly as before the test.
 *
 *   php -d allow_url_fopen=1 cr8v-event-ticketing/tests/test_navigation.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
global $wpdb;
$wpdb->get_var( "SELECT GET_LOCK('cr8v_theme_mods_test', 900)" );

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}
function http_get( $path ) {
	$ctx  = stream_context_create( array( 'http' => array( 'timeout' => 180, 'ignore_errors' => true, 'header' => "User-Agent: crux-nav-test\r\n" ) ) );
	$body = @file_get_contents( 'http://dev-playground.local' . $path, false, $ctx );
	return false === $body ? '' : $body;
}
/** Links of the desktop nav of a page: label => href. */
function nav_links( $html ) {
	$out = array();
	if ( preg_match( '#<nav style="display:flex; align-items:center; gap:28px;">(.*?)</nav>#s', $html, $m ) ) {
		preg_match_all( '#<a href="([^"]*)" style="([^"]*)">([^<]*)</a>#', $m[1], $mm, PREG_SET_ORDER );
		foreach ( $mm as $x ) { $out[ html_entity_decode( $x[3] ) ] = array( $x[1], $x[2] ); }
	}
	return $out;
}

$stylesheet = get_option( 'stylesheet' );
$opt        = 'theme_mods_' . $stylesheet;
$backup     = get_option( $opt );
$menus_before = array_map( function ( $m ) { return (int) $m->term_id; }, wp_get_nav_menus() );
$mods       = is_array( $backup ) ? $backup : array();
$mods['nav_menu_locations'] = array();
update_option( $opt, $mods );

echo "== 1. No menu assigned: the original links\n";
$fb = crux_nav_items( 'desktop', 'events', 'events' );
t( 'the fallback is used', false === $fb['menu'] && 'Home' === $fb['items'][0]['label'] );
$home = http_get( '/' );
$l    = nav_links( $home );
t( 'the header shows Home, Events, Gallery, About, Blog and Contact', ! array_diff( array( 'Home', 'Events', 'Gallery', 'About', 'Blog', 'Contact' ), array_keys( $l ) ) );
t( 'the Services dropdown is there', false !== strpos( $home, 'class="mega"' ) );

echo "== 2. Demo importer\n";
$ids_before = count( wp_get_nav_menus() );
crux_seed_menus();
$loc = get_nav_menu_locations();
t( 'three menus are assigned to the three locations', ! empty( $loc['primary'] ) && ! empty( $loc['consultancy'] ) && ! empty( $loc['footer'] ) );
t( 'the main menu has the 7 original links, the consultancy menu 6, the footer menu 8', 7 === count( wp_get_nav_menu_items( $loc['primary'] ) ) && 6 === count( wp_get_nav_menu_items( $loc['consultancy'] ) ) && 8 === count( wp_get_nav_menu_items( $loc['footer'] ) ) );
crux_seed_menus();
t( 'running it again creates nothing new', count( wp_get_nav_menus() ) === $ids_before + 3 && 7 === count( wp_get_nav_menu_items( $loc['primary'] ) ) );
$custom = wp_create_nav_menu( 'ZZ client menu' );
$mods = (array) get_option( $opt ); $mods['nav_menu_locations'] = array( 'primary' => $custom ); update_option( $opt, $mods );
crux_seed_menus();
$loc2 = get_nav_menu_locations();
t( "a client's own menu on a location is never replaced", (int) $loc2['primary'] === (int) $custom );
$mods = (array) get_option( $opt ); $mods['nav_menu_locations'] = $loc; update_option( $opt, $mods );
wp_delete_nav_menu( $custom );

echo "== 3. Menu mode: editing a menu changes the live page\n";
$items = wp_get_nav_menu_items( $loc['primary'] );
$byTitle = array(); foreach ( $items as $i ) { $byTitle[ $i->title ] = $i; }
$home2 = http_get( '/' );
$l2 = nav_links( $home2 );
t( 'menu mode shows the same links as the original', array_keys( $l2 ) === array_keys( $l ) );
t( 'and the same addresses', array_map( function ( $x ) { return $x[0]; }, $l2 ) === array_map( function ( $x ) { return $x[0]; }, $l ) );
t( 'the footer links come from the footer menu too', false !== strpos( http_get( '/about/' ), '>Sponsors</a>' ) );
wp_update_nav_menu_item( $loc['primary'], $byTitle['Gallery']->ID, array( 'menu-item-title' => 'ZZ Photo Wall', 'menu-item-url' => home_url( '/gallery/' ), 'menu-item-type' => 'custom', 'menu-item-status' => 'publish' ) );
wp_delete_post( $byTitle['Blog']->ID, true );
$h3 = http_get( '/' );
$l3 = nav_links( $h3 );
t( 'renaming a menu entry renames the link', isset( $l3['ZZ Photo Wall'] ) && ! isset( $l3['Gallery'] ) );
t( 'removing a menu entry removes the link from the header', ! isset( $l3['Blog'] ) );
t( 'and from the mobile drawer', false === strpos( $h3, 'mlink" href="' . esc_url( home_url( '/blog/' ) ) . '"' ) );
t( 'renamed entry also shows in the mobile drawer', false !== strpos( $h3, '>ZZ Photo Wall</a>' ) );
wp_update_nav_menu_item( $loc['primary'], $byTitle['Contact']->ID, array( 'menu-item-title' => 'Contact', 'menu-item-url' => home_url( '/contact/' ), 'menu-item-type' => 'custom', 'menu-item-status' => 'publish', 'menu-item-position' => 1 ) );
$l4 = array_keys( nav_links( http_get( '/' ) ) );
t( 'moving an entry up moves the link (it was last, now second)', array_search( 'Contact', $l4, true ) <= 1, implode( ',', $l4 ) );
wp_delete_post( $byTitle['Services']->ID, true );
t( 'without a Services entry the dropdown disappears', false === strpos( http_get( '/' ), 'class="mega"' ) );

echo "== 4. Highlighted link in menu mode\n";
$ab = nav_links( http_get( '/about/' ) );
t( 'the About page highlights About', isset( $ab['About'] ) && false !== strpos( $ab['About'][1], 'border-bottom:1.5px solid' ) );
t( 'and not Contact', isset( $ab['Contact'] ) && false === strpos( $ab['Contact'][1], 'border-bottom' ) );

echo "== 5. Everything restored\n";
foreach ( wp_get_nav_menus() as $m ) { if ( ! in_array( (int) $m->term_id, $menus_before, true ) ) { wp_delete_nav_menu( $m ); } }
update_option( $opt, $backup );
$after = array_map( function ( $m ) { return (int) $m->term_id; }, wp_get_nav_menus() );
t( 'the site has exactly the menus it had before', $after === $menus_before );
t( 'saved theme settings are exactly as before', get_option( $opt ) === $backup );

echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
