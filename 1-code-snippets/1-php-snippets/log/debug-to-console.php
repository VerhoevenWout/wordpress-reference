<?php

	// ----------------------------------------------------------------------
	// DEBUG TO CONSOLE
	// debug_to_console('Test');
	function debug_to_console($data) {
	    $output = $data;
	    if (is_array($output)){
	        $output = implode( ',', $output);
	    }
	    echo "<script>console.log('Debug Objects: " . $output . "');</script>";
	}