<style>

.news-content{
	padding-top: 3em;
	@include xl{
		padding-top: 0;
	}
	.news-block{
		display: flex;
		// flex: auto;
		flex: initial;
		flex-direction: column;
		margin-bottom: 5em;
		width: 100vw;

		@include md{
			width: 50vw;
		}
		@include lg{
			width: 33.333333333333vw;

		}
		@include xl{
			width: 25vw;
		}
	}
	img{
		object-fit: cover;
		height: calc(100vw - 10rem);
		width: 100%;
		@include md{
			height: calc(50vw - 10rem);
		}
		@include lg{
			height: calc(33.333333333333vw - 10rem);

		}
		@include xl{
			height: calc(25vw - 10rem);
		}
	}
	h4{
		color: $black;
		font-size: 2.2rem;
		margin: 1em 0;
	}
	p{
		color: $light-black;
		font-size: 1.4rem;
		display: inline;
	}
	span{
		color: $darkest-gray;
		font-size: 1.2rem;
		display: block;
		padding: 1em 0;
	}
	span.link{
		color: $red;
		font-size: 1.4rem;
		padding: 0;
	}
}
	
</style>


<div class="row news-content">
<?php $args = array('order' => 'DESC', 'posts_per_page'=>-1);
$postslist = get_posts($args);$i = 0;
foreach ($postslist as $post): setup_postdata($post); ?>
	<?php $thumb = get_field('news_thumbnail'); ?>
	<?php $excerpt = get_field('news_excerpt');$excerpt = preg_replace(" ([.*?])",'',$excerpt);$excerpt = strip_shortcodes($excerpt);$excerpt = strip_tags($excerpt);$excerpt = substr($excerpt, 0, 200);$excerpt = substr($excerpt, 0, strripos($excerpt, " "));$excerpt = trim(preg_replace( '/s+/', ' ', $excerpt));$excerpt = $excerpt.'...';?>
	<?php $post_date = get_the_date( 'j F Y' ); ?>

	<a href="<?= the_permalink() ?>" title="<?php the_title(); ?>">
		<!-- <div class="columns small-12 medium-6 large-4 xxlarge-3"> -->
		<div class="columns news-block">
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
