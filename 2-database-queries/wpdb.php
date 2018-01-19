<?php

	// INSERT
	global $wpdb;
	$sqlinsert = "
		INSERT INTO mll_orders (order_title, user_id)
		VALUES ('".$offerteNaam."','".$currentuser['ID']."');
	";
   	$wpdb->query($sqlinsert);
   	// Get last inserted ID
   	$lastid = $wpdb->insert_id;