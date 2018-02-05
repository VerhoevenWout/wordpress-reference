<?php

// ----------------------------------------------------------------------
// ACF GOOGLE MAPS FIX
add_action('acf/fields/google_map/api', function($api){
$api['key'] = 'AIzaSyABxEL5TeJO7-jdW4YYveUdxIwVGLkMjH8';
return $api;
});