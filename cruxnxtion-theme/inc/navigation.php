<?php
/**
 * Crux Nxtion - navigation: WordPress menus with the original links as the fallback.
 *
 * Until a menu is assigned to a location the header, drawer and footer show the original links, so the site looks exactly
 * as before. The demo importer creates menus from those same links and assigns them, after which the client edits the
 * navigation under Appearance > Menus. The Services dropdown keeps its fixed design (only its label and its place in the
 * order come from the menu); sub-items of a menu entry are ignored.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function crux_register_menus() {
	register_nav_menus(
		array(
			'primary'     => __( 'Main menu (events and information pages)', 'cruxnxtion' ),
			'consultancy' => __( 'Main menu (consultancy pages)', 'cruxnxtion' ),
			'footer'      => __( 'Footer menu', 'cruxnxtion' ),
		)
	);
}
add_action( 'after_setup_theme', 'crux_register_menus' );

/** The original links: array of key, label, path (and mega for the Services dropdown). */
function crux_nav_fallback( $surface, $nav, $wing ) {
	if ( 'footer' === $surface ) {
		return array(
			array( 'key' => 'home', 'label' => 'Home', 'path' => 'consultancy' === $wing ? '/consultancy/' : '/' ),
			array( 'key' => 'services', 'label' => 'Services', 'path' => 'consultancy' === $wing ? '/services-consultancy/' : '/services/' ),
			array( 'key' => 'events', 'label' => 'Events', 'path' => '/events/' ),
			array( 'key' => 'gallery', 'label' => 'Gallery', 'path' => '/gallery/' ),
			array( 'key' => 'about', 'label' => 'About', 'path' => '/about/' ),
			array( 'key' => 'faq', 'label' => 'FAQ', 'path' => '/faq/' ),
			array( 'key' => 'blog', 'label' => 'Blog', 'path' => '/blog/' ),
			array( 'key' => 'sponsors', 'label' => 'Sponsors', 'path' => '/sponsors/' ),
		);
	}
	$items = array(
		array( 'key' => 'home', 'label' => 'Home', 'path' => 'consultancy' === $wing ? '/consultancy/' : '/' ),
		array( 'key' => 'services', 'label' => 'Services', 'path' => '/services/', 'mega' => true ),
	);
	if ( 'desktop' === $surface && 'consultancy' === $nav ) {
		$items[] = array( 'key' => 'founder', 'label' => 'Founder', 'path' => '/founder/' );
	} else {
		$items[] = array( 'key' => 'events', 'label' => 'Events', 'path' => '/events/' );
		$items[] = array( 'key' => 'gallery', 'label' => 'Gallery', 'path' => '/gallery/' );
	}
	$items[] = array( 'key' => 'about', 'label' => 'About', 'path' => '/about/' );
	$items[] = array( 'key' => 'blog', 'label' => 'Blog', 'path' => '/blog/' );
	$items[] = array( 'key' => 'contact', 'label' => 'Contact', 'path' => '/contact/' );
	return $items;
}

/** Top-level items of the menu assigned to a location, or null when none is assigned. */
function crux_nav_menu_items( $location ) {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		return null;
	}
	$menu_items = wp_get_nav_menu_items( $locations[ $location ] );
	if ( ! $menu_items ) {
		return null;
	}
	$base  = rtrim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	$items = array();
	foreach ( $menu_items as $mi ) {
		if ( (int) $mi->menu_item_parent ) {
			continue;
		}
		$path = (string) wp_parse_url( $mi->url, PHP_URL_PATH );
		$rel  = ( $base && 0 === strpos( $path, $base . '/' ) ) ? substr( $path, strlen( $base ) ) : $path;
		$rel  = '' === $rel ? '/' : trailingslashit( $rel );
		$items[] = array(
			'key'   => sanitize_title( trim( $rel, '/' ) ) ? sanitize_title( trim( $rel, '/' ) ) : 'home',
			'label' => $mi->title,
			'url'   => $mi->url,
			'path'  => $rel,
			'mega'  => in_array( 'crux-mega', (array) $mi->classes, true ) || in_array( $rel, array( '/services/', '/services-consultancy/' ), true ),
		);
	}
	return $items;
}

/** Links for a surface ('desktop', 'drawer', 'footer'): the assigned menu, else the original links. */
function crux_nav_items( $surface, $nav, $wing ) {
	$location = 'footer' === $surface ? 'footer' : ( 'desktop' === $surface && 'consultancy' === $nav ? 'consultancy' : 'primary' );
	$menu     = crux_nav_menu_items( $location );
	if ( null !== $menu ) {
		return array( 'menu' => true, 'items' => $menu );
	}
	return array( 'menu' => false, 'items' => crux_nav_fallback( $surface, $nav, $wing ) );
}

/** Path of the highlighted top link for a header "active" key. */
function crux_active_path( $active, $wing ) {
	$map = array(
		'home'    => 'consultancy' === $wing ? '/consultancy/' : '/',
		'events'  => '/events/',
		'gallery' => '/gallery/',
		'about'   => '/about/',
		'blog'    => '/blog/',
		'contact' => '/contact/',
		'founder' => '/founder/',
	);
	return isset( $map[ $active ] ) ? $map[ $active ] : '';
}

/** Does this surface show the Services dropdown? */
function crux_nav_has_mega( $surface, $nav, $wing ) {
	$set = crux_nav_items( $surface, $nav, $wing );
	foreach ( $set['items'] as $it ) {
		if ( ! empty( $it['mega'] ) ) {
			return true;
		}
	}
	return false;
}

/** Wording of the Services entry. */
function crux_nav_services_label( $surface, $nav, $wing ) {
	$set = crux_nav_items( $surface, $nav, $wing );
	foreach ( $set['items'] as $it ) {
		if ( ! empty( $it['mega'] ) ) {
			return $it['label'];
		}
	}
	return 'Services';
}

function crux_drawer_link_style( $skin ) {
	return 'dark' === $skin ? 'color:var(--crux-text,#F4F5FA); border-bottom:1px solid var(--crux-line,#1E2B5E);' : 'color:var(--crux-ink2,#10142E); border-bottom:1px solid #E1DEF3;';
}

/** Print the links before ('before') or after ('after') the Services dropdown. */
function crux_render_nav( $surface, $part, $skin, $nav, $wing, $active ) {
	$set    = crux_nav_items( $surface, $nav, $wing );
	$before = array();
	$after  = array();
	$seen   = false;
	foreach ( $set['items'] as $it ) {
		if ( ! empty( $it['mega'] ) ) {
			$seen = true;
			continue;
		}
		if ( $seen ) {
			$after[] = $it;
		} else {
			$before[] = $it;
		}
	}
	$list = ( 'before' === $part ) ? $before : $after;
	foreach ( $list as $it ) {
		$url = isset( $it['url'] ) ? $it['url'] : home_url( $it['path'] );
		if ( $set['menu'] ) {
			$ap = crux_active_path( $active, $wing );
			$on = '' !== $ap && $ap === $it['path'];
		} else {
			$on = $it['key'] === $active;
		}
		if ( 'drawer' === $surface ) {
			echo '<a class="mlink" href="' . esc_url( $url ) . '" style="' . esc_attr( crux_drawer_link_style( $skin ) ) . '">' . esc_html( $it['label'] ) . "</a>\n";
		} else {
			echo '<a href="' . esc_url( $url ) . '" style="' . crux_nav_style( $skin, 'on', $on ? 'on' : 'off' ) . '">' . esc_html( $it['label'] ) . "</a>\n";
		}
	}
}

/** The footer link row. */
function crux_render_footer_nav( $color, $wing ) {
	$set = crux_nav_items( 'footer', 'events', $wing );
	foreach ( $set['items'] as $it ) {
		$url = isset( $it['url'] ) ? $it['url'] : home_url( $it['path'] );
		echo '<a href="' . esc_url( $url ) . '" style="font-size:14px; color:' . esc_attr( $color ) . ';">' . esc_html( $it['label'] ) . "</a>\n";
	}
}
