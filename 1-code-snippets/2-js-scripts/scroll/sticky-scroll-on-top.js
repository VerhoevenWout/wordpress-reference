$(function($){
	var stickyHeader = 300;
	
	$(window).scroll(function() {
		var scroll = getCurrentScroll();
		var navBannerPos = $('.nav-banner').offset();
		
		if ( scroll >= navBannerPos.top ) {
			$('.not-ie-old .site-header').addClass('sticky');
		}
		else {
			$('.site-header').removeClass('sticky');
		}
	});
	function getCurrentScroll() {
		return window.pageYOffset || document.documentElement.scrollTop;
    }
});