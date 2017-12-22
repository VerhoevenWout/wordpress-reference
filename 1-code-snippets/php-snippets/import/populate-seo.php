<?php 


// SPLIT LINKEDPAGES
// GET TITLE FOR EACH LINKED PAGE
// GET TITLE OF EACH VENUE

// $selectpages = '
// 	SELECT * FROM Pages
// 	WHERE Language = '.$lang.' 
// 	LIMIT 10 OFFSET '.$offsetvalue.'
// ';
// $allPages = $wpdb->get_results( $selectpages );

// $selectVenues = '
// 	SELECT Title, LinkedPages FROM '.$venuesTable.'
// 	LIMIT 10 OFFSET '.$offsetvalue.'
// ';
// $venues = $wpdb->get_results( $selectVenues );

// $venuescount = count($allVenues);
// for ($i=0; $i < $venuescount; $i++) { 
// 	foreach($venues as $key => $venue){
// 		getData($venue);
// 	}
// 	if ($i > 0 && $i % 10 == 0) {
// 		// $offsetvalue = $offsetvalue + 10;
// 	    // sleep(1);
// 	}
// }


$lang = '"en"';
$venuesTable = 'venuesEN';

// getVenueCount($lang, $venuesTable);
function getVenueCount($lang, $venuesTable){
	$offsetvalue = 0;
	global $wpdb;
	$allVenues = '
		SELECT Title, LinkedPages FROM '.$venuesTable;
	$allVenues = $wpdb->get_results( $allVenues );

	foreach($allVenues as $key => $venue){
		getData($venue);
	}

	// error_log($venues);
	echo '<pre>';
	var_dump(count($allVenues));
	var_dump('DONE IMPORTING');
	echo '</pre>';
	die();
}


function getData($venue){
	$venueAndSeoTitle = array();
	$venueAndSeoLink = array();

	global $wpdb;

	// split cell into rows
	$page_array = explode( ', ', $venue->LinkedPages);

	foreach ($page_array as $key => $pageid) {
		$getPageName = '
			SELECT Title FROM Pages p WHERE p.Id = '.$pageid.'
		';
		$pagenameresult = $wpdb->get_results( $getPageName );

		$venueTitle = get_object_vars($venue)['Title'];
		$seoTitle = get_object_vars($pagenameresult[0])['Title'];
		// $temparr = [$venueTitle, $seoTitle];
		$temparr = [$venueTitle, html_entity_decode($seoTitle, ENT_QUOTES, "utf-8")];
		
		array_push($venueAndSeoTitle, $temparr);
	}

	// Get id venue and seo
	foreach($venueAndSeoTitle as $key => $title){
		$venueTitle = $title[0];
		$seoTitle = $title[1];

// PROBLEM: database contains: Séminaire Hôtels Anvers, sql query contains SÃ©minaire HÃ´tels Anvers

		$getVenueId = '
			SELECT Id FROM wp_posts p WHERE p.post_title = '.json_encode($venueTitle).'
		';
		$venueId = $wpdb->get_results( $getVenueId );
		$venueId = get_object_vars($venueId[0])['Id'];



		// $seoTitle = "Séminaire Hôtels Anvers";
		// $seoTitle = json_encode($seoTitle);
		// $seoTitle = utf8_encode($seoTitle);
		echo '<pre>';
		var_dump($seoTitle);var_dump($seoId);
		echo '</pre>';

		$getSeoId = '
			SELECT Id FROM wp_posts p WHERE p.post_title = '.json_encode($seoTitle).'
		';
		error_log($getSeoId);
		$seoId = $wpdb->get_results( $getSeoId );
		$seoId = get_object_vars($seoId[0])['Id'];



		if ($seoId) {
			$sql = 'INSERT INTO `wp_postmeta`
				(`post_id`,`meta_key`,`meta_value`) 
				values ('.$venueId.', "_fiche_seopage", '.$seoId.')
			';
			$insertVenueToSeo = $wpdb->query($sql);
			error_log($insertVenueToSeo);
		}

	}
}















