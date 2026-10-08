<?php
/**
 * Custom Post Type: Event
 * Taxonomy: Event Category
 *
 * @package Cr8v_Events_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Event CPT and Taxonomies
 */
if ( ! function_exists( 'cr8v_register_events_cpt' ) ) {
	function cr8v_register_events_cpt() {

		// 1. Labels for Event CPT
		$labels = array(
			'name'                  => _x( 'Events', 'Post Type General Name', 'cr8v-events-core' ),
			'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'cr8v-events-core' ),
			'menu_name'             => __( 'Events', 'cr8v-events-core' ),
			'name_admin_bar'        => __( 'Event', 'cr8v-events-core' ),
			'archives'              => __( 'Event Archives', 'cr8v-events-core' ),
			'attributes'            => __( 'Event Attributes', 'cr8v-events-core' ),
			'parent_item_colon'     => __( 'Parent Event:', 'cr8v-events-core' ),
			'all_items'             => __( 'All Events', 'cr8v-events-core' ),
			'add_new_item'          => __( 'Add New Event', 'cr8v-events-core' ),
			'add_new'               => __( 'Add New Event', 'cr8v-events-core' ),
			'new_item'              => __( 'New Event', 'cr8v-events-core' ),
			'edit_item'             => __( 'Edit Event', 'cr8v-events-core' ),
			'update_item'           => __( 'Update Event', 'cr8v-events-core' ),
			'view_item'             => __( 'View Event', 'cr8v-events-core' ),
			'view_items'            => __( 'View Events', 'cr8v-events-core' ),
			'search_items'          => __( 'Search Events', 'cr8v-events-core' ),
			'not_found'             => __( 'No events found in archive', 'cr8v-events-core' ),
			'not_found_in_trash'    => __( 'No events found in Trash', 'cr8v-events-core' ),
			'featured_image'        => __( 'Event Poster Artwork', 'cr8v-events-core' ),
			'set_featured_image'    => __( 'Set poster artwork', 'cr8v-events-core' ),
			'remove_featured_image' => __( 'Remove poster artwork', 'cr8v-events-core' ),
			'use_featured_image'    => __( 'Use as poster artwork', 'cr8v-events-core' ),
		);

		$args = array(
			'label'                 => __( 'Event', 'cr8v-events-core' ),
			'description'           => __( 'Live events, site-specific theatre, and cultural festivals.', 'cr8v-events-core' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
			'taxonomies'            => array( 'event_category' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-calendar-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'events',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => false, // Disables Gutenberg block editor in favor of dedicated Studio layout
			'rewrite'               => array( 'slug' => 'events', 'with_front' => false ),
		);

		// A site can adjust the post type (for example its address slug) without editing this plugin.
		$args = apply_filters( 'cr8v_events_event_cpt_args', $args );
		register_post_type( 'event', $args );

		// 2. Taxonomy: Event Category
		$tax_labels = array(
			'name'                       => _x( 'Event Categories', 'Taxonomy General Name', 'cr8v-events-core' ),
			'singular_name'              => _x( 'Event Category', 'Taxonomy Singular Name', 'cr8v-events-core' ),
			'menu_name'                  => __( 'Categories', 'cr8v-events-core' ),
			'all_items'                  => __( 'All Categories', 'cr8v-events-core' ),
			'parent_item'                => __( 'Parent Category', 'cr8v-events-core' ),
			'parent_item_colon'          => __( 'Parent Category:', 'cr8v-events-core' ),
			'new_item_name'              => __( 'New Category Name', 'cr8v-events-core' ),
			'add_new_item'               => __( 'Add New Category', 'cr8v-events-core' ),
			'edit_item'                  => __( 'Edit Category', 'cr8v-events-core' ),
			'update_item'                => __( 'Update Category', 'cr8v-events-core' ),
			'view_item'                  => __( 'View Category', 'cr8v-events-core' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'cr8v-events-core' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'cr8v-events-core' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'cr8v-events-core' ),
			'popular_items'              => __( 'Popular Categories', 'cr8v-events-core' ),
			'search_items'               => __( 'Search Categories', 'cr8v-events-core' ),
			'not_found'                  => __( 'Not Found', 'cr8v-events-core' ),
			'no_terms'                   => __( 'No categories', 'cr8v-events-core' ),
			'items_list'                 => __( 'Categories list', 'cr8v-events-core' ),
			'items_list_navigation'      => __( 'Categories list navigation', 'cr8v-events-core' ),
		);

		$tax_args = array(
			'labels'                     => $tax_labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'show_in_rest'               => false,
			'rewrite'                    => array( 'slug' => 'event-category', 'with_front' => false ),
		);

		register_taxonomy( 'event_category', array( 'event' ), $tax_args );
	}
	add_action( 'init', 'cr8v_register_events_cpt', 0 );
}

/**
 * Explicitly disable Gutenberg Block Editor for Events (High Priority)
 */
if ( ! function_exists( 'cr8v_disable_gutenberg_for_events' ) ) {
	function cr8v_disable_gutenberg_for_events( $use_block_editor, $post_type ) {
		if ( $post_type === 'event' ) {
			return false;
		}
		return $use_block_editor;
	}
	add_filter( 'use_block_editor_for_post_type', 'cr8v_disable_gutenberg_for_events', 999, 2 );

	function cr8v_disable_gutenberg_for_event_posts( $use_block_editor, $post ) {
		if ( is_object( $post ) && isset( $post->post_type ) && $post->post_type === 'event' ) {
			return false;
		}
		return $use_block_editor;
	}
	add_filter( 'use_block_editor_for_post', 'cr8v_disable_gutenberg_for_event_posts', 999, 2 );
}

/**
 * Helpers shared by every Cr8v event site.
 */
if ( ! function_exists( 'cr8v_event_iso_date' ) ) {
	/**
	 * Returns a real calendar date as Y-m-d, or null for anything looser (a bare year, free text, an impossible date).
	 */
	function cr8v_event_iso_date( $value ) {
		$value = trim( (string) $value );
		if ( preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $value, $m ) && checkdate( (int) $m[2], (int) $m[3], (int) $m[1] ) ) {
			return $value;
		}
		return null;
	}
}

if ( ! function_exists( 'cr8v_event_badge_styles' ) ) {
	/**
	 * Ticket colours an event can choose. Sites that do not colour code their cards ignore the value.
	 */
	function cr8v_event_badge_styles() {
		return array(
			'blue'   => __( 'Blue', 'cr8v-events-core' ),
			'red'    => __( 'Red', 'cr8v-events-core' ),
			'purple' => __( 'Purple', 'cr8v-events-core' ),
		);
	}
}

/**
 * A site whose events are edited only in the Studio box can hide the default content editor and Excerpt box, so
 * there is one place to edit each thing: add_filter( 'cr8v_events_hide_default_editor', '__return_true' ).
 * Off by default; sites that still use the default editor are unchanged.
 */
if ( ! function_exists( 'cr8v_events_maybe_hide_default_editor' ) ) {
	function cr8v_events_maybe_hide_default_editor() {
		if ( post_type_exists( 'event' ) && apply_filters( 'cr8v_events_hide_default_editor', false ) ) {
			remove_post_type_support( 'event', 'editor' );
			remove_post_type_support( 'event', 'excerpt' );
		}
	}
	add_action( 'init', 'cr8v_events_maybe_hide_default_editor', 20 );
}
