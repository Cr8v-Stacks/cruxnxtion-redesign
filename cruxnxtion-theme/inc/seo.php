<?php
/**
 * Crux Nxtion - search and social sharing meta: Open Graph, Twitter Card and Schema.org JSON-LD (Organization, Article,
 * Event). Switched off automatically when an SEO plugin is active, so tags are never printed twice.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** The post of the page being shown (the queried one, not whatever the loop touched last). */
function crux_seo_post() {
	$q = get_queried_object();
	return ( $q instanceof WP_Post ) ? $q : get_post();
}

function crux_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
}

/** Description for the current page. */
function crux_seo_description() {
	$text = '';
	if ( is_singular() ) {
		$post = crux_seo_post();
		$text = $post->post_excerpt ? $post->post_excerpt : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
		if ( 'event' === $post->post_type ) {
			$meta = get_post_meta( $post->ID, '_cr8v_event_excerpt', true );
			$text = $meta ? $meta : $text;
		}
	} elseif ( is_archive() && get_the_archive_description() ) {
		$text = wp_strip_all_tags( get_the_archive_description() );
	}
	$text = trim( preg_replace( '/\s+/', ' ', (string) $text ) );
	if ( '' === $text ) {
		$text = (string) get_bloginfo( 'description' );
	}
	if ( '' === $text && is_front_page() && function_exists( 'crux_value' ) ) {
		$text = wp_strip_all_tags( crux_value( 'home', 'hero_paragraph_1' ) );
	}
	if ( '' === $text ) {
		$text = wp_get_document_title();
	}
	return wp_html_excerpt( $text, 200, '…' );
}

/** Picture for the current page: featured image, else the site logo. */
function crux_seo_image() {
	$sp = crux_seo_post();
	if ( is_singular() && $sp && has_post_thumbnail( $sp ) ) {
		return get_the_post_thumbnail_url( $sp, 'large' );
	}
	return function_exists( 'crux_logo_url' ) ? crux_logo_url() : '';
}

function crux_seo_json_ld() {
	$items = array();
	if ( is_front_page() ) {
		$items[] = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Organization',
			'name'     => get_bloginfo( 'name' ),
			'url'      => home_url( '/' ),
			'logo'     => crux_seo_image(),
			'email'    => function_exists( 'crux_opt' ) ? crux_opt( 'email' ) : '',
			'address'  => function_exists( 'crux_address' ) ? crux_address() : '',
		);
	}
	if ( is_singular( 'post' ) ) {
		$p       = crux_seo_post();
		$items[] = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'Article',
			'headline'         => get_the_title( $p ),
			'datePublished'    => get_the_date( 'c', $p ),
			'dateModified'     => get_the_modified_date( 'c', $p ),
			'author'           => array( '@type' => 'Person', 'name' => get_the_author_meta( 'display_name', $p->post_author ) ),
			'image'            => crux_seo_image(),
			'mainEntityOfPage' => get_permalink( $p ),
			'publisher'        => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ) ),
		);
	}
	if ( is_singular( 'event' ) ) {
		$p     = crux_seo_post();
		$date  = (string) get_post_meta( $p->ID, '_cr8v_event_date', true );
		$venue = (string) get_post_meta( $p->ID, '_cr8v_event_venue', true );
		$event = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Event',
			'name'        => get_the_title( $p ),
			'description' => crux_seo_description(),
			'image'       => crux_seo_image(),
			'url'         => get_permalink( $p ),
			'eventStatus' => 'https://schema.org/EventScheduled',
			'organizer'   => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) ),
		);
		if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
			$event['startDate'] = $date;
		}
		if ( '' !== $venue ) {
			$event['location'] = array( '@type' => 'Place', 'name' => $venue, 'address' => $venue );
		}
		$items[] = $event;
	}
	foreach ( $items as $item ) {
		echo '<script type="application/ld+json">' . wp_json_encode( array_filter( $item, function ( $v ) { return '' !== $v && null !== $v; } ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

function crux_seo_head() {
	if ( crux_seo_plugin_active() || is_admin() || is_customize_preview() ) {
		return;
	}
	$title = wp_get_document_title();
	$desc  = crux_seo_description();
	$img   = crux_seo_image();
	$url   = is_singular() ? get_permalink( crux_seo_post() ) : ( is_front_page() ? home_url( '/' ) : home_url( add_query_arg( array() ) ) );
	$type  = is_singular( 'post' ) ? 'article' : 'website';
	$tags  = array(
		array( 'property', 'og:site_name', get_bloginfo( 'name' ) ),
		array( 'property', 'og:locale', str_replace( '-', '_', get_locale() ) ),
		array( 'property', 'og:type', $type ),
		array( 'property', 'og:title', $title ),
		array( 'property', 'og:description', $desc ),
		array( 'property', 'og:url', $url ),
		array( 'name', 'twitter:card', $img ? 'summary_large_image' : 'summary' ),
		array( 'name', 'twitter:title', $title ),
		array( 'name', 'twitter:description', $desc ),
	);
	if ( $img ) {
		$tags[] = array( 'property', 'og:image', $img );
		$tags[] = array( 'name', 'twitter:image', $img );
	}
	if ( $desc && ! is_404() ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	foreach ( $tags as $t ) {
		echo '<meta ' . esc_attr( $t[0] ) . '="' . esc_attr( $t[1] ) . '" content="' . esc_attr( $t[2] ) . '">' . "\n";
	}
	crux_seo_json_ld();
}
add_action( 'wp_head', 'crux_seo_head', 5 );
