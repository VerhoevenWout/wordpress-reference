<?php
global $muller;

// Template name: Home

/*
	Variables to load {
		WP / page
		\muller\homehelper / getlayout / layouts 	
	}
*/

get_header(); 
while ( have_posts() ) : the_post();
foreach ($muller->layouts as $key => $layout):

	echo $layout;

endforeach;
endwhile;
get_footer(); 
?>