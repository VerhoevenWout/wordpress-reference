<?php /* Template Name: Alumni Overview */ ?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <main id="main" role="main">
    <div class="visual">
      <div class="visual-img">
        <?php if(get_field('custom_banner')) { ?>
            <?php $image = wp_get_attachment_image_src(get_field('custom_banner'), 'img-size1',true);	?>
          <img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title(get_field('custom_banner')) ?>" />
        <?php } else { ?>
            <?php $image = wp_get_attachment_image_src(get_field('custom_banner_fallback', 'option'), 'img-size1',true);	?>
          <img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title(get_field('custom_banner_fallback','option')) ?>" />
        <?php } ?>
      </div>
    </div>
    <div class="main-holder">
      <div class="container alumni">
        <div class="row">
          <div class="col-centered col-lg-9 col-md-8 col-sm-8 ">
            <div id="content">
              <div class="row">
                <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                  <header class="heading">
                    <?php
                    // $words = explode(' ', the_title('', '',  false));
                    $words[0] = '<span>'.$words[0].'</span>';
                    $title = implode(' ', $words);
                    echo "<h1 class='alumni-heading'>" . $title . "</h1>";
                    ?>
                    <p class="alumni-intro"><?php echo the_content() ?></p>
                    <div class="row">
                      <?php
                      $args = array( 'post_type' => 'alumni', 'posts_per_page' => 10 );
                      $loop = new WP_Query( $args );
                      while ( $loop->have_posts() ) : $loop->the_post();
                      ?>
                        <div class="alumni-post-wrapper col-md-4">
                          <?php $photo = get_field('alumni_photo');
                          if ($photo) : ?>
                            <a href="<?php the_permalink(); ?>">
                              <div class="alumni-photo" style="background:transparent url('<?php echo $photo; ?>') center top no-repeat; background-size:cover;"></div>
                            </a>
                            <a href="<?php the_permalink(); ?>">
                              <h4><?php the_title() ?></h4>
                            </a>
                            <h6 class="went_to_school_dates"><?php the_field('went_to_school_dates'); ?></h6>
                            <p><?php the_field('alumni_thumbnail_excerpt'); ?></p>
                            <a href="<?php the_permalink(); ?>">Read more</a>
                          <?php endif; ?>
                        </div>
                      <?php
                      endwhile;
                      ?>
                    </div>

                  </header>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
