<?php
/**
 * Crux Nxtion - brand colours as design tokens.
 *
 * The stylesheets and inline styles use var(--crux-<token>, <original hex>). Nothing is printed until a colour is changed in the
 * Customizer (Brand colours), so an untouched site renders exactly as before; a changed colour prints one :root rule that
 * retints every page, and the Customizer preview updates it instantly.
 *
 * Colours inside SVG attributes, scripts and rgba() tints are not tokens (CSS variables do not work there).
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** token => array( label, default hex ). */
function crux_colour_tokens() {
	return array(
		'navy'    => array( __( 'Brand navy (buttons, stubs, accents)', 'cruxnxtion' ), '#002671' ),
		'blue'    => array( __( 'Bright blue (links, small labels)', 'cruxnxtion' ), '#5B8DEF' ),
		'red'     => array( __( 'Brand red (call-to-action buttons)', 'cruxnxtion' ), '#BA0000' ),
		'crimson' => array( __( 'Crimson (highlights)', 'cruxnxtion' ), '#E5383B' ),
		'purple'  => array( __( 'Purple (consultancy accent)', 'cruxnxtion' ), '#8C7AE6' ),
		'violet'  => array( __( 'Deep violet (consultancy buttons)', 'cruxnxtion' ), '#6C58DB' ),
		'ink'     => array( __( 'Page background (darkest)', 'cruxnxtion' ), '#0A0F26' ),
		'ink2'    => array( __( 'Section background (dark)', 'cruxnxtion' ), '#10142E' ),
		'surface' => array( __( 'Card background', 'cruxnxtion' ), '#111838' ),
		'line'    => array( __( 'Borders and dividers', 'cruxnxtion' ), '#1E2B5E' ),
		'text'    => array( __( 'Light text on dark', 'cruxnxtion' ), '#F4F5FA' ),
	);
}

/** The colour set for a token ("" when not changed from the default). */
function crux_colour_value( $token ) {
	$tokens = crux_colour_tokens();
	if ( ! isset( $tokens[ $token ] ) ) {
		return '';
	}
	$v = sanitize_hex_color( (string) get_theme_mod( 'crux_colour_' . $token, $tokens[ $token ][1] ) );
	return ( $v && strtolower( $v ) !== strtolower( $tokens[ $token ][1] ) ) ? $v : '';
}

function crux_customize_register_colours( $wp_customize ) {
	$wp_customize->add_section(
		'crux_colours',
		array(
			'title'       => __( 'Brand colours', 'cruxnxtion' ),
			'description' => __( 'Change a colour here and it changes everywhere it is used, on every page. Reset a colour to put the original back.', 'cruxnxtion' ),
			'panel'       => 'crux_site',
			'priority'    => 0,
		)
	);
	foreach ( crux_colour_tokens() as $token => $def ) {
		$wp_customize->add_setting(
			'crux_colour_' . $token,
			array(
				'default'           => $def[1],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'crux_colour_' . $token,
				array(
					'label'   => $def[0],
					'section' => 'crux_colours',
				)
			)
		);
	}
}
add_action( 'customize_register', 'crux_customize_register_colours' );

/** One :root rule for the colours that were changed. */
function crux_colours_css() {
	$rules = array();
	foreach ( array_keys( crux_colour_tokens() ) as $token ) {
		$v = crux_colour_value( $token );
		if ( '' !== $v ) {
			$rules[] = '--crux-' . $token . ':' . $v;
		}
	}
	return $rules ? ':root{' . implode( ';', $rules ) . '}' : '';
}

function crux_print_colours() {
	$css = crux_colours_css();
	if ( '' !== $css || is_customize_preview() ) {
		echo '<style id="crux-colours">' . $css . "</style>\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- hex colours only, sanitized.
	}
}
add_action( 'wp_head', 'crux_print_colours', 6 );
