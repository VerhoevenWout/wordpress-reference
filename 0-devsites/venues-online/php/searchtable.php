<?php
// IMPORT VENUES
// add_action( 'init', 'loopvenues' );

function loopvenues(){
	$venues = get_posts([
		'posts_per_page' => 250, 
		'offset' => 500,
		'post_type' => 'venues',
		'suppress_filters' => 0
	]); 

	foreach ($venues as $key => $venue) {
		$post_id = $venue->ID;
		$data = [];
		$json = loop_json($post_id, $post_id);
		
		$data['json_nl'] = json_encode($json);

		$fr_id = icl_object_id($post_id,'post',false,'fr');
		if ($fr_id == null){
			$json_fr = null;
		} else{
			$json_fr = loop_json($fr_id, $post_id);
		}
		$data['json_fr'] = json_encode($json_fr);
		$data['id_fr'] = $fr_id;

		$en_id = icl_object_id($post_id,'post',false,'en');
		if ($en_id == null){
			$json_fr = null;
		} else{
			$json_en = loop_json($en_id, $post_id);
		}
		$data['json_en'] = json_encode($json_en);
		$data['id_en'] = $en_id;

		$data['id'] = $post_id;
		$data['id_nl'] = $post_id;
		$data['persons_min'] = get_field('venue_number_of_persons_min', $post_id);
		$data['persons_max'] = get_field('venue_number_of_persons_max', $post_id);
		$data['halls'] = get_field('venue_number_of_halls', $post_id);

		$post = get_post($post_id); 
	    $post_slug = $post->post_name;
		$data['linkurl'] = '/venues/' . $post_slug;

		$address = get_field('venue_address', $post_id);
		$data['lat'] = $address['lat'];
		$data['lng'] = $address['lng'];

		error_log($post_id);
		error_log($address['lng']);

		if (get_post_status($post_id) == 'publish') {
			$data['active'] = 1;
		} else{
			$data['active'] = 0;
		}

		global $wpdb;
		$wpdb->replace('wp_searchtable', $data);
	}
}

function loop_json( $post_id, $parent_post_id ){
	$json = [];

	$json['title'] = get_the_title($post_id);
	$json['short_title'] = get_field('venue_short_name', $post_id);
	
	$address = get_field('venue_address', $post_id);
	$json['lat'] = $address['lat'];
	$json['lng'] = $address['lng'];

	$json['activities'] = get_field('venue_activities', $post_id);
	$json['type_location'] = get_field('venue_type_location', $post_id);
	$json['facilities'] = get_field('venue_facilities', $post_id);
	$json['location'] = get_field('venue_location', $post_id);

	$json['persons_min'] = get_field('venue_number_of_persons_min', $parent_post_id);
	$json['persons_max'] = get_field('venue_number_of_persons_max', $parent_post_id);
	$json['halls'] = get_field('venue_number_of_halls', $parent_post_id);
	$json['keywords'] = get_field('venue_keywords', $parent_post_id);
	
	$json['description'] = get_field('venue_description',$post_id);
	$json['detailed_description'] = get_field('venue_detailed_description', $post_id);
	$json['capacity_table'] = get_field('venue_capacity_table', $parent_post_id);
	$json['address'] = $address['address'];
	$json['zipcode'] = get_field('venue_zipcode', $parent_post_id);
	$json['city'] = get_field('venue_city', $parent_post_id);
	$json['phone'] = get_field('venue_phone', $parent_post_id);
	$json['fax'] = get_field('venue_fax', $parent_post_id);
	$json['external_link'] = get_field('venue_external_link', $parent_post_id);
	$json['email'] = get_field('venue_email', $parent_post_id);
	$json['social_media_link'] = get_field('venue_social_media_link', $parent_post_id);
	$json['external_link'] = get_field('venue_external_link', $parent_post_id);
	
	$json['created_at'] = get_the_date('Y-m-d', $post_id);
	$json['created_at_unix'] = get_the_date('U', $post_id);
	$json['modified_time'] = get_the_modified_time('Y-m-d', $post_id);
	$json['modified_time_unix'] = get_the_modified_time('U', $post_id);
	$json['recommended_bool'] = get_field('venue_recommended_bool', $parent_post_id);
	
	$post = get_post($post_id); 
    $post_slug = $post->post_name;
	$json['slug'] = $post_slug;
	$json['post_id'] = $post_id;
	$json['parent_post_id'] = $parent_post_id;
	$json['post_id_old'] = get_field('venue_id', $post_id);

	//loop through images to make array
	$imageArray = array();
	$imageThumbArray = array();
	
	$galleryArray = get_field('venue_gallery', $parent_post_id);
	foreach ($galleryArray as $galleryItem) {
		array_push($imageArray, $galleryItem['url']);

		if ($galleryItem['sizes']['large']) {
			array_push($imageThumbArray, $galleryItem['sizes']['large']);
		} else{
			array_push($imageThumbArray, $galleryItem['url']);
		}
	}

	$json['imageArray'] = $imageArray;
	$json['imageThumbArray'] = $imageThumbArray;
	return $json;
}

function updatevenue($post_id){
	error_log('updatevenue');
	$main_id = icl_object_id($post_id,'post',false,'nl');
	if ($main_id == null){
		$main_id = $post_id;
	}
	$data = [];

	$address = get_field('venue_address', $main_id);
	if ($address == null){
		error_log('address field empty');
		return;
	}

	error_log('address field not empty');
	$data['lat'] = $address['lat'];
	$data['lng'] = $address['lng'];

	$json = loop_json($post_id, $post_id);

	$nl_id = $main_id;
	error_log('nl_id');
	error_log($nl_id);

	if ($nl_id == null){
		$json_nl = null;
	} else{
		$json_nl = loop_json($nl_id, $post_id);
	}
	$data['json_nl'] = json_encode($json_nl);
	$data['id_nl'] = $nl_id;

	$fr_id = icl_object_id($post_id,'post',false,'fr');
	if ($fr_id == null){
		$json_fr = null;
	} else{
		$json_fr = loop_json($fr_id, $post_id);
	}
	$data['json_fr'] = json_encode($json_fr);
	$data['id_fr'] = $fr_id;

	$en_id = icl_object_id($post_id,'post',false,'en');
	if ($en_id == null){
		$json_fr = null;
	} else{
		$json_en = loop_json($en_id, $post_id);
	}
	$data['json_en'] = json_encode($json_en);
	$data['id_en'] = $en_id;

	$data['id'] = $main_id;
	$data['id_nl'] = $main_id;
	$data['persons_min'] = get_field('venue_number_of_persons_min', $post_id);
	$data['persons_max'] = get_field('venue_number_of_persons_max', $post_id);
	$data['halls'] = get_field('venue_number_of_halls', $post_id);

	$post = get_post($post_id); 
    $post_slug = $post->post_name;
	$data['linkurl'] = '/venues/' . $post_slug;

	if (get_post_status($post_id) == 'publish') {
		$data['active'] = 1;
	} else{
		$data['active'] = 0;
	}

	if ($data['id_nl'] == null && $data['id_fr'] == null && $data['id_en'] == null) {
		return;
	}

	global $wpdb;
	$wpdb->replace('wp_searchtable', $data);
}


function deletevenue($post_id){
	$main_id = icl_object_id($post_id,'post',false,'nl');
	$data = [];

	$post_language_details = apply_filters( 'wpml_post_language_details', NULL, $post_id ) ;

	error_log($post_id);
	error_log(json_encode($post_language_details));
	$post_language_details = $post_language_details["language_code"];
	error_log(json_encode($post_language_details));

	global $wpdb;
   	if ($post_language_details === 'fr') {
   		error_log('french');

   		$sql = '
	   		UPDATE wp_searchtable
			SET json_fr = null, id_fr = null
			WHERE id = '.$main_id;

		error_log($sql);
		$wpdb->query($sql);
   	} elseif($post_language_details == 'en'){
   		error_log('english');

   		$sql = '
	   		UPDATE wp_searchtable
			SET json_en = null, id_en = null
			WHERE id = '.$main_id;

		error_log($sql);
		$wpdb->query($sql);

   	} else{
   		error_log('delete row');

   		$sql = '
   			DELETE FROM wp_searchtable
			WHERE id = '.$main_id;

		error_log($sql);
		$wpdb->query($sql);
   	}
}

add_action( 'save_post', 'updatevenue' );
add_action( 'before_delete_post', 'deletevenue' );



