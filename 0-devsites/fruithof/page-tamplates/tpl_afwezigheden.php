<?php
global $betrope;

// Template name: Afwezigheden

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
<section class="block column small-12">
	<header>
		<h1 class="page-title"><?= $voltatheme->WP['page']->post_title; ?></h1>
	</header>
	<div class="wysiwyg">
		<?= apply_filters("the_content", $voltatheme->WP['page']->post_content); ?>
	</div>
</section>

<section class="block indekijker-block column small-12">
	<?php

		$args = array(
			'post_type' => 'post',
				'tax_query' => array(
				    array(
				    'taxonomy' => 'category',
				    'field' => 'slug',
				    'terms' => 'afwezigheden'
				     )
				  )
		);

		$query = new WP_Query( $args ); 


		if ( $query->have_posts() ) :
		?>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<article class="indekijker-item wysiwyg column small-12 xmedium-9">
					<div>
						<?php the_content(); ?>
					</div>
				</article>
				
			<?php
				endwhile;
			endif;
			/* Restore original Post Data */
			wp_reset_postdata();
		?>
			
</section>
	
<section class="block column small-12">
	<div class="wysiwyg">
		<?php the_field("content_field"); ?>
	</div>
</section>

<?php 
endwhile;
get_footer(); 
?>