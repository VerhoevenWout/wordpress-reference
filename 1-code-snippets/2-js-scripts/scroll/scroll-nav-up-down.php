<style>
	.nav-up {
	  transform: translateY(-60px);
	}
</style>

<nav class="row expanded">
	<div class="columns sm-12">
		<img src="<?= get_bloginfo('template_url') ?>/dist/img/logo-2.png ?>">
		<?php wp_nav_menu( array('menu' => 'main-menu')); ?>
		<div class="button-container">
			<a href="/aanvraag" class="button primary">Aanvraag</a>
			<a href="/doneer" class="button secondary">Doneer</a>
		</div>

		<button class="hamburger hamburger--squeeze" type="button">
		  <span class="hamburger-box">
		    <span class="hamburger-inner"></span>
		  </span>
		</button>
	</div>
</nav>

<script>
	// --------------------------------------------------------------------
	// SCROLL NAV UP DOWN
	var didScroll;
	var lastScrollTop = 0;
	var delta = 5;
	var navbarHeight = $('nav').outerHeight();
	$(window).scroll(function(event){
	    didScroll = true;
	});
	setInterval(function() {
	    if (didScroll) {
	      hasScrolled();
	      didScroll = false;
	    }
	}, 250);
	function hasScrolled() {
	    var st = $(this).scrollTop();
	    // Make sure they scroll more than delta
	    if(Math.abs(lastScrollTop - st) <= delta)
	        return;
	    if (st > lastScrollTop && st > navbarHeight){
			// Scroll Down
			$('.hamburger').removeClass('is-active');
			$('nav ul').removeClass('main-menu-expand');
			$('nav').removeClass('nav-down').addClass('nav-up');
	    } else {
			// Scroll Up
			if(st + $(window).height() < $(document).height()) {
				$('nav').removeClass('nav-up').addClass('nav-down');
			}
	    }
    	lastScrollTop = st;
	}
</script>