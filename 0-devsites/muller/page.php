<?php
global $muller;

//The template for displaying all pages

/*
	Variables to load {
		WP / page
		\muller\menushelper / getBreadcrumb / breadcrumb 
	}
*/

get_header(); 
while ( have_posts() ) : the_post();
?>

<header class='row'>
	<div class='columns small-12 breadcrumb'>
		<?= $muller->breadcrumb;?>
	</div>
</header>
<div class="row">
	<main class='columns small-12'>
		<div class="wysiwyg">
			<?= apply_filters("the_content", $muller->WP['page']->post_content); ?>
		</div>
	</main>
</div>

<?php 
endwhile;
get_footer(); 
?>