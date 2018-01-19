<?php

add_action('init', 'customize_default_post_type');
function customize_default_post_type() {
    $labels = array(
        'name'               => _x( 'Posts', 'post type general name'),
        'singular_name'      => _x( 'Post', 'post type singular name'),
        'menu_name'          => _x( 'Posts', 'admin menu'),
        'name_admin_bar'     => _x( 'Posts', 'add post on admin bar'),
        'add_new'            => _x( 'Add New Post', 'post'),
        'add_new_item'       => __( 'New Post'),
        'new_item'           => __( 'New Post'),
        'edit_item'          => __( 'Edit Post'),
        'view_item'          => __( 'View Post'),
        'all_items'          => __( 'All Posts'),
        'search_items'       => __( 'Search Posts'),
        'parent_item_colon'  => __( 'Parent Posts:'),
        'not_found'          => __( 'No posts found.'),
        'not_found_in_trash' => __( 'No posts found in Trash.')
    );
    register_post_type( 'post', [
        'labels' => $labels,
        'public'  => true,
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => '<your custom slug>' ),  //<--- Custom slug goes here.
        'query_var' => false,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'post-formats' ),
    ] );
}

/** This bit prevents the post editor on the backend from being listed twice **/
add_action( 'admin_menu', 'customizeAdminMenu' );
function customizeAdminMenu(){
    remove_menu_page('edit.php');
}