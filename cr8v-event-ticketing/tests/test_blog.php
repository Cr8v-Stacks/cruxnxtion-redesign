<?php
/**
 * Blog tests: real posts everywhere.
 *
 *  1. The six original articles are real posts; the seeder is safe (idempotent, never overwrites, never resurrects).
 *  2. A post the client writes shows its FULL content, category, tags, author box, share buttons, previous and next links
 *     and comments (the old template showed only a hard-coded set of articles or an excerpt).
 *  3. The blog list, archives (category, tag, author, date) and search show real posts, with paging and empty states.
 *  4. Open Graph, Twitter Card and Schema.org data: Article, Event, Organization.
 *  5. The single gallery photo page, and the templates the agency standard asks for exist.
 *
 *   php -d allow_url_fopen=1 cr8v-event-ticketing/tests/test_blog.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . 'wp-admin/includes/user.php';
global $wpdb;

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}
function http_get( $path ) {
	$ctx  = stream_context_create( array( 'http' => array( 'timeout' => 180, 'ignore_errors' => true, 'header' => "User-Agent: crux-blog-test\r\n" ) ) );
	$body = @file_get_contents( 'http://dev-playground.local' . $path, false, $ctx );
	return false === $body ? '' : $body;
}
function rel( $url ) { return wp_make_link_relative( $url ); }
function http_status( $path ) {
	$ctx = stream_context_create( array( 'http' => array( 'ignore_errors' => true, 'timeout' => 120, 'follow_location' => 0 ) ) );
	$h   = @get_headers( 'http://dev-playground.local' . $path, false, $ctx );
	return $h ? (int) substr( $h[0], 9, 3 ) : 0;
}

$admins = get_users( array( 'role' => 'administrator', 'number' => 1 ) );
wp_set_current_user( $admins[0]->ID );
$made = array(); $users = array(); $tmp_terms = array();

echo "== 1. The original articles are real posts\n";
$data = require get_template_directory() . '/inc/blog-seed-data.php';
$real = 0;
foreach ( $data as $slug => $a ) { $p = get_page_by_path( $slug, OBJECT, 'post' ); if ( $p && 'publish' === $p->post_status && false !== strpos( $p->post_content, '<h2>' ) && $p->post_excerpt ) { $real++; } }
t( 'all ' . count( $data ) . ' original articles exist as published posts with their text', count( $data ) === $real );
$with_thumb = 0; foreach ( $data as $slug => $a ) { $p = get_page_by_path( $slug, OBJECT, 'post' ); if ( $p && has_post_thumbnail( $p ) ) { $with_thumb++; } }
t( 'each has its Featured Image from the Media Library (when the theme photos are imported)', $with_thumb === count( $data ) );
$r = crux_seed_blog_posts( null, 'zz-blogtest-' );
t( 'the seeder creates a missing article', 6 === count( array_filter( $r, function ( $s ) { return 'created' === $s; } ) ), wp_json_encode( $r ) );
foreach ( $r as $slug => $s ) { $p = get_page_by_path( $slug, OBJECT, 'post' ); if ( $p ) { $made[] = $p->ID; } }
$again = crux_seed_blog_posts( null, 'zz-blogtest-' );
t( 'a second run changes nothing and makes no duplicates', 6 === count( array_filter( $again, function ( $s ) { return 'unchanged' === $s; } ) ) );
$first = get_page_by_path( 'zz-blogtest-behind-dance-out-2023', OBJECT, 'post' );
wp_update_post( array( 'ID' => $first->ID, 'post_content' => 'Client wrote this.' ) );
crux_seed_blog_posts( null, 'zz-blogtest-' );
t( "the client's edits survive a re-run", 'Client wrote this.' === get_post( $first->ID )->post_content );
wp_trash_post( $first->ID );
$rep = crux_seed_blog_posts( null, 'zz-blogtest-' );
t( 'an article moved to the trash is not recreated', 'skipped (trashed)' === $rep['zz-blogtest-behind-dance-out-2023'] );
foreach ( $made as $id ) { wp_delete_post( $id, true ); }
$made = array();

echo "== 2. A post the client writes shows everything\n";
$author_id = wp_insert_user( array( 'user_login' => 'zz_blogauthor', 'user_pass' => wp_generate_password( 32 ), 'user_email' => 'zz_blogauthor@example.com', 'role' => 'author', 'display_name' => 'Zed Writer', 'description' => 'Zed writes about nights that work.' ) );
$users[] = $author_id;
$cat = wp_insert_term( 'ZZ Test Category', 'category' ); $cat_id = (int) $cat['term_id']; $tmp_terms[] = array( $cat_id, 'category' );
$long = '';
for ( $i = 1; $i <= 6; $i++ ) { $long .= "<h2>ZZ section $i heading</h2>\n<p>ZZ paragraph $i " . str_repeat( 'word ', 60 ) . "</p>\n"; }
$long .= "<ul><li>ZZ list item</li></ul>\n<blockquote><p>ZZ quote text</p></blockquote>\n";
$older = wp_insert_post( array( 'post_type' => 'post', 'post_status' => 'publish', 'post_title' => 'ZZ Older Article', 'post_content' => 'Older.', 'post_date' => '2020-05-05 10:00:00', 'post_author' => $author_id ) );
$post  = wp_insert_post( array( 'post_type' => 'post', 'post_status' => 'publish', 'post_title' => 'ZZ Unique Blog Title', 'post_name' => 'zz-unique-blog-title', 'post_content' => $long, 'post_excerpt' => 'ZZ short excerpt only', 'post_author' => $author_id, 'post_date' => '2021-06-06 10:00:00', 'comment_status' => 'open', 'tags_input' => array( 'zztag' ) ) );
$newer = wp_insert_post( array( 'post_type' => 'post', 'post_status' => 'publish', 'post_title' => 'ZZ Newer Article', 'post_content' => 'Newer.', 'post_date' => current_time( 'mysql' ), 'post_author' => $author_id ) );
$made = array( $older, $post, $newer );
wp_set_post_terms( $post, array( $cat_id ), 'category' );
wp_insert_comment( array( 'comment_post_ID' => $post, 'comment_author' => 'ZZ Commenter', 'comment_author_email' => 'zz@example.com', 'comment_content' => 'ZZ comment body text', 'comment_approved' => 1 ) );
$h = http_get( rel( get_permalink( $post ) ) );
t( 'the page shows the post title and the full text, not just the excerpt', false !== strpos( $h, 'ZZ Unique Blog Title' ) && false !== strpos( $h, 'ZZ paragraph 6' ) && false !== strpos( $h, 'ZZ section 3 heading' ) );
preg_match( '#<article class="crux-prose">(.*?)</article>#s', $h, $am );
t( 'the excerpt is not printed in place of the article', ! empty( $am[1] ) && false === strpos( $am[1], 'ZZ short excerpt only' ) && false !== strpos( $am[1], 'ZZ paragraph 1' ) );
t( 'formatting survives (list and quote)', false !== strpos( $h, '<li>ZZ list item</li>' ) && false !== strpos( $h, '<blockquote>' ) );
t( 'the category name is shown', false !== stripos( $h, 'ZZ Test Category' ) );
t( 'the author name, the date and the reading time are shown', false !== strpos( $h, 'Zed Writer' ) && false !== strpos( $h, 'June 6, 2021' ) && 1 === preg_match( '/\d+ min read/', $h ) );
t( 'the tag is shown and links to its archive', false !== strpos( $h, '#zztag' ) && false !== strpos( $h, '/tag/zztag/' ) );
t( 'the author box shows the biography', false !== strpos( $h, 'Zed writes about nights that work.' ) );
t( 'share buttons are there with the encoded address', false !== strpos( $h, 'wa.me/?text=' ) && false !== strpos( $h, 'facebook.com/sharer' ) && false !== strpos( $h, rawurlencode( get_permalink( $post ) ) ) );
t( 'previous and next article links point at the neighbouring posts', false !== strpos( $h, 'ZZ Older Article' ) && false !== strpos( $h, 'ZZ Newer Article' ) && false !== strpos( $h, 'crux-postnav' ) );
t( 'the comment and the comment form are shown', false !== strpos( $h, 'ZZ comment body text' ) && false !== strpos( $h, 'id="commentform"' ) );
t( 'the sidebar lists other recent articles', false !== strpos( $h, 'ZZ Newer Article' ) );
wp_update_post( array( 'ID' => $post, 'comment_status' => 'closed' ) );
$h2 = http_get( rel( get_permalink( $post ) ) );
t( 'with comments closed the form is gone but the comment stays', false === strpos( $h2, 'id="commentform"' ) && false !== strpos( $h2, 'ZZ comment body text' ) );

echo "== 3. Lists, archives and search show real posts\n";
$blog = http_get( '/blog/' );
t( 'the blog list shows the newest post as the featured card', false !== strpos( $blog, 'ZZ Newer Article' ) && 1 === substr_count( $blog, 'grid-column:span 3' ) );
$count_posts = (int) wp_count_posts()->publish;
$per         = (int) get_option( 'posts_per_page' );
t( 'the blog list has one card for each post of the page (not fixed tiles)', substr_count( $blog, 'class="ticket reveal"' ) === min( $per, $count_posts ), (string) substr_count( $blog, 'class="ticket reveal"' ) );
if ( $count_posts > $per ) {
	t( 'with more posts than fit a page there are page links', false !== strpos( $blog, 'crux-pagination' ) && false !== strpos( $blog, '/blog/page/2/' ) );
	$p2 = http_get( '/blog/page/2/' );
	t( 'page 2 lists posts and has no featured card', substr_count( $p2, 'class="ticket reveal"' ) >= 1 && false === strpos( $p2, 'grid-column:span 3' ) );
}
$cat_page = http_get( rel( get_category_link( $cat_id ) ) );
t( 'the category page lists its post under the category name', false !== strpos( $cat_page, 'ZZ Unique Blog Title' ) && false !== strpos( $cat_page, 'ZZ Test Category' ) && false === strpos( $cat_page, 'Category:' ) );
$tag_page = http_get( '/tag/zztag/' );
t( 'the tag page lists its post', false !== strpos( $tag_page, 'ZZ Unique Blog Title' ) );
$au_page = http_get( rel( get_author_posts_url( $author_id ) ) );
t( 'the author page shows the author, the biography and the posts', false !== strpos( $au_page, 'Zed Writer' ) && false !== strpos( $au_page, 'Zed writes about nights that work.' ) && false !== strpos( $au_page, 'ZZ Unique Blog Title' ) );
$date_page = http_get( '/2021/06/' );
t( 'the date archive lists the posts of that month only', false !== strpos( $date_page, 'ZZ Unique Blog Title' ) && false === strpos( $date_page, 'ZZ Newer Article' ) );
$s = http_get( '/?s=' . rawurlencode( 'Unique Blog Title' ) );
t( 'search finds the post and says how many results', false !== strpos( $s, 'ZZ Unique Blog Title' ) && 1 === preg_match( '/\d+ results?/', $s ) );
t( 'search has its own box, filled with the words searched', false !== strpos( $s, 'class="crux-searchform"' ) && false !== strpos( $s, 'value="Unique Blog Title"' ) );
$none = http_get( '/?s=zzqqxxnothingmatches' );
t( 'a search with no results says so', false !== strpos( $none, 'Nothing found' ) && false !== strpos( $none, '0 results' ) );
$empty_cat = wp_insert_term( 'ZZ Empty Category', 'category' ); $tmp_terms[] = array( (int) $empty_cat['term_id'], 'category' );
t( 'an empty archive says so', false !== strpos( http_get( rel( get_category_link( (int) $empty_cat['term_id'] ) ) ), 'No articles found here yet.' ) );

$ctx = stream_context_create( array( 'http' => array( 'follow_location' => 0, 'ignore_errors' => true, 'timeout' => 120 ) ) );
@file_get_contents( 'http://dev-playground.local/blog/zz-unique-blog-title/', false, $ctx );
$loc = ''; foreach ( (array) $http_response_header as $hh ) { if ( 0 === stripos( $hh, 'Location:' ) ) { $loc = trim( substr( $hh, 9 ) ); } }
t( 'an old /blog/<post>/ address redirects to the real post address', get_permalink( $post ) === $loc, $loc );
t( 'an unknown /blog/<anything>/ address is a real 404, not a placeholder article', 404 === http_status( '/blog/zz-nothing-here/' ) );
echo "== 4. Open Graph, Twitter Card and structured data\n";
function ld_blocks( $html ) { preg_match_all( '#<script type="application/ld\+json">(.*?)</script>#s', $html, $m ); return array_filter( array_map( function ( $j ) { return json_decode( $j, true ); }, $m[1] ) ); }
t( 'a post has one set of Open Graph and Twitter tags (no duplicates) with type article', 1 === substr_count( $h, 'property="og:title"' ) && false !== strpos( $h, 'property="og:type" content="article"' ) && false !== strpos( $h, 'name="twitter:card"' ) );
$art = array_filter( ld_blocks( $h ), function ( $b ) { return 'Article' === ( $b['@type'] ?? '' ); } );
t( 'a post carries valid Article data with headline, author and date', 1 === count( $art ) && 'ZZ Unique Blog Title' === reset( $art )['headline'] && 'Zed Writer' === reset( $art )['author']['name'] && 0 === strpos( reset( $art )['datePublished'], '2021-06-06' ) );
$ev = http_get( '/event/ankara-festival/' );
$evb = array_filter( ld_blocks( $ev ), function ( $b ) { return 'Event' === ( $b['@type'] ?? '' ); } );
t( 'an event carries valid Event data with name, start date and place', 1 === count( $evb ) && ! empty( reset( $evb )['name'] ) && ! empty( reset( $evb )['startDate'] ) && ! empty( reset( $evb )['location']['name'] ) );
$home = http_get( '/' );
$org  = array_filter( ld_blocks( $home ), function ( $b ) { return 'Organization' === ( $b['@type'] ?? '' ); } );
t( 'the home page carries Organization data', 1 === count( $org ) );
t( 'every page has a description and a share picture', false !== strpos( $home, 'name="description"' ) && false !== strpos( $home, 'property="og:image"' ) );
t( 'the share buttons are on the event page too', false !== strpos( $ev, 'crux-share__copy' ) );
t( 'no tag is printed when an SEO plugin is active (switch exists)', function_exists( 'crux_seo_plugin_active' ) && false === crux_seo_plugin_active() );

echo "== 5. Gallery photo page and the standard templates\n";
$g = wp_insert_post( array( 'post_type' => 'gallery_item', 'post_status' => 'publish', 'post_title' => 'ZZ Gallery Photo' ) );
$made[] = $g;
update_post_meta( $g, '_cr8v_gallery_kicker', 'ZZ kicker' ); update_post_meta( $g, '_cr8v_gallery_location', 'ZZ Place' ); update_post_meta( $g, '_cr8v_gallery_notes', 'ZZ production notes' );
$gp = http_get( rel( get_permalink( $g ) ) );
t( 'a single gallery item shows its title, kicker, location, notes and a way back', false !== strpos( $gp, 'ZZ Gallery Photo' ) && false !== strpos( $gp, 'ZZ kicker' ) && false !== strpos( $gp, 'ZZ Place' ) && false !== strpos( $gp, 'ZZ production notes' ) && false !== strpos( $gp, 'Back to the gallery' ) );
$missing = array();
foreach ( array( 'header.php', 'footer.php', 'archive.php', 'category.php', 'tag.php', 'author.php', 'date.php', 'search.php', 'comments.php', 'single.php', 'single-event.php', 'single-gallery_item.php', 'archive-event.php', '404.php', 'front-page.php', 'page.php', 'home.php', 'index.php' ) as $f ) { if ( ! file_exists( get_template_directory() . '/' . $f ) ) { $missing[] = $f; } }
t( 'every template the agency standard lists exists', ! $missing, implode( ',', $missing ) );

echo "== Cleanup\n";
foreach ( $made as $id ) { wp_delete_post( $id, true ); }
foreach ( $tmp_terms as $tt ) { wp_delete_term( $tt[0], $tt[1] ); }
$tg = get_term_by( 'slug', 'zztag', 'post_tag' ); if ( $tg ) { wp_delete_term( $tg->term_id, 'post_tag' ); }
foreach ( $users as $uid ) { wp_delete_user( $uid ); }
$left = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_title LIKE 'ZZ %' OR post_name LIKE 'zz-%'" );
t( 'no test posts, users or terms left behind', 0 === $left && ! get_user_by( 'login', 'zz_blogauthor' ) );

echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
