<?php
// ----------------------------------------------------------------------
// OVERRIDE 404-STATUS
function pilau_override_404( $template = null, $type = 'page' ) {
	global $wp_query;
	// Change type of query
	$wp_query->is_404 = false;
	$type_property = "is_$type";
	if ( property_exists( $wp_query, $type_property ) )
		$wp_query->$type_property = true;
	// Make sure HTTP status is good
	status_header( '200' );
	// Load template?
	if ( $template ) {
		$template_found = locate_template( $template, true );
		if ( $template_found )
			exit;
	}
}