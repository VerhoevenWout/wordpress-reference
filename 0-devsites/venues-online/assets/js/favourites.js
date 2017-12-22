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
import md5 from 'md5';
// import generaltranslations from './data/general-translations.json';

import VueCarousel from 'vue-carousel';
import { Carousel, Slide } from 'vue-carousel';

require("babel-polyfill");

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
Vue.config.devtools = false; 

new Vue({
    
	el: '.page-wrap',

	components: {
		Fiche,
		Selectedfiche,
		Slick,
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
			isfavouritespage: true,
			translations: null,

			lang: null,
			search: null,

			slickOptions: {
                dots: false,
                arrows: true,
                slidesToShow: 3,
				slidesToScroll: 3,
                responsive: [
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 764,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					}
				],
            },
		}
	},

	created(){
		this.setLang();
		this.readfavourite();
	},

	mounted() {
		this.checkurl();

		EventBus.$on('removefavourite', this.removefavourite);
		EventBus.$on('readfavourite', this.readfavourite);
		EventBus.$on('setfavourite', this.setfavourite);
		// EventBus.$on('requestofferpopup', this.requestofferpopup);
		EventBus.$on('handleRememberMe', this.handleRememberMe);
		EventBus.$on('clickofferpopup', this.clickofferpopup);
		EventBus.$on('togglemarker', this.togglemarker);
	},

	methods: {
		clickDocument(){
			EventBus.$emit('clickDocument');
		},
		
		submitSearchName(){
			// this.isactive = true;

			$('.venue-search input').removeClass('venue-search-expand');
			$('.language-menu').removeClass('hideanimation');
			$('.full-main-menu-container').removeClass('menu-is-active');

			var searchArr = new Array();
      		searchArr = this.search.split(" ");
      		// console.log(searchArr);
			if (this.search == null || searchArr.length > 1){
				console.log('empty');
				return;
			}

	        var formData = new FormData();
			formData.append('action', 'get_event_fiches_by_name');
			formData.append('lang', this.lang);
			formData.append('search', this.search);
			
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body) {
					this.setfiches(response.body, this.filterdata, this.locatie, this.taxs);
					// this.setspoofurl();
				} else{
					console.log('search.vue/getfiches error');
				}
	        });
		},
		setLang(){
			var urlpath = window.location.pathname.split('/');
			this.lang = urlpath[1];
		},
		setsinglemarkerlatlng(latlngvalues){
			this.singlelat = latlngvalues.lat + 20;
			this.singlelng = latlngvalues.lng;
		},

		openmarker(marker){
			// console.log(marker);
			for (var key in this.fiches){
				this.fiches[key].markeropen = false;
			}
			marker.markeropen = marker.markeropen ? false :true;
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

		removefavourite(post){
			// console.log('remove fav to cookie');
			var index = this.favarray.indexOf(post);
			if (index > -1) {
			    this.favarray.splice(index, 1);
			}
			this.createCookie('vo-fav', JSON.stringify(this.favarray), 20);
			this.setfichesbyfavourite();
	    },
		readfavourite(){
			if (this.readCookie('vo-shared-fav')){
				var sharedfavcookie = this.readCookie('vo-shared-fav');
				// console.log(sharedfavcookie);

				var sharedfavcookiedata = JSON.parse(sharedfavcookie);
				this.favarray = sharedfavcookiedata;
				this.setfichesbyfavourite();

			} else if (this.readCookie('vo-fav')){
				var favcookie = this.readCookie('vo-fav');
				var favcookiedata = JSON.parse(favcookie);
				this.favarray = favcookiedata;
				this.setfichesbyfavourite();
			} else{
				this.disableloading();
			}
			this.eraseCookie('vo-shared-fav');
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

		setfichesbyfavourite(){
			var formData = new FormData();
			formData.append('action', 'get_favourite_fiches');
			formData.append('favarray',  this.favarray);
			
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body =! null){
					this.fiches = JSON.parse(response.bodyText);
					
					this.calculateMapCenter();
					this.disableloading();

					this.setMarkers();
				} else{
					// NO FICHES
					this.disableloading();
				}
	        });
		},

	    setMarkers(){
	    	var hostroot = location.protocol + '//' + location.host;
	    	var normalMarkerUrl = hostroot + '/wp-content/themes/venues-online/dist/img/single-logo-marker.png';

			for (var key in this.fiches){
				Vue.set(this.fiches[key], 'markerurl', normalMarkerUrl );
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
        	for(var key in this.fiches){
        		if (this.fiches[key].id == id) {
        			if (settoactive == true) {
        				this.fiches[key].markerurl = hostroot + '/wp-content/themes/venues-online/dist/img/single-logo-marker-active.png';
        			} else{
        				this.fiches[key].markerurl = hostroot + '/wp-content/themes/venues-online/dist/img/single-logo-marker.png';
        			}
        		}
        	}
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

		sharefavourites(translations){
			var urlstring = window.location.origin;
			var favcookie = this.readCookie('vo-fav');
			var favarrayhash = md5(JSON.stringify(favcookie));
			// console.log(JSON.stringify(favcookie));
			// history.replaceState(null, null, urlstring+'/nl/'+favarrayhash);
			history.replaceState(null, null, urlstring+'/'+this.lang+'/'+favarrayhash);

			var formData = new FormData();
			formData.append('action', 'post_hash_data');
			formData.append('hash', favarrayhash);
			formData.append('filterdata', JSON.stringify(favcookie));
			formData.append('type', '"favresult"');

			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body){
					var hash_url = urlstring+'/'+this.lang+'/'+favarrayhash;
					history.replaceState(null, null, hash_url);
					var subject = translations[36];
			        var message = translations[37]+':%0D%0A'+hash_url;
			        window.location.href = "mailto:?subject="+subject+"&body="+message;
				}
	        });
		},

		copyToClipboard(text) {
		    if (window.clipboardData && window.clipboardData.setData) {
		        // IE specific code path to prevent textarea being shown while dialog is visible.
		        return clipboardData.setData("Text", text); 
		    } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
		        var textarea = document.createElement("textarea");
		        textarea.textContent = text;
		        textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in MS Edge.
		        document.body.appendChild(textarea);
		        textarea.select();
		        try {
		            return document.execCommand("copy");  // Security exception may be thrown by some browsers.
		        } catch (ex) {
		            console.warn("Copy to clipboard failed.", ex);
		            return false;
		        } finally {
		            document.body.removeChild(textarea);
		        }
		    }
		},
		handleRememberMe(cookiedata){
			cookiedata = decodeURIComponent(cookiedata);
			cookiedata = JSON.parse(cookiedata);
			// console.log(cookiedata);

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

		getfichecount(filterdata){
			var formData = new FormData();
			formData.append('action', 'get_event_fiches_count');
			formData.append('language',  this.lang);
			formData.append('filterdata', JSON.stringify(filterdata));
			
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body) {
					console.log('getfichecount');
					this.fichescount = response.body;
					this.pageindexmin = 0;
					this.pageindexmax = Math.floor(this.fichescount / this.postsperpage);
					// rest in array

					var pagination = [];
					for (var i = 0; i < response.body; i++){
						if (i !== 0 && i % this.postsperpage === 0) {
							pagination.push(i);
						}
					}

					// REMAINDER
					var remainder = this.fichescount - pagination.slice(-1)[0];
					pagination.push(remainder);
					this.pagination = pagination;
				} else{
					this.fichescount = 0;
					console.log('search.vue/getfiches error');
				}
	        });
		},
	}
});