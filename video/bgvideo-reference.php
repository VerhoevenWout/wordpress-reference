<style media="screen">
  .loading-svg{
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  z-index: 999;
  transition: all .3s;
  }

  #embed-container iframe,
  #embed-container video,
  #embed-container object,
  #embed-container embed {
  position: absolute;
  top: 90px;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  min-width: 1080px;
  min-height: 800px;
  width: 100%;
  height: 100%;
  }
  .intro-background{
  width: 100%;
  height: 100vh;
  background-color: #000000!important;
  }
</style>

<div id="intro-wrapper" class="section">
  <div id="embed-container">
    <div class="intro-overlay"></div>
    <div class="content-big">
      <img class="loading-svg" src="<?php echo get_bloginfo('template_url') ?>/assets/img/ring.svg"/>
      <video class="hidden-print home-video" autoplay="" loop="" id="bgvid">
        <source src="<?php echo get_template_directory_uri(); ?>/assets/img/FD_HomepageLoop.mp4" type="video/mp4">
      </video>
      <!-- <embed src="<?php echo get_template_directory_uri(); ?>/assets/img/FD_HomepageLoop.mp4" autostart="true" hidden="true" loop="true" height="30" width="144" /> -->
      <!-- <iframe src="https://player.vimeo.com/video/<?php the_field(video_id) ?>?background=1&loop=100" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> -->
    </div>
    <div class="content-small">
      <?php $image = get_field('header_image_fallback');
      if ($image) : ?>
        <div class="intro-background" style="background:transparent url('<?php echo $image; ?>') center top no-repeat; background-size:cover;"></div>
      <?php else : ?>
        <div class="intro-background" style="background:transparent url('<?php echo get_template_directory_uri(); ?>/assets/img/header-image.jpg') center top no-repeat; background-size:cover;"></div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  // IFRAME HEADER RESPONSIVE RESIZE
  function resize(){
  var windowWidth = $(window).width();
  // Load Variables - we do this here so they are reset when the screen changes size.
  var SW = $(window).width();
  var VH = SW * 0.5625;
  var SH = $(window).height();
  var VW = SH * 1.777;
  // Screen size check based on 16:9 ratio
  if (SW > VW) {
    $(".content-big video").width(SW).height(VH).css("top", -(VH - SH) /2);
  } else {
    $(".content-big video").height(SH).width(VW).css("left", -(VW - SW) /2);
  }
  // if (SW > VW) {
  //   $(".content-big iframe").width(SW).height(VH).css("top", -(VH - SH) /2);
  // } else {
  //   $(".content-big iframe").height(SH).width(VW).css("left", -(VW - SW) /2);
  // }
  }
  resize();
  $(window).resize(function() {
  resize();
  });

  // LOADING SVG FADEOUT ON VIDEO 1s
  var iframe = document.querySelector('iframe');
  // var player = new Vimeo.Player(iframe);
  var player = $('video');
  player.on('progress', function(data) {
  seconds: 1;
  $('.loading-svg').addClass('loading-svg-hide');
  });
  player.play();
  player.setVolume(0);
</script>
