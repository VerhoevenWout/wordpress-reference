<?php
global $betrope;

// Template name: Paramedici

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
</section>

<section class="block paramedici-block column small-12">

	<?php

		$terms = get_field('select_team');

		
		foreach ($terms as $term) :
			$args = array(
				'post_type' => 'team',
				'tax_query' => array(
				    array(
				    'taxonomy' => 'team-functions',
				    'field' => 'slug',
				    'terms' => addslashes($term->name)
				     )
				  )
			);
			$query = new WP_Query( $args ); 


			if ( $query->have_posts() ) :
		?>
			<header>
				<h2><?php echo $term->name; ?></h2>
			</header>
			<h3>Team</h3>
			<ul>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<li>			
					<?php the_title(); ?>
				</li>
				
			<?php endwhile; ?>
			</ul>

			<h3>Praktische info</h3>
			<?php print_r($term->description); ?>
		<?php endif;
			/* Restore original Post Data */
			wp_reset_postdata();
		endforeach;

		?>
</section>
	
<section class="block column small-12">
	<div class="wysiwyg">
		<?= apply_filters("the_content", $voltatheme->WP['page']->post_content); ?>
	</div>
</section>

<?php 
endwhile;
get_footer(); 
?>