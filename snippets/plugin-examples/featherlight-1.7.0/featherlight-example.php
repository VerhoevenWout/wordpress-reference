<style media="screen">
  .featherlight iframe{
  width: 800px!important;
  height: 450px!important;
  max-width: 90vw;
  /*max-height: 50vh;*/
  }
</style>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <a href="https://player.vimeo.com/video/<?php the_field('video_url')?>?autoplay=1" data-featherlight="iframe">
  <!-- OR -->
  <a href="<?php the_field('video_url')?>?autoplay=1" data-featherlight="iframe">
    <div class="news-box-link <?php if($i % 2 == 0){ echo 'dark';}else{echo 'light';}?>">
      <div class="image-crop">
        <?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
        <?php if($image_url[0]){?>
        <div class="image" style="background-image:url('<?php echo $image_url[0]; ?>');"></div>
          <?php }else{ ?>
            <div class="image" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/img/article-default.jpg');"></div>
          <?php } ?>
        <div class="overlay"><h6>Watch Video</h6></div>
      </div>
      <div class="text">
        <span class="title"><?php echo the_title();?></span>
        <span class="date"><?php echo the_time('jS F, Y');?></span>
      </div>
    </div>
  </a>
<?php endwhile ?>

<!-- OR -->

<?php else: ?>
  <!-- Link to lightbox video -->
  <a href="<?php the_field('video_url')?>?autoplay=1" data-featherlight="iframe">
    <div class="news-box-link <?php if($i % 2 == 0){ echo 'dark';}else{echo 'light';}?>">
      <div class="image-crop">
        <?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' ); ?>
        <?php if($image_url[0]){?>
        <div class="image" style="background-image:url('<?php echo $image_url[0]; ?>');"></div>
          <?php }else{ ?>
            <div class="image" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/img/article-default.jpg');"></div>
          <?php } ?>
        <div class="overlay"><h6>Watch Video</h6></div>
      </div>
      <div class="text">
        <span class="title"><?php echo the_title();?></span>
        <span class="date"><?php echo the_time('jS F, Y');?></span>
      </div>
    </div>
  </a>
<?php endif; ?>
