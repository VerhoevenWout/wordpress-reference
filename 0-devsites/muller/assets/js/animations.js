var $ = require('jquery');
var objectFitImages = require('object-fit-images');




$(document).ready(function() {
	//Detect ie 
	var ua = window.navigator.userAgent;

	var trident = ua.indexOf('Trident/');
	  if (trident > 0) {
	    // IE 11 => return version number
	    var rv = ua.indexOf('rv:');
	    $('body').addClass('ie11');
	  }
	//objectFitImages
	
	var $homeimages = $('body.page-template-tpl-home main picture img, body.page-template-tpl-blokken main picture img, body.page-template-tpl-blokken main img, body.nieuws-template-default main picture img');
	objectFitImages($homeimages);

	var $relatedimages = $('.related ul li ul li a .rect .container img');
	objectFitImages($relatedimages);

	$(window).scroll(function() {
	    if ($(this).scrollTop() >= 200) {
	        $('body').addClass('return-to-top-show');
	    } else {
	        $('body').removeClass('return-to-top-show');
	    }
	});
	$('#return-to-top').click(function() {
	    $('body,html').animate({
	        scrollTop : 0
	    }, 500);
	});

	function getCookie(cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');

	    for (var i=0; i < ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1);
	        if (c.indexOf(name) === 0) return c.substring(name.length,c.length);
	    }

	    return false;
	}
	function setCookie(cname, cvalue) {
		var d = new Date();
	    d.setTime(d.getTime() + (9000*24*60*60*1000));
	    var expires = "expires="+d.toUTCString();
	    
	    document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/;secure;";  //secure werkt enkel over https 
	}
	$('#cookie-close').click(function() {
		$('#cookie-banner').hide('fast');
		setCookie('visited', 'yes');
	});
});