<?php 

function custom_post_type() {
    $labels = array(
        'name'               => _x( 'Nieuws', 'post type general name'),
        'singular_name'      => _x( 'Nieuws', 'post type singular name'),
        'menu_name'          => _x( 'Nieuws', 'admin menu'),
        'name_admin_bar'     => _x( 'Nieuws', 'add post on admin bar'),
        'add_new'            => _x( 'Add New Nieuws', 'post'),
        'add_new_item'       => __( 'New Nieuws'),
        'new_item'           => __( 'New Nieuws'),
        'edit_item'          => __( 'Edit Nieuws'),
        'view_item'          => __( 'View Nieuws'),
        'all_items'          => __( 'All Nieuws'),
        'search_items'       => __( 'Search Nieuws'),
        'parent_item_colon'  => __( 'Parent Nieuws:'),
        'not_found'          => __( 'No posts found.'),
        'not_found_in_trash' => __( 'No posts found in Trash.')
    );
     
    $args = array(
        'label'               => __( 'Nieuws'),
        'description'         => __( 'Nieuws'),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
     
    // Registering your Custom Post Type
    register_post_type( 'nieuws', $args );
 
}
add_action( 'init', 'custom_post_type', 0 );