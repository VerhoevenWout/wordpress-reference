<?php
global $muller;

// Template name: Nieuws

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
	<div class="row news-content">

	<?php $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1'; ?>
	<?php $args = array(
		'post_type' => 'nieuws', 
		'post_status' => 'publish',
		'order' => 'ASC', 
		'has_archive' => true,
		'paged' => $paged,
		'posts_per_page'=> '5',
	);
	$postslist = new WP_Query( $args );

	if ( $postslist->have_posts()) :
	while ( $postslist->have_posts() ) : $postslist->the_post(); ?>
		<?php $thumb = get_field('news_thumbnail'); ?>
		<?php $excerpt = get_field('news_excerpt');$excerpt = preg_replace(" ([.*?])",'',$excerpt);$excerpt = strip_shortcodes($excerpt);$excerpt = strip_tags($excerpt);$excerpt = substr($excerpt, 0, 200);$excerpt = substr($excerpt, 0, strripos($excerpt, " "));$excerpt = trim(preg_replace( '/s+/', ' ', $excerpt));$excerpt = $excerpt.'...';?>
		<?php $post_date = get_the_date( 'j F Y' ); ?>

		<a href="<?= the_permalink() ?>" title="<?php the_title(); ?>">
			<div class="news-block">
				<img src="<?= $thumb['url'] ?>" alt="">
				<h4><?php the_title(); ?></h4>
				<p><?= $excerpt ?></p>
				<span class="link"><?= _e('Lees meer') ?></span>
				<span><?= $post_date ?></span>
			</div>
		</a>

	<?php endwhile; ?>
	</div>
	<div class="row">
		<?php next_posts_link( 'Older Entries', $postslist->max_num_pages ); ?>
		<?php previous_posts_link( 'Next Entries &raquo;' ); ?>
		<?php wp_reset_postdata(); ?>
	</div>
	<?php endif; ?>

<?php 
get_footer(); 
?>