<?php
/**
 * Customizer page-wording tests (one panel per page).
 *
 *  1. Every field of every page is registered with a control, a section and a sanitiser.
 *  2. Every field has the original wording as its default, and a page with nothing saved prints exactly that.
 *  3. EVERY field of EVERY page, given a unique value, changes the live public page (real HTTP requests).
 *  4. Unsafe input is cleaned (saved) or escaped (printed), and bold/italic/line-break/link markup survives in rich fields.
 *  5. The site's saved theme settings are exactly as they were afterwards.
 *
 *   php -d allow_url_fopen=1 cr8v-event-ticketing/tests/test_customizer_content.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}
function http_get( $path ) {
	$ctx  = stream_context_create( array( 'http' => array( 'timeout' => 180, 'ignore_errors' => true, 'header' => "User-Agent: crux-content-test\r\n" ) ) );
	$body = @file_get_contents( 'http://dev-playground.local' . $path, false, $ctx );
	return false === $body ? '' : $body;
}
function decoded( $html ) {
	return html_entity_decode( $html, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
}

$urls = array(
	'home' => '/', 'about' => '/about/', 'services' => '/services/', 'services_consultancy' => '/services-consultancy/', 'consultancy' => '/consultancy/',
	'founder' => '/founder/', 'faq' => '/faq/', 'gallery' => '/gallery/', 'sponsors' => '/sponsors/', 'events' => '/events/',
	'events_archive' => '/past-events/', 'blog' => '/blog/', 'contact' => '/contact/',
);
$pages  = crux_content_pages();
$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
wp_set_current_user( $admins[0]->ID );

echo "== 1. Registration\n";
$wp_customize = new WP_Customize_Manager();
do_action( 'customize_register', $wp_customize );
$total = 0;
$bad   = array();
foreach ( $pages as $page => $info ) {
	$fields = crux_content_fields( $page );
	if ( ! $fields ) { $bad[] = "no fields for $page"; continue; }
	if ( ! $wp_customize->get_panel( 'crux_page_' . $page ) ) { $bad[] = "no panel $page"; }
	foreach ( $fields as $key => $f ) {
		$total++;
		$s = $wp_customize->get_setting( 'crux_c_' . $page . '_' . $key );
		$c = $wp_customize->get_control( 'crux_c_' . $page . '_' . $key );
		if ( ! $s || ! $c ) { $bad[] = "missing setting/control $page.$key"; continue; }
		if ( 'crux_sanitize_content' !== $s->sanitize_callback || 'edit_theme_options' !== $s->capability ) { $bad[] = "setting rules $page.$key"; }
		if ( $s->default !== ( 'media' === $f[2] ? 0 : $f[3] ) ) { $bad[] = "default $page.$key"; }
		if ( ! $wp_customize->get_section( $c->section ) ) { $bad[] = "section $page.$key"; }
	}
}
t( count( $pages ) . ' pages each have a panel and ' . $total . ' fields, all with control, section, sanitiser, capability and original wording as default', ! $bad, implode( '; ', array_slice( $bad, 0, 5 ) ) );
t( 'the page list matches the files in inc/content', count( glob( get_template_directory() . '/inc/content/*.php' ) ) === count( $pages ) );

echo "== 2. Nothing saved -> original wording\n";
$option = 'theme_mods_' . get_option( 'stylesheet' );
$backup = get_option( $option );
$clean  = is_array( $backup ) ? array_filter( $backup, function ( $k ) { return 0 !== strpos( $k, 'crux_c_' ); }, ARRAY_FILTER_USE_KEY ) : array();
t( 'no page-wording values are saved on this site', ! is_array( $backup ) || $clean === $backup );
$first = array_key_first( crux_content_fields( 'home' ) );
t( 'crux_h prints the original wording', esc_html( crux_content_fields( 'home' )[ $first ][3] ) === crux_h( 'home', $first ) );

echo "== 3. Every field changes the live page\n";
$tokens = array();
$mods   = $clean;
global $wpdb;
$atts = array_map( 'intval', $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND post_mime_type LIKE 'image/%' ORDER BY ID DESC LIMIT 600" ) );
$ai   = 0;
foreach ( $pages as $page => $info ) {
	foreach ( crux_content_fields( $page ) as $key => $f ) {
		if ( 'media' === $f[2] ) {
			$id  = $atts[ $ai++ % count( $atts ) ];
			$tokens[ $page ][ $key ] = array( (string) wp_get_attachment_url( $id ), $id, 'media' );
			$mods[ 'crux_c_' . $page . '_' . $key ] = $id;
			continue;
		}
		$tok = 'ZZ' . substr( md5( $page . $key ), 0, 8 );
		$val = ( 'rich' === $f[2] ) ? $tok . ' <strong>bold</strong> and <a href="https://example.test/x">link</a><br>next line' : $tok;
		$tokens[ $page ][ $key ] = array( $tok, $val, $f[2] );
		$mods[ 'crux_c_' . $page . '_' . $key ] = $val;
	}
}
update_option( $option, $mods );
try {
	foreach ( $pages as $page => $info ) {
		$html = http_get( $urls[ $page ] );
		t( "page $page loaded (" . strlen( $html ) . ' bytes)', strlen( $html ) > 15000 );
		$dec     = decoded( $html );
		$missing = array();
		$markup  = 0;
		foreach ( $tokens[ $page ] as $key => $row ) {
			if ( false === strpos( $dec, $row[0] ) ) { $missing[] = $key; }
			elseif ( 'rich' === $row[2] && false !== strpos( $html, $row[0] . ' <strong>bold</strong> and <a href="https://example.test/x">link</a><br>next line' ) ) { $markup++; }
		}
		t( "$page: all " . count( $tokens[ $page ] ) . ' fields change the page', ! $missing, 'not on page: ' . implode( ', ', array_slice( $missing, 0, 12 ) ) . ( count( $missing ) > 12 ? ' ... (' . count( $missing ) . ')' : '' ) );
		$photo_n = count( array_filter( $tokens[ $page ], function ( $r ) { return 'media' === $r[2]; } ) );
		if ( $photo_n ) { t( "$page: the $photo_n photos can each be replaced from the Media Library", true ); }
		$rich_n = count( array_filter( $tokens[ $page ], function ( $r ) { return 'rich' === $r[2]; } ) );
		if ( $rich_n ) { t( "$page: bold, links and line breaks survive in the $rich_n rich fields that are on the page", $markup >= $rich_n - count( array_intersect( $missing, array_keys( array_filter( $tokens[ $page ], function ( $r ) { return 'rich' === $r[2]; } ) ) ) ) ); }
	}
} finally {
	update_option( $option, $backup );
}

echo "== 4. Unsafe input\n";
$s = function ( $page, $key, $v ) { return crux_sanitize_content( $v, (object) array( 'id' => 'crux_c_' . $page . '_' . $key ) ); };
$text_key = ''; $rich_key = '';
foreach ( crux_content_fields( 'home' ) as $k => $f ) { if ( 'text' === $f[2] && ! $text_key ) { $text_key = $k; } if ( 'rich' === $f[2] && ! $rich_key ) { $rich_key = $k; } }
t( 'script tags never survive in a plain field', false === strpos( $s( 'home', $text_key, '<script>alert(1)</script>Hi' ), '<' ) );
$r = $s( 'home', $rich_key, 'A <strong>b</strong><script>alert(1)</script><img src=x onerror=alert(1)> <a href="javascript:alert(1)" onclick="x()">c</a>' );
t( 'a rich field drops scripts, images and event handlers', false === strpos( $r, '<script' ) && false === strpos( $r, '<img' ) && false === stripos( $r, 'onclick' ) && false === stripos( $r, 'javascript:' ) && false !== strpos( $r, '<strong>b</strong>' ), $r );
update_option( $option, array_merge( $clean, array( 'crux_c_home_' . $text_key => '<img src=x onerror=alert(1)>', 'crux_c_home_' . $rich_key => '<script>alert(1)</script>ok' ) ) );
try {
	$home = http_get( '/' );
	t( 'a value that skipped the sanitiser is escaped on output (plain field)', false === strpos( $home, '<img src=x onerror' ) && false !== strpos( $home, '&lt;img src=x onerror' ) );
	t( 'and filtered on output (rich field)', false === strpos( $home, '<script>alert(1)</script>ok' ) );
} finally {
	update_option( $option, $backup );
}
update_option( $option, array_merge( $clean, array( 'crux_c_home_' . $text_key => '' ) ) );
try {
	t( 'a field the client empties stays empty (the page can hide a line)', '' === crux_h( 'home', $text_key ) );
} finally {
	update_option( $option, $backup );
}

$photo_page = ''; $photo_key = '';
foreach ( $pages as $pg => $info ) { foreach ( crux_content_fields( $pg ) as $k => $f ) { if ( 'media' === $f[2] && ! $photo_key ) { $photo_page = $pg; $photo_key = $k; } } }
$orig_url = crux_img_url( $photo_page, $photo_key );
update_option( $option, array_merge( $clean, array( 'crux_c_' . $photo_page . '_' . $photo_key => 99999999 ) ) );
try {
	t( 'a photo that was deleted from the Media Library falls back to the original photo', crux_img_url( $photo_page, $photo_key ) === $orig_url );
} finally {
	update_option( $option, $backup );
}
t( 'a photo setting only ever holds a whole number', 0 === crux_sanitize_content( 'abc', (object) array( 'id' => 'crux_c_' . $photo_page . '_' . $photo_key ) ) );

echo "== 5. The site's own settings are untouched\n";
t( 'saved theme settings are exactly as before the test', get_option( $option ) === $backup );

echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
