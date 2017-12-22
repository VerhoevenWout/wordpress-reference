<?php
//The template for displaying all pages

get_header(); ?>

<?php 
	$contact_name = get_field('contact_name', 'option');
	$contact_extra = get_field('contact_extra', 'option');
	$address = get_field('contact_address', 'option');
	$home = get_page_by_path( 'home' );
?>

	<div class="container" id='vue-search' v-bind:class="{ 'search-active': isactive }">
		<div class="row expanded">
			<div class="small-24 large-16 columns" >
				
				<article class="expanded row">
		 			<slick ref="slick" :options="slickOptions">
						<?php while(have_rows('header_background_repeater', $home->ID)): the_row(); ?>
							<div>
								<img class="slide" src="<?php echo the_sub_field('background'); ?>">
							</div>
						<?php endwhile ;?>
					</slick>

					<div class="page-content small-24 columns" >
						<div class="row">
							<div class="small-24 medium-9 xlarge-6 medium-order-1 columns relative">
								<div class="sidebar">
									<p class="heading">Contact</p>
									<h4><?php echo $contact_name ?></h4>
									<h4><?php echo $contact_extra ?></h4>
									<h4><?php echo $address['address'] ?></h4>
									<a href="tel:<?php echo the_field('contact_tel', 'option'); ?>">T: <?php echo the_field('contact_tel', 'option'); ?></a>
									<h4>F: <?php echo the_field('contact_fax', 'option'); ?></h4>
									<a href="mailto:<?php echo the_field('contact_email', 'option'); ?>"><?php echo the_field('contact_email', 'option'); ?></a>
									<div class="sidebar-icons">
										<?php if( get_field('contact_facebook_link', 'option') ): ?>
											<a href='<?php echo the_field('contact_facebook_link', 'option') ?>' target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
										<?php endif; ?>

										<?php if( get_field('contact_twitter_link', 'option') ): ?>
											<a href='<?php echo the_field('contact_twitter_link', 'option') ?>' target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
										<?php endif; ?>

										<?php if( get_field('contact_linkedin_link', 'option') ): ?>
											<a href='<?php echo the_field('contact_linkedin_link', 'option') ?>' target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
										<?php endif; ?>

										<?php if( get_field('contact_instagram_link', 'option') ): ?>
											<a href='<?php echo the_field('contact_instagram_link', 'option') ?>' target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="small-24 medium-15 xlarge-17 medium-order-0 columns">
								<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
									<h1 class="heading light"><?php the_title() ?></h1>
									<?php the_content(); ?>
								<?php endwhile; endif ?>
							</div>
						</div>

					</div>
				</article>
			</div>

			<div class="map-container noPadding small-8 columns selectedfiche-map">
				<gmap-map 
					style="width: 100%; height: 100%; position: absolute; left:0; top:0"
				    :center="getposition(<?php echo $address['lat']; ?>, <?php echo $address['lng']; ?>)"
				    :zoom="14"
				    :options="{styles: mapsstyle, gestureHandling: 'greedy'}"
				>	
					<gmap-marker
						:clickable="true"
						:position="getposition(<?php echo $address['lat']; ?>, <?php echo $address['lng']; ?>)"
						icon='/wp-content/themes/venues-online/dist/img/single-logo-marker.png'
				    ></gmap-marker>
				</gmap-map>
			</div>
		</div>
		<div class="row expanded">
			<div class="map-container map-container-mobile noPadding small-24 columns selectedfiche-map">
				<gmap-map 
					style="width: 100%; height: 100%; position: absolute; left:0; top:0"
				    :center="getposition(<?php echo $address['lat']; ?>, <?php echo $address['lng']; ?>)"
				    :zoom="14"
				    :options="{styles: mapsstyle}"
				>	
					<gmap-marker
						:clickable="true"
						:position="getposition(<?php echo $address['lat']; ?>, <?php echo $address['lng']; ?>)"
						icon='/wp-content/themes/venues-online/dist/img/single-logo-marker.png'
				    ></gmap-marker>
				</gmap-map>
			</div>
		</div>
	</div>

<?php get_footer(); ?>