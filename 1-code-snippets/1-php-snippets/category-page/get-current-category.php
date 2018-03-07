<?php
	
	// Get category from slug
	$current_category = get_category(get_query_var( 'cat' ));
	$current_category_name = $current_category->name;
	$current_category_id = $current_category->cat_ID;

	// WP_Query
	$loop = new WP_Query( array('post_type' => 'nieuws', 'cat' => $current_category_id, 'post_status' => 'publish', 'posts_per_page'=> '10', 'order' => 'desc', 'orderby' => 'date'));
	if( $loop->have_posts() ):
        $i = 1; 
        while( $loop->have_posts() ): $loop->the_post(); global $post;

	    $i++; 
		endwhile;
	    wp_reset_postdata();
	endif;

	// For loop
	$args = array('post_type' => 'nieuws', 'category-type' => $current_category_name, 'post_status' => 'publish', 'posts_per_page'=> '10', 'order' => 'desc', 'orderby' => 'date');
	$args = array(
		'post_type' => 'nieuws',
		'category' => 2,
		// 'category' => 2,
	);
	$posts = get_posts($args);
	echo '<pre>';
	var_dump($posts);
	echo '</pre>';
