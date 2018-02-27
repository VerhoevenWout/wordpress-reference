<?php get_header(); ?>
	<div class="content">
		<div class="col-md-10 col-md-offset-1">
			<h2>404 - Page Not Found</h2>
		</div>
	</div>

<?php get_footer(); ?>



<!-- or -->


<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 */

get_header(); ?>

<div class="row">
	<div class="columns small-12">
		<h1 class="page-header"><?php _e('Oeps...') ?></h1>
		<p><?php _e('Deze pagina bestaat niet.') ?></p>
		<a href="/"><?php _e('Ga terug naar de homepage') ?></a>
	</div>
</div>

<?php get_footer(); ?>