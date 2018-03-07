<template>
	<div class='columns small-12 product-grid '>
		<div class='loading'
			 v-show='filterloader'
		>
			<div class='spin'></div>
		</div>
		<div class='count'>{{ this.string.Selectie[lang] }}: {{ products.length }} producten</div>
		<div class='pagination' v-show='this.pages > 1'  v-if="$mq.resize && $mq.above('70em')" v-bind:class="{ fixed: paginationfixed }">
			<ul>
				<a class="slider-arrow left" 
				   v-on:click="goToPage(currentpage-1)"
				   v-show='currentpage != 1'
				>
					<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#231f20;stroke-miterlimit:10"/></svg>
				</a>
				<li v-for="n in pages" 
					v-show='(((currentpage - 2) < n) && ((currentpage + 2) > n)) || n == 1 || n == pages' 
					v-on:click='goToPage(n)'  
					v-bind:class="{'active': currentpage == n , 'nopseudo' : (currentpage - 3) < n && (currentpage + 3) > n }"
				>
					{{ n }}
				</li>
				<a class="slider-arrow right" 
				   v-on:click="goToPage(currentpage+1)"
				   v-show='currentpage != this.pages'
				 >
				   	<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#231f20;stroke-miterlimit:10"/></svg>
				</a>
			</ul>
		</div>
		<div class='row grid'>
			<article class='columns small-6 medium-4 large-3 xlarge-4 xxlarge-3'  v-for="product in pageproducts" >
				<a :href='"/"+lang+"/"+product.post_name'>
					<div v-if='browser.ie == 11' class="rect" v-html="getimgbackgroundhtml(product.img)" ></div>
					<div v-else class='rect'>
						<div  class='container'> 
							<img :src="getimg(product.img)">
						</div>
					</div>
					<h2>{{ decodeHtml(product.post_title) }}</h2>
				</a>
			</article>
		</div>
		<div class='pagination'  v-show="this.pages > 1 && ((!isactive && $mq.resize && $mq.below('70em')) || ($mq.resize && $mq.above('70em')))" v-bind:class="{ fixed: paginationfixed }">
			<ul>
				<a class="slider-arrow left" 
				   v-on:click="goToPage(currentpage-1)"
				   v-show='currentpage != 1'
				>
					<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#231f20;stroke-miterlimit:10"/></svg>
				</a>
				<li v-for="n in pages" 
					v-show='(((currentpage - 2) < n) && ((currentpage + 2) > n)) || n == 1 || n == pages' 
					v-on:click='goToPage(n)'  
					v-bind:class="{'active': currentpage == n , 'nopseudo' : (currentpage - 3) < n && (currentpage + 3) > n }"
				>
					{{ n }}
				</li>
				<a class="slider-arrow right" 
				   v-on:click="goToPage(currentpage+1)"
				   v-show='currentpage != this.pages'
				 >
				   	<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#231f20;stroke-miterlimit:10"/></svg>
				</a>
			</ul>
		</div>
	</div>
</template>

<script>
	var inViewport = require('in-viewport');
	var urlParams = require('url-params');
	


	import 'url-polyfill';
	import { EventBus } from '../helper/event.js';
	import 'url-search-params-polyfill';

	export default {
		name: 'product',

		props: ['title', 'termid', 'filterloader', 'activefilters', 'currenturl', 'lang', 'isactive'], 

		data: function(){
			return{
				currentpage : 1,
				postPerPage : 48,
				paginationfixed : false, 
				pages: 0, 
				browser: {
					ie: false,
					edge: false
				},
				allproducts: [],
				products: [], 
				string: {
					'Selectie': {
						'nl': 'Selectie', 
						'fr': 'Sélection',
						'en': 'Selection'
					}
				},
				count: [],
				countquery: '',
				store:{
					products: {}, 
					count:[]
				}
			}
		},

		created: function(){

			window.addEventListener('scroll', this.handleScroll);
			this.detectIE();

			EventBus.$on('update-products',  this.updateproducts);
			EventBus.$on('get-count-products',  this.getcountproducts);
			EventBus.$on('storeproducts', this.storeproducts);
			EventBus.$on('updatemerkproducts', this.updatemerkproducts);
			EventBus.$on('setproducts', this.setproducts);

		},


	     computed: {
	     	//Get the products of a certain page
		    pageproducts: function() {
		    	if(this.products != undefined){
		    		var currentpage = this.currentpage-1;
		    		this.pages = Math.ceil(Object.keys(this.products).length/this.postPerPage);
		    		return this.products.slice(currentpage*this.postPerPage, Number((currentpage*this.postPerPage)+this.postPerPage))
		    	}
			}
		},

	    methods: {
	    	//Go to page in pagination
	    	goToPage: function(n){
	    		var url = urlParams.remove(this.currenturl, 'page');

	    		if(n > 0 && n < this.pages+1){
					this.currentpage = n;
					var currenturl = window.location.href;
					var url = urlParams.add(url, 'page', this.currentpage);
					
				}else{

				}
				EventBus.$emit('seturl', url);
			},
			//Handle scroll for sticky elements mobile
			handleScroll: function(){
				var elem = document.getElementById('mainfooter');
				this.paginationfixed = inViewport(elem);
			},

			//Do ajax call to get the correct products for the category filter pages
			'updateproducts': function(allfilters, countquery = false, allcats, url){

				if(countquery != false){

					this.countquery = countquery;
					if(url.indexOf('?') > -1){
						url = url.substring(0, url.indexOf('?'));
					}
					

				}
				
				var sendcountquery = {};
				sendcountquery.cats = this.countquery.cats;

				var urlobject = new URL(url);
				var params = new URLSearchParams(urlobject.search);
				for(var key in this.countquery){
					if(params.has(key)){
						sendcountquery[key] = this.countquery[key];
					}
				}

				for(var key in this.activefilters){
					sendcountquery[key] = this.countquery[key];
				}


				var formData = new FormData();
				formData.append('action', 'get_filter_products');
				formData.append('termid', this.termid);
				formData.append('countquery', JSON.stringify(sendcountquery));
				formData.append('filters', JSON.stringify(allfilters));
				formData.append('allcats', JSON.stringify(allcats));
				formData.append('url', url);
				formData.append('lang', this.lang);

				var vm = this;
				this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
		        	// set data on vm
		        	
		        	this.count = response.body.count;

		        	if(this.count != null){
		        		EventBus.$emit('updatecount', this.count);
		        	}

		            this.products = response.body.products;
		        	EventBus.$emit('updatetotal', this.products.length);

		        	if(countquery != false){
		        		if(window.location.href.indexOf("?") > -1 && window.location.href.indexOf("?page=") == -1) {
		        			EventBus.$emit('checkparams');
		        		 }else{
		        		 	EventBus.$emit('nextfilterQ', false);
		        		 }
					
					}else{
						EventBus.$emit('nextfilterQ', true);
					}

					var urlstring = window.location.href;
					var url = new URL(urlstring);
					var params = new URLSearchParams(url.search);
					
					if(params.has('page')){
						this.currentpage = params.get('page');
					}else{
						this.currentpage = 1;
					}

					this.$forceUpdate();

		        
		        });

			},
			//Do ajax call to get the correct products for the merk  pages
			'updatemerkproducts': function(termid, countquery){

				var formData = new FormData();
				formData.append('action', 'get_merk_products');
				formData.append('termid', termid);
				formData.append('countquery', JSON.stringify(countquery));
				formData.append('url', window.location.href);
				formData.append('lang', this.lang);
				
				var vm = this;
				this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
		        	
		        	// set data on vm
		            this.products = response.body.products;
		        	EventBus.$emit('updatetotal', this.products.length);

		        	var urlstring = window.location.href;
					var url = new URL(urlstring);
					var params = new URLSearchParams(url.search);
		        	
					if(params.has('page')){
						this.currentpage = params.get('page');
					}else{
						this.currentpage = 1;
					}

		        });
			

			},
			//Decode html to correctly view special chars
			decodeHtml: function (html) {
		      var txt = document.createElement("textarea");
		      txt.innerHTML = html;
		      return txt.value;
		    },
		    //Set the products, used only by search.js
		    setproducts: function(products){
		    	this.products = products;
		    },
		    //store the products and info when mobile overlay is open
		    storeproducts: function(restore = false){
		    	if(restore){
		    		this.products = this.store.products;
		    		this.count = this.store.count;
		    		EventBus.$emit('updatecount', this.count);
		    		EventBus.$emit('updatetotal', this.products.length);
		    	}else{
		    		this.store.products = this.products;
		    		this.store.count = this.count;
		    	}
		    	
		    }, 
		    //Check if the img exist otherwise return placeholder
		    getimg(img){
		    	if(img == null){
		    		return "/wp-content/themes/muller/dist/img/beeld-categorie-230.jpg";
		    	}else{
		    		return img;
		    	}
		    },

		    getimgbackgroundhtml(img){
		    	var imgurl = this.getimg(img);
		    
		    	var html = '<div class="container ie11" style=\'background-image: url("https:'+imgurl+'")\'>';

		    	return html;
		    },
		    detectIE() {
				  var ua = window.navigator.userAgent;

				  // Test values; Uncomment to check result …

				  // IE 10
				  // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';
				  
				  // IE 11
				  // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';
				  
				  // Edge 12 (Spartan)
				  // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';
				  
				  // Edge 13
				  // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';

				  var msie = ua.indexOf('MSIE ');
				  if (msie > 0) {
				    // IE 10 or older => return version number
				    return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
				  }

				  var trident = ua.indexOf('Trident/');
				  if (trident > 0) {
				    // IE 11 => return version number
				    var rv = ua.indexOf('rv:');
				    this.browser.ie = parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
				  }

				  var edge = ua.indexOf('Edge/');
				  if (edge > 0) {
				    // Edge (IE 12+) => return version number
				    this.browser.edge = parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
				  }

			}
		    
		}
	
	}

</script>