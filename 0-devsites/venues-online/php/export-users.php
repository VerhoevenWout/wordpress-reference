<?php

require_once('lib/PHPExcel.php');
// add_action( 'init', 'loop_users' );

function loop_users(){
	$args = array(
		// 'number' => 500,
		// 'offset' => 100,
	);
	$users = get_users($args);
	$data = [];
	foreach ($users as $key => $value) {
		$user_display_name 	= $value->data->display_name;
		$user_id 			= $value->data->ID;
		$export_data 		= loop_venues_per_user($user_id, $user_display_name);
		write_to_excel_users($export_data);
	}
}

function loop_venues_per_user($user_id, $user_display_name){
	$venue_results = get_venue_results($user_id);
	$results_array = [];
	if ($venue_results) {
		foreach ($venue_results as $key => $value) {
			$nl_post_id 	= icl_object_id($value->post_id, 'post', FALSE,'nl');
			$nl_post_url 	= get_permalink($nl_post_id);
			$nl_post_obj 	= get_post($nl_post_id);

			$fr_post_id 	= icl_object_id($value->post_id, 'post', FALSE,'fr');
			$fr_post_url 	= get_permalink($fr_post_id);
			$fr_post_obj 	= get_post($fr_post_id);

			$en_post_id 	= icl_object_id($value->post_id, 'post', FALSE,'en');
			$en_post_url 	= get_permalink($en_post_id);
			$en_post_obj 	= get_post($en_post_id);

			if ($nl_post_obj->post_status == 'publish'){
				// GET NL SEO FOR THIS VENUE
				if ($nl_post_id) {
					$nl_seo_results = get_seo_results($nl_post_id);
				    if ($nl_seo_results) {
				    	$temp_nl_seo_arr = [];
				    	foreach ($nl_seo_results as $seo_key => $seo_value) {
				    		$seo_id 	= $seo_value->ID;
				    		$seo_title 	= $seo_value->post_title;
				    		$nl_seo_id	 	= icl_object_id($seo_id, 'post', FALSE,'nl');
							$nl_seo_obj 	= get_post($en_post_id);
				    		$nl_seo_url	 	= get_permalink($nl_seo_id);
			    			array_push($temp_nl_seo_arr, $nl_seo_url);
				    	}
				    }
				}
	    		// GET FR SEO FOR THIS VENUE
				if ($fr_post_id) {
	    			$fr_seo_results = get_seo_results($fr_post_id);
		    	    if ($fr_seo_results) {
		    	    	$temp_fr_seo_arr = [];
		    	    	foreach ($fr_seo_results as $seo_key => $seo_value) {
		    	    		$seo_id 	= $seo_value->ID;
		    	    		$seo_title 	= $seo_value->post_title;
		    	    		$fr_seo_id	 	= icl_object_id($seo_id, 'post', FALSE,'fr');
		    				$fr_seo_obj 	= get_post($fr_post_id);
		    	    		$fr_seo_url	 	= get_permalink($fr_seo_id);
		        			array_push($temp_fr_seo_arr, $fr_seo_url);
		    	    	}
		    	    }
	    	    }
	    		// GET EN SEO FOR THIS VENUE
				if ($en_post_id) {
		    		$en_seo_results = get_seo_results($en_post_id);
		    	    if ($en_seo_results) {
		    	    	$temp_en_seo_arr = [];
		    	    	foreach ($en_seo_results as $seo_key => $seo_value) {
		    	    		$seo_id 	= $seo_value->ID;
		    	    		$seo_title 	= $seo_value->post_title;
		    	    		$en_seo_id	 	= icl_object_id($seo_id, 'post', FALSE,'en');
		    				$en_seo_obj 	= get_post($en_post_id);
		    	    		$en_seo_url	 	= get_permalink($en_seo_id);
		        			array_push($temp_en_seo_arr, $en_seo_url);
		    	    	}
		    	    }
	    	    }

				$result = [
					'user_display_name' 		=> $user_display_name,
					'post_name' 				=> $nl_post_obj->post_name,
					'nl_post_url' 				=> $nl_post_url,
					'fr_post_url' 				=> $fr_post_url,
					'en_post_url' 				=> $en_post_url,
					'nl_seo_url_of_this_venue'	=> $temp_nl_seo_arr,
					'fr_seo_url_of_this_venue'	=> $temp_fr_seo_arr,
					'en_seo_url_of_this_venue'	=> $temp_en_seo_arr,
				];
				array_push($results_array, $result);
			}
		}
	} else{
		$result = [
			'user_display_name' => $user_display_name, 
		];
		array_push($results_array, $result);
	}
	// echo '<pre style="background: white; z-index: 99999999; position: relative">';
	// var_dump($results_array);
	// echo '</pre>';
    return $results_array;
}
function write_to_excel_users($export_data){
	$user_display_name 	= $export_data[0]['user_display_name'];

	$user_display_name 	= str_replace(' ', '_', $user_display_name);
	$export_name 		= 'xls_export_'.$user_display_name.'.xls';
	$upload_dir 		= wp_upload_dir()['basedir'].'/xls_exports/'.$export_name;

	$excel 		= [];
	$excel[] 	= [
		'Venue', 
		'URL',
	];
	// REMOVE DUPLICATES
	$export_data = array_map('unserialize', array_unique(array_map('serialize', $export_data)));
	foreach ($export_data as $key => $venue) {
		$post_title 				= $venue['post_name'];
		$nl_post_url 				= $venue['nl_post_url'];
		$fr_post_url 				= $venue['fr_post_url'];
		$en_post_url 				= $venue['en_post_url'];
		$nl_seo_url_of_this_venue 	= $venue['nl_seo_url_of_this_venue'];
		$fr_seo_url_of_this_venue 	= $venue['fr_seo_url_of_this_venue'];
		$en_seo_url_of_this_venue 	= $venue['en_seo_url_of_this_venue'];

		$excel[] = [
			$post_title,
			str_replace('venues-online.loc','venues-online.com',$nl_post_url),
		];
		$excel[] = [
			$post_title,
			str_replace('venues-online.loc','venues-online.com',$fr_post_url),
		];
		$excel[] = [
			$post_title,
			str_replace('venues-online.loc','venues-online.com',$en_post_url),
		];

		if ($nl_seo_url_of_this_venue != null) {
			foreach ($nl_seo_url_of_this_venue as $key => $value) {
				$excel[] = [
					'', 
					str_replace('venues-online.loc','venues-online.com',$value),
				];
			}
		}
		if ($fr_seo_url_of_this_venue != null) {
			foreach ($fr_seo_url_of_this_venue as $key => $value) {
				$excel[] = [
					'', 
					str_replace('venues-online.loc','venues-online.com',$value),
				];
			}
		}
		if ($en_seo_url_of_this_venue != null) {
			foreach ($en_seo_url_of_this_venue as $key => $value) {
				$excel[] = [
					'', 
					str_replace('venues-online.loc','venues-online.com',$value),
				];
			}
		}
		$excel[] = [];
	}

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->fromArray($excel, null, 'A1');
	foreach(range('A','G') as $columnID) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save($upload_dir);
}

function get_venue_results($user_id){
    global $wpdb;
	$venue_sql = '
		SELECT DISTINCT pm.post_id, p.*, t.language_code 
		FROM wp_posts AS p 
		JOIN wp_icl_translations AS t on p.ID=t.element_id 
		JOIN wp_postmeta AS pm ON p.ID=pm.post_id 
		WHERE t.element_type = "post_venues" 
		AND pm.meta_value = '.$user_id.'
		ORDER BY p.post_title ASC, t.language_code DESC';
	$venue_results = $wpdb->get_results($venue_sql);
	return $venue_results;
}
function get_seo_results($post_id){
	error_log($post_id);
    global $wpdb;
	$seo_sql = '
		SELECT DISTINCT pm.post_id, p.*, t.language_code 
        FROM wp_posts AS p 
        JOIN wp_icl_translations AS t on p.ID=t.element_id 
        JOIN wp_postmeta AS pm ON p.ID=pm.meta_value 
        WHERE pm.meta_key = "_fiche_seopage" 
        AND pm.post_id = '.$post_id.'
        ORDER BY p.post_title ASC, t.language_code DESC';
    $seo_results = $wpdb->get_results($seo_sql);
	return $seo_results;
}
