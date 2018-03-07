var $ = jQuery.noConflict();

var VueResource = require('vue-resource');

import Vue from 'vue/dist/vue.js';
import { EventBus } from './helper/event.js';
import Search from './components/search.vue';
import Fiche from './components/fiche.vue';
import Selectedfiche from './components/selected-fiche.vue';
import Slick from 'vue-slick';
import * as VueGoogleMaps from 'vue2-google-maps'
import mapsstyle from './data/map-style.json';
import jQuery from 'jQuery';

// For lightbox
import VueImg from 'v-img';
Vue.use(VueImg);

require("babel-polyfill");
var Promise = require('es6-promise').Promise;

var SocialSharing = require('vue-social-sharing');
Vue.use(SocialSharing);
Vue.use(VueResource);


var urlpath = window.location.pathname.split('/');
var lang = urlpath[1];
if (lang == 'fr'){
	Vue.use(VueGoogleMaps, {
	  load: {
	    key: 'AIzaSyAlu17PuCOggAb8q65PiJ2RhOkIwEzUxto',
	    libraries: 'places',
	    language: 'fr',
	  }
	});
	Vue.component('gmap-autocomplete', VueGoogleMaps.Autocomplete);
	Vue.component('google-map', VueGoogleMaps.Map);
} else if(lang == 'en'){
	Vue.use(VueGoogleMaps, {
	  load: {
	    key: 'AIzaSyAlu17PuCOggAb8q65PiJ2RhOkIwEzUxto',
	    libraries: 'places',
	    language: 'en',
	  }
	});
	Vue.component('gmap-autocomplete', VueGoogleMaps.Autocomplete);
	Vue.component('google-map', VueGoogleMaps.Map);
}else{
	Vue.use(VueGoogleMaps, {
	  load: {
	    key: 'AIzaSyAlu17PuCOggAb8q65PiJ2RhOkIwEzUxto',
	    libraries: 'places',
	    language: 'nl',
	  }
	});
	Vue.component('gmap-autocomplete', VueGoogleMaps.Autocomplete);
	Vue.component('google-map', VueGoogleMaps.Map);
}

// TURN OFF VUE DEVELOPMENT MODE
Vue.config.devtools = true;

new Vue({

	el: '.page-wrap',

	components: {
		Search,
		Fiche,
		Selectedfiche,
		Slick,
	},

	data() {
		return{
			mapoptions: {},
			fiches: null,
			filterdata: {},
			fichescount: 0,

			resulttext: null,
			
			pagination: null,
			pageindex: 0,
			pageindexmin: 0,
			pageindexmax: 0,
			postsperpage: 24,

			isactive: false,
			mapsstyle: mapsstyle,
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
			singlelat: null,
			singlelng: null,

			ipaddress: '127.0.0.1',
			lang: null,
			newSeoLinks: null,

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
            getAddressDataError: null,
            externalLinkUrl: null
		}
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
		this.setLang();
		this.checkurl();
		this.getipaddress();

		this.getExternalLinkData();

		EventBus.$on('getfichecount', this.getfichecount);
		EventBus.$on('setfiches', this.setfiches);
		EventBus.$on('gotopage', this.gotopage);
		EventBus.$on('setseopages', this.setseopages);
		EventBus.$on('favourite', this.favourite);
		EventBus.$on('readfavourite', this.readfavourite);

		EventBus.$on('enableloading', this.enableloading);
		EventBus.$on('disableloading', this.disableloading);
		EventBus.$on('handleRememberMe', this.handleRememberMe);
		EventBus.$on('clickofferpopup', this.clickofferpopup);

		EventBus.$on('togglemarker', this.togglemarker);
		EventBus.$on('setsinglemarkerlatlng', this.setsinglemarkerlatlng);
	},

	methods: {
		clickDocument(){
			EventBus.$emit('clickDocument');
		},

		checkurl(){
			// checkSubmitName
			if (localStorage.getItem('searchName') != null){
				this.eraseCookie('vo-404-data');

		        var formData = new FormData();
				formData.append('action', 'get_event_fiches_by_name');
				formData.append('lang', this.lang);
				formData.append('search', localStorage.getItem('searchName'));

				this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
					if (response.body) {
						console.log('search.js/checkurl response');
						this.setfiches(response.body, this.filterdata, this.locatie, this.taxs);
						this.search = null;
						localStorage.removeItem('searchName');
						this.disableloading();
						return;
					} else{
						console.log('search.js/checkurl error');
						this.disableloading();
					}
		        });
			} else{
				if (window.location.search.indexOf('venue') > -1) {
			    	var venue = this.getParameterByName('venue');
			    	venue = venue.replace('=true','');
					var urlstring = window.location.href.split('?')[0];
					window.location.href = urlstring + '/venues/' + venue;
				}
				var data404 = this.readCookie('vo-404-data');
				$('body').hasClass('new-seo-page')
				if(data404 == null && !$('body').hasClass('new-seo-page')){
					// this.checkSubmitName();
					this.disableloading();
				}
			}

	    },
		getParameterByName(name) {
		    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
		    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
		},
		submitSearchName(){
			var searchArr = new Array();
			if (this.search == null){
				console.log('submitSearchName error1');
				$('.venue-search input').addClass('venue-search-expand');
				$('.venue-search input').focus();
				return;
			}
      		searchArr = this.search.split(" ");
			if (this.search == null){
				console.log('submitSearchName error2');
				$('.venue-search input').addClass('venue-search-expand');
				$('.venue-search input').focus();
				return;
			}
			$('.venue-search input').removeClass('venue-search-expand');
			$('.full-main-menu-container').removeClass('menu-is-active');

			localStorage.setItem('searchName', this.search);

			window.location = '/';
		},
		// checkSubmitName(){
			
		// },

		setspoofurl(){
			var urlstring = window.location.origin + '/'+this.lang;
	    	history.replaceState(null, null, urlstring);
			var filterdata = {
				searchdata: this.filterdata,
				location: this.locatie,
			}
			var hash = md5(JSON.stringify(filterdata));

			var formData = new FormData();
			formData.append('action', 'post_hash_data');
			formData.append('hash', hash);
			formData.append('filterdata', JSON.stringify(filterdata));
			formData.append('type', '"searchresult"');

			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body){
					history.replaceState(null, null, urlstring+'/'+hash);
					this.createCookie('vo-404-data', hash, 20);
				} else{
					console.log('setspoofurl() response failed');
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
			for (var key in this.fiches){
				this.fiches[key].markeropen = false;
			}
			marker.markeropen = marker.markeropen ? false :true;
		},


		buildNewSeoLinks(filterdata, locatie, taxs){
			var lang 					= this.lang;
			var seo_page_activity 		= filterdata.taxs.activiteit;
			var seo_page_city 			= locatie;
			var seo_page_type_location 	= JSON.parse(JSON.stringify(filterdata.taxs.type_locatie));
			var taxs 					= JSON.parse(JSON.stringify(taxs));

			var newSeoLinkArr = [];
			$.each(taxs.activiteit, function(valueA, keyA) {
				$.each(taxs.type_locatie, function(valueB, keyB) {

					var activity_value 			= taxs.activiteit[valueA];
					var activity_value_name		= activity_value.name;
					activity_value				= activity_value.slug;
					// activity_value 			= activity_value.replace("/", "-");
					// activity_value 			= activity_value.replace(" ", "-");

					var type_location_value 	= taxs.type_locatie[valueB];
					var type_location_value_name= type_location_value.name;
					type_location_value 		= type_location_value.slug;
					// type_location_value 		= type_location_value.replace("/", "-");
					// type_location_value 		= type_location_value.replace(" ", "-");

			   		var newSeoTitle 			= activity_value_name+' '+seo_page_city+' '+type_location_value_name;

			   		var splitStr = newSeoTitle.toLowerCase().split(' ');
					for (var i = 0; i < splitStr.length; i++) {
						splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
					}
					newSeoTitle = splitStr.join(' '); 

					var newSeoUrl 			= '/'+lang+'/'+activity_value+'/'+seo_page_city+'/'+type_location_value;
			   		newSeoUrl 				= newSeoUrl.toLowerCase();

					var link = {title: newSeoTitle, url: newSeoUrl}
					newSeoLinkArr.push(link);
			   	});
		   	});

			this.newSeoLinks = newSeoLinkArr;
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

		setseopages(seopages){
			this.seopages = seopages;
	    },

		getposition(lt, lg){
			lt = parseFloat(lt);
			lg = parseFloat(lg);
			var pos = {lat: lt, lng: lg};
			if (lt == null) {
				var pos = {lat: 50, lng: 50};
			}
			return pos;
		},

		readfavourite(){
			if (this.readCookie('vo-fav')) {
				var favcookie = this.readCookie('vo-fav');
				var favcookiedata = JSON.parse(favcookie);
				this.favarray = favcookiedata;
				return favcookiedata;
			}
		},
		favourite(post){
			this.favarray = [];
			this.readfavourite();
			this.favarray.push(post);
			this.createCookie('vo-fav', JSON.stringify(this.favarray), 20);
	    },

	    createCookie(name,value,days){
		    var expires = "";
		    if (days) {
		        var date = new Date();
		        date.setTime(date.getTime() + (days*24*60*60*1000));
		        expires = "; expires=" + date.toUTCString();
		    }
		    document.cookie = name + "=" + value + expires + "; path=/";
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
		eraseCookie(name){
		    this.createCookie(name,"",-1);
		},

		enableloading(){
			this.loading = true;
		},
		disableloading(){
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
		},

		clickofferpopup(post_id, title){
			console.log('post_id');
			console.log(post_id);
			console.log('title');
			console.log(title);
			
			this.offertitle = title;
			$('.offerpopup').addClass('popup-container-enable');
			$('div.page-wrap').addClass('displaynoneMobile');
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
				this.ipaddress = ipaddress;
				sessionStorage.setItem("ipaddress", ipaddress);
			}, response => {});
		},

		getfichecount(filterdata){
			var formData = new FormData();
			formData.append('action', 'get_event_fiches_count');
			formData.append('language',  this.lang);
			formData.append('filterdata', JSON.stringify(filterdata));
			
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body) {
					this.fichescount = response.body;
					this.pageindexmin = 0;
					this.pageindexmax = Math.floor(this.fichescount / this.postsperpage);
					var pagination = [];
					for (var i = 0; i < response.body; i++){
						if (i !== 0 && i % this.postsperpage === 0) {
							pagination.push(i);
						}
					}

					// REMAINDER
					var remainder = this.fichescount - pagination.slice(-1)[0];
					pagination.push(remainder);
					if (remainder == 0){
						this.pagination = pagination-1;
					} else{
						this.pagination = pagination;
					}
				} else{
					this.fichescount = 0;
					console.log('getfichecount: search.vue/getfiches error');
				}
	        });
		},

		// HAPPENS ON SEARCH
		setfiches(fiches, filterdata, locatie, taxs, translations){

			this.filterdata = filterdata;
			this.isactive = true;

			//Rerender map
			Vue.$gmapDefaultResizeBus.$emit('resize');

			// console.log('setfiches');
			// console.log(fiches);
			if (fiches.length == 0){
				this.fiches = null;
				this.paginatedfiches = null;
			} else{
				this.fiches = fiches;
				this.getAddressDataError = false;
				this.fichescount = this.fiches.length;

				this.readfavourite();
				this.calculateMapCenter();
				this.disableloading();
				this.setMarkers();
				return;
			}

			if (filterdata.lat == null){
				this.getAddressDataError = true;
			}

			// If url is the same, go to the previous selected page
			var sessionStorageUrl = sessionStorage.getItem('url');

			if (localStorage.getItem('searchName') == null){
				if (sessionStorageUrl == window.location.href) {
					this.currentpage = parseInt(sessionStorage.getItem('page'));
					// this.paginatefiches(fiches);

					this.gotopage(this.currentpage);
				} else{
					this.currentpage = 0;
					// this.paginatefiches(fiches, 0, this.currentpage);
					this.gotopage(this.currentpage);
				}
			}

			this.readfavourite();
			// Can forward translations for seo-pages??
			if (filterdata.activiteit && locatie && taxs){
				this.buildNewSeoLinks(filterdata, locatie, taxs);
			}
		},

		gotopage(page){
			EventBus.$emit('clearImages');
	   		$("html, body").animate({ scrollTop: 0}, "slow");
			var oldpage = this.pageindex;
			this.pageindex = page;
			sessionStorage.setItem('url', window.location.href);
			sessionStorage.setItem('page', page);

			var hostroot = location.protocol + '//' + location.host;

			var formData = new FormData();
			formData.append('action', 'get_event_fiches');
			formData.append('language', this.lang);
			formData.append('filterdata', JSON.stringify(this.filterdata));
			formData.append('old_offset', oldpage);
			formData.append('offset', page);
			formData.append('ipaddress', this.ipaddress);

			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body) {
					// reset fiches
					this.fiches = null;
					this.fiches = response.body;

					this.readfavourite();
					this.calculateMapCenter();
					this.disableloading();
					this.setMarkers();
				} else{
					console.log('gotopage: search.vue/getfiches error');
				}
	        });
		},

		paginationIndexDown(){
			if (this.pageindex > this.pageindexmin){
				this.gotopage(this.pageindex-1);
			}
	    },
	    paginationIndexUp(){
	    	if (this.pageindex <= this.pageindexmax){
				this.gotopage(this.pageindex+1);
	    	}
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

	    getExternalLinkData(){
			// this.externalLinkUrl = localStorage.getItem("external_link_url");
			// this.externalLinkPostId = localStorage.getItem("external_link_post_id");
			// this.externalLinkShortTitle = localStorage.getItem("external_link_short_title");

			var url = location.href;
			console.log(this.getUrlParameter('url'));
			this.externalLinkUrl = this.getUrlParameter('url');
			this.externalLinkPostId = this.getUrlParameter('id');
			this.externalLinkShortTitle = this.getUrlParameter('title');
	    },
	    getUrlParameter(name) {
	        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
	        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
	        var results = regex.exec(location.search);
	        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
	    },
	}
});






































































