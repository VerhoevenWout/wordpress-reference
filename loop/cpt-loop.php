<?php
	function create_posttype() {
		register_post_type( 'mediacenter_photos',
	  // CPT Options
	    array(
	      'labels' => array(
	        'name' => __( 'Mediacenter Photos' ),
	        'singular_name' => __( 'Mediacenter Photos' )
	      ),
	      'public' => true,
	      'has_archive' => true,
	      'rewrite' => array('slug' => 'mediacenter-photos'),
	      'menu_icon' => 'dashicons-format-image',
	      'supports' => array( 'title', 'thumbnail','editor' ),
        'taxonomies' => array('post_tag'),
	    )
	  );
	}
	add_action( 'init', 'create_posttype' );
?>

<!-- PAGE -->
<!-- Template Name: Media Centre Photos -->
<?php get_header(); ?>
<?php get_template_part( 'tpl/parts/section-page-header' ); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="container">
	    <div class="row">
	      <h2>Awards dinner videos</h2>

        <?php $args = array(
          'post_type' => 'photos',
          'post_status' => 'publish',
          'posts_per_page'=> '5',
          'paged' => $paged,
          'order' => 'asc',
          'orderby' => 'menu_order',
        );
        $loop = new WP_Query( $args );
        if( $loop->have_posts() ): ?>
          <?php $i = 1; while( $loop->have_posts() ): $loop->the_post(); global $post; ?>

						<!-- code -->
						<div class="col-md-4">
							<a href="<?php echo get_post_permalink(); ?>">
								<div class="video_text_container latests_item ">
									<div class="video_image_contain">
										<?php if (has_post_thumbnail( $post->ID ) ): ?>
											<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
										<?php endif; ?>
										<div class="video_image" style="background-image:url('<?php echo $image[0]; ?>');"></div>
										<div class="video_image_overlay"></div>
									</div>
									<div class="text_contain">
										<div class="text"><?php the_title();?></div>
									</div>
								</div>
							</a>
						</div>
						<!-- code -->

          <?php $i++; endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>

	    </div>
    </div>

	<?php endwhile; endif; ?>
<?php get_footer(); ?>

<!-- SINGLE -->
<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<!-- VIDEOS -->
		<?php if( 'videos' == get_post_type() ): ?>
			<div class="row">
				<?php if( have_rows('multiple_videos_repeater') ): ?>
				  <?php while( have_rows('multiple_videos_repeater') ): the_row(); ?>
						<div class="col-sm-4 no-padding">
							<a class="popup-youtube" href="<?php the_sub_field('video_url')?>">
					      <div class="news-box-link <?php if($i % 2 == 0){ echo 'dark';}else{echo 'light';}?>">
					        <div class="image-crop">
										<?php $image_url = get_sub_field('video_image') ?>
					          <?php if($image_url){?>
					          <div class="image" style="background-image:url('<?php echo $image_url; ?>');"></div>
					            <?php }else{ ?>
					              <div class="image" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/img/article-default.jpg');"></div>
					            <?php } ?>
					          <div class="overlay"><h6>Watch Video</h6></div>
					        </div>
					        <div class="text">
										<span class="title"><?php echo the_sub_field('video_title');?></span>
					        </div>
					      </div>
					    </a>
						</div>
				  <?php endwhile ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<!-- END VIDEOS -->
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
