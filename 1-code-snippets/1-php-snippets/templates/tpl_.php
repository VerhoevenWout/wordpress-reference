<?php
	// Template name: Diensten
?>
<?php get_header(); ?>
<?php $home = get_page_by_path( 'home' ); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	
<?php endwhile; endif; ?>
<?php get_footer(); ?>