<?php
/**
 * Brand colour tests: design tokens, Customizer controls and the printed :root rule.
 *
 *  1. The tokens, their settings and controls exist; only a real hex colour is accepted.
 *  2. An untouched site prints no colour rule; the stylesheets and inline styles use var(--crux-token, original hex).
 *  3. Changing a colour prints one :root rule on a real page and the rule is gone again after reset.
 *  4. The Customizer preview script updates the variables instantly.
 *
 *   php -d allow_url_fopen=1 cr8v-event-ticketing/tests/test_colours.php
 */
require __DIR__ . '/bootstrap.php';
global $wpdb;
$wpdb->get_var( "SELECT GET_LOCK('cr8v_theme_mods_test', 900)" );

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}
function http_get( $path ) {
	$ctx  = stream_context_create( array( 'http' => array( 'timeout' => 180, 'ignore_errors' => true, 'header' => "User-Agent: crux-colour-test\r\n" ) ) );
	$body = @file_get_contents( 'http://dev-playground.local' . $path, false, $ctx );
	return false === $body ? '' : $body;
}

$tokens = crux_colour_tokens();
t( '11 colour tokens', 11 === count( $tokens ) );
t( 'every default is a 6-digit hex', 11 === count( array_filter( $tokens, function ( $d ) { return (bool) preg_match( '/^#[0-9A-F]{6}$/i', $d[1] ); } ) ) );

require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
$wp_customize = new WP_Customize_Manager();
do_action( 'customize_register', $wp_customize );
$have = 0;
$post = 0;
foreach ( array_keys( $tokens ) as $k ) {
	$s = $wp_customize->get_setting( 'crux_colour_' . $k );
	if ( $s && $wp_customize->get_control( 'crux_colour_' . $k ) ) { $have++; }
	if ( $s && 'postMessage' === $s->transport ) { $post++; }
}
t( 'a setting and a colour control for every token', 11 === $have );
t( 'every colour previews instantly (postMessage)', 11 === $post );
t( 'section "Brand colours" is in the site-wide panel', $wp_customize->get_section( 'crux_colours' ) && 'crux_site' === $wp_customize->get_section( 'crux_colours' )->panel );
t( 'a non-colour is rejected by the sanitizer', null === sanitize_hex_color( 'red; } body{display:none' ) );

$saved = array();
foreach ( array_keys( $tokens ) as $k ) { $saved[ $k ] = get_theme_mod( 'crux_colour_' . $k, null ); remove_theme_mod( 'crux_colour_' . $k ); }

t( 'untouched site: no colour rule', '' === crux_colours_css() );
$home = http_get( '/' );
t( 'untouched site: no #crux-colours rule printed', false === strpos( $home, 'id="crux-colours"' ) );
t( 'inline styles carry tokens with the original colour as fallback', substr_count( $home, 'var(--crux-' ) > 50 );
// Ticket stubs print the colour chosen for each event (event data, not a site colour), so they are left out.
$no_stubs = preg_replace( '/<div class="ticket-stub"[^>]*>/', '', $home );
t( 'no brand hex left loose in a style attribute', 0 === preg_match( '/style="[^"]*(?<![\w&,])#(?:002671|5B8DEF|BA0000|0A0F26|10142E|111838|1E2B5E|F4F5FA)(?![0-9A-Fa-f])/i', $no_stubs ) );

$css = '';
foreach ( glob( get_template_directory() . '/assets/css/*.css' ) as $f ) { $css .= file_get_contents( $f ); }
t( 'stylesheets use the tokens', substr_count( $css, 'var(--crux-' ) > 100 );
t( 'stylesheets keep no loose brand hex outside var()', 0 === preg_match( '/(?<!,)#(?:002671|5B8DEF|BA0000|0A0F26|10142E|111838|1E2B5E|F4F5FA)(?![0-9A-Fa-f])/i', $css ) );

set_theme_mod( 'crux_colour_navy', '#112233' );
set_theme_mod( 'crux_colour_red', 'not-a-colour' );
t( 'a changed colour gives one :root rule', ':root{--crux-navy:#112233}' === crux_colours_css(), crux_colours_css() );
t( 'an invalid stored value is ignored', false === strpos( crux_colours_css(), 'red' ) );
$home = http_get( '/' );
t( 'the page prints the rule', false !== strpos( $home, '<style id="crux-colours">:root{--crux-navy:#112233}</style>' ) );
set_theme_mod( 'crux_colour_navy', '#002671' );
t( 'setting a colour back to its original prints nothing', '' === crux_colours_css() );

$js = file_get_contents( get_template_directory() . '/assets/js/customizer-preview.js' );
t( 'preview script sets the CSS variable', false !== strpos( $js, "setProperty( '--crux-' + token" ) );
t( 'preview script is given every token', false !== strpos( file_get_contents( get_template_directory() . '/inc/customizer-pages.php' ), "'colours' => array_keys( crux_colour_tokens() )" ) );

foreach ( $saved as $k => $v ) { if ( null === $v ) { remove_theme_mod( 'crux_colour_' . $k ); } else { set_theme_mod( 'crux_colour_' . $k, $v ); } }

$wpdb->get_var( "SELECT RELEASE_LOCK('cr8v_theme_mods_test')" );
echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
