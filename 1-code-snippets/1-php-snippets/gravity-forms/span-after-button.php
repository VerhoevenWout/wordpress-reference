<?php

// Adds a span after gravity forms button
add_filter( 'gform_submit_button', 'dw_add_span_tags', 10, 2 );
function dw_add_span_tags ( $button, $form ) {
	return $button .= "<span aria-hidden='true'></span>";
}