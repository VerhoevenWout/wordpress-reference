//var number = require('./modules/number.js');

import Vue from 'vue/dist/vue.js'
import VueResource from 'vue-resource';
import importfunction from './components/importfunction.vue';
import { EventBus } from './helper/event.js';

Vue.use(VueResource);

window.onload = function () {
new Vue({

	el: '#import',

	components: {
		importfunction
	},
	

	 data() {
	    return {
	       inprogress: false, 
	       productid: ''
	    };
	},

	mounted: function() {
		
		 EventBus.$on('inprogressmethod',  this.inprogressmethod);
		
    }, 

    methods: {
		inprogressmethod: function(importfunctionname){
			this.inprogress = importfunctionname;
		}, 
		getimages: function(){

			var formData = new FormData();
			formData.append('action', 'get_imgs');
			formData.append('ID', this.productid);

	    	this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
	        });

		}
	}

});
}