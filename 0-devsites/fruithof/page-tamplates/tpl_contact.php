<?php
global $betrope;

// Template name: Contact

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
	<section class="block column-block column small-12">
		<header>
			<h1 class="page-title"><?= $voltatheme->WP['page']->post_title; ?></h1>
		</header>
		<div class="wysiwyg row">
			<?php if( have_rows('content_row') ): ?>

			 	<?php while ( have_rows('content_row') ) : the_row(); ?>

			 		<?php
			 			if (get_sub_field('content_row_number') == "1 kolom") {
			 				$column = "12";
			 			} else {
			 				$column = "6";
			 			}
			 		?>

			 		<section class="column small-12 xmedium-3">
			 			 <?php the_sub_field('content_row_column1'); ?>
			 		</section>
			 		<?php if (get_sub_field('content_row_number') == "2 kolommen") : ?>
			 			
				 		<section class="column small-12 xmedium-9">
					 		<?php 
					 			$location = get_field('map_location', 22);

					 			if( !empty($location) ):
					 		?>
					 			<section>
					 				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7fP2vODlBzM3qYtLay9jBLqNraRZst_s"></script>
					 				<script src="<?php bloginfo('template_url'); ?>/dist/js/maps.bundle.js"></script>
					 				
					 				<div class="acf-map">
					 					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
					 						<h2>Groepspraktijk Fruithof</h2>
					 						<strong>
					 							Sint Theresiastraat 5 <br>
					 							2600 Berchem <br>
					 							<a href="mailto:info@groepspraktijkfruithof.be">info@groepspraktijkfruithof.be</a>
					 						</strong>
					 					</div>
					 				</div>

					 			</section>

					 		<?php endif; ?>
				 			 <?php the_sub_field('content_row_column2'); ?>
				 		</section>
				 	<?php endif; ?>
			 		
			    <?php endwhile; ?>

			<?php endif; ?>

		</div>
	</section>

<?php 
endwhile;
get_footer(); 
?>