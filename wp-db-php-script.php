<?php

function update_searchtable( $post_id ){
	
	$data = [];
	$json = [];

	//ID 
	$data['id'] = $post_id;

	//Title
	$json['title'] = get_the_title($post_id);
	
	//Get adres
	$adres = get_field('venue_address', $post_id);
	//format dat for lat long columns
	$data['lat'] = $adres['lat'];
	$data['lng'] = $adres['lng'];
	//format dat for json
	$json['lat'] = $adres['lat'];
	$json['lng'] = $adres['lng'];
	$json['address'] = $adres['address'];
	

	//Update table
	global $wpdb;
	$data['json'] = json_encode($json);
	$wpdb->replace('wp_searchtable', $data);
}

add_action( 'save_post', 'update_searchtable' );


function update_seo_link( $id ){

	$post = get_post($id);

	$query = '
		SELECT m.meta_value
		FROM wp_posts as p
		JOIN wp_postmeta as m ON p.ID =  m.post_id and m.meta_key= "_fiche_seopage"
		WHERE p.post_title = "'.$post->post_title.'" AND p.post_type = "fiche"
	';

	global $wpdb; 
    $result = $wpdb->get_results($query);

    foreach ($result as $key => $value) {
    	$sql = "insert into " . $wpdb->prefix . "postmeta(post_id, meta_key, meta_value) values(" . $post->ID . ", '_fiche_seopage', " . $value->meta_value . ")";
		$wpdb->query($sql);
    }
}

//add_action( 'init', 'loopvenues' );

function loopvenues(){
    
	$venues = get_posts([
		'posts_per_page' => 200, 
		'offset' => 500,
		'post_type' => 'venues',
		'suppress_filters' => false
	]); 

	foreach ($venues as $key => $venue) {
		update_seo_link($venue->ID);
	}

}