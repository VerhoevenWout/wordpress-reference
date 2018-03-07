var $ = require('jquery');
var number = require('./modules/number.js')();
var slick = require('slick-carousel');

import Vue from 'vue/dist/vue.js'
import vMediaQuery from 'v-media-query';
import Slider from './components/slider.vue';
import Counter from './components/counter.vue';


Vue.use(vMediaQuery)


new Vue({

	el: '#single-product',

	components: {
		Slider,
		Counter
	},
	
	data() {
        return {
           count: 1,
           sliderOpen: false, 
           sliderslick: false
        };
    },

 //    watch: {
	// 	'$mq.resize': 'screenResize'
	// },

	mounted: function() {
		if(this.$mq.below('736px')){
			this.initslider();
		}

		var vm = this;
		$(window).on('resize', function(){
			if (!$('.product-slider').hasClass('slick-initialized')) {
				if($(window).width() < 736){
					vm.initslider();
				}
			}

		});
    }, 

    // product-slider slick-initialized 

    methods: {
    	initslider: function(){
    		var $carousel = $('.product-slider');
    		$(document).on('keydown', function(e) {
                if(e.keyCode == 37) {
                    $carousel.slick('slickPrev');
                }
                if(e.keyCode == 39) {
                    $carousel.slick('slickNext');
                }
            });
    		
    		this.sliderslick = $('.product-slider').slick({
    			accessibility: true,
	            nextArrow: '<a class="slider-arrow right" ><svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#231f20;stroke-miterlimit:10"/></svg></a>',
	            prevArrow: '<a class="slider-arrow left"><svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#231f20;stroke-miterlimit:10"/></svg></a>'
	        });

    		$('.product-slider').resize();
    	},
	  	openpopup: function(){
	  		$('body').addClass('openpopup');
	  	}, 
	  	openslider: function(){
	  		this.sliderOpen = true;
	  		if(this.$mq.above('736px') && this.sliderslick == false){
	  			this.initslider();
	  		}
	  	},
	  	closeslider: function(){
	  		this.sliderOpen = false;
	  	},
	  	closepopup: function(){
	  		$('body').removeClass('openpopup');
	  		this.stopvideo();
	  	}, 
	  	stopvideo: function() {
			$('.popup').each(function(i, element) {
				var iframe = element.querySelector( 'iframe');
				var video = element.querySelector( 'video' );
				if ( iframe ) {
					var iframeSrc = iframe.src;
					iframe.src = iframeSrc;
				}
				if ( video ) {
					video.pause();
				}
			});
		}
	}
});