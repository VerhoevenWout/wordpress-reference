<?php
global $muller;

// Template name: Contact

/*
    Variables to load {
        WP / page
        \muller\menushelper / getBreadcrumb / breadcrumb 
    }
*/

get_header(); 
?>


        <header class='row'>
            <div class='columns small-12 breadcrumb'>
                <?= $muller->breadcrumb;?>
            </div>
        </header>
        <div class="row">
            <main class='columns small-12'>
                <div class="wysiwyg">
                    <div class="row contact">
                        <div class="columns small-12 medium-6">
                         <?= apply_filters("the_content", $muller->WP['page']->post_content); ?>

                        </div>
                        <div class="map columns small-12 medium-6">
                            <div id="map"></div>
                            <script>
                                  function initMap() {

                                    var myLatLng = {lat: 51.389623, lng: 4.735071};
                                    // Styles a map in night mode.
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                       center: myLatLng,
                                      zoom: 12,
                                      styles: [
                                        {
                                    "featureType": "administrative",
                                    "elementType": "all",
                                    "stylers": [
                                        {
                                            "visibility": "simplified"
                                        },
                                        {
                                            "gamma": "1.00"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "administrative.locality",
                                    "elementType": "labels",
                                    "stylers": [
                                        {
                                            "color": "#ba5858"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "administrative.neighborhood",
                                    "elementType": "labels",
                                    "stylers": [
                                        {
                                            "color": "#e57878"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "landscape",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "visibility": "simplified"
                                        },
                                        {
                                            "lightness": "65"
                                        },
                                        {
                                            "saturation": "-100"
                                        },
                                        {
                                            "hue": "#ff0000"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "poi",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "visibility": "simplified"
                                        },
                                        {
                                            "saturation": "-100"
                                        },
                                        {
                                            "lightness": "80"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "poi",
                                    "elementType": "labels",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "poi.attraction",
                                    "elementType": "labels",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "visibility": "simplified"
                                        },
                                        {
                                            "color": "#dddddd"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "geometry.fill",
                                    "stylers": [
                                        {
                                            "lightness": "-46"
                                        },
                                        {
                                            "color": "#ff0000"
                                        },
                                        {
                                            "saturation": "-72"
                                        },
                                        {
                                            "gamma": "2.63"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "labels",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.highway.controlled_access",
                                    "elementType": "labels",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.arterial",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "visibility": "simplified"
                                        },
                                        {
                                            "color": "#dddddd"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.arterial",
                                    "elementType": "labels",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.local",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "visibility": "simplified"
                                        },
                                        {
                                            "color": "#eeeeee"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "road.local",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                        {
                                            "color": "#ba5858"
                                        },
                                        {
                                            "saturation": "-100"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "transit.station",
                                    "elementType": "all",
                                    "stylers": [
                                        {
                                            "visibility": "off"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "transit.station",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                        {
                                            "color": "#ba5858"
                                        },
                                        {
                                            "visibility": "simplified"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "transit.station",
                                    "elementType": "labels.icon",
                                    "stylers": [
                                        {
                                            "hue": "#ff0036"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "water",
                                    "elementType": "geometry",
                                    "stylers": [
                                        {
                                            "visibility": "simplified"
                                        },
                                        {
                                            "color": "#dddddd"
                                        }
                                    ]
                                },
                                {
                                    "featureType": "water",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                        {
                                            "color": "#ba5858"
                                        }
                                    ]
                                }
                                      ]
                                    });
                                    
                                    var marker = new google.maps.Marker({
                                      position: myLatLng,
                                      map: map,
                                      icon: '/wp-content/themes/muller/dist/img/icon.png'
                                    });

                                  }
                              
                            </script>

                            </div>
                        </div>
                </div>
            </main>
        </div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpu6k4cEnOpK-L5xIMlkjLvozrPvhhrzI&callback=initMap" async defer></script>

<?php 
get_footer(); 
?>