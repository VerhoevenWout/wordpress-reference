var VueResource = require('vue-resource');

import Vue from 'vue/dist/vue.js'
import vMediaQuery from 'v-media-query';

Vue.use(VueResource);
Vue.use(vMediaQuery);

new Vue({

	el: '#nav',
	
	data: {
		subcatmenu: '',
		isActive: false,
		activesubmenu: false,
		currentterm: {},
		activeItem: false
	},

    methods: {
		opensubmenu(id, url){
			if(this.$mq.below('70em')){
				this.activeItem = id;
			}else{
				window.location.replace(url);
			}
		},
		closesubmenu(){
			this.activeItem = false;
		},
		closemenu: function(){
		  	var ele = document.getElementsByName("menu-radio");
		  	for(var i=0;i<ele.length;i++){
		    	ele[i].checked = false;	  			
		  	}

		  	this.isActive = false;
		  	this.activesubmenu = false;
			this.activeItem = false;
		  	this.currentterm = {};
		},
		decodeHtml: function (html) {
	      var txt = document.createElement("textarea");
	      txt.innerHTML = html;
	      return txt.value;
	    }
	}
});