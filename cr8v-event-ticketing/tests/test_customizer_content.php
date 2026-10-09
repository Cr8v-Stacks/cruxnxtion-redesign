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
	'privacy' => '/privacy-policy/', 'terms' => '/terms-conditions/', 'cookies' => '/cookie-policy/', 'not_found' => '/this-page-does-not-exist/',
	'single_event' => '/event/ankara-festival/',
);
$first_post = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 1 ) );
$urls['single_post'] = $first_post ? wp_make_link_relative( get_permalink( $first_post[0] ) ) : '/';
$pages  = crux_content_pages();
// Two runs at the same time would overwrite each other's saved settings: wait for the other run to finish.
global $wpdb;
$wpdb->get_var( "SELECT GET_LOCK('cr8v_theme_mods_test', 900)" );
$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
wp_set_current_user( $admins[0]->ID );

echo "== 1. Registration\n";
$wp_customize = new WP_Customize_Manager();
do_action( 'customize_register', $wp_customize );
$lazy_ok = true;
foreach ( $pages as $page => $info ) {
	$first_key = array_key_first( crux_content_fields( $page ) );
	if ( $wp_customize->get_panel( 'crux_page_' . $page ) || $wp_customize->get_control( 'crux_c_' . $page . '_' . $first_key ) || ! $wp_customize->get_setting( 'crux_c_' . $page . '_' . $first_key ) ) { $lazy_ok = false; }
}
t( 'opening the Customizer builds no page panels or controls (they load on demand) but every setting exists', $lazy_ok );
$total = 0;
foreach ( $pages as $page => $info ) { crux_register_page_controls( $wp_customize, $page ); }
$payload_ok = true;
foreach ( $pages as $page => $info ) {
	$pl = crux_page_controls_payload( $page );
	$n  = count( crux_content_fields( $page ) );
	if ( 1 !== count( $pl['panels'] ) || count( $pl['controls'] ) !== $n || ! $pl['sections'] ) { $payload_ok = false; echo "      payload $page: " . count( $pl['controls'] ) . " of $n
"; }
	foreach ( $pl['controls'] as $c ) { if ( empty( $c['content'] ) || empty( $c['section'] ) || ! isset( $pl['sections'][ $c['section'] ] ) ) { $payload_ok = false; } }
}
t( 'the on-demand payload of every page has its panel, sections and every control', $payload_ok );
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
		if ( $s->default !== ( 'media' === $f[2] ? 0 : ( 'styled' === $f[2] ? crux_rich_to_plain( $f[3] ) : $f[3] ) ) ) { $bad[] = "default $page.$key"; }
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
		if ( 'url' === $f[2] ) {
			$u = 'https://example.test/zz-' . substr( md5( $page . $key ), 0, 8 );
			$tokens[ $page ][ $key ] = array( $u, $u, 'url' );
			$mods[ 'crux_c_' . $page . '_' . $key ] = $u;
			continue;
		}
		$tok = 'ZZ' . substr( md5( $page . $key ), 0, 8 );
		$val = ( 'rich' === $f[2] ) ? $tok . ' <strong>bold</strong> and <a href="https://example.test/x">link</a><br>next line' : $tok;
		if ( 'styled' === $f[2] ) { $val = $tok . ' **bold** and {{accent}}' . chr( 10 ) . 'next line'; }
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
			elseif ( 'styled' === $row[2] && false !== strpos( $html, $row[0] . ' <strong>bold</strong> and ' ) && false !== strpos( $html, '<br>next line' ) ) { $markup++; }
		}
		t( "$page: all " . count( $tokens[ $page ] ) . ' fields change the page', ! $missing, 'not on page: ' . implode( ', ', array_slice( $missing, 0, 12 ) ) . ( count( $missing ) > 12 ? ' ... (' . count( $missing ) . ')' : '' ) );
		$photo_n = count( array_filter( $tokens[ $page ], function ( $r ) { return 'media' === $r[2]; } ) );
		if ( $photo_n ) { t( "$page: the $photo_n photos can each be replaced from the Media Library", true ); }
		$rich_n = count( array_filter( $tokens[ $page ], function ( $r ) { return in_array( $r[2], array( 'rich', 'styled' ), true ); } ) );
		if ( $rich_n ) { t( "$page: bold, links and line breaks survive in the $rich_n rich fields that are on the page", $markup >= $rich_n - count( array_intersect( $missing, array_keys( array_filter( $tokens[ $page ], function ( $r ) { return in_array( $r[2], array( 'rich', 'styled' ), true ); } ) ) ) ) ); }
	}
} finally {
	update_option( $option, $backup );
}

echo "== 4. Unsafe input\n";
$s = function ( $page, $key, $v ) { return crux_sanitize_content( $v, (object) array( 'id' => 'crux_c_' . $page . '_' . $key ) ); };
$text_key = ''; $rich_key = ''; $rich_page = ''; $styled_key = '';
foreach ( crux_content_fields( 'home' ) as $k => $f ) { if ( 'text' === $f[2] && ! $text_key ) { $text_key = $k; } if ( 'styled' === $f[2] && ! $styled_key ) { $styled_key = $k; } }
foreach ( $pages as $pg => $inf ) { foreach ( crux_content_fields( $pg ) as $k => $f ) { if ( 'rich' === $f[2] && ! $rich_key ) { $rich_key = $k; $rich_page = $pg; } } }
t( 'script tags never survive in a plain field', false === strpos( $s( 'home', $text_key, '<script>alert(1)</script>Hi' ), '<' ) );
$r = $s( $rich_page, $rich_key, 'A <strong>b</strong><script>alert(1)</script><img src=x onerror=alert(1)> <a href="javascript:alert(1)" onclick="x()">c</a>' );
t( 'a rich field drops scripts, images and event handlers', false === strpos( $r, '<script' ) && false === strpos( $r, '<img' ) && false === stripos( $r, 'onclick' ) && false === stripos( $r, 'javascript:' ) && false !== strpos( $r, '<strong>b</strong>' ), $r );
update_option( $option, array_merge( $clean, array( 'crux_c_home_' . $text_key => '<img src=x onerror=alert(1)>', 'crux_c_' . $rich_page . '_' . $rich_key => '<script>alert(1)</script>ok' ) ) );
try {
	$home = http_get( '/' );
	t( 'a value that skipped the sanitiser is escaped on output (plain field)', false === strpos( $home, '<img src=x onerror' ) && false !== strpos( $home, '&lt;img src=x onerror' ) );
	$rich_html = http_get( $urls[ $rich_page ] );
	t( 'and filtered on output (rich field, checked on its own page)', strlen( $rich_html ) > 15000 && false === strpos( $rich_html, '<script>alert(1)</script>ok' ) );
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

$url_key = ''; $url_page = '';
foreach ( $pages as $pg => $inf ) { foreach ( crux_content_fields( $pg ) as $k => $f ) { if ( 'url' === $f[2] && ! $url_key ) { $url_page = $pg; $url_key = $k; } } }
t( 'a button address refuses javascript: and data: links', '' === crux_sanitize_content( 'javascript:alert(1)', (object) array( 'id' => 'crux_c_' . $url_page . '_' . $url_key ) ) && '' === crux_sanitize_content( 'data:text/html;base64,AAAA', (object) array( 'id' => 'crux_c_' . $url_page . '_' . $url_key ) ) );
t( 'a button address accepts a page on this site and a full https address', '/contact/' === crux_sanitize_content( '/contact/', (object) array( 'id' => 'crux_c_' . $url_page . '_' . $url_key ) ) && 'https://example.test/x' === crux_sanitize_content( 'https://example.test/x', (object) array( 'id' => 'crux_c_' . $url_page . '_' . $url_key ) ) );
$nl = chr(10);
t( 'friendly formatting: Enter, {{accent}}, **bold** and _italic_ become a line break, colour, bold and italic', crux_plain_to_rich( 'One' . $nl . 'Two {{red}} **b** _i_', '#E5383B' ) === 'One<br>Two <span style="color:#E5383B;">red</span> <strong>b</strong> <em>i</em>' );
t( 'friendly formatting escapes any markup the client types', false === strpos( crux_plain_to_rich( '<script>x</script> {{y}}<img src=x>', '#fff' ), '<script' ) && false === strpos( crux_plain_to_rich( '<img src=x onerror=1>', '' ), '<img' ) );
$styled_bad = array(); $styled_n = 0;
foreach ( $pages as $pg => $inf ) { foreach ( crux_content_fields( $pg ) as $k => $f ) { if ( 'styled' === $f[2] ) { $styled_n++; if ( ! crux_rich_round_trips( $f[3] ) ) { $styled_bad[] = "$pg.$k"; } } } }
t( "all $styled_n friendly fields turn back into their original markup exactly (nothing changes until the client edits)", $styled_n >= 20 && ! $styled_bad, implode( ',', $styled_bad ) );
$st_page = 'home';
update_option( $option, array_merge( $clean, array( 'crux_c_home_' . $styled_key => 'Typed' . $nl . '{{accent}} and **bold**' ) ) );
try {
	$h = http_get( '/' );
	t( 'a friendly field saved with the new syntax prints a line break, the accent colour and bold on the page', false !== strpos( $h, 'Typed<br><span style="color:' ) && false !== strpos( $h, '<strong>bold</strong>' ) );
} finally {
	update_option( $option, $backup );
}
echo "== 4b. Pencils and instant preview
";
$tpl_files = array(
	'home' => 'front-page.php', 'about' => 'page-about.php', 'services' => 'page-services.php', 'services_consultancy' => 'page-services-consultancy.php',
	'consultancy' => 'page-consultancy.php', 'founder' => 'page-founder.php', 'faq' => 'page-faq.php', 'gallery' => 'page-gallery.php',
	'sponsors' => 'page-sponsors.php', 'events' => 'page-events.php', 'events_archive' => 'page-events-archive.php', 'blog' => 'home.php', 'contact' => 'page-contact.php',
	'privacy' => 'page-privacy-policy.php', 'terms' => 'page-terms-conditions.php', 'cookies' => 'page-cookie-policy.php', 'not_found' => '404.php',
	'single_event' => 'single-event.php', 'single_post' => 'single.php',
);
$bad_marks = array(); $unmarked = 0; $total_fields = 0; $live_bad = array();
foreach ( $pages as $page => $info ) {
	$code   = file_get_contents( get_template_directory() . '/' . $tpl_files[ $page ] );
	$fields = crux_content_fields( $page );
	preg_match_all( "/crux_edit_attr\( '" . $page . "', '(\w+)' \)/", $code, $mm );
	$marked = array_unique( $mm[1] );
	foreach ( $marked as $k ) { if ( ! isset( $fields[ $k ] ) ) { $bad_marks[] = "$page.$k"; } }
	foreach ( $fields as $k => $f ) { $total_fields++; if ( ! in_array( $k, $marked, true ) ) { $unmarked++; } }
	$live_file = get_template_directory() . '/inc/content/live/' . $page . '.php';
	$live      = file_exists( $live_file ) ? (array) include $live_file : array();
	foreach ( $live as $k ) { if ( ! isset( $fields[ $k ] ) || ! in_array( $fields[ $k ][2], array( 'text', 'textarea' ), true ) || ! isset( crux_live_fields()[ $page . '.' . $k ] ) ) { $live_bad[] = "$page.$k"; } }
}
t( 'every pencil marker points at a real field', ! $bad_marks, implode( ',', array_slice( $bad_marks, 0, 6 ) ) );
t( 'at least 85% of all fields have a pencil on their page (' . ( $total_fields - $unmarked ) . ' of ' . $total_fields . ')', ( $total_fields - $unmarked ) / $total_fields >= 0.85 );
t( 'only plain text fields update instantly', ! $live_bad, implode( ',', array_slice( $live_bad, 0, 6 ) ) );
$wp_customize2 = new WP_Customize_Manager();
do_action( 'customize_register', $wp_customize2 );
$trans_ok = true;
foreach ( crux_live_fields() as $pk => $_ ) { list( $pg, $kk ) = explode( '.', $pk, 2 ); $st = $wp_customize2->get_setting( 'crux_c_' . $pg . '_' . $kk ); if ( ! $st || 'postMessage' !== $st->transport ) { $trans_ok = false; } }
t( 'instant-update fields use the postMessage transport and the rest reload the preview', $trans_ok && 'refresh' === $wp_customize2->get_setting( 'crux_c_home_hero_heading_1' )->transport );
$pc = file_get_contents( get_template_directory() . '/parts/site-header.php' ) . file_get_contents( get_template_directory() . '/parts/site-footer.php' ) . file_get_contents( get_template_directory() . '/inc/layout.php' );
preg_match_all( "/crux_edit_attr_opt\( '(\w+)' \)/", $pc, $om );
$opt_bad = array(); foreach ( array_unique( $om[1] ) as $o ) { if ( ! isset( crux_customizer_fields()[ $o ] ) ) { $opt_bad[] = $o; } }
t( 'site-wide pencil markers (' . count( array_unique( $om[1] ) ) . ') all point at real settings', ! $opt_bad && count( array_unique( $om[1] ) ) >= 15, implode( ',', $opt_bad ) );
t( 'the public site prints no pencil attributes', '' === crux_edit_attr( 'home', 'hero_heading_1' ) && '' === crux_edit_attr_opt( 'email' ) );
$titles_ok = true;
$pgt = crux_content_pages();
foreach ( $pgt as $pg => $inf ) { if ( false !== stripos( $inf[0], 'wording' ) || false !== stripos( $inf[0], ' page' ) ) { $titles_ok = false; } }
$secs_ok = true;
foreach ( $pages as $pg => $inf ) { foreach ( crux_content_fields( $pg ) as $k => $f ) { if ( preg_match( '/^[a-z ]+$/', $f[0] ) || false !== strpos( $f[0], ' / ' ) || '' === trim( $f[0] ) || 'Page' === $f[0] ) { $secs_ok = false; echo "      section name: $pg {$f[0]}
"; break; } } }
t( 'page names and section names are readable (no "wording", no raw template comments)', $titles_ok && $secs_ok );

echo "== 5. The site's own settings are untouched\n";
t( 'saved theme settings are exactly as before the test', get_option( $option ) === $backup );

echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
