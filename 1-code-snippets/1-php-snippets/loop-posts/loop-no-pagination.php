<?php $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1'; ?>
<?php $args = array(
	'post_type' => 'nieuws', 
	'post_status' => 'publish',
	'order' => 'ASC', 
	// 'posts_per_page' => -1,
	'has_archive' => true,
	'paged' => $paged,
	'posts_per_page'=> '5',
);
$postslist = get_posts($args);$i = 0;

foreach ($postslist as $post): setup_postdata($post); ?>
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

	<?php $i++; wp_reset_postdata(); ?>
<?php endforeach; ?>
</div>