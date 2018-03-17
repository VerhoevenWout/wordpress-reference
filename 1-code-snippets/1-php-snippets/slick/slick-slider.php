<style>
	.banner-carousel{
		position: relative;
		z-index: 1;
		height: 500px;
		img{
			object-fit: cover;
			max-height: 500px;
		}
	}
</style>

<div class="banner-carousel">
	<?php
	$images = get_field('banner_carousel_gallery');
	if( $images ): ?>
		<?php foreach( $images as $image ): ?>
	      <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
		<?php endforeach; ?>
	<?php endif; ?>

</div>

<script>
	(function(){
		'use strict';
	$( document ).ready(function() {
		// --------------------------------------------------------------------
		// SLICK
		$('.banner-carousel').slick({
			autoplay: true,
			autoplaySpeed: 7000,
			draggable: false,
		    arrows: false,
		    dots: false,
		    fade: true,
		    speed: 900,
		    infinite: true,
		    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
		    touchThreshold: 100,
		});
		$('.testimonials-carousel').slick({
			autoplay: true,
			autoplaySpeed: 3000,
			draggable: true,
		    arrows: false,
		    dots: true,
		    fade: false,
		    speed: 900,
		    infinite: true,
		    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
		    touchThreshold: 100,
		    slidesToShow: 1,
		    slidesToScroll: 1,
		});
		$('.stories-carousel').slick({
			autoplay: true,
			autoplaySpeed: 3000,
			draggable: true,
		    arrows: true,
		    dots: true,
		    fade: false,
		    speed: 900,
		    infinite: true,
		    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
		    touchThreshold: 100,
		    slidesToShow: 2,
		    slidesToScroll: 2,
		    responsive: [
		    {
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
				}
			},
		    {
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			},
		    {
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			},
			]
		});
	    
	});

	})(); // END OF USE STRICT FUNCTION
</script>