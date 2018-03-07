//var number = require('./modules/number.js');

import Vue from 'vue/dist/vue.js'
import VueResource from 'vue-resource';
import * as Cookies from "js-cookie";

Vue.use(VueResource);

new Vue({

	el: '#cart',

	 data() {
	    return {
	       cookie: {
	       	cart: {},
	       	naam:'',
	       	opmerking: ''
	       },
	       products: {}, 
	       naam: '', 
	       opmerking: '',
	       offertesend: false, 
	       loading: true
	    };
	},

	mounted: function() {
		var cart = window.localStorage.getItem('cart');
		var offerteid = this.getUrlParameter('cartvalue');

		if (offerteid){
			// get products in offerteid
			var productids = [];
			var formData = new FormData();
			formData.append('offerteid', offerteid);
			formData.append('action', 'get_products');
	    	this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
	        	if (response.status == 200){
		        	this.products = response.body;
		        	
		        	for(var product in this.products){
		        		this.cookie.cart[this.products[product].nlID] = this.products[product].count;
		        	}

		        	this.cookie.naam = '';
		        	this.cookie.opmerking = '';

					window.localStorage.setItem('cart', JSON.stringify(JSON.parse(JSON.stringify(this.cookie))) );
	        	}
	        	this.loading = false;
	        	var urlstring = window.location.origin + window.location.pathname;
	        	history.replaceState(null, null, urlstring);
	        });
		} else if(cart){
			cart = JSON.parse(cart);
			if(Object.keys(cart).length != undefined){
				var cookie = cart;
				this.cookie = cookie;
				var formData = new FormData();
				formData.append('action', 'get_products');
				formData.append('cart', JSON.stringify(cookie.cart));

				this.naam = this.cookie.naam;
				this.opmerking = this.cookie.opmerking;

				if(Object.keys(cookie).length != 0){
					var vm = this;

			    	this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
			    		if(response.body){
			        		vm.products = response.body;
			        	}
			        	this.loading = false;
			        });
		    	}
			}else{
				this.loading = false;
			}
		} else{
			this.loading = false;
		}
    }, 

    methods: {
    	getUrlParameter: function(name) {
    	    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    	    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    	    var results = regex.exec(location.search);
    	    results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    	    if (results){
	    	    results = results[1].replace(/\/$/, "");
    	    }
    	  	return results;
    	},

	  	quantityup: function(id, nlid){
	  		this.products[id].count = parseInt(this.products[id].count) + parseInt(this.products[id].EV);
	  		this.cookie.cart[nlid] = this.products[id].count;
			window.localStorage.setItem('cart', JSON.stringify(JSON.parse(JSON.stringify(this.cookie))) );
	  	},
	  	quantitydown: function(id, nlid){
	  		if(parseInt(this.products[id].count) > parseInt(this.products[id].EV)){
	  			this.products[id].count = parseInt(this.products[id].count) - parseInt(this.products[id].EV);
		  		this.cookie.cart[nlid] = this.products[id].count;
	  		}
			window.localStorage.setItem('cart', JSON.stringify(JSON.parse(JSON.stringify(this.cookie))) );
	  	}, 
	  	deleteproduct: function(id, nlid){
	  		Vue.delete(this.products, id);
	  		if (this.cookie.cart){
		  		Vue.delete(this.cookie.cart, nlid);
		  		// this.cookie.cart[id] = this.products[id].count;
				window.localStorage.setItem('cart', JSON.stringify(JSON.parse(JSON.stringify(this.cookie))) );
	  		}
	  	// 	if (this.cookie){
		  // 		Vue.delete(this.cookie, id);
		  // 		// this.cookie[id] = this.products[id].count;
				// window.localStorage.setItem('cart', JSON.stringify(JSON.parse(JSON.stringify(this.cookie))) );
	  	// 	}
	  	},
	  	zendofferte: function(){
	  		this.loading = true;

	  		var formData = new FormData();
	  		formData.append('action', 'offerteaanvraag');
			formData.append('naam', JSON.stringify(this.cookie.naam));
			formData.append('opmerking', JSON.stringify(this.cookie.opmerking));
			formData.append('products', JSON.stringify(this.products));
			
	    	this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
	        	if (response.status == 200){
	        		var products = this.products;
	        		for(var product in products){
		        		for(var product in products){
		        			var ID = product;
			        		this.deleteproduct(ID);
		        		}
	        		}

	        		this.cookie = {
	        			cart: {},
	        			naam:'',
	        			opmerking: ''
	        		};

	        		var urlstring = window.location.origin + window.location.pathname;
	        		history.replaceState(null, null, urlstring);
	        		this.offertesend = true;
	        		this.loading = false;
					window.localStorage.setItem('cart', JSON.stringify(JSON.parse(JSON.stringify(this.cookie))) );
	        	}
	        });
	    
	  	},
	  	closeoffertesend(){
	  		this.offertesend = false;
	  	},
	  	savefields: function(){
	  		this.cookie.naam = this.naam;
	  		this.cookie.opmerking = this.opmerking;

			window.localStorage.setItem('cart', JSON.stringify(JSON.parse(JSON.stringify(this.cookie))) );
	  	}
	}

});