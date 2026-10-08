<?php
/**
 * Crux Nxtion - Customizer: page panels that load on demand.
 *
 * Every page setting is registered all the time (so a save works whatever was opened), but the panel, sections and
 * controls of a page are created only when that page is shown in the preview. They are fetched from the server at
 * that moment (assets/js/customizer-pages.js, action crux_page_controls). Opening the Customizer therefore builds
 * only the site-wide controls instead of about 850.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function crux_customize_register_content( $wp_customize ) {
	foreach ( crux_content_pages() as $page => $info ) {
		foreach ( crux_content_fields( $page ) as $key => $f ) {
			$wp_customize->add_setting(
				'crux_c_' . $page . '_' . $key,
				array(
					'default'           => ( 'media' === $f[2] ) ? 0 : $f[3],
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'crux_sanitize_content',
					'transport'         => 'refresh',
				)
			);
		}
	}
}
add_action( 'customize_register', 'crux_customize_register_content', 20 );

/** Create the panel, sections and controls of ONE page (its settings must already exist). */
function crux_register_page_controls( $wp_customize, $page ) {
	$pages  = crux_content_pages();
	$fields = crux_content_fields( $page );
	if ( ! isset( $pages[ $page ] ) || ! $fields ) {
		return;
	}
	$wp_customize->add_panel(
		'crux_page_' . $page,
		array(
			'title'       => $pages[ $page ][0] . ' wording',
			'description' => __( 'The words and photos on this page. Change a field and the preview reloads. Layout and events are managed elsewhere.', 'cruxnxtion' ),
			'priority'    => 40,
		)
	);
	$sections = array();
	foreach ( $fields as $key => $f ) {
		$sid = 'crux_pg_' . $page . '_' . sanitize_key( $f[0] );
		if ( ! isset( $sections[ $sid ] ) ) {
			$sections[ $sid ] = true;
			$wp_customize->add_section( $sid, array( 'title' => $f[0], 'panel' => 'crux_page_' . $page, 'priority' => count( $sections ) ) );
		}
		if ( 'media' === $f[2] ) {
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					'crux_c_' . $page . '_' . $key,
					array( 'label' => $f[1], 'section' => $sid, 'mime_type' => 'image' )
				)
			);
			continue;
		}
		$wp_customize->add_control(
			'crux_c_' . $page . '_' . $key,
			array(
				'label'       => $f[1],
				'section'     => $sid,
				'type'        => ( 'text' === $f[2] ) ? 'text' : 'textarea',
				'description' => ( 'rich' === $f[2] ) ? __( 'Formatted text: bold, italic, line breaks and links are kept.', 'cruxnxtion' ) : '',
			)
		);
	}
}

/**
 * What the Customizer needs to add one page's panel, sections and controls on the fly: the same data WordPress itself
 * sends for registered ones, built on a throw-away manager.
 */
function crux_page_controls_payload( $page ) {
	require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
	$manager = new WP_Customize_Manager();
	crux_customize_register_content( $manager );
	crux_register_page_controls( $manager, $page );
	$payload = array( 'panels' => array(), 'sections' => array(), 'controls' => array() );
	foreach ( $manager->panels() as $panel ) {
		if ( 0 === strpos( $panel->id, 'crux_page_' ) ) {
			$payload['panels'][ $panel->id ] = $panel->json();
		}
	}
	foreach ( $manager->sections() as $section ) {
		if ( 0 === strpos( $section->id, 'crux_pg_' ) ) {
			$payload['sections'][ $section->id ] = $section->json();
		}
	}
	foreach ( $manager->controls() as $control ) {
		if ( 0 === strpos( $control->id, 'crux_c_' ) ) {
			$payload['controls'][ $control->id ] = $control->json();
		}
	}
	return $payload;
}

function crux_ajax_page_controls() {
	check_ajax_referer( 'crux_page_controls', 'nonce' );
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_send_json_error( null, 403 );
	}
	$page = isset( $_POST['page'] ) ? sanitize_key( wp_unslash( $_POST['page'] ) ) : '';
	if ( ! isset( crux_content_pages()[ $page ] ) ) {
		wp_send_json_error( null, 400 );
	}
	wp_send_json_success( crux_page_controls_payload( $page ) );
}
add_action( 'wp_ajax_crux_page_controls', 'crux_ajax_page_controls' );

/** Which page's wording belongs to an address in the preview: path => page key. */
function crux_page_url_map() {
	$map = array();
	foreach ( crux_content_pages() as $page => $info ) {
		$map[ ( 'front' === $info[1] ) ? '/' : '/' . $info[1] . '/' ] = $page;
	}
	return $map;
}

function crux_customizer_scripts() {
	wp_enqueue_script( 'crux-customizer-pages', get_template_directory_uri() . '/assets/js/customizer-pages.js', array( 'customize-controls' ), CRUX_THEME_VERSION, true );
	wp_localize_script(
		'crux-customizer-pages',
		'cruxPages',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'crux_page_controls' ),
			'map'     => crux_page_url_map(),
			'home'    => home_url( '/' ),
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'crux_customizer_scripts' );
