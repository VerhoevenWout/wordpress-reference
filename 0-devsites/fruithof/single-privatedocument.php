<?php
global $voltatheme;

// Template for downloading a public document without showing the url

	$docs_file 	= get_field("docs_file");
	$file_name 	= $docs_file['filename'];
	$file_url 	= $docs_file['url'];


	header('Content-Type: application/pdf');
	header("Content-Transfer-Encoding: Binary");
	header("Content-disposition: attachment; filename=".$file_name);
	readfile($file_url);

?>