<?php

	// --------------------------------------------------------------------
	// CUSTOM POST TYPE VENUES
	function cptui_register_my_cpts() {

		/**
		 * Post Type: Venues.
		 */

		$labels = array(
			"name" => __( "Venues", "" ),
			"singular_name" => __( "Venue", "" ),
		);

		$args = array(
			"label" => __( "Venues", "" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => false,
			"rest_base" => "",
			"has_archive" => false,
			"show_in_menu" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "venues", "with_front" => true ),
			"query_var" => true,
			"supports" => array( "title", "thumbnail" ),
		);

		register_post_type( "venues", $args );
	}

	add_action( 'init', 'cptui_register_my_cpts' );

	// ----------------------------------------------------------------------
	// CREATE POST TYPE SEO-PAGE
	function oxygen_post_types_init() {

		register_post_type( 'seopage',
			array(
				'labels' => array(
					'name'                => __( 'SEO pages' ),
					'singular_name'       => __( 'SEO page' ),
					'all_items'           => __( 'All SEO pages' ),
					'add_new_item'        => __( 'Add new SEO page' ),
					'add_new'             => __( 'Add SEO page' ),
					'new_item'            => __( 'New SEO page' ),
					'edit_item'           => __( 'Edit SEO page' ),
					'update_item'         => __( 'Update SEO page' ),
					'view_item'           => __( 'View SEO page' ),
					'search_items'        => __( 'Search SEO pages' ),
					),
				'supports' => array('title', 'editor', 'author', 'thumbnail', 'page-attributes'),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array(
					'slug' => 'vo',
				),
			)
		);
	}
	add_action( 'init', 'oxygen_post_types_init' );

	// --------------------------------------------------------------------
	// TAXONOMIES
	function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Faciliteiten.
	 */

	$labels = array(
		"name" => __( "Faciliteiten", "" ),
		"singular_name" => __( "Faciliteit", "" ),
	);

	$args = array(
		"label" => __( "Faciliteiten", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Faciliteiten",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'faciliteit', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "faciliteit", array( "venues" ), $args );

	/**
	 * Taxonomy: Liggingen.
	 */

	$labels = array(
		"name" => __( "Liggingen", "" ),
		"singular_name" => __( "Ligging", "" ),
	);

	$args = array(
		"label" => __( "Liggingen", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Liggingen",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'ligging', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "ligging", array( "venues" ), $args );

	/**
	 * Taxonomy: Activiteiten.
	 */

	$labels = array(
		"name" => __( "Activiteiten", "" ),
		"singular_name" => __( "Activiteit", "" ),
	);

	$args = array(
		"label" => __( "Activiteiten", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Activiteiten",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'activiteit', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "activiteit", array( "venues" ), $args );

	/**
	 * Taxonomy: Types Locatie.
	 */

	$labels = array(
		"name" => __( "Types Locatie", "" ),
		"singular_name" => __( "Type Locatie", "" ),
	);

	$args = array(
		"label" => __( "Types Locatie", "" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Types Locatie",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'type_locatie', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "type_locatie", array( "venues" ), $args );
}

add_action( 'init', 'cptui_register_my_taxes' );

