//var number = require('./modules/number.js');

import Vue from 'vue/dist/vue.js'
import VueResource from 'vue-resource';
import VeeValidate from 'vee-validate';

Vue.use(VueResource);
Vue.use(VeeValidate);

new Vue({

	el: '#profile',

	data() {
	    return {
	       user: {}, 
	       passconfirm: false,
	       passnotmatch: false,
	       submitconfirm: false
	    };
	},

	mounted: function() {
			
			var formData = new FormData();
			formData.append('action', 'getuser');

			var vm = this;

	    	this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
	        	vm.user = response.body;
	        });

    },
    /*
    watch: {
    	user: function(val){
    		this.password();
    	}
    },
	*/
    methods: {
    	/*
    	'password': function(){
    		if(this.user.password != "") {
				this.user.password_confirmation.setAttr("v-validate", "'required|confirmed:password'");
			}
    	},
		*/
	    'save': function() {
	    	this.submitconfirm = false;
	    	this.passconfirm = false;
	    	this.passnotmatch = false;

	    	this.$validator.validateAll().then(result => {
		        if (result) {

		        	var formData = new FormData();
					formData.append('action', 'saveuser');
					formData.append('user', JSON.stringify(this.user));

					if(this.errors.length == 0){
						this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {

							this.sub
							
							if(response.body.userinfo){
								this.submitconfirm = true;
							}

							if(response.body.userpass == 'success'){
								this.passconfirm = true;
							}

							if(response.body.userpass == 'success'){
								this.passnotmatch = true;
							}
							
			        	});
					}

					
					return;
		        }

	      		alert('Gelieve het formulier volledig in te vullen!')
	    	});
		}
		
	}
});