<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 */

get_header(); 
?>
<div class="row">
	<main class='columns small-12'>
		<h1 class="page-title"><?php _e('Pagina niet gevonden', 'muller') ?></h1>
		<a href='/' class='btn'><?php _e('Terug naar home', 'muller') ?></a>
	</main>
</div>

<?php 
get_footer(); 
?>