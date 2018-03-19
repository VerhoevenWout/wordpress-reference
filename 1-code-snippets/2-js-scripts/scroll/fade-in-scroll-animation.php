<style>
	.inner-animation{
		transition: all .8s;
		&.not-visible{
			opacity: 0;
			transform: translateY(3em);
		}
	}
</style>

<div class="row">
	<div class="inner-animation not-visible">
		<!-- code -->
	</div>
</div>

<script>
	// --------------------------------------------------------------------
	// FADE IN SCROLL ANIMATION
	$(window).on('beforeunload', function(){
	  $(window).scrollTop(0);
	});
	revealElement();
	$(window).scroll(function () {
	   revealElement();
	});
	function revealElement(){
	  $('.inner-animation').each(function () {
	     if (isScrolledIntoView(this) === true) {
	         $(this).removeClass('not-visible');
	     }
	  });
	}
	function isScrolledIntoView(elem) {
	    var docViewTop = $(window).scrollTop();
	    var docViewBottom = docViewTop + $(window).height();

	    var elemTop = $(elem).offset().top;
	    // var elemBottom = elemTop + $(elem).height();
	    var elemBottom = $(elem).offset().top+200;

	    // return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	}
</script>