<style>
	/******************************************************************************
	* * * * * 								   		 #Translate Menu      					 		  * * * * *
	******************************************************************************/
	.flag-menu{
		position: absolute;
    right: 10px;
	}
	@media screen and (max-width: 765px) {
		.flag-menu{
			right: 65px;
	    top: 0px;
		}
	}
	.skiptranslate.goog-te-gadget {
	display: none !important;
	}
	.translation-links {
	position: absolute;
	display: inline-block;
	top: 40px;
	right: 10px;
  text-align: right;
	}
	.translation-links img {
	width: 26px;
	height: auto;
	}
	.translation-links .sub-menu li {
	display: inline-block;
	}
	.translation-links .sub-menu li a {
	padding: 0 0 0 5px;
	}
	.translation-links > li.menu-item-has-children {
	background-size: 5px 5px;
	-webkit-transition: background-size 0.15s ease-in-out;
		 -moz-transition: background-size 0.15s ease-in-out;
					transition: background-size 0.15s ease-in-out;
	}
	.translation-links > li.menu-item-has-children.hover {
	background: url('../images/menu-triangle.png') no-repeat;
	background-position: 108% 100%;
	background-size: 19px 10px;
	}
	.translation-links > li.menu-item-has-children .sub-menu {
	display: block;
  position: absolute;
  top: 20px;
  /* background: white; */
  width: 265px;
  padding: 10px 0 0 0;
  right: 0;
  z-index: 900;
	}

	.main-menu-mobile .translation-links {
	margin-top: 10px;
	margin-bottom: 5px;
	}
	.main-menu-mobile .translation-links img {
	width: 40px;
	height: auto;
	border: 1px solid white;
	}
	.main-menu-mobile .translation-links li {
	display: inline-block;
	}
	.main-menu-mobile .translation-links li a {
  padding: 0 5px 0 0;
	}
  /*Revome Google translation message*/
	.skiptranslate{
		position: absolute;
		display: none;
	}
</style>

<div class="flag-menu">
	<div id="google_translate_element"><div class="skiptranslate goog-te-gadget" dir="ltr"><div id=":0.targetLanguage" class="goog-te-gadget-simple" style="white-space: nowrap;"><img src="https://www.google.com/images/cleardot.gif" class="goog-te-gadget-icon" alt="" style="background-image: url(&quot;https://translate.googleapis.com/translate_static/img/te_ctrl3.gif&quot;); background-position: -65px 0px;" scale="0"><span style="vertical-align: middle;"><a aria-haspopup="true" class="goog-te-menu-value" href="javascript:void(0)"><span>Select Language</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1" scale="0"><span style="border-left: 1px solid rgb(187, 187, 187);">​</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1" scale="0"><span aria-hidden="true" style="color: rgb(118, 118, 118);">▼</span></a></span></div></div></div>
	<script type="text/javascript">
		function googleTranslateElementInit() {
		  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,fr,es,pa', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
		}
	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

  <ul class="translation-links">
    <li class="menu-item-has-children">
      <a href="#" id=":2.restore" title="English" class="english" data-lang="English">
        <img src="<?php echo get_bloginfo('template_url') ?>/assets/img/flag-uk.png" width="33" height="22" scale="0">
      </a>
      <ul class="sub-menu" style="display: none;">
        <li>
          <a href="#" title="Translate into French" class="french" data-lang="French">
            <img src="<?php echo get_bloginfo('template_url') ?>/assets/img/flag-france.png" width="33" height="22" scale="0">
          </a>
        </li>
        <li>
          <a href="#" title="Translate into Spanish" class="spanish" data-lang="Spanish">
            <img src="<?php echo get_bloginfo('template_url') ?>/assets/img/flag-spain.png" width="33" height="22" scale="0">
          </a>
        </li>
        <li>
          <a href="#" title="Translate into Punjabi" class="punjabi" data-lang="Punjabi">
            <img src="<?php echo get_bloginfo('template_url') ?>/assets/img/flag-punjab.png" width="33" height="22" scale="0">
          </a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<script>
  jQuery('.translation-links a').click(function() {
    var lang = jQuery(this).data('lang');
    var $frame = jQuery('.goog-te-menu-frame:first');
    /*if (!$frame.size()) {
    //alert("Error: Could not find Google translate frame.");
    return false;
    }*/
    $frame.contents().find('.goog-te-menu2-item span.text:contains('+lang+')').get(0).click();
    return false;
  });

  // fire onload trigger on IMG tags that have empty SRC attribute, for the flags, logo and search icon.
  var images = jQuery('img:not([src=""])');
  images.each(function(i) {
    jQuery(this).trigger('onload');
  });

  // $('ul.translation-links > li.menu-item-has-children .sub-menu').hide();
  $('.translation-links ').hover(function() {
    console.log('hover');
    $('.sub-menu').fadeIn();
    $(this).addClass('hover');
  }, function() {
    $('.sub-menu').fadeOut();
    $(this).removeClass('hover');
  });
</script>
