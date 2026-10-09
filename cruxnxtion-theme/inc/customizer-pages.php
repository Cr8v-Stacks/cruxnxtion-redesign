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
					'default'           => ( 'media' === $f[2] ) ? 0 : ( 'styled' === $f[2] ? crux_rich_to_plain( $f[3] ) : $f[3] ),
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'crux_sanitize_content',
					'transport'         => isset( crux_live_fields()[ $page . '.' . $key ] ) ? 'postMessage' : 'refresh',
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
			'title'       => sprintf( __( 'This page: %s', 'cruxnxtion' ), $pages[ $page ][0] ),
			'description' => __( 'The words and photos of the page shown on the right. Open a section, or hover over the page and click a pencil to jump to the matching field. Layout and events are managed elsewhere.', 'cruxnxtion' ),
			'priority'    => 31,
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
					array(
						'label'       => $f[1],
						'section'     => $sid,
						'mime_type'   => 'image',
						'description' => '<span class="crux-orig-photo" style="display:block;margin-top:6px;"><em>' . esc_html__( 'Photo on the page now (the original until you choose another):', 'cruxnxtion' ) . '</em><img src="' . esc_url( crux_get_blob_url( $f[3] ) ) . '" alt="" style="display:block;max-width:100%;height:auto;margin-top:6px;border:1px solid #c3c4c7;border-radius:3px;"></span>',
					)
				)
			);
			continue;
		}
		$wp_customize->add_control(
			'crux_c_' . $page . '_' . $key,
			array(
				'label'       => $f[1],
				'section'     => $sid,
				'type'        => ( 'text' === $f[2] ) ? 'text' : ( 'url' === $f[2] ? 'url' : 'textarea' ),
				'input_attrs' => ( 'styled' === $f[2] ) ? array( 'rows' => 4 ) : array(),
				'description' => ( 'styled' === $f[2] ) ? __( 'Press Enter for a new line. Put {{double braces}} around words to give them the accent colour, **two stars** around bold words and _underscores_ around italic words.', 'cruxnxtion' ) : ( ( 'rich' === $f[2] ) ? __( 'Formatted text (HTML): bold, italic, line breaks and links are kept.', 'cruxnxtion' ) : ( 'url' === $f[2] ? __( 'Where the button goes: start with / for a page on this site (for example /contact/) or paste a full https:// address.', 'cruxnxtion' ) : '' ) ),
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

/** Pencils and instant text updates inside the preview. */
function crux_customizer_preview_scripts() {
	wp_enqueue_script( 'crux-customizer-preview', get_template_directory_uri() . '/assets/js/customizer-preview.js', array( 'customize-preview' ), CRUX_THEME_VERSION, true );
	wp_localize_script( 'crux-customizer-preview', 'cruxPreview', array( 'live' => array_keys( crux_live_fields() ) ) );
}
add_action(
	'customize_preview_init',
	function () {
		add_action( 'wp_enqueue_scripts', 'crux_customizer_preview_scripts' );
	}
);

/**
 * This theme has no widget areas, so the Customizer does not need its block-based widget editor. Turning it off stops
 * WordPress and WooCommerce from loading well over a hundred block-editor scripts and styles into the Customizer
 * (about half of everything it downloaded), which makes it open much faster and avoids plugin clashes with those scripts.
 */
add_filter( 'use_widgets_block_editor', '__return_false' );
