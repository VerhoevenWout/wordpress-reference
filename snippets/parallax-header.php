<!-- Parallax -->
<div class="banner" data-background="/media/ISFA-banner.jpg" style="background-image: url(&quot;/media/ISFA-banner.jpg&quot;); background-position: center 100px;">
	<img src="/media/ISFA-banner-720x350.jpg" alt="">
</div>

<script type="text/javascript">
  function isMobile(){
    return (
      (navigator.userAgent.match(/Android/i)) ||
      (navigator.userAgent.match(/webOS/i)) ||
      (navigator.userAgent.match(/iPhone/i)) ||
      (navigator.userAgent.match(/iPod/i)) ||
      (navigator.userAgent.match(/iPad/i)) ||
      (navigator.userAgent.match(/BlackBerry/))
    );
  }
  function scrollBanner() {
    var scrollPos = $(this).scrollTop();
    if ($(window).width() > 992) {
      var yPos = (-scrollPos/2) + ($('.navbar').height());
      var coords = 'center ' + yPos + 'px';
      $('.banner').css({
        backgroundPosition : coords
      });
    }
  }
  $(function() {
    var $banner = $('.banner');
    if ($banner.data('background')){
      if ($(window).width() > 750) {
        $banner.css({
          backgroundImage	: 'url(' + $banner.data('background') + ')'
        });
      }
      if (isMobile()) {
        $banner.css({
          backgroundAttachment	: 'initial',
          backgroundPosition		: 'center center'
        });
      } else {
        $(window).on('scroll',function() {
          scrollBanner();
          var menuScrollOffset = 400;
          if($(window).scrollTop() > menuScrollOffset) {
            $('.navbar').addClass('small');
          } else {
            $('.navbar').removeClass('small');
          }
        });
        scrollBanner();
      }
    }
  });
</script>
