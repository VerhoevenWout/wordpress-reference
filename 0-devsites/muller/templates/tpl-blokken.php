<?php
global $muller;

// Template name: Blokken

/*
	Variables to load {
		WP / page
		\muller\homehelper / getlayout / layouts 	
		\muller\menushelper / getBreadcrumb / breadcrumb 
	}
*/

get_header(); 
?>


		<header class='row'>
			<div class='columns small-12 breadcrumb'>
				<?= $muller->breadcrumb;?>
			</div>
		</header>
		<?php 
			while ( have_posts() ) : the_post();
			foreach ($muller->layouts as $key => $layout):

				echo $layout;

			endforeach;
			endwhile;
		?>

<?php 
get_footer(); 
?>