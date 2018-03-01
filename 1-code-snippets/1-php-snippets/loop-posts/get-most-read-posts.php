<!-- 

	NOTE: WILL NOT WORK WITH CACHING PLUGIN
	http://www.wpbeginner.com/wp-tutorials/how-to-track-popular-posts-by-views-in-wordpress-without-a-plugin/

-->

<!-- functions.php -->
<?php

// SET POSTVIEWS FOR MOST READ NEWS ARTICLES
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
?>

<!-- single.php -->
<?php
    wpb_set_post_views(get_the_ID());
?>

<!-- get most read posts -->
<?php
$popularpost = new WP_Query( array('post_type' => 'nieuws', 'posts_per_page' => 3, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC') );
while ( $popularpost->have_posts() ) : $popularpost->the_post();
    the_title();
endwhile;
wp_reset_postdata();
?>