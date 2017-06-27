<?php
// https://developer.wordpress.org/resource/dashicons/#businessman
function create_posttype() {
	register_post_type( 'case-studies-1',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Case Studies' ),
				'singular_name' => __( 'Case Study' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'case-studies'),
			'menu_icon' => 'dashicons-format-status',
			'supports' => array( 'editor','title', 'thumbnail', ),
            'taxonomies' => array('post_tag'),
		)
	);
	register_post_type( 'case-studies-2',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Case Studies' ),
				'singular_name' => __( 'Case Study' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'case-studies'),
			'menu_icon' => 'dashicons-format-status',
			'supports' => array( 'editor','title', 'thumbnail', ),
						'taxonomies' => array('post_tag'),
		)
	);
}
add_action( 'init', 'create_posttype' );

// ======================================================================================
// OR ===================================================================================
// ======================================================================================

function projects_function() {
	$labels = array(
		'name'               => _x( 'Projects', 'post type general name' ),
		'singular_name'      => _x( 'Projects', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'item' ),
		'add_new_item'       => __( 'Add new Projects' ),
		'edit_item'          => __( 'Edit Projects' ),
		'new_item'           => __( 'New Projects' ),
		'all_items'          => __( 'All Projects' ),
		'view_item'          => __( 'View Projects' ),
		'search_items'       => __( 'Search Projects' ),
		'not_found'          => __( 'No Projects found' ),
		'not_found_in_trash' => __( 'No Projects found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Projects'
	);
	$args = array(
		'labels'        => $labels,
		'menu_position' => 23,
		'description'   => '',
		'public'        => true,
		'show_ui' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_in_nav_menus' => true,
		'supports'      => array( 'title', 'editor' ),
		'has_archive'   => true,
	);
	register_post_type( 'projects', $args );
}
add_action( 'init', 'projects_function' );
