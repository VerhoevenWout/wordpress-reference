<?php
global $betrope;

// Template name: Team

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

<section class="block team-block column small-12 row xmedium-collapse">

	<?php

		$team = array();

		$terms = get_field('select_team');

		foreach( $terms as $term ): 
			$team[] = $term->name;

		endforeach;
		
		foreach ($team as &$lid) :
			$args = array(
				'post_type' => 'team',
				'tax_query' => array(
				    array(
				    'taxonomy' => 'team-functions',
				    'field' => 'slug',
				    'terms' => addslashes($lid)
				     )
				  )
			);
			$query = new WP_Query( $args ); 


			if ( $query->have_posts() ) :
		?>
			<header class="column small-12">
				<h2><?php echo $lid; ?></h2>
			</header>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<article class="column small-6 medium-4 large-3">
					<aside>
						<?php 
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'medium' ); 
							} else {
								echo "<img src='" . get_bloginfo('template_url') . "/dist/img/profile-placeholder.svg' />";
							}
						 ?>
					</aside>				
					 <header>
						 <h3>
						 	<?php the_title(); ?>
						 </h3>
					 </header>
					 <?php if ( ($lid == "Huisartsen") || ($lid == "Haio's") ): ?>
					 <p>
					 	<a href="/belkwartier/#<?php echo $post->post_name; ?>">belkwartier</a> <!-- <a href="<?php the_permalink(); ?>">meer info</a> --><br>
					 	<a href="http://groepspraktijkfruithof.digitalewachtkamer.be/" class="read-more" target="_blank">Boek je afspraak online</a>
					 </p>
					<?php elseif ($lid == "Medewerkers"): ?>
						<p>
							<?php the_field("team_functie"); ?>
						</p>
					<?php else: ?>

					<?php endif; ?>
				</article>
				
			<?php
				endwhile;
			endif;
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