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
		$accent = $dark ? '#5B8DEF' : '#6C58DB';
		return 'color:' . $accent . '; ' . $base . ' border-bottom:1.5px solid ' . $accent . ';';
	}
	return 'color:' . ( $dark ? '#F4F5FA' : '#10142E' ) . '; ' . $base;
}
