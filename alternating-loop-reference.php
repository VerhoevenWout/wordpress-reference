

<div class="content-big">
	<div class="row">
		<div class="col-md-12">
			<?php
			$args = array('order' => 'DESC', 'posts_per_page'=>-1);
			$postslist = get_posts($args);
			$i = 0;foreach ($postslist as $post): setup_postdata($post); ?>
				<?php if($i % 2 === 0): ?>
					<!-- even projects -->
					<?php get_template_part( 'partials/loop-content' ); ?>
				<?php endif ?>
				<?php $i++; wp_reset_postdata(); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php
			$args = array('order' => 'DESC', 'posts_per_page'=>-1);
			$postslist = get_posts($args);
			$i = 0; foreach ($postslist as $post): setup_postdata($post); ?>
				<?php if($i % 2 === 1): ?>
					<!-- odd projects -->
					<?php get_template_part( 'partials/loop-content' ); ?>
				<?php endif ?>
				<?php $i++; wp_reset_postdata(); ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<!-- PARTIAL -->
<?php $image = get_field('work_image');
if ($image) : ?>
  <div class="individual-work" style="background:transparent url('<?php echo $image; ?>') center top no-repeat; background-size:cover;">
    <div class="individual-work-content">
      <h3><?php the_field('work_title') ?></h3>
      <p><?php the_field('work_subtitle') ?></p>
      <p><?php the_field('work_function') ?></p>

      <!-- <div class="iframe-container iframe-container-16x9">
      </div> -->

      <a class="individual-work-button individual-work-button1" href="https://player.vimeo.com/video/<?php the_field('work_id')?>?autoplay=1" data-featherlight="iframe">watch video</a>
      <a class="individual-work-button individual-work-button2" href="<?php the_permalink(); ?>">more details</a>
    </div>
  </div>
<?php else : ?>
  <div class="fullscreen-header-img" style="background:transparent url('<?php echo get_template_directory_uri(); ?>/images/header-image.jpg') center top no-repeat; background-size:cover;"></div>
<?php endif; ?>
