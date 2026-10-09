<?php
/**
 * Site header: document head, the page's stylesheet, the page wrapper and the shared header (announcement bar, menu, drawer).
 *
 * Templates call get_header( null, $args ) with:
 *   body_bg, root_bg   background colours of the page (dark pages #0A0F26, light pages #FFFFFF)
 *   skin, nav, wing, active   see parts/site-header.php
 * and choose their stylesheet first with crux_use_page_css( 'dark' | 'home' | 'light' | 'consultancy' | 'contact' | 'legal' | 'faq' ).
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$crux_h = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'body_bg' => '#0A0F26',
		'root_bg' => '#0A0F26',
		'skin'    => 'dark',
		'nav'     => 'events',
		'wing'    => 'events',
		'active'  => '',
	)
);
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="background:<?php echo esc_attr( $crux_h['body_bg'] ); ?>; margin:0; padding:0;">
<?php wp_body_open(); ?>

<div style="width:100%; max-width:100%; margin:0; background:<?php echo esc_attr( $crux_h['root_bg'] ); ?>; overflow-x:clip;" data-m="root">

  <?php
  get_template_part(
	'parts/site-header',
	null,
	array(
		'skin'   => $crux_h['skin'],
		'nav'    => $crux_h['nav'],
		'wing'   => $crux_h['wing'],
		'active' => $crux_h['active'],
	)
  );
  ?>
