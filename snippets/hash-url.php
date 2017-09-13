<!-- VO HASH SCRIP -->

<?php
	function hash_url(){
		$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url_params = explode("/", $url, 2)[1];

		global $wpdb;
		$querystr = "
		    SELECT hash
		    FROM wp_hash_table 
		    WHERE url LIKE '%$url_params'
		";
		$hash_result_array = $wpdb->get_row($querystr);
		// get value from stdClass
		$hash_result = $hash_result_array->hash;

		if (!$hash_result){
			// Create hash and store
			$new_hash = md5($url_params);
			$querystr = "
			    INSERT INTO `wp_hash_table`
	          	(`url`,`hash`) 
	   			values ('$url_params', '$new_hash')
			";
			$wpdb->query($querystr);
			$hash_result = $new_hash;
		}

		// $wpdb->show_errors();
		// $wpdb->print_error();

		// return $url_params;
		// return $hash_result;

		$home_url = get_home_url();
		echo "Location: " . $home_url . "/" .$url_params;
		echo "</br>Converted:</br>";
		echo "Location: " . $home_url . "/" .$hash_result;

		// header ("Location: " $home_url . "/" .$hash_result);
	}

	hash_url();
?>





<!-- SNIPPETS -->
<?php
	$url = '[type]/[plaats]/[type-locatie]/[faciliteiten]/[ligging]/';

	$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$url_params = explode("/", $url, 2)[1];

	global $wpdb;

	// ------------------------------------------------------------
	// READ
	$querystr = "
	    SELECT hash
	    FROM wp_hash_table 
	    WHERE url LIKE '%$url_params'
	";
	$querystr = "
	    SELECT DISTINCT meta_value 
	    FROM $wpdb->postmeta 
	    WHERE meta_key LIKE 'naam' 
	    ORDER BY meta_value ASC
	    LIMIT 500
	";
	// as object
	$result = $wpdb->get_results( $querystr, OBJECT );
	// or as value
	$hash_result_array = $wpdb->get_row($querystr);
	// get value from stdClass
	$hash_result = $hash_result_array->hash;

	if($result){
		var_dump($result);
	}
	else{
	    $wpdb->print_error();
	}
	// ------------------------------------------------------------
	// ------------------------------------------------------------
	// INSERT
	$new_hash = md5($url_params);
	$querystr = "
	    INSERT INTO `wp_hash_table`
      	(`url`,`hash`) 
			values ('$url_params', '$new_hash')
	";
	$wpdb->query($querystr);

	$wpdb->insert('wp_hash_table', array(
	    'id' => 'test',
	    'url' => 'test',
	    'hash' => 'test@gmail.com',
	    'date' => '3456734567',
	    'hits' => '3456734567'
	));
	// ------------------------------------------------------------
	// ------------------------------------------------------------
	// UPDATE
	$wpdb->update('wp_hash_table', array(
	    'hash' => $rand_str,
	    'date' => 'test',
	    'hits' => 'test'
	),array('url'=>$url_params));

	$wpdb->show_errors();
	$wpdb->print_error();
	// ------------------------------------------------------------
	// ------------------------------------------------------------

	// global $wpdb;
	// $querystr = "
	//     SELECT DISTINCT meta_value 
	//     FROM $wpdb->postmeta 
	//     WHERE meta_key LIKE 'naam' 
	//     -- ORDER BY meta_value ASC
	//     LIMIT 500
	// ";

	// $result = $wpdb->get_results( $querystr, OBJECT );

	// if ($result){
	// 	var_dump($result);
	// }
	// else{
	//     $wpdb->print_error();
	// }

?>


<!-- Setup Table -->
CREATE TABLE `wp_hash_table` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(620) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `hits` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;




CREATE TABLE `wp_hash_table` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `url_params` varchar(620) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;