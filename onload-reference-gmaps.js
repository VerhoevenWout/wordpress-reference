function on_load_functions(){
 $count = 2;
	$('.fade-in').waitForImages({
    finished:function(){$('.fade-in').css('opacity',1);},
    waitForAll:true
  });

  $( '.off-screen' ).each(function( index ) {
    if ($(this).isOnScreen()) {
      $(this).removeClass('off-screen');
    }
  });

	$('.fade-in').waitForImages({
    finished:function(){$('.fade-in').css('opacity',1);},
    waitForAll:true
  });
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
  	var offset = 60;
  	if($(window).width() < 1100){
  		offset = 70;
  	}
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top - offset
        }, 1000);
        return false;
      }
    }
  });

	if($('.twitter-carousel .tweets').length){
  	$('.twitter-carousel .tweets').slick({
  	arrows: false,
  		dots: true
  	});
	}
	if(typeof google !== 'undefined' && $(".map-contain")[0]){
		function initialize() {

		var image = '../wp-content/themes/Loop/assets/img/pin.png';
		var myLatlng = new google.maps.LatLng(44.414637, 8.947088);

		var draggable = true;
		if($(window).width() < 1100){
			draggable = false;
		}
		var zoom = 15;
		var mapOptions = {
			zoom: zoom,
			center: myLatlng,
			scrollwheel: false,
			draggable: draggable,
			styles: [{"featureType":"all","elementType":"labels","stylers":[{"lightness":63},{"hue":"#ccc"}]},{"featureType":"administrative","elementType":"all","stylers":[{"hue":"#000bff"},{"visibility":"on"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"color":"#4a4a4a"},{"visibility":"on"}]},{"featureType":"administrative","elementType":"labels.text","stylers":[{"weight":"0.01"},{"color":"#727272"},{"visibility":"on"}]},{"featureType":"administrative.country","elementType":"labels","stylers":[{"color":"#ccc"}]},{"featureType":"administrative.country","elementType":"labels.text","stylers":[{"color":"#ccc"}]},{"featureType":"administrative.province","elementType":"geometry.fill","stylers":[{"visibility":"on"}]},{"featureType":"administrative.province","elementType":"labels.text","stylers":[{"color":"#545454"}]},{"featureType":"administrative.locality","elementType":"labels.text","stylers":[{"visibility":"on"},{"color":"#737373"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text","stylers":[{"color":"#7c7c7c"},{"weight":"0.01"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text","stylers":[{"color":"#404040"}]},{"featureType":"landscape","elementType":"all","stylers":[{"lightness":16},{"hue":"#ccc"},{"saturation":-61}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"color":"#828282"},{"weight":"0.01"}]},{"featureType":"poi.government","elementType":"labels.text","stylers":[{"color":"#4c4c4c"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"hue":"#00ff91"}]},{"featureType":"poi.park","elementType":"labels.text","stylers":[{"color":"#7b7b7b"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.text","stylers":[{"color":"#999999"},{"visibility":"on"},{"weight":"0.01"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"hue":"#ccc"},{"lightness":53}]},{"featureType":"road.highway","elementType":"labels.text","stylers":[{"color":"#626262"}]},{"featureType":"transit","elementType":"labels.text","stylers":[{"color":"#676767"},{"weight":"0.01"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#0055ff"}]}]
		}
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			icon: image
		});
	}
//	google.maps.event.addDomListener(window, 'load', initialize);
		initialize();
	}
}

on_load_functions();
