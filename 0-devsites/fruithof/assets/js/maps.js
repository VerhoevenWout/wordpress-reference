(function($) {

	function new_map( $el ) {
		var $markers = $el.find('.marker');

		var args = {
			center		: new google.maps.LatLng(0, 0),
			mapTypeId	: google.maps.MapTypeId.ROADMAP,
			styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
		};

		var map = new google.maps.Map( $el[0], args);

		map.markers = [];

		$markers.each(function(){							
	    	add_marker( $(this), map );							
		});
		
		center_map( map );

		if (!$('body').hasClass('page-template-tpl_contact')) {
			add_rangecircle($markers, map );
		}

		return map;
	}

	function add_marker( $marker, map ) {						
		var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

		var image = {
		    url: '/wp-content/themes/fruithof/dist/img/marker.png',
		    size: new google.maps.Size(50, 69),
		    scaledSize: new google.maps.Size(50, 69),
		    origin: new google.maps.Point(0, 0),
		    anchor: new google.maps.Point(25, 69)
		  };

		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map,
			icon		: image
		});

		map.markers.push( marker );

		if( $marker.html() ) {

			var infowindow = new google.maps.InfoWindow({
				content		: $marker.html()
			});

			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open( map, marker );
			});
		}
	}

	function add_rangecircle($marker, map) {
		
		// Define the LatLng coordinates for the polygon's path.
		// See https://www.google.com/maps/d/edit?mid=170-FIGyuhIIM0NFjRder5oiSG-k&ll=51.18348558960666%2C4.447836400000028&z=14
		// volta.be@gmail.com google account
		var kernGebiedCoords = [
		  {lng: 4.423853,	lat: 51.182284},
		  {lng: 4.423727,	lat: 51.181835},
		  {lng: 4.424703,	lat: 51.177942},
		  {lng: 4.425412,	lat: 51.175173},
		  {lng: 4.425801,	lat: 51.173518},
		  {lng: 4.426055,	lat: 51.173493},
		  {lng: 4.427015,	lat: 51.173226},
		  {lng: 4.428071,	lat: 51.173168},
		  {lng: 4.431641,	lat: 51.173399},
		  {lng: 4.432963,	lat: 51.173438},
		  {lng: 4.433964,	lat: 51.173449},
		  {lng: 4.43441,	lat: 51.173446},
		  {lng: 4.435401,	lat: 51.173382},
		  {lng: 4.436205,	lat: 51.173302},
		  {lng: 4.437717,	lat: 51.172936},
		  {lng: 4.438444,	lat: 51.172843},
		  {lng: 4.439968,	lat: 51.17275},
		  {lng: 4.442073,	lat: 51.172644},
		  {lng: 4.442644,	lat: 51.172672},
		  {lng: 4.443325,	lat: 51.17274},
		  {lng: 4.444944,	lat: 51.172761},
		  {lng: 4.445427,	lat: 51.172762},
		  {lng: 4.446672,	lat: 51.172883},
		  {lng: 4.448089,	lat: 51.172916},
		  {lng: 4.448323,	lat: 51.17295},
		  {lng: 4.449469,	lat: 51.173148},
		  {lng: 4.45084,	lat: 51.173556},
		  {lng: 4.451853,	lat: 51.17396},
		  {lng: 4.453462,	lat: 51.174971},
		  {lng: 4.450171,	lat: 51.178657},
		  {lng: 4.449319,	lat: 51.179622},
		  {lng: 4.449379,	lat: 51.179725},
		  {lng: 4.448086,	lat: 51.181209},
		  {lng: 4.447852,	lat: 51.181451},
		  {lng: 4.447508,	lat: 51.181704},
		  {lng: 4.446261,	lat: 51.183114},
		  {lng: 4.445019,	lat: 51.184496},
		  {lng: 4.444256,	lat: 51.185376},
		  {lng: 4.443625,	lat: 51.186076},
		  {lng: 4.441881,	lat: 51.188033},
		  {lng: 4.440902,	lat: 51.189169},
		  {lng: 4.439369,	lat: 51.190939},
		  {lng: 4.437567,	lat: 51.192878},
		  {lng: 4.433784,	lat: 51.195637},
		  {lng: 4.43304,	lat: 51.194913},
		  {lng: 4.43163,	lat: 51.194014},
		  {lng: 4.430223,	lat: 51.1933},
		  {lng: 4.428321,	lat: 51.192562},
		  {lng: 4.42811,	lat: 51.192343},
		  {lng: 4.424501,	lat: 51.190894},
		  {lng: 4.42336,	lat: 51.190378},
		  {lng: 4.423169,	lat: 51.190165},
		  {lng: 4.423119,	lat: 51.189814},
		  {lng: 4.423171,	lat: 51.189385},
		  {lng: 4.423293,	lat: 51.188861},
		  {lng: 4.423515,	lat: 51.188138},
		  {lng: 4.424019,	lat: 51.185862},
		  {lng: 4.424336,	lat: 51.184501},
		  {lng: 4.424361,	lat: 51.183977},
		  {lng: 4.424311,	lat: 51.183531},
		  {lng: 4.423853,	lat: 51.182284}
		];

		// Construct the polygon.
		var kernGebied = new google.maps.Polygon({
		  paths: kernGebiedCoords,
		  strokeColor: '#FF0000',
		  strokeOpacity: 0.8,
		  strokeWeight: 1,
		  fillColor: '#FF0000',
		  fillOpacity: 0.05
		});

		kernGebied.setMap(map);
	}

	function center_map( map ) {
		var bounds = new google.maps.LatLngBounds();

		$.each( map.markers, function( i, marker ){

			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
			bounds.extend( latlng );

		});

		if( map.markers.length == 1 ) {
		    map.setCenter( bounds.getCenter() );
		    map.setZoom( 13 );
		} else {
			map.fitBounds( bounds );
		}
	}

	var map = null;

	$(document).ready(function(){

		$('.acf-map').each(function(){

			// create map
			map = new_map( $(this) );

		});

	});

})(jQuery);