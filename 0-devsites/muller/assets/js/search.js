var $ = require('jquery');
var VueResource = require('vue-resource');
var urlParams = require('url-params');

//Components
import Vue from 'vue/dist/vue.js'
import Product from './components/product.vue';
import vMediaQuery from 'v-media-query';
import { EventBus } from './helper/event.js';
import 'url-search-params-polyfill';


Vue.use(VueResource);
Vue.use(vMediaQuery);

new Vue({

	el: '#vue-search',
	
	components: {
		Product
	},

	data: {
		results: {}, 
		searchquery: '', 
		loading: false, 
		paramkey: 'query', 
		currenturl: '', 
		lang: 'nl'
	},

	mounted: function() {
		var urlstring = window.location.href;
		var url = new URL(urlstring);
		var params = new URLSearchParams(url.search);

		if(params.has(this.paramkey)){
			this.searchquery = params.get(this.paramkey);
			this.search();
		}

		this.currenturl = window.location.href;
    },

	methods: {
		search: function(){
			if(!this.loading){
				this.loading = true;

				var formData = new FormData();
		       	formData.append('search', this.searchquery);
				formData.append('action', 'search_products');
				formData.append('lang', this.lang);
				formData.append('url', window.location.href);
				
				this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {

		        	this.results = response.body.results;

		        	EventBus.$emit('setproducts', this.results);
		        	this.loading = false;
		        });
			}
		},
		'setlang': function(lang){
			this.lang = lang;
		},
	}
});