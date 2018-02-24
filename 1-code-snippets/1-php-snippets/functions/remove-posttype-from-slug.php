<?php
// ----------------------------------------------------------------------
// REMOVE POSTTYPE FROM SLUG
// First, we will remove the slug from the permalink:
function na_remove_slug( $post_link, $post, $leavename ) {
    if ( 'venues' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    return $post_link;
}
add_filter( 'post_type_link', 'na_remove_slug', 10, 3 );
// Just removing the slug isn't enough. Right now, you'll get a 404 page because WordPress only expects posts and pages to behave this way. You'll also need to add the following:
function na_parse_request( $query ) {
    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'venues', 'page' ) );
    }
}
add_action( 'pre_get_posts', 'na_parse_request' );