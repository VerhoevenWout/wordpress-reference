
<!-- Link to lightbox video -->
<!-- single_video_url = https://www.youtube.com/watch?v=v8O8Em_RPNg -->
<a class="popup-youtube" href="<?php the_field('single_video_url')?>">
  <div class="news-box-link <?php if($i % 2 == 0){ echo 'dark';}else{echo 'light';}?>">
    <div class="image-crop">
      <?php $image_url = get_field('single_video_image') ?>
      <?php if($image_url){?>
      <div class="image" style="background-image:url('<?php echo $image_url; ?>');"></div>
        <?php }else{ ?>
          <div class="image" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/img/article-default.jpg');"></div>
        <?php } ?>
      <div class="overlay"><h6>Watch Video</h6></div>
    </div>
    <div class="text">
      <span class="title"><?php echo the_title();?></span>
    </div>
  </div>
</a>

<script type="text/javascript">
  $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,

    fixedContentPos: false,
    iframe: {
      patterns: {
          youtube: {
            index: 'youtube.com/',
            id: 'v=',
            src: '//www.youtube.com/embed/%id%?autoplay=1'
          },
          vimeo: {
              index: 'vimeo.com/',
              id: '/',
              src: '//player.vimeo.com/video/%id%?autoplay=1'
          },
          gmaps: {
              index: '//maps.google.',
              src: '%id%&output=embed'
          }
        },
      srcAction: 'iframe_src',
    }
  });
</script>
