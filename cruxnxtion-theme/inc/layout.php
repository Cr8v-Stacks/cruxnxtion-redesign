<?php
/**
 * Crux Nxtion - shared page layout helpers (header, footer and pre-footer parts).
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Style attribute of a top navigation link. The highlighted link gets the accent colour and an underline.
 *
 * @param string $skin   'dark' or 'light'.
 * @param string $key    Link key: home, events, gallery, about, blog, contact, founder.
 * @param string $active Key of the highlighted link, or ''.
 */
function crux_nav_style( $skin, $key, $active ) {
	$dark = ( 'dark' === $skin );
	$base = 'font-size:14px; font-weight:600; letter-spacing:0.2px;';
	if ( $key === $active ) {
		$accent = $dark ? 'var(--crux-blue,#5B8DEF)' : 'var(--crux-violet,#6C58DB)';
		return 'color:' . $accent . '; ' . $base . ' border-bottom:1.5px solid ' . $accent . ';';
	}
	return 'color:' . ( $dark ? 'var(--crux-text,#F4F5FA)' : 'var(--crux-ink2,#10142E)' ) . '; ' . $base;
}

/**
 * Colours of the footer for the dark (events) and light (consultancy and information) pages.
 */
function crux_footer_palette( $skin ) {
	if ( 'light' === $skin ) {
		return array(
			'bg'     => 'var(--crux-ink2,#10142E)',
			'hi'     => '#F2F1F8',
			'mid'    => '#B9AFF0',
			'lo'     => '#2A2F5C',
			'nav'    => '#9A9AC0',
			'soc_bg' => 'rgba(242,241,248,0.05)',
			'soc_bc' => 'rgba(242,241,248,0.12)',
			'copy'   => '#6E6E9A',
		);
	}
	return array(
		'bg'     => 'var(--crux-ink,#0A0F26)',
		'hi'     => 'var(--crux-text,#F4F5FA)',
		'mid'    => '#A9C0F5',
		'lo'     => 'var(--crux-line,#1E2B5E)',
		'nav'    => '#A3A9C8',
		'soc_bg' => 'rgba(244,245,250,0.05)',
		'soc_bc' => 'rgba(244,245,250,0.12)',
		'copy'   => '#7A82A8',
	);
}

/**
 * Attributes of a link: an address inside the site, or an outside address that opens in a new tab.
 *
 * @param array $link array( 'in' => '/contact/' ) or array( 'out' => 'https://...' ).
 */
function crux_link_attrs( $link ) {
	if ( isset( $link['out'] ) ) {
		return 'href="' . esc_url( $link['out'] ) . '" target="_blank" rel="noopener"';
	}
	return 'href="' . esc_url( home_url( $link['in'] ) ) . '"';
}

/**
 * One call-to-action button of the pre-footer band.
 *
 * @param array $btn array( 'text' => ..., 'link' => ..., 'tone' => 'red' | 'purple' ).
 */
function crux_prefooter_button( $btn ) {
	$style = 'red' === $btn['tone']
		? 'background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;'
		: 'background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E) !important; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;';
	return '<a ' . crux_link_attrs( $btn['link'] ) . ' style="' . $style . '"' . ( ! empty( $btn['edit'] ) ? crux_edit_attr_opt( $btn['edit'] ) : '' ) . ' class="bx">' . esc_html( $btn['text'] ) . '</a>';
}

/**
 * Content of the pre-footer band. Each key is one of the combinations the templates used before the band was shared.
 */
function crux_prefooter_data( $key ) {
	$calendly = crux_opt( 'calendly_url' );
	$events   = array(
		'title'      => crux_opt( 'pf_events_title' ),
		'desc'       => crux_opt( 'pf_events_desc' ),
		'ids'        => array( 'title' => 'pf_events_title', 'desc' => 'pf_events_desc' ),
		'btn1'       => array( 'edit' => 'pf_events_btn1', 'text' => crux_opt( 'pf_events_btn1' ), 'link' => array( 'in' => '/contact/?type=events' ), 'tone' => 'red' ),
		'btn2'       => array( 'edit' => 'pf_events_btn2', 'text' => crux_opt( 'pf_events_btn2' ), 'link' => array( 'in' => '/contact/?type=consultancy' ), 'tone' => 'purple' ),
		'badge_img'  => 'events',
		'badge_link' => array( 'in' => '/contact/?type=events' ),
		'aria'       => 'Plan An Event',
		'alt'        => 'Plan An Event — spinning badge',
	);
	switch ( $key ) {
		case 'events-light':
			$events['badge_img'] = 'consultancy';
			return $events;
		case 'founder':
			$events['badge_img']  = 'consultancy';
			$events['badge_link'] = array( 'in' => '/contact/?type=consultancy' );
			return $events;
		case 'services':
			$events['badge_img']  = 'consultancy';
			$events['btn2']['link'] = array( 'out' => $calendly );
			$events['badge_link'] = array( 'out' => $calendly );
			$events['aria']       = 'Book Discovery Call';
			return $events;
		case 'idea':
			return array(
				'title'      => crux_opt( 'pf_consult_title' ),
				'desc'       => crux_opt( 'pf_consult_desc' ),
				'ids'        => array( 'title' => 'pf_consult_title', 'desc' => 'pf_consult_desc' ),
				'btn1'       => array( 'edit' => 'pf_consult_btn1', 'text' => crux_opt( 'pf_consult_btn1' ), 'link' => array( 'out' => $calendly ), 'tone' => 'purple' ),
				'btn2'       => array( 'edit' => 'pf_consult_btn2', 'text' => crux_opt( 'pf_consult_btn2' ), 'link' => array( 'in' => '/' ), 'tone' => 'red' ),
				'badge_img'  => 'consultancy',
				'badge_link' => array( 'out' => $calendly ),
				'aria'       => 'Book A Discovery Call',
				'alt'        => 'Book A Discovery Call — spinning badge',
			);
	}
	return $events;
}

/* ---- Page stylesheets -------------------------------------------------------------------------------------------------- */

/**
 * Choose the stylesheet of the page before get_header(): dark, home, light, consultancy, contact, legal or faq. Each is the
 * stylesheet that used to be printed inside every template. It loads after the theme's and the plugins' styles, where the
 * inline copy used to sit, so nothing is overridden differently.
 */
function crux_use_page_css( $family ) {
	$GLOBALS['crux_page_css_family'] = preg_replace( '/[^a-z]/', '', (string) $family );
}

function crux_enqueue_page_css() {
	$family = isset( $GLOBALS['crux_page_css_family'] ) ? $GLOBALS['crux_page_css_family'] : '';
	$file   = get_template_directory() . '/assets/css/crux-' . $family . '.css';
	if ( '' === $family || ! file_exists( $file ) ) {
		return;
	}
	// The file's change time is part of the address: this site strips ?ver= from addresses, which left browsers on stale copies.
	wp_enqueue_style( 'crux-page-css', get_template_directory_uri() . '/assets/css/crux-' . $family . '.css?cv=' . filemtime( $file ), array( 'crux-style' ), null );
}
add_action( 'wp_enqueue_scripts', 'crux_enqueue_page_css', 999 );
