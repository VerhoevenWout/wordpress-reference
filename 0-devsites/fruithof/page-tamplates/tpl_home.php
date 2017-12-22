<?php
global $voltatheme;

// Template name: Home

/*
	Variables to load {
		WP / page
		ACF / home_link_text
		ACF / home_link_url
	}
*/

get_header(); 
while ( have_posts() ) : the_post();
?>
	<section class="block home-block column small-12 xmedium-5 large-4">
		<header>
			<h1 class="page-title"><?= $voltatheme->WP['page']->post_title; ?></h1>
		</header>
		<div class="wysiwyg">
			<?= apply_filters("the_content", $voltatheme->WP['page']->post_content); ?>
		</div>
	</section>
	<aside class="block home-hero-block column small-12 xmedium-7 large-8">
		<?php
			$image = get_field('home_hero');

		if( !empty($image) ): ?>

			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

		<?php endif; ?>
	</aside>

	<section class="block prikbord-block inline column small-12 xmedium-12">
		<header>
			<h2 class="page-title">Meldingen</h2>
		</header>
		<?php
			$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;

			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 2,
				'paged' => $paged,
				'orderby' => 'date',
				'order'   => 'DESC'
			);
			// The Query
			$the_query = new WP_Query( $args );

			// The Loop
			if ( $the_query->have_posts() ) :
		?>
				<?php while ( $the_query->have_posts() ) :

					$the_query->the_post(); ?>

					<article>
						<header>
							<strong><?php echo get_the_date('d.m.Y'); ?></strong><?php the_title(); ?>
						</header>

						<footer>
							<a href="<?php the_permalink(); ?>" class="read-more">Lees meer</a> <i class="icon-arrow-right"></i>
						</footer>
					</article>

				<?php endwhile; ?>
				<div class="block block-prev-next-links">
					<?php 
						next_posts_link( '<i class="icon-arrow-left"></i> ouder', $the_query->max_num_pages );
						previous_posts_link( 'nieuwer <i class="icon-arrow-right"></i>' );
					?>
				</div>
				

			<?php wp_reset_postdata(); ?>
			<?php else: ?>
				Geen Prikbordberichten gevonden
		<?php endif; ?>
	</section>

<?php 
endwhile;
get_footer(); 
?>