var $ = require('jquery');
var VueResource = require('vue-resource');
var VueScroll = require('vue-scroll');
var urlParams = require('url-params');
var _ = require('lodash');

//Components
import Vue from 'vue/dist/vue.js'
import Product from './components/product.vue';
import productfilter from './components/filter.vue';
import vMediaQuery from 'v-media-query';
import { EventBus } from './helper/event.js';
import 'url-search-params-polyfill';
import lodash from 'lodash'


Vue.use(VueResource);
Vue.use(vMediaQuery);
Vue.use(VueScroll);

new Vue({

	el: '#vue-product-filter',
	
	components: {
		Product,
		productfilter
	},

	data: {
		allproducts: {},
		products: {},
		filters: {},
		termid: '',
		lang: '',
		termparent: '',
		checkedfilters: {},
		merkreeks: {}, 
		countproducts: 0, 
		isactive: false,
		countquery: '',
		filterQ: {},
		filterQindex: 1,
		filterQindexcurrent: 0,
		filterloader: true,
		store: {
			urlstring: '',
			checkedfilters: {}
		},
		activefilters: {
			'cats': true
		},
		currenturl: '',
		countloader: false
	},

	mounted: function() {

        if(this.$mq.above('70em')){
        	this.isactive = true;
        }

        this.currenturl = window.location.href;

        //Get the filters and the query info
        var formData = new FormData();
		formData.append('action', 'get_tax_products');
		formData.append('term_id', this.termid);
		formData.append('lang', this.lang);
		
		var vm = this;
		this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
        	// set data on vm
        	this.filters = response.body.filters;
        	this.checkedfilters['cats'] = this.filters.cats.childerenIds;
        	this.countquery = response.body.countquery;

        	//$(window).bind("popstate", this.popStateRequery);

        	//Emit call to products.vue to get the products 
			EventBus.$emit('update-products', this.checkedfilters, this.countquery, this.filters.cats.childerenIds, this.currenturl);
			
        });

        var vm = this;

        
       	EventBus.$on('updatefilterproducts', this.updatefilterproducts);
       	EventBus.$on('addtofilterQ', this.addtofilterQ);
       	EventBus.$on('nextfilterQ', this.nextfilterQ);
       	EventBus.$on('updatetotal', this.updatetotal);
       	EventBus.$on('getcountfromserver', this.getcountfromserver);
       	EventBus.$on('setactive', this.setactive);
       	EventBus.$on('seturl', this.seturl);
    },
    
	methods: {
		//Set the term id , is called on root vue object 
		'setTermid': function(id, parent){
			this.termid = id;
			this.termparent = parent;
		},

		'setlang': function(lang){
			this.lang = lang;
		},

		//Toggle the filter overlay on the mobile version.
		'togglefilter': function(){
			if(this.filterloader == false){
		
				if(!this.isactive){
					this.isactive = true;
					$('body').addClass('noscroll');
					
					// this.store.urlstring = window.location.href;
					// for(var key in this.checkedfilters){
					// 	this.store.checkedfilters[key] = this.checkedfilters[key];
					// }
					// EventBus.$emit('storeproducts', false);
				}else{
					$('body').removeClass('noscroll');
					// this.checkedfilters = {};
					// for(var key in this.filters){
					// 	if(typeof this.checkedfilters[key] == 'undefined' ){
					// 		this.checkedfilters[key] = [];
					// 	}else{
					// 		this.checkedfilters[key] = this.store.checkedfilters[key];
					// 	}					

					// 	EventBus.$emit('updatecheckfilter', key, this.checkedfilters[key]);
					// }
					// this.store.checkedfilters = {};

					// EventBus.$emit('storeproducts', true);
					// this.seturl(this.store.urlstring);

					this.isactive = false;
				}
			}
		}, 
		//Set the filters selected in the mobile overlay
		'applyfilters': function(){
			if(this.filterloader == false){
				this.isactive = false;
				this.filterloader = true;
				this.nextfilterQ(false);
			}
		},
		//Is called from the Q to update the checkedfilter array en url and the call updatefilterproducts
		'updatefilter':  function(filterdata, name, updateproducts = true){
			var urlstring = window.location.href;

			if(name == 'merkReeks' && typeof this.checkedfilters['merken'] != 'undefined'){
				delete this.checkedfilters['merken'];
				EventBus.$emit('updatecheckfilter', 'merken', []);
			}

			var url = urlParams.remove(this.currenturl, name);

			if(filterdata.length == 0){
				delete this.checkedfilters[name];
				var url = urlParams.add(url, name);
			}else{
				this.checkedfilters[name] = filterdata;
				url = urlParams.add(url, name, filterdata);
			}
			this.seturl(url);
			

			if(Object.keys(this.checkedfilters).length == 0 || typeof this.checkedfilters['cats'] == 'undefined'){
				this.checkedfilters['cats'] = this.filters.cats.childerenIds;
			}

			if(updateproducts){
				this.updatefilterproducts(url);
			}
		},
		//Emit event to products.vue to start the ajax call for filterd products 
		'updatefilterproducts': function(url){
			EventBus.$emit('update-products', this.checkedfilters, false, this.filters.cats.childerenIds, url);
		},
		//Handle the history state 
		popStateRequery: function(event) {
            event.preventDefault();
            if(this.currenturl.indexOf('?') > -1){
				this.currenturl = this.currenturl.substring(0, this.currenturl.indexOf('?'));
			}
            EventBus.$emit('checkparams');
			//this.updatefilterproducts();

            return false;
        },
        //Add filter change to the Q 
		addtofilterQ: function(filterdata, name, merkreeks) {
			this.filterQindex++;
			this.filterloader = true;

			var newfilterdata = [];
			
			if(merkreeks){

				this.merkreeks[merkreeks] = filterdata;

				var i = 0;
				for (var key in this.merkreeks) {
					for (var key2 in this.merkreeks[key]) {
						newfilterdata[i] = this.merkreeks[key][key2];
						i++;
					}
				}

			}else{
				_.merge(newfilterdata, filterdata);
			}

			var start = false;
			if(Object.keys(this.filterQ).length === 0 && this.filterQ.constructor === Object){
				start = true;
			}

			this.filterQ[this.filterQindex] = {
				'filterdata': newfilterdata,
				'name': name
			};
			
			if(start){
				this.filterQindexcurrent = this.filterQindex;
				this.nextfilterQ();
			}
		}, 
		//Do the next filterchange in the Q 
		nextfilterQ(deleteindex = false){

			if(deleteindex){
				delete this.filterQ[this.filterQindexcurrent];
				if(Object.keys(this.filterQ).length === 0 && this.filterQ.constructor === Object){
				
				}else{
					this.filterQindexcurrent++;
				}
			}

			if(typeof this.filterQ[this.filterQindexcurrent] != 'undefined'){
				this.updatefilter(
					this.filterQ[this.filterQindexcurrent].filterdata,
					this.filterQ[this.filterQindexcurrent].name
				);
			}else{
				this.filterloader = false;
				$('.subcatmenu.filters.subcatmenu').show();
			}
		},
		//Update the product total
		updatetotal(count){
			this.countproducts = count;
		},
		//Do ajax call to get the count values from the server without the products 
		getcountfromserver: function(){
				this.countloader = true;

				var sendcountquery = {};
				sendcountquery.cats = this.countquery.cats;

				var url = new URL(this.currenturl);
				var params = new URLSearchParams(url.search);
				for(var key in this.countquery){
					if(params.has(key)){
						sendcountquery[key] = this.countquery[key];
					}
				}

				for(var key in this.activefilters){
					sendcountquery[key] = this.countquery[key];
				}

				var formData = new FormData();
				formData.append('action', 'get_filter_counts');
				formData.append('countquery', JSON.stringify(sendcountquery));
				formData.append('filters', JSON.stringify(this.checkedfilters));
				formData.append('allcats', JSON.stringify(this.filters.cats.childerenIds));
				formData.append('url', this.currenturl);
				formData.append('lang', this.lang);

				var vm = this;
				this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
		        	// set data on vm
		        	
		        	this.count = response.body.count;

		        	EventBus.$emit('updatecount', this.count);
		        	this.countloader = false;
					
		        });

			

		},
		//Add filter to active filter array to see wich filters are open
		setactive: function(name, remove = false){
		    	
	    	if(remove == true){
	    		for(var key in this.activefilters){
	    			if(key == name){
	    				delete this.activefilters[key];
	    				//this.activefilters.splice(key, 1);
	    			}
	    		}
	    		
	    	}else{
	    		if(typeof this.activefilters[name] == 'undefined'){
	    			this.activefilters[name] = true;
	    		}
	    	}

	    	this.filterloader = false;
		    $('.subcatmenu.filters.subcatmenu').show();	
		 },
		 seturl: function(url){
		    	this.currenturl = url;
		    	history.replaceState(null, null, url);
		 }
	}
});