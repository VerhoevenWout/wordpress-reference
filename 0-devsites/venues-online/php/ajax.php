<?php

function ajax_get_fiches_exclude() {
	$data = $_POST['data'];
	$meta_key = $_POST['meta_key'];
	$id = $_POST['id'];
	$lang = $_POST['lang'];

	if ($meta_key == "_fiche_user" && (!isset($user_id) || $user_id == 0)) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
	}

	$fiches = get_fiches_exclude($meta_key, $id, $data, $lang);
	wp_send_json( $fiches );

    die();
}
add_action( 'wp_ajax_ajax_get_fiches_exclude', 'ajax_get_fiches_exclude' );
add_action( 'wp_ajax_nopriv_ajax_get_fiches_exclude', 'ajax_get_fiches_exclude' );

function ajax_get_seopages_exclude_fiche() {
	$data = $_POST['data'];
	$id = $_POST['id'];
	$lang = $_POST['lang'];

	$seopages = get_seopages_exclude_fiche($data, $id, $lang);
	wp_send_json( $seopages );

	die();
}
add_action( 'wp_ajax_ajax_get_seopages_exclude_fiche', 'ajax_get_seopages_exclude_fiche' );
add_action( 'wp_ajax_nopriv_ajax_get_seopages_exclude_fiche', 'ajax_get_seopages_exclude_fiche' );

function ajax_handle_post_meta() {
	$crud = $_POST['crud'];
	$post_id = $_POST['post_id'];
	$meta_key = $_POST['meta_key'];
	$meta_value = $_POST['meta_value'];

	if ($meta_key == '_fiche_user' && (!isset($meta_value) || empty($meta_value))) {
		$current_user = wp_get_current_user();
		$meta_value = $current_user->ID;
	}

	if ($crud == 'create') {
		add_post_meta($post_id, $meta_key, $meta_value, 0);
	} else if ($crud == 'delete') {
		delete_post_meta($post_id, $meta_key, $meta_value);
	}

	die();
}
add_action( 'wp_ajax_ajax_handle_post_meta', 'ajax_handle_post_meta' );
add_action( 'wp_ajax_nopriv_ajax_handle_post_meta', 'ajax_handle_post_meta' );

function ajax_get_stats_by_day() {
	$post_id = $_POST['post_id'];
	$year = $_POST['year'];
	$month = $_POST['month'];

	if (isset($_POST["dayfrom"])&&is_numeric($_POST["dayfrom"])) { $param_dayfrom = $_POST["dayfrom"]; }
	if (isset($_POST["monthfrom"])&&is_numeric($_POST["monthfrom"])) { $param_monthfrom = $_POST["monthfrom"]; }
	if (isset($_POST["yearfrom"])&&is_numeric($_POST["yearfrom"])) { $param_yearfrom = $_POST["yearfrom"]; }
	if (isset($_POST["dayto"])&&is_numeric($_POST["dayto"])) { $param_dayto = $_POST["dayto"]; }
	if (isset($_POST["monthto"])&&is_numeric($_POST["monthto"])) { $param_monthto = $_POST["monthto"]; }
	if (isset($_POST["yearto"])&&is_numeric($_POST["yearto"])) { $param_yearto = $_POST["yearto"]; }

	wp_send_json(get_stats_by_day($post_id, $year, $month, $param_dayfrom, $param_monthfrom, $param_yearfrom, $param_dayto, $param_monthto, $param_yearto));
	
	die();
}
add_action( 'wp_ajax_ajax_get_stats_by_day', 'ajax_get_stats_by_day' );
add_action( 'wp_ajax_nopriv_ajax_get_stats_by_day', 'ajax_get_stats_by_day' );


function ajax_get_company_stats() {
	$post_id = $_POST['post_id'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];

	if (isset($_POST["dayfrom"])&&is_numeric($_POST["dayfrom"])) { $param_dayfrom = $_POST["dayfrom"]; }
	if (isset($_POST["monthfrom"])&&is_numeric($_POST["monthfrom"])) { $param_monthfrom = $_POST["monthfrom"]; }
	if (isset($_POST["yearfrom"])&&is_numeric($_POST["yearfrom"])) { $param_yearfrom = $_POST["yearfrom"]; }
	if (isset($_POST["dayto"])&&is_numeric($_POST["dayto"])) { $param_dayto = $_POST["dayto"]; }
	if (isset($_POST["monthto"])&&is_numeric($_POST["monthto"])) { $param_monthto = $_POST["monthto"]; }
	if (isset($_POST["yearto"])&&is_numeric($_POST["yearto"])) { $param_yearto = $_POST["yearto"]; }

	// stats-controller.php
	wp_send_json(get_company_stats($post_id, $year, $month, $day, $param_dayfrom, $param_monthfrom, $param_yearfrom, $param_dayto, $param_monthto, $param_yearto));

	die();
}
add_action( 'wp_ajax_ajax_get_company_stats', 'ajax_get_company_stats' );
add_action( 'wp_ajax_nopriv_ajax_get_company_stats', 'ajax_get_company_stats' );


function ajax_get_csv() {
	$mode = $_GET['mode'];

	$param_user = 0;
	$post_id = 0;
	$param_year = date("Y");
	$param_month = 0;
	$param_day = 0;

	if (isset($_GET["user"])&&is_numeric($_GET["user"])) { $param_user = $_GET["user"]; }
	if (isset($_GET["post_id"])) { $post_id = $_GET["post_id"]; }
	if (isset($_GET["year"])&&is_numeric($_GET["year"])) { $param_year = $_GET["year"]; }
	if (isset($_GET["month"])&&is_numeric($_GET["month"])) { $param_month = $_GET["month"]; }
	if (isset($_GET["day"])&&is_numeric($_GET["day"])) { $param_day = $_GET["day"]; }

	$param_dayfrom = 1;
	$param_monthfrom = 1;
	$param_yearfrom = date("Y");
	$param_dayto = 31;
	$param_monthto = 12;
	$param_yearto = date("Y");

	if (isset($_GET["dayfrom"])&&is_numeric($_GET["dayfrom"])) { $param_dayfrom = $_GET["dayfrom"]; }
	if (isset($_GET["monthfrom"])&&is_numeric($_GET["monthfrom"])) { $param_monthfrom = $_GET["monthfrom"]; }
	if (isset($_GET["yearfrom"])&&is_numeric($_GET["yearfrom"])) { $param_yearfrom = $_GET["yearfrom"]; }
	if (isset($_GET["dayto"])&&is_numeric($_GET["dayto"])) { $param_dayto = $_GET["dayto"]; }
	if (isset($_GET["monthto"])&&is_numeric($_GET["monthto"])) { $param_monthto = $_GET["monthto"]; }
	if (isset($_GET["yearto"])&&is_numeric($_GET["yearto"])) { $param_yearto = $_GET["yearto"]; }

	if($mode=="companies")
	{
		if (isset($_GET["yearto"])&&is_numeric($_GET["yearto"]))
		{
			$rows = get_company_stats($post_id, $param_year, $param_month, $param_day, $param_dayfrom, $param_monthfrom, $param_yearfrom, $param_dayto, $param_monthto, $param_yearto);
		}
		else
		{
			$rows = get_company_stats($post_id, $param_year, $param_month, $param_day);
		}
	}
	else
	{
		if($post_id==0)
		{
			if (isset($_GET["yearto"])&&is_numeric($_GET["yearto"]))
			{
				$rows = get_stats(null, $param_user, $param_dayfrom, $param_monthfrom, $param_yearfrom, $param_dayto, $param_monthto, $param_yearto);
			}
			else
			{
				$rows = get_stats($param_year, $param_user);
			}
		}
		else
		{
			if($param_month==0)
			{
				if (isset($_GET["dayfrom"])&&is_numeric($_GET["dayfrom"]))
				{
					$rows = get_stats_by_day($post_id, 0, 0, $param_dayfrom, $param_monthfrom, $param_yearfrom, $param_dayto, $param_monthto, $param_yearto);
				}
				else
				{
					$rows = get_stats_by_month($post_id, $param_yearfrom, $param_yearto);
				}
			}
			else
			{
				$rows = get_stats_by_day($post_id, $param_year, $param_month);
			}
		}
	}

	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=" . date("YmdHis") . ".csv");
	header("Pragma: no-cache");
	header("Expires: 0");

	if($rows)
	{
		$countrows = 0;
		foreach ($rows as $row) {
			if($countrows==0)
			{
				echo "\"" . implode('";"',array_keys(get_object_vars($row))) . "\"";
			}

			echo "\n\"" . implode('";"',array_values(get_object_vars($row))) . "\"";

			$countrows = $countrows + 1;
		}
	}

	die();
}
add_action( 'wp_ajax_ajax_get_csv', 'ajax_get_csv' );
add_action( 'wp_ajax_nopriv_ajax_get_csv', 'ajax_get_csv' );

// ----------------------------------------------------------------------------
// FICHES
function ajax_get_event_fiches() {

	$lang = $_POST['language'];
	$filterdata = json_decode(stripcslashes($_POST['filterdata']));
	$old_offset = $_POST['old_offset'];
	$offset = $_POST['offset'];

	// if offset is higer than old offset + 1

	if ($offset){
		$page_offset = $offset * 6;
		$pagination = 'LIMIT 24 OFFSET '.$page_offset.' ';
	} else{
		$pagination = 'LIMIT 24 ';
	}

	$sums = [];

	$idselector = 'id_'.$lang;
	if ($idselector != 'id_nl'){
		$idselector = 'id_'.$lang;
		$idselectorv2 = 'id_'.$lang.',';
		$idselectorv3 = 'st.id_'.$lang.',';
	} else{
		$idselector = 'id_'.$lang;
		$idselectorv2 = '';
		$idselectorv3 = '';
	}

	if($filterdata->taxs->activiteit == 'all'){
		unset($filterdata->taxs->activiteit);
	}else{
		$tmparr = [];
		$tmparr[] = $filterdata->taxs->activiteit;
		$filterdata->taxs->activiteit = $tmparr;
	}

	foreach ($filterdata->taxs as $key => $tax) {

		if($key == 'type_locatie'){
			$count = 0;
		}else{
			$count = count($tax)-1;
		}

		if(count($tax) > 0 && $tax != 'all'){
			$test = implode(', ', $tax);
			error_log(json_encode($test));
			$sums[] = 'SUM(tt.term_id in( '.implode(' , ', $tax).' )) > '.$count.' ';
		}
	}

	//Persons 
	$personquery = [
		'25' => 'AND persons_max <= 25',
		'50' => 'AND persons_min <= 50 AND persons_max <= 50',
		'100' => 'AND persons_min <= 100 AND persons_max <= 100',
		'250' => 'AND persons_min <= 250 AND persons_max <= 250',
		'500' => 'AND persons_min <= 500 AND persons_max <= 500',
		'500+' => 'AND persons_max >= 500',
		'all' => 'AND persons_max >= 1',
	];
	//Halls 
	$hallsquery = [
		'3' => 'AND halls <= 3',
		'5' => 'AND halls <= 5',
		'5+' => 'AND halls > 5',
		'all' => 'AND halls >= 1',
	];

	$sumsstring = '';
	if(count($sums) > 0){
		$sumsstring = ' GROUP BY '.$idselector.' HAVING '.implode(' AND ', $sums).' ';
	}else{
		$sumsstring = ' GROUP BY '.$idselector.' ';
	}

	$query = '
	SELECT '.$idselectorv2.' id_nl, json_nl, json_fr, json_en, persons_max, persons_min, halls, lat, lng, favourite, active, linkurl
		FROM (
		SELECT 	'.$idselectorv3.' st.id_nl,
		        st.json_nl, st.json_fr, st.json_en,
		        st.persons_max,
		        st.persons_min,
		        st.halls,
		        st.lat, st.lng,
		        st.favourite,
		        st.active,
		        st.linkurl,
		        p.radius,
		        p.distance_unit
		                 * DEGREES(ACOS(COS(RADIANS(p.latpoint))
		                 * COS(RADIANS(st.lat))
		                 * COS(RADIANS(p.longpoint - st.lng))
		                 + SIN(RADIANS(p.latpoint))
		                 * SIN(RADIANS(st.lat)))) AS distance
		FROM wp_searchtable AS st
		JOIN (   
		    SELECT  '.$filterdata->lat.'  AS latpoint,  '.$filterdata->lng.' AS longpoint,
		            '.$filterdata->radius.' AS radius,      111.045 AS distance_unit
		    ) AS p ON 1=1
		WHERE st.lat
		    BETWEEN p.latpoint  - (p.radius / p.distance_unit)
		    AND p.latpoint  + (p.radius / p.distance_unit)
		    AND st.lng
		    BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
		    AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
		) AS d
		JOIN wp_term_relationships tr ON '.$idselector.' = tr.object_id 
		JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id 
		LEFT JOIN wp_postmeta pm ON id_nl = pm.post_id AND pm.meta_key = "venue_recommended_bool"
		WHERE distance <= radius '.$personquery[$filterdata->persons].' '.$hallsquery[$filterdata->halls].' AND active = 1 
		'.$sumsstring.'
		ORDER BY 
		(pm.meta_value = 1 AND distance < 10) DESC,
		distance '.$pagination.'
	';

	global $wpdb; 
	error_log($query);
    $result = $wpdb->get_results($query);

	wp_send_json($result);

	die();
}
add_action( 'wp_ajax_get_event_fiches', 'ajax_get_event_fiches' );
add_action( 'wp_ajax_nopriv_get_event_fiches', 'ajax_get_event_fiches' );

function ajax_get_event_fiches_count() {

	$lang = $_POST['language'];
	$filterdata = json_decode(stripcslashes($_POST['filterdata']));

	error_log('message');
	error_log($_POST['filterdata']);

	$sums = [];

	$idselector = 'id_'.$lang;
	if ($idselector != 'id_nl'){
		$idselector = 'id_'.$lang;
		$idselectorv2 = 'id_'.$lang.',';
		$idselectorv3 = 'st.id_'.$lang.',';
	} else{
		$idselector = 'id_'.$lang;
		$idselectorv2 = '';
		$idselectorv3 = '';
	}

	if($filterdata->taxs->activiteit == 'all'){
		unset($filterdata->taxs->activiteit);
	}else{
		$tmparr = [];
		$tmparr[] = $filterdata->taxs->activiteit;
		$filterdata->taxs->activiteit = $tmparr;
	}

	foreach ($filterdata->taxs as $key => $tax) {

		if($key == 'type_locatie'){
			$count = 0;
		}else{
			$count = count($tax)-1;
		}

		if(count($tax) > 0 && $tax != 'all'){
			$test = implode(', ', $tax);
			error_log(json_encode($test));
			$sums[] = 'SUM(tt.term_id in( '.implode(' , ', $tax).' )) > '.$count.' ';
		}
	}

	//Persons 
	$personquery = [
		'25' => 'AND persons_max <= 25',
		'50' => 'AND persons_min <= 50 AND persons_max <= 50',
		'100' => 'AND persons_min <= 100 AND persons_max <= 100',
		'250' => 'AND persons_min <= 250 AND persons_max <= 250',
		'500' => 'AND persons_min <= 500 AND persons_max <= 500',
		'500+' => 'AND persons_max >= 500',
		'all' => 'AND persons_max >= 1',
	];
	//Halls 
	$hallsquery = [
		'3' => 'AND halls <= 3',
		'5' => 'AND halls <= 5',
		'5+' => 'AND halls > 5',
		'all' => 'AND halls >= 1',
	];

	$sumsstring = '';
	if(count($sums) > 0){
		$sumsstring = ' GROUP BY '.$idselector.' HAVING '.implode(' AND ', $sums).' ';
	}else{
		$sumsstring = ' GROUP BY '.$idselector.' ';
	}

	$query = '
	SELECT '.$idselectorv2.' id_nl, json_nl, json_fr, json_en, persons_max, persons_min, halls, lat, lng, favourite, active
		FROM (
		SELECT 	'.$idselectorv3.' st.id_nl,
		        st.json_nl, st.json_fr, st.json_en,
		        st.persons_max,
		        st.persons_min,
		        st.halls,
		        st.lat, st.lng,
		        st.favourite,
		        st.active,
		        p.radius,
		        p.distance_unit
		                 * DEGREES(ACOS(COS(RADIANS(p.latpoint))
		                 * COS(RADIANS(st.lat))
		                 * COS(RADIANS(p.longpoint - st.lng))
		                 + SIN(RADIANS(p.latpoint))
		                 * SIN(RADIANS(st.lat)))) AS distance
		FROM wp_searchtable AS st
		JOIN (   
		    SELECT  '.$filterdata->lat.'  AS latpoint,  '.$filterdata->lng.' AS longpoint,
		            '.$filterdata->radius.' AS radius,      111.045 AS distance_unit
		    ) AS p ON 1=1
		WHERE st.lat
		    BETWEEN p.latpoint  - (p.radius / p.distance_unit)
		    AND p.latpoint  + (p.radius / p.distance_unit)
		    AND st.lng
		    BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
		    AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
		) AS d
		JOIN wp_term_relationships tr ON '.$idselector.' = tr.object_id 
		JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id 
		LEFT JOIN wp_postmeta pm ON id_nl = pm.post_id AND pm.meta_key = "venue_recommended_bool"
		WHERE distance <= radius '.$personquery[$filterdata->persons].' '.$hallsquery[$filterdata->halls].' AND active = 1 
		'.$sumsstring.'
		ORDER BY 
		(pm.meta_value = 0 AND distance < 2),
		distance '.$pagination.'
	';

	global $wpdb;
	error_log($query);
    $result = $wpdb->get_results($query);
    $result = count($result);
    error_log($result);

	wp_send_json($result);

	die();
}
add_action( 'wp_ajax_get_event_fiches_count', 'ajax_get_event_fiches_count' );
add_action( 'wp_ajax_nopriv_get_event_fiches_count', 'ajax_get_event_fiches_count' );



function ajax_get_event_fiches_by_name() {
	$lang = $_POST['lang'];
	$search = $_POST['search'];

	if ($lang == null || $lang == undefined) {
		$lang = 'nl';
	}

	$sql = '
		SELECT ID, post_title FROM wp_posts 
		WHERE post_type = "venues" AND post_status = "publish" AND post_title LIKE "%'.$search.'%"';

	global $wpdb;
	$results = $wpdb->get_results($sql);

	$post_ids_arr = [];
	foreach ($results as $value) {
		array_push($post_ids_arr, $value->ID);
	}

	$sql = '
		SELECT * FROM wp_searchtable
		WHERE id_'.$lang.' IN ('.implode(',',$post_ids_arr).')';

	error_log($sql);
	global $wpdb;
	$result = $wpdb->get_results($sql);

	wp_send_json($result);
}
add_action( 'wp_ajax_get_event_fiches_by_name', 'ajax_get_event_fiches_by_name' );
add_action( 'wp_ajax_nopriv_get_event_fiches_by_name', 'ajax_get_event_fiches_by_name' );

function ajax_get_taxs() {

	$lang = $_POST['lang'];

	// Needed for changing ICL_LANGUAGE_CODE to correct language (doesn't happen since ajax)
	global $sitepress;
	$sitepress->switch_lang($lang);

	$taxs = json_decode(stripcslashes($_POST['taxs']));
	error_log($_POST['taxs']);

	$taxs = ["activiteit","faciliteit","ligging","type_locatie"];
	// $taxs = ["faciliteit","ligging","type_locatie"];

	foreach ($taxs as $key) {
	
		// $temparr = get_terms( $key, array('hide_empty' => false ) );
		$temparr = get_terms(
			$key,
			array(
				'taxonomy' => $key,
				'hide_empty' => false
			)
		);



		$taxs[$key] = [];	
		foreach ($temparr as $term) {
			$taxs[$key][$term->term_id] = $term;
			error_log('$term');
			error_log($term->name);
		}
	}
	error_log(json_encode($taxs));
	wp_send_json($taxs);
}
add_action( 'wp_ajax_get_taxs', 'ajax_get_taxs' );
add_action( 'wp_ajax_nopriv_get_taxs', 'ajax_get_taxs' );

function ajax_update_favourite(){

	$data = $_POST['id'];
	$addorremove = $_POST['addorremove'];

	if ($addorremove == 'add'){
		$sql = '
			UPDATE wp_searchtable
			SET favourite = favourite + 1
			WHERE id = '.$data;
	} elseif ($addorremove == 'remove'){
		// check if greater than 1
		$sql = '
			UPDATE wp_searchtable
			SET favourite = favourite - 1
			WHERE id = '.$data.' AND favourite >= 1';
	}

	error_log($sql);
	global $wpdb;
	$result = $wpdb->query($sql);

	wp_send_json($result);
}
add_action( 'wp_ajax_update_favourite', 'ajax_update_favourite' );
add_action( 'wp_ajax_nopriv_update_favourite', 'ajax_update_favourite' );

function ajax_get_seopages_by_fiche() {
    
	$post_id = $_POST['id'];
    $sql = '
        SELECT DISTINCT pm.post_id, p.*, t.language_code 
        FROM wp_posts AS p 
        JOIN wp_icl_translations AS t on p.ID=t.element_id 
        JOIN wp_postmeta AS pm ON p.ID=pm.meta_value 
        WHERE pm.meta_key = "_fiche_seopage" AND pm.post_id = '.$post_id;

    error_log($sql);
	global $wpdb;
	$result = $wpdb->get_results($sql);

	wp_send_json($result);
}
add_action( 'wp_ajax_get_seopages_by_fiche', 'ajax_get_seopages_by_fiche' );
add_action( 'wp_ajax_nopriv_get_seopages_by_fiche', 'ajax_get_seopages_by_fiche' );

function ajax_get_fiches_by_seopages() {
    
	$url = stripcslashes($_POST['url']);
   	$seo_page_id = url_to_postid($url);
	$lang = $_POST['language'];

   	$idselector = 'id_'.$lang;

    $sql = '
        SELECT DISTINCT pm.post_id, p.ID, p.post_title
		FROM wp_posts AS p 
		JOIN wp_icl_translations AS t on p.ID=t.element_id 
		JOIN wp_postmeta AS pm ON p.ID=pm.post_id 
		WHERE t.element_type = "post_venues" 
		AND pm.meta_value = '.$seo_page_id;

    error_log($sql);
	global $wpdb;
	$result = $wpdb->get_results($sql);

	$post_ids = [];
	foreach( $result as $key => $row) {
		// each column in your row will be accessible like this
		$post_id = $row->post_id;
		array_push($post_ids, $post_id);
	}

	$post_ids_string = implode(',', $post_ids);

	$sql = '
		SELECT DISTINCT '.$idselector.', json_nl, json_fr, json_en, persons_max, persons_min, halls, lat, lng, favourite
		FROM wp_searchtable 
		WHERE '.$idselector.' IN ('.$post_ids_string.')';

	error_log($sql);
    $result = $wpdb->get_results($sql);
	wp_send_json($result);
}
add_action( 'wp_ajax_get_fiches_by_seopages', 'ajax_get_fiches_by_seopages' );
add_action( 'wp_ajax_nopriv_get_fiches_by_seopages', 'ajax_get_fiches_by_seopages' );

function ajax_get_favourite_fiches(){

	$data = $_POST['favarray'];
	$sql = '
		SELECT DISTINCT id, json_nl, json_fr, json_en, persons_max, persons_min, halls, lat, lng, favourite
		FROM wp_searchtable 
		WHERE id IN ('.$data.')';

	error_log($sql);
	global $wpdb; 
    $result = $wpdb->get_results($sql);

	wp_send_json($result);
}
add_action( 'wp_ajax_get_favourite_fiches', 'ajax_get_favourite_fiches' );
add_action( 'wp_ajax_nopriv_get_favourite_fiches', 'ajax_get_favourite_fiches' );

function ajax_post_hash_data(){
	$hash = $_POST['hash'];
	$filterdata = json_encode(stripcslashes($_POST['filterdata']));
	$type = stripcslashes($_POST['type']);

	global $wpdb;

	$sqlcheck = "
	    SELECT url_params, type
	    FROM wp_url_hash_table 
	    WHERE hash LIKE '".$hash."'
	";
	error_log($sqlcheck);
    $result = $wpdb->get_results($sqlcheck);

    if ($result) {
    	wp_send_json($result);
    } else{
		$sqlinsert = "
		    INSERT INTO wp_url_hash_table (hash, url_params, type) 
			values ('".$hash."',".$filterdata.",".$type.")
		";
	    $result = $wpdb->query($sqlinsert);
		error_log($sqlinsert);
	}
}
add_action( 'wp_ajax_post_hash_data', 'ajax_post_hash_data' );
add_action( 'wp_ajax_nopriv_post_hash_data', 'ajax_post_hash_data' );

function ajax_logstats(){
	$post_id = $_POST['post_id'];
	$actionvalue = stripcslashes($_POST['actionvalue']);
	$site_id = $_POST['site_id'];
	$ipaddress = $_POST['ipaddress'];

	global $wpdb;

	$sqlinsert = "
	    INSERT INTO actions (post_id, action, ipaddress, site_id ) 
		values (".$post_id.",".$actionvalue.",'".$ipaddress."','".$site_id."')
	";
    $result = $wpdb->query($sqlinsert);
	error_log($sqlinsert);
}
add_action( 'wp_ajax_logstats', 'ajax_logstats' );
add_action( 'wp_ajax_nopriv_logstats', 'ajax_logstats' );

// ------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------
// NON AJAX CALLS
function get_fiche_data($id){
	global $wpdb;
	$sql = '
		SELECT * FROM wp_searchtable
		WHERE id = '.$id;

		error_log($sql);

	$result = $wpdb->get_results( $sql );

	$resultarray['favourite'] = $result[0]->favourite;
	$resultarray['json_nl'] = $result[0]->json_nl;
	$resultarray['json_fr'] = $result[0]->json_fr;
	$resultarray['json_en'] = $result[0]->json_en;

	return $resultarray;
}
function get_fiches_by_seopages($url) {

	$lang = ICL_LANGUAGE_CODE;
   	$seo_page_id = url_to_postid($url);
   	error_log('LANGUAGE: ' . $lang);

   	if ($lang === 'fr') {
	   	error_log('french');
   		$id_code = 'id_fr';

   	} elseif($lang == 'en'){
   		error_log('english');
   		$id_code = 'id_en';

   	} else{
   		error_log('dutch');
   		$id_code = 'id_nl';
   	}

    $sql = '
        SELECT DISTINCT pm.post_id, p.ID, p.post_title
		FROM wp_posts AS p 
		JOIN wp_icl_translations AS t on p.ID=t.element_id 
		JOIN wp_postmeta AS pm ON p.ID=pm.post_id 
		WHERE t.element_type = "post_venues" 
		AND pm.meta_value = '.$seo_page_id;

    error_log($sql);
	global $wpdb;
	$result = $wpdb->get_results($sql);

	$post_ids = [];
	foreach( $result as $key => $row) {
		// each column in your row will be accessible like this
		$post_id = $row->post_id;
		array_push($post_ids, $post_id);
	}

	$post_ids_string = implode(',', $post_ids);


	$sql = '
		SELECT DISTINCT id, json_nl, json_fr, json_en, persons_max, persons_min, halls, lat, lng, favourite
		FROM wp_searchtable 
		WHERE '.$id_code.' IN ('.$post_ids_string.')';

	error_log($sql);
    $result = $wpdb->get_results($sql);

	error_log(json_encode($result));

	return $result;
}