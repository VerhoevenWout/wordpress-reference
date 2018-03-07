// OLD SEOPAGES

var $ = jQuery.noConflict();

var VueResource = require('vue-resource');

import Vue from 'vue/dist/vue.js';
import { EventBus } from './helper/event.js';
import Fiche from './components/fiche.vue';
import Selectedfiche from './components/selected-fiche.vue';
import Slick from 'vue-slick';
import * as VueGoogleMaps from 'vue2-google-maps'
import mapsstyle from './data/map-style.json';
import jQuery from 'jQuery';
// import md5 from 'md5';
// import generaltranslations from './data/general-translations.json';

import VueCarousel from 'vue-carousel';
import { Carousel, Slide } from 'vue-carousel';

require("babel-polyfill");
var Promise = require('es6-promise').Promise;

Vue.use(VueResource);

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAlu17PuCOggAb8q65PiJ2RhOkIwEzUxto',
    libraries: 'places',
    language: 'nl',
  }
});
Vue.component('gmap-autocomplete', VueGoogleMaps.Autocomplete);
Vue.component('google-map', VueGoogleMaps.Map);   

// TURN OFF VUE DEVELOPMENT MODE
Vue.config.devtools = true;   

new Vue({
    
	el: '.page-wrap',

	components: {
		Fiche,
		Selectedfiche,
		Slick
	},

	data() {
		return{
			fiches: null,
			fichescount: 0,

			paginatedfiches: null,
			pagination: null,
			pageindex: 0,
			pageindexmin: 0,
			pageindexmax: 0,

			isactive: false,
			mapsstyle: mapsstyle,
			currentpage: 0,
			postsperpage: 6,
			mapcenter: {
				lat: 50.8503396,
				lng: 4.351710300000036,
				zoom: 12
			},
	    	favarray: [],
            seopages: [],
			loading: true,
			isfavouritespage: false,
			translations: null,

			search: null,

			ipaddress: '127.0.0.1',
			lang: null,
			search: null,
		}
	}, 

	created(){
		// this.readfavourite();
		this.setLang();
		this.checkurl();
		this.getipaddress();
		this.setfichesbyseopage();
	},

	mounted() {
		VueGoogleMaps.loaded.then(() => {
			this.mapoptions1 = {
				mapTypeControl: false,
				zoomControl: false,
				zoomControl: false,
				streetViewControl: false,
				styles: mapsstyle,
				gestureHandling: 'greedy',
				fullscreenControl: true,
				fullscreenControlOptions: {
					position: google.maps.ControlPosition.RIGHT_BOTTOM
				}
			}
			this.mapoptions2 = {
				mapTypeControl: false,
				zoomControl: false,
				zoomControl: false,
				streetViewControl: false,
				styles: mapsstyle,
				fullscreenControl: true,
				fullscreenControlOptions: {
					position: google.maps.ControlPosition.RIGHT_BOTTOM
				}
			}
		});
		
		EventBus.$on('favourite', this.favourite);
		EventBus.$on('readfavourite', this.readfavourite);
		// EventBus.$on('requestofferpopup', this.requestofferpopup);
		EventBus.$on('handleRememberMe', this.handleRememberMe);
		EventBus.$on('clickofferpopup', this.clickofferpopup);
		EventBus.$on('togglemarker', this.togglemarker);
		EventBus.$on('disableloading', this.disableloading);

		EventBus.$on('getAddressDataError', this.getAddressDataError);
	},

	methods: {
		getAddressDataError(bool){
			this.getAddressDataError == bool;
		},
		clickDocument(){
			EventBus.$emit('clickDocument');
		},
		
		// submitSearchName(){
		// 	var searchArr = new Array();
		// 	if (this.search == null){
		// 		console.log('submitSearchName error1');
		// 		$('.venue-search input').addClass('venue-search-expand');
		// 		$('.venue-search input').focus();
		// 		return;
		// 	}
  //     		searchArr = this.search.split(" ");
		// 	if (this.search == null){
		// 		console.log('submitSearchName error2');
		// 		$('.venue-search input').addClass('venue-search-expand');
		// 		$('.venue-search input').focus();
		// 		return;
		// 	}
		// 	$('.venue-search input').removeClass('venue-search-expand');
		// 	$('.full-main-menu-container').removeClass('menu-is-active');

		// 	localStorage.setItem('searchName', this.search);

		// 	window.location = '/';
		// },

		setLang(){
			var urlpath = window.location.pathname.split('/');
			this.lang = urlpath[1];
		},
		setsinglemarkerlatlng(latlngvalues){
			this.singlelat = latlngvalues.lat + 20;
			this.singlelng = latlngvalues.lng;
		},
		checkurl(){
			if (window.location.search.indexOf('venue') > -1) {
				var venue = this.getParameterByName('venue');
		    	venue = venue.replace('=true','');
				var urlstring = window.location.href.split('?')[0];
		    	urlstring = urlstring.replace('mijn-favorieten/','');
				window.location.href = urlstring + '/venues/' + venue;
			}
			this.eraseCookie('vo-404-data');
	    },
	    getParameterByName(name) {
		    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
		    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
		},

		favourite(post){
			this.favarray = [];
			this.readfavourite();
			this.favarray.push(post);
			this.createCookie('vo-fav', JSON.stringify(this.favarray), 20);
	    },
		readfavourite(){
			if (this.readCookie('vo-fav')) {
				var favcookie = this.readCookie('vo-fav');
				var favcookiedata = JSON.parse(favcookie);
				this.favarray = favcookiedata;
				
				this.setfichesbyseopage();
			
			} else{
				this.disableloading();
			}
		},
		readCookie(name){
		    var nameEQ = name + "=";
		    var ca = document.cookie.split(';');
		    for(var i=0;i < ca.length;i++) {
		        var c = ca[i];
		        while (c.charAt(0)==' ') c = c.substring(1,c.length);
		        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		    }
		    return null;
		},
		createCookie(name,value,days){
		    var expires = "";
		    if (days) {
		        var date = new Date();
		        date.setTime(date.getTime() + (days*24*60*60*1000));
		        expires = "; expires=" + date.toUTCString();
		    }
		    document.cookie = name + "=" + value + expires + "; path=/";
		    // document.cookie = name + "=" + value + expires;
		},
		eraseCookie(name){
		    this.createCookie(name,"",-1);
		},

		openmarker(marker){
			for (var key in this.fiches){
				this.fiches[key].markeropen = false;
			}
			marker.markeropen = marker.markeropen ? false :true;
		},

		// SETFICHES
		setfichesbyseopage(){
			var seopageid = null;
			var currenturl = window.location.href;
			var formData = new FormData();
			formData.append('action', 'get_fiches_by_seopages');
			formData.append('url', currenturl);
			formData.append('language', this.lang);
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body =! null){
					this.fiches = JSON.parse(response.bodyText);
					var hostroot = location.protocol + '//' + location.host;

					this.setMarkers();
					this.calculateMapCenter();

					this.disableloading();
				} else{
					// NO FICHES
					this.disableloading();
				}
	        });
		},

	    calculateMapCenter(){
			var latsLngsArr = [];
			for (var key in this.fiches){
				latsLngsArr.push([ this.fiches[key].lat, this.fiches[key].lng ]);
			}

			var latMin = Math.min.apply(null, latsLngsArr.map(function (e) { return e[0]}));
        	var latMax = Math.max.apply(null, latsLngsArr.map(function (e) { return e[0]}));
        	var lngMin = Math.min.apply(null, latsLngsArr.map(function (e) { return e[1]}));
        	var lngMax = Math.max.apply(null, latsLngsArr.map(function (e) { return e[1]}));

			var zoomLevel = null;
			var latDiff = latMax - latMin;
			var lngDiff = lngMax - lngMin;
			var maxDiff = (lngDiff > latDiff) ? lngDiff : latDiff;
			if (maxDiff < 360 / Math.pow(2, 20)) {
			    zoomLevel = 12;
			} else {
			    zoomLevel = -1*( (Math.log(maxDiff)/Math.log(2)) - (Math.log(360)/Math.log(2)) );
			    zoomLevel = Math.ceil(zoomLevel);
			    if (zoomLevel < 1)
			        zoomLevel = 1;
			}

			this.mapcenter.zoom = zoomLevel;

			var averageLatLng = this.getLatLngCenter(latsLngsArr);
			this.centermap(averageLatLng);
		},
		rad2degr(rad) { return rad * 180 / Math.PI; },
		degr2rad(degr) { return degr * Math.PI / 180; },
		// pairs in degrees. e.g. [[latitude1, longtitude1], [latitude2, ...
		// return array with the center latitude longtitude pairs in degrees.
		getLatLngCenter(latLngInDegr) {
		    var LATIDX = 0;
		    var LNGIDX = 1;
		    var sumX = 0;
		    var sumY = 0;
		    var sumZ = 0;

		    for (var i=0; i<latLngInDegr.length; i++) {
		        var lat = this.degr2rad(latLngInDegr[i][LATIDX]);
		        var lng = this.degr2rad(latLngInDegr[i][LNGIDX]);
		        // sum of cartesian coordinates
		        sumX += Math.cos(lat) * Math.cos(lng);
		        sumY += Math.cos(lat) * Math.sin(lng);
		        sumZ += Math.sin(lat);
		    }
		    var avgX = sumX / latLngInDegr.length;
		    var avgY = sumY / latLngInDegr.length;
		    var avgZ = sumZ / latLngInDegr.length;
		    // convert average x, y, z coordinate to latitude and longtitude
		    var lng = Math.atan2(avgY, avgX);
		    var hyp = Math.sqrt(avgX * avgX + avgY * avgY);
		    var lat = Math.atan2(avgZ, hyp);

		    return ([this.rad2degr(lat), this.rad2degr(lng)]);
		},
		centermap(averageLatLng){
			this.mapcenter.lat = averageLatLng[0];
			this.mapcenter.lng = averageLatLng[1];
		},

		getposition(lt, lg){
			lt = parseFloat(lt);
			lg = parseFloat(lg);

			var pos = {lat: lt, lng: lg};
			
			return pos;
		},
		
		enableloading(){
			this.loading = true;
		},
		disableloading(){
			// console.log('disable loading');
			this.loading = false;
		},

		handleRememberMe(cookiedata){
			cookiedata = decodeURIComponent(cookiedata);
			cookiedata = JSON.parse(cookiedata);
			if(this.lang == 'fr'){
				var formCode = '6';
			} else if(this.lang == 'en'){
				var formCode = '7';
			} else{
				var formCode = '1';
			}

			$('#input_'+formCode+'_2').val(cookiedata.name);
			$('#input_'+formCode+'_4').val(cookiedata.company);
			$('#input_'+formCode+'_5').val(cookiedata.phone);
			$('#input_'+formCode+'_6').val(cookiedata.email);
			$('#input_'+formCode+'_8').val(cookiedata.persons);
			$('#input_'+formCode+'_9_2').val(cookiedata.date[0]);
			$('#input_'+formCode+'_9_1').val(cookiedata.date[1]);
			$('#input_'+formCode+'_9_3').val(cookiedata.date[2]);
			// $('#input_'+formCode+'_15').val(cookiedata.would_like);
			// $('#input_'+formCode+'_15').val(cookiedata.looking_for);

		},
		clickofferpopup(post_id, title){
			this.offertitle = title;
			$('.offerpopup').addClass('popup-container-enable');
			if(this.lang == 'fr'){
				var formCode = '6';
			} else if(this.lang == 'en'){
				var formCode = '7';
			} else{
				var formCode = '1';
			}
			$('#input_'+formCode+'_15').val(post_id);
		},

		getipaddress(){
			this.$http.get('//freegeoip.net/json/?').then(response => {
				var ipaddress = response.body.ip;
				console.log(ipaddress);
				this.ipaddress = ipaddress;
				localStorage.setItem("ipaddress", ipaddress);
			}, response => {
				console.log(response);
			});
		},

        setMarkers(){
        	var hostroot = location.protocol + '//' + location.host;
        	var normalMarkerUrl = hostroot + '/wp-content/themes/venues-online/dist/img/single-logo-marker.png';

    		for (var key in this.fiches){
    			Vue.set(this.fiches[key], 'markerurl', normalMarkerUrl );
				Vue.set(this.fiches[key], 'markerzindex', 1 );
    			Vue.set(this.fiches[key], 'markeropen', false );

        		var fichedata = JSON.parse(this.fiches[key].json_nl);
        		if (fichedata.imageArray != null){
    				Vue.set(this.fiches[key], 'markerimage', fichedata.imageArray[0] );
        		}
    			Vue.set(this.fiches[key], 'markertext', fichedata.short_title );
    		}
        },

        togglemarker(id, settoactive){
    		var hostroot = location.protocol + '//' + location.host;
    		var activeMarkerUrl = hostroot + '/wp-content/themes/venues-online/dist/img/single-logo-marker-active.png';
    		var normalMarkerUrl = hostroot + '/wp-content/themes/venues-online/dist/img/single-logo-marker.png';

        	for(var key in this.fiches){
        		if (this.fiches[key].id_nl == id) {
        			if (settoactive == true) {
    					Vue.set(this.fiches[key], 'markerurl', activeMarkerUrl );
						Vue.set(this.fiches[key], 'markerzindex', 5 );
        			} else{
        				this.fiches[key].markerurl = normalMarkerUrl;
						Vue.set(this.fiches[key], 'markerzindex', 1 );
        			}
        		}
        	}
        },
	}
	
});