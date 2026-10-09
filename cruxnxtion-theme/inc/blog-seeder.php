<?php
/**
 * Crux Nxtion - the six original journal articles as real WordPress posts.
 *
 * The single post template used to carry these six articles inside its own code, and showed only an excerpt for any
 * post the client wrote. Now every article is an ordinary post that the client can open, edit, delete or add to, and
 * the single post template prints the real post. This seeder creates the six once.
 *
 * Rules (the client's edits always win): a missing article is created; an existing one is never touched; one the client
 * moved to the trash is never recreated.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function crux_blog_post_is_trashed( $slug ) {
	global $wpdb;
	return (bool) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'trash' AND post_name IN ( %s, %s ) LIMIT 1",
			$slug,
			$slug . '__trashed'
		)
	);
}

/**
 * @param array|null $articles Rows (defaults to the bundled data).
 * @param string     $prefix   Slug prefix, only used by tests.
 * @return array Slug => 'created' | 'unchanged' | 'skipped (trashed)'.
 */
function crux_seed_blog_posts( $articles = null, $prefix = '' ) {
	$articles = null === $articles ? require get_template_directory() . '/inc/blog-seed-data.php' : $articles;
	$report   = array();
	$author   = get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ) );
	foreach ( $articles as $slug => $a ) {
		$slug = $prefix . $slug;
		if ( get_page_by_path( $slug, OBJECT, 'post' ) ) {
			$report[ $slug ] = 'unchanged';
			continue;
		}
		if ( crux_blog_post_is_trashed( $slug ) ) {
			$report[ $slug ] = 'skipped (trashed)';
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'post',
				'post_status'  => 'publish',
				'post_title'   => $a['title'],
				'post_name'    => $slug,
				'post_content' => $a['content'],
				'post_excerpt' => $a['excerpt'],
				'post_author'  => $author ? (int) $author[0] : 1,
			),
			true
		);
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		$term = term_exists( $a['category'], 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $a['category'], 'category' );
		}
		if ( ! is_wp_error( $term ) && $term ) {
			wp_set_post_terms( $id, array( (int) ( is_array( $term ) ? $term['term_id'] : $term ) ), 'category' );
		}
		$att = function_exists( 'crux_blob_attachment_id' ) ? crux_blob_attachment_id( $a['hero'] ) : 0;
		if ( $att ) {
			set_post_thumbnail( $id, $att );
		}
		$report[ $slug ] = 'created';
	}
	return $report;
}

/** Once per install, from wp-admin or the site, after the Media Library holds the theme's photos. */
function crux_maybe_seed_blog() {
	if ( '1' === get_option( 'crux_blog_seeded_v1' ) ) {
		return;
	}
	crux_seed_blog_posts();
	update_option( 'crux_blog_seeded_v1', '1' );
}
add_action( 'init', 'crux_maybe_seed_blog', 40 );
