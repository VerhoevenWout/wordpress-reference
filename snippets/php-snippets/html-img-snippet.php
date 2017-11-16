<!-- You can do both to show images -->
<img src="<?php echo get_template_directory_uri(); ?>/assets/img/facebook.png" alt="image">
<img src="<?php echo get_bloginfo('template_url') ?>/assets/img/facebook.png" alt="image">

<!-- Show images using divs -->
<?php $image = get_field('work_image');?>
<div class="intro-background" style="background:transparent url('<?php echo $image; ?>') center top no-repeat; background-size:cover;"></div>

<!-- Do shortcode in html -->
<?php echo do_shortcode("[instagram-feed]"); ?>
