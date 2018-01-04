<?php 

$lang = '"fr"';
$venuesTable = 'venuesFR';

// getVenueCount($lang, $venuesTable);
function getVenueCount($lang, $venuesTable){
	$offsetvalue = 0;
	global $wpdb;
	$allVenues = '
		SELECT Title, LinkedPages FROM '.$venuesTable.'';
	$allVenues = $wpdb->get_results( $allVenues );

	foreach($allVenues as $key => $venue){
		getData($venue);
	}

	error_log($venues);
	echo '<pre>';
	var_dump(count($allVenues));
	echo 'DONE IMPORTING';
	echo '</pre>';
	die();
}


function getData($venue){
	$venueAndSeoTitle = array();
	$venueAndSeoLink = array();

	global $wpdb;

	// split cell into rows
	$page_array = explode( ', ', $venue->LinkedPages);

	// Get page names of seo pages where this venue is included
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
		
		// echo '<pre>';
		// var_dump($temparr);
		// echo '</pre>';
	}

	// Get id venue and seo
	foreach($venueAndSeoTitle as $key => $title){
		$venueTitle = $title[0];
		$seoTitle = $title[1];
// PROBLEM: database contains: Séminaire Hôtels Anvers, sql query contains SÃ©minaire HÃ´tels Anvers
// convert for instance à to &#224; -> convert to %
$venueTitleSplit = str_split($venueTitle);
echo '<pre>';
var_dump($seoTitle);
echo '</pre>';


		$getVenueId = '
			SELECT Id FROM wp_posts p WHERE p.post_title = "'.$venueTitle.'"
		';
		$venueId = $wpdb->get_results( $getVenueId );
		$venueId = get_object_vars($venueId[0])['Id'];
		// var_dump($venueId);
		// VENUE ID WORKS
		// ---------------------------------------------------------------------------------------------------------

		// $seoTitle = "Séminaire Hôtels Anvers";
		// $seoTitle = "Centre de conférence Anvers";
		$search  = array("ç","æ","œ","á","é","í","ó","ú","à","è","ì","ò","ù","ä","ë","ï","ö","ü","ÿ","â","ê","î","ô","û","å","ø","Ø","Å","Á","À","Â","Ä","È","É","Ê","Ë","Í","Î","Ï","Ì","Ò","Ó","Ô","Ö","Ú","Ù","Û","Ü","Ÿ","Ç","Æ","Œ");

		$seoTitle = str_replace($search, '%', $seoTitle);
		$getSeoId = '
			SELECT Id FROM wp_posts p WHERE p.post_title LIKE "'.$seoTitle.'"
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
			// error_log($insertVenueToSeo);
		}

	}
}













