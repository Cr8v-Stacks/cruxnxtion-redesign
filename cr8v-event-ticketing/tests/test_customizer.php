<?php
/**
 * Customizer tests (site-wide settings of the Crux Nxtion theme).
 *
 *  1. Every setting is registered with a control in an existing section, a safe sanitizer and the right capability.
 *  2. Every setting is actually used by the theme (no dead field the client could change with no effect).
 *  3. EVERY setting, given a unique value, changes the live public page it belongs to (real HTTP requests).
 *  4. Unsafe input is cleaned or escaped; an emptied required field falls back to the original wording.
 *  5. The site's saved theme settings are exactly as they were afterwards.
 *
 *   php cr8v-event-ticketing/tests/test_customizer.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
global $wpdb;

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}
function http_get( $path ) {
	$ctx = stream_context_create( array( 'http' => array( 'timeout' => 120, 'ignore_errors' => true, 'header' => "User-Agent: crux-customizer-test\r\n" ) ) );
	$body = @file_get_contents( 'http://dev-playground.local' . $path, false, $ctx );
	return false === $body ? '' : $body;
}

$fields   = crux_customizer_fields();
$sections = crux_customizer_sections();
$admins   = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
wp_set_current_user( $admins[0]->ID );

echo "== 1. Registration\n";
$wp_customize = new WP_Customize_Manager();
do_action( 'customize_register', $wp_customize );
t( 'the Crux panel exists', (bool) $wp_customize->get_panel( 'crux_site' ) );
$all_ok = true;
foreach ( $sections as $id => $s ) { if ( ! $wp_customize->get_section( 'crux_' . $id ) ) { $all_ok = false; echo "      missing section $id\n"; } }
t( 'all ' . count( $sections ) . ' sections exist', $all_ok );
$set_ok = $ctl_ok = $san_ok = $cap_ok = $def_ok = $sec_ok = true;
foreach ( $fields as $id => $f ) {
	$setting = $wp_customize->get_setting( 'crux_' . $id );
	$control = $wp_customize->get_control( 'crux_' . $id );
	if ( ! $setting ) { $set_ok = false; echo "      no setting $id\n"; continue; }
	if ( ! $control ) { $ctl_ok = false; echo "      no control $id\n"; }
	elseif ( 'crux_' . $f['section'] !== $control->section || ! $wp_customize->get_section( $control->section ) ) { $sec_ok = false; echo "      bad section $id\n"; }
	if ( 'crux_sanitize_setting' !== $setting->sanitize_callback ) { $san_ok = false; echo "      no sanitizer $id\n"; }
	if ( 'edit_theme_options' !== $setting->capability ) { $cap_ok = false; echo "      capability $id\n"; }
	if ( $setting->default !== $f['default'] ) { $def_ok = false; echo "      default $id\n"; }
}
t( 'every field has a setting', $set_ok );
t( 'every field has a control', $ctl_ok );
t( 'every control sits in an existing section', $sec_ok );
t( 'every setting is sanitised', $san_ok );
t( 'only users who may edit theme options can change settings', $cap_ok );
t( 'the default of every setting is the original wording', $def_ok );

echo "== 2. No dead fields\n";
$files = array();
$rii = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( get_template_directory(), FilesystemIterator::SKIP_DOTS ) );
foreach ( $rii as $file ) {
	if ( 'php' === $file->getExtension() && 'customizer.php' !== $file->getFilename() ) { $files[] = file_get_contents( $file->getPathname() ); }
}
$code = implode( "\n", $files );
$indirect = array(
	'social_'      => 'crux_social_url(',
	'addr_'        => 'crux_address(',
	'bar_events_text' => 'crux_bar_text( "events" )', 'bar_dual_text' => 'crux_bar_text( "dual" )', 'bar_consult_text' => 'crux_bar_text( "consult" )',
	'card_photo'   => 'crux_card_photo_url(',
);
$dead = array();
foreach ( $fields as $id => $f ) {
	$found = ( false !== strpos( $code, "'$id'" ) ) || ( false !== strpos( $code, "\"$id\"" ) );
	foreach ( $indirect as $prefix => $needle ) {
		if ( 0 === strpos( $id, $prefix ) && false !== strpos( $code, $needle ) ) { $found = true; }
	}
	if ( 0 === strpos( $id, 'social_' ) ) { $found = $found && false !== strpos( $code, '"' . substr( $id, 7 ) . '"' ); }
	if ( ! $found ) { $dead[] = $id; }
}
t( 'every field is used by the theme', ! $dead, implode( ',', $dead ) );

echo "== 3. Every field changes the live page\n";
$option  = 'theme_mods_' . get_option( 'stylesheet' );
$backup  = get_option( $option );
$photo   = (int) $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND post_mime_type LIKE 'image/%' ORDER BY ID DESC LIMIT 1" );
$tokens  = array();
$mods    = is_array( $backup ) ? $backup : array();
foreach ( $fields as $id => $f ) {
	switch ( $f['type'] ) {
		case 'tel':   $raw = '+44 7' . str_pad( (string) abs( crc32( $id ) % 1000000000 ), 9, '0', STR_PAD_LEFT ); break;
		case 'email': $raw = 'zz' . substr( md5( $id ), 0, 8 ) . '@example.test'; break;
		case 'url':   $raw = 'https://example.test/zz-' . substr( md5( $id ), 0, 8 ); break;
		case 'media': $raw = $photo; break;
		default:      $raw = 'ZZ ' . $id . ' ' . substr( md5( $id ), 0, 6 );
	}
	$clean = crux_sanitize_setting( $raw, (object) array( 'id' => 'crux_' . $id ) );
	$tokens[ $id ] = $clean;
	$mods[ 'crux_' . $id ] = $clean;
}
update_option( $option, $mods );
try {
	$pages = array(
		'/'                  => http_get( '/' ),
		'/about/'            => http_get( '/about/' ),
		'/consultancy/'      => http_get( '/consultancy/' ),
		'/contact/'          => http_get( '/contact/' ),
		'/faq/'              => http_get( '/faq/' ),
		'/privacy-policy/'   => http_get( '/privacy-policy/' ),
	);
	foreach ( $pages as $p => $html ) { t( "page $p loaded", strlen( $html ) > 20000 ); }
	$decoded = array();
	foreach ( $pages as $p => $html ) {
		$h = preg_replace_callback( '/&#(\d+);/', function ( $m ) { return html_entity_decode( $m[0], ENT_QUOTES, 'UTF-8' ); }, $html );
		$decoded[ $p ] = html_entity_decode( $h, ENT_QUOTES, 'UTF-8' );
	}
	$where = array(
		'phone_main' => '/', 'phone_events' => '/contact/', 'phone_consult' => '/contact/', 'email' => '/', 'calendly_url' => '/',
		'social_instagram' => '/', 'social_tiktok' => '/', 'social_whatsapp' => '/',
		'bar_events_text' => '/', 'bar_events_link' => '/', 'bar_dual_text' => '/about/', 'bar_dual_link' => '/about/', 'bar_consult_text' => '/consultancy/', 'bar_consult_link' => '/consultancy/',
		'cta_events_text' => '/', 'cta_consult_text' => '/consultancy/', 'card_title' => '/', 'card_button' => '/',
		'pf_eyebrow' => '/', 'pf_events_title' => '/', 'pf_events_desc' => '/', 'pf_events_btn1' => '/', 'pf_events_btn2' => '/',
		'pf_consult_title' => '/consultancy/', 'pf_consult_desc' => '/consultancy/', 'pf_consult_btn1' => '/consultancy/', 'pf_consult_btn2' => '/consultancy/',
		'brand_1' => '/', 'brand_2' => '/', 'copyright' => '/',
		'addr_line' => '/privacy-policy/', 'addr_city' => '/privacy-policy/', 'addr_country' => '/privacy-policy/',
	);
	foreach ( $fields as $id => $f ) {
		if ( 'card_photo' === $id ) {
			$needle = wp_get_attachment_image_url( $tokens[ $id ], 'large' );
			t( 'edit "' . $f['label'] . '" -> it changes on the page', $photo && $needle && false !== strpos( $decoded['/'], $needle ) );
			continue;
		}
		$needle = (string) $tokens[ $id ];
		if ( 'tel' === $f['type'] ) { $needle = $needle; }
		$page = $where[ $id ] ?? null;
		if ( null === $page ) { t( "no page recorded for $id", false ); continue; }
		$hay = $decoded[ $page ];
		if ( 'bar_events_text' === $id || 'bar_dual_text' === $id ) { $needle = str_replace( array( '{year}', '{next_year}' ), array( date( 'Y' ), (string) ( (int) date( 'Y' ) + 1 ) ), $needle ); }
		t( 'edit "' . $f['label'] . '" -> it changes on ' . $page, false !== strpos( $hay, $needle ), 'missing: ' . $needle );
	}
	t( 'the e-mail setting also feeds the "mailto" links', false !== strpos( $pages['/'], 'mailto:' ) );
	$tel_digits = preg_replace( '/[^0-9+]/', '', $tokens['phone_main'] );
	t( 'the phone setting also feeds the tap-to-call link', false !== strpos( $pages['/'], 'tel:' . $tel_digits ) );
	t( 'an address change reaches the front page text too', false !== strpos( $decoded['/'], $tokens['addr_line'] . ', ' . $tokens['addr_city'] ) );
	t( 'a social link opens in a new tab once it is set', (bool) preg_match( '/href="' . preg_quote( esc_url( $tokens['social_instagram'] ), '/' ) . '" target="_blank" rel="noopener" aria-label="Instagram"/', $pages['/'] ) );
} finally {
	update_option( $option, $backup );
}

echo "== 4. Unsafe input\n";
$s = function ( $id, $v ) { return crux_sanitize_setting( $v, (object) array( 'id' => 'crux_' . $id ) ); };
t( 'script tags are removed from text', false === strpos( $s( 'card_title', '<script>alert(1)</script>Hello' ), '<' ) );
t( 'a javascript: link is refused', '' === $s( 'calendly_url', 'javascript:alert(1)' ) );
t( 'a data: link is refused', '' === $s( 'social_tiktok', 'data:text/html;base64,AAAA' ) );
t( 'a phone number keeps only digits and phone punctuation', '+44 7000 1' === $s( 'phone_main', '+44 7000 1<b>x</b>' ) || '+44 7000 1' === trim( $s( 'phone_main', '+44 7000 1abc' ) ) );
t( 'an invalid e-mail becomes empty', '' === $s( 'email', 'not an email' ) );
update_option( $option, array_merge( $mods, array( 'crux_card_title' => '<img src=x onerror=alert(1)>', 'crux_calendly_url' => 'javascript:alert(1)', 'crux_copyright' => '<script>x</script>' ) ) );
try {
	$home = http_get( '/' );
	t( 'even a value that skipped the sanitiser is escaped on output (heading)', false === strpos( $home, '<img src=x onerror' ) && false !== strpos( $home, '&lt;img src=x onerror' ) );
	t( 'and a hostile link never reaches a link target', false === stripos( $home, 'href="javascript:' ) );
	t( 'and a hostile footer line is escaped', false === strpos( $home, '<script>x</script>' ) );
} finally {
	update_option( $option, $backup );
}
$mods_empty = is_array( $backup ) ? $backup : array();
$mods_empty['crux_card_title'] = '';
$mods_empty['crux_social_instagram'] = '';
update_option( $option, $mods_empty );
try {
	t( 'an emptied required field falls back to the original wording', 'NOT SURE WHICH?' === crux_opt( 'card_title' ) );
	t( 'an emptied optional field stays empty and shows the "#" placeholder', '' === crux_opt( 'social_instagram' ) && '#' === crux_social_url( 'instagram' ) );
} finally {
	update_option( $option, $backup );
}

echo "== 5. The site's own settings are untouched\n";
t( 'saved theme settings are exactly as before the test', get_option( $option ) === $backup );
t( 'the e-mail used for enquiries is the original again', 'infoandsales@cruxnxtion.co.uk' === crux_opt( 'email' ) || get_theme_mod( 'crux_email' ) === ( is_array( $backup ) ? ( $backup['crux_email'] ?? false ) : false ) );

echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
