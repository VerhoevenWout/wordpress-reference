var $ = require('jquery');
var VueResource = require('vue-resource');

//Components
import Vue from 'vue/dist/vue.js'
import Product from './components/product.vue';
import vMediaQuery from 'v-media-query';
import { EventBus } from './helper/event.js';

Vue.use(VueResource);
Vue.use(vMediaQuery);

new Vue({

	el: '#vue-merk-filter',
	
	components: {
		Product
	},

	data: {
		allproducts: {},
		products: {},
		filters: {},
		termid: '',
		checkedfilters: {}, 
		count: 0, 
		isActive: false,
		countquery: {
			'merken':{
				join: "INNER JOIN mll_term_relationships trMerk ON p.ID=trMerk.object_id \n\t\t\t\t\t\t INNER JOIN mll_term_taxonomy ttMerk ON trMerk.term_taxonomy_id = ttMerk.term_taxonomy_id and ttMerk.taxonomy = \"merk-reeks\"",
				name: 'merken'
			}
		}, 
		currenturl: ''
	},

	mounted: function() {

        if(this.$mq.above('70em')){
        	this.isActive = true;
        }

        this.currenturl = window.location.href;


        EventBus.$emit('updatemerkproducts', this.termid, this.countquery);
        
        EventBus.$on('seturl', this.seturl);
    },

	methods: {
		'setTermid': function(id){
			this.termid = id;
		},
		'togglefilter': function(){
		
			if(!this.isActive){
				this.isActive = true;
				$('body').addClass('noscroll');
				
				
			}else{
				$('body').removeClass('noscroll');
				

				this.isActive = false;
			}

		},
		seturl: function(url){
		    this.currenturl = url;
		    history.replaceState(null, null, url);
		}
	}
	
});