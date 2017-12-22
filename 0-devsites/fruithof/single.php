<?php
global $voltatheme;

//The template for displaying all pages

/*
	Variables to load {
		WP / post
	}
*/

get_header(); 
while ( have_posts() ) : the_post();
?>
<section class="block column-block column small-12 xmedium-10">
	<header>
		<h1 class="page-title"><?= $voltatheme->WP['post']->post_title; ?></h1>
	</header>
	<div class="wysiwyg">
		<?= apply_filters("the_content", $voltatheme->WP['post']->post_content); ?>

		<a href="/meldingen/" class="read-more"><i class="icon-arrow-left"></i>Naar alle meldingen</a>
	</div>

<?php 
endwhile;
get_footer(); 
?>