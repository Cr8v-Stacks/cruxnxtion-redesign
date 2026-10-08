<?php
/**
 * Custom Post Type: Gallery Item
 * Taxonomy: Gallery Category
 *
 * @package Cr8v_Events_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Gallery Item CPT and Taxonomies
 */
if ( ! function_exists( 'cr8v_register_gallery_cpt' ) ) {
	function cr8v_register_gallery_cpt() {

		// 1. Labels for Gallery Item CPT
		$labels = array(
			'name'                  => _x( 'Documentary Gallery', 'Post Type General Name', 'cr8v-events-core' ),
			'singular_name'         => _x( 'Documentary Photograph', 'Post Type Singular Name', 'cr8v-events-core' ),
			'menu_name'             => __( 'Gallery', 'cr8v-events-core' ),
			'name_admin_bar'        => __( 'Gallery Photograph', 'cr8v-events-core' ),
			'archives'              => __( 'Gallery Archives', 'cr8v-events-core' ),
			'attributes'            => __( 'Gallery Attributes', 'cr8v-events-core' ),
			'all_items'             => __( 'All Gallery Photographs', 'cr8v-events-core' ),
			'add_new_item'          => __( 'Add New Gallery Photograph', 'cr8v-events-core' ),
			'add_new'               => __( 'Add New Photograph', 'cr8v-events-core' ),
			'new_item'              => __( 'New Gallery Photograph', 'cr8v-events-core' ),
			'edit_item'             => __( 'Edit Gallery Photograph', 'cr8v-events-core' ),
			'update_item'           => __( 'Update Gallery Photograph', 'cr8v-events-core' ),
			'view_item'             => __( 'View Gallery Photograph', 'cr8v-events-core' ),
			'view_items'            => __( 'View Gallery Photographs', 'cr8v-events-core' ),
			'search_items'          => __( 'Search Gallery Photographs', 'cr8v-events-core' ),
			'not_found'             => __( 'No gallery photographs found', 'cr8v-events-core' ),
			'not_found_in_trash'    => __( 'No gallery photographs found in Trash', 'cr8v-events-core' ),
			'featured_image'        => __( 'Documentary Photograph', 'cr8v-events-core' ),
			'set_featured_image'    => __( 'Set documentary photograph', 'cr8v-events-core' ),
			'remove_featured_image' => __( 'Remove documentary photograph', 'cr8v-events-core' ),
			'use_featured_image'    => __( 'Use as documentary photograph', 'cr8v-events-core' ),
		);

		$args = array(
			'label'                 => __( 'Gallery Item', 'cr8v-events-core' ),
			'description'           => __( 'Live production photography and architecture showcase.', 'cr8v-events-core' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail' ), // Clean title and featured image support
			'taxonomies'            => array( 'gallery_category' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-format-gallery',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => false, // Disables Gutenberg block editor in favor of dedicated Studio layout
			'rewrite'               => array( 'slug' => 'gallery-item', 'with_front' => false ),
		);

		register_post_type( 'gallery_item', $args );

		// 2. Taxonomy: Gallery Category
		$tax_labels = array(
			'name'                       => _x( 'Gallery Categories', 'Taxonomy General Name', 'cr8v-events-core' ),
			'singular_name'              => _x( 'Gallery Category', 'Taxonomy Singular Name', 'cr8v-events-core' ),
			'menu_name'                  => __( 'Categories', 'cr8v-events-core' ),
			'all_items'                  => __( 'All Categories', 'cr8v-events-core' ),
			'parent_item'                => __( 'Parent Category', 'cr8v-events-core' ),
			'parent_item_colon'          => __( 'Parent Category:', 'cr8v-events-core' ),
			'new_item_name'              => __( 'New Category Name', 'cr8v-events-core' ),
			'add_new_item'               => __( 'Add New Category', 'cr8v-events-core' ),
			'edit_item'                  => __( 'Edit Category', 'cr8v-events-core' ),
			'update_item'                => __( 'Update Category', 'cr8v-events-core' ),
			'view_item'                  => __( 'View Category', 'cr8v-events-core' ),
			'search_items'               => __( 'Search Categories', 'cr8v-events-core' ),
			'not_found'                  => __( 'Not Found', 'cr8v-events-core' ),
			'no_terms'                   => __( 'No categories', 'cr8v-events-core' ),
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
			'rewrite'                    => array( 'slug' => 'gallery-category', 'with_front' => false ),
		);

		register_taxonomy( 'gallery_category', array( 'gallery_item' ), $tax_args );
	}
	add_action( 'init', 'cr8v_register_gallery_cpt', 0 );
}

/**
 * Explicitly disable Gutenberg Block Editor for Gallery Items (High Priority)
 */
if ( ! function_exists( 'cr8v_disable_gutenberg_for_gallery' ) ) {
	function cr8v_disable_gutenberg_for_gallery( $use_block_editor, $post_type ) {
		if ( $post_type === 'gallery_item' ) {
			return false;
		}
		return $use_block_editor;
	}
	add_filter( 'use_block_editor_for_post_type', 'cr8v_disable_gutenberg_for_gallery', 999, 2 );

	function cr8v_disable_gutenberg_for_gallery_posts( $use_block_editor, $post ) {
		if ( is_object( $post ) && isset( $post->post_type ) && $post->post_type === 'gallery_item' ) {
			return false;
		}
		return $use_block_editor;
	}
	add_filter( 'use_block_editor_for_post', 'cr8v_disable_gutenberg_for_gallery_posts', 999, 2 );
}
