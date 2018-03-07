var $ = require('jquery');
var slick = require('slick-carousel');
var enquire = require('enquire.js');

enquire.register("screen and (max-width:480px)", function(){
	$(".slick-blokken").slick({
		nextArrow: '<a class="slider-arrow right"><svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5.8 10.89"><title>Naamloos-4</title><polyline points="0.18 0.18 5.45 5.45 0.18 10.72" style="fill:none;stroke:#2e2a25;stroke-miterlimit:10;stroke-width:0.5px"/></svg></a>',
		prevArrow: '<a class="slider-arrow left" ><svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5.8 10.89"><title>Naamloos-4</title><polyline points="0.18 0.18 5.45 5.45 0.18 10.72" style="fill:none;stroke:#2e2a25;stroke-miterlimit:10;stroke-width:0.5px"/></svg></a><div class="overflow">',
		mobileFirst: true,
		slide: '.slickthis',
		responsive: [{ 
	      breakpoint: 480,
	      settings: "unslick" // destroys slick 
	    }]
	});
});

$(document).ready(function() {
	$('.open-dropdown-trigger').click(function(){
		var subBlokDataID = $(this).attr('sub-blok-data-id');
		
		$('.sub-blok-container').removeClass('show-js-element');
		$('.sub-blok-arrow').removeClass('show-js-element');

		$('.sub-blok-container-md-' + subBlokDataID).addClass('show-js-element');
		$('.sub-blok-arrow-' + subBlokDataID).addClass('show-js-element');
		$('.blokken .row .column').addClass('hide-js-element-mobile');
		$('#nav').addClass('hide-js-element-mobile');
	});

	$('.close').click(function(){
		var target = $(this).attr('target');
		$(target).removeClass('show-js-element');
		$('.blokken .row .column').removeClass('hide-js-element-mobile');

	});

});