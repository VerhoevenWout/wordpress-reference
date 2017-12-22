<?php get_header(); ?>
<?php $home = get_page_by_path( 'home' ); ?>

	<div class="homepage-wrapper">

    <div id="intro-wrapper" class="section">
			<div id="embed-container">
        <!-- <div class="intro-overlay"></div> -->
				<div class="content-big">
					<img class="loading-svg" src="<?php echo get_bloginfo('template_url') ?>/assets/img/ring.svg"/>
        	<iframe src="https://player.vimeo.com/video/<?php the_field(video_id) ?>?background=1&loop=100" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				</div>
				<div class="content-small">
					<?php $image = get_field('header_image_fallback');
					if ($image) : ?>
						<div class="intro-background" style="background:transparent url('<?php echo $image; ?>') center top no-repeat; background-size:cover;"></div>
					<?php else : ?>
						<div class="intro-background" style="background:transparent url('<?php echo get_template_directory_uri(); ?>/images/header-image.jpg') center top no-repeat; background-size:cover;"></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
    <div id="work-wrapper" class="section">
      <div class="col-md-10 col-md-offset-1">
				<h2>work</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="inner-work-wrapper">
						<div class="wide-wrapper">
							<div class="content-small">
								<div class="row">
									<div class="col-md-12">
										<?php
										$args = array('order' => 'DESC', 'posts_per_page'=>-1);
										$postslist = get_posts($args);
										foreach ($postslist as $post) :  setup_postdata($post); ?>
											<a href="<?php the_permalink(); ?>">
												<?php $image = get_field('work_image');
												if ($image) : ?>
													<div class="individual-work" style="background:transparent url('<?php echo $image; ?>') center top no-repeat; background-size:cover;"></div>
										  	<?php else : ?>
										  		<div class="fullscreen-header-img" style="background:transparent url('<?php echo get_template_directory_uri(); ?>/images/header-image.jpg') center top no-repeat; background-size:cover;"></div>
										  	<?php endif; ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
							<div class="content-big">
								<div class="row">
									<div class="col-md-12">
										<?php
										$args = array('category_name' => 'first', 'order' => 'DESC', 'posts_per_page'=>-1);
										$postslist = get_posts($args);
										foreach ($postslist as $post) :  setup_postdata($post); ?>
											<?php get_template_part( 'partials/loop-content' ); ?>
										<?php endforeach; ?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<?php
										$args = array('category_name' => 'second', 'order' => 'DESC', 'posts_per_page'=>-1);
										$postslist = get_posts($args);
										foreach ($postslist as $post) :  setup_postdata($post); ?>
											<?php get_template_part( 'partials/loop-content' ); ?>
										<?php endforeach; ?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<?php
										$args = array('category_name' => 'third', 'order' => 'DESC', 'posts_per_page'=>-1);
										$postslist = get_posts($args);
										foreach ($postslist as $post) :  setup_postdata($post); ?>
											<?php get_template_part( 'partials/loop-content' ); ?>
										<?php endforeach; ?>
									</div>
								</div>
						</div>
					</div>
					<div class="arrow-container arrow-left-container">
						<img class="arrow-left" src="<?php echo get_bloginfo('template_url') ?>/assets/img/arrow-right.png"/>
					</div>
					<div class="arrow-container arrow-right-container">
						<img class="arrow-right" src="<?php echo get_bloginfo('template_url') ?>/assets/img/arrow-right.png"/>
					</div>
				</div>
			</div>
    </div>
    <div id="about-wrapper" class="section">
      <div class="col-md-10 col-md-offset-1">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
						<h2>about</h2>
            <p class="about-main"><?php the_field('about_main', $home->ID) ?></p>
            <p class="about-sub"><?php the_field('about_sub', $home->ID) ?></p>

            <a class="about-button" href="#">read more</a>
            <a class="about-button about-button-filled" href="#">contact</a>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <?php $image = get_field('about_image', $home->ID);
  					if ($image) : ?>
  			    	<div class="about-img" style="background:transparent url('<?php echo $image; ?>') left top no-repeat; background-size:cover;"></div>
  			  	<?php else : ?>
  			  		<div class="about-img" style="background:transparent url('<?php echo get_template_directory_uri(); ?>/images/fergus.png') center top no-repeat; background-size:cover;"></div>
  			  	<?php endif; ?>
          </div>
        </div>
      </div>
    </div>
		<div id="sponsor-wrapper" class="section">
			<div class="col-md-10 col-md-offset-1">
				<h2>Clients</h2>
				<div class="sponsor-content">
					<div class="row">
				    <?php if ( !empty( get_field('sponsor_repeater', $home->ID) ) ) :
							while(have_rows('sponsor_repeater', $home->ID)): the_row();?>
								<div class="sponsor-image-container">
									<img class="sponsor-image" src="<?php echo the_sub_field('sponsor_image'); ?>" alt="">
								</div>
					    <?php endwhile;
						endif; ?>
					</div>
				</div>
			</div>
		</div>
    <div id="contact-wrapper" class="section">
      <div class="col-md-10 col-md-offset-1">
        <h2>contact</h2>
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-4 first-align icon-container">
            <img class="contact-icon" src="<?php echo get_bloginfo('template_url') ?>/assets/img/envelope-icon.png"/>
            <p class="contact-icon-paragraph"><?php the_field('email', $home->ID) ?></p>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-4 second-align icon-container">
            <img class="contact-icon" src="<?php echo get_bloginfo('template_url') ?>/assets/img/endcall-icon.png"/>
						<a href="tel:<?php the_field('phone_number', $home->ID) ?>">
            	<p class="contact-icon-paragraph"><?php the_field('phone_number', $home->ID) ?></p>
						</a>

          </div>
          <div class="col-md-4 col-sm-4 col-xs-4 third-align icon-container">
            <img class="contact-icon" src="<?php echo get_bloginfo('template_url') ?>/assets/img/share-icon.png"/>
            <a class="contact-icon-link" target="_blank" href="<?php the_field('vimeo_link', $home->ID) ?>">
              <img src="<?php echo get_bloginfo('template_url') ?>/assets/img/vimeo-icon.png"/>
            </a>
            <a class="contact-icon-link" target="_blank" href="<?php the_field('twitter_link') ?>">
              <img src="<?php echo get_bloginfo('template_url') ?>/assets/img/twitter-icon.png"/>
            </a>
            <a class="contact-icon-link" target="_blank" href="<?php the_field('skype_link') ?>">
              <img src="<?php echo get_bloginfo('template_url') ?>/assets/img/skype-icon.png"/>
            </a>
          </div>
        </div>
        <!-- End row -->
        <hr>
        <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
	          <div class="contact-inner">
	            <h3><?php the_field('contact_form_header', $home->ID) ?></h3>
	            <p><?php the_field('contact_form_paragraph', $home->ID) ?></p>
							<?php gravity_form( 1, false, false, false, '', false ); ?>
	          </div>
          </div>
        </div>
        <!-- End row -->

      </div>
    </div>
	</div>

<?php get_footer(); ?>
