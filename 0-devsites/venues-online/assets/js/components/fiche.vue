<template>
	<article v-on:mouseover="mouseoverfiche()" v-on:mouseleave="mouseleavefiche()" class="fiche small-24 medium-12 xlarge-8 colunms">
		<div class="fiche-content">
			<div class="slick-container">
				<div class="tag-container">
					<div v-if="recommended" class="tag recommended">
						{{ this.translations[51] }}
					</div>
					<div v-if="isNewVenue && !recommended" class="tag new">
						{{ this.translations[50] }}
					</div>
				</div>

				<div v-if="fichedata.imageArray == undefined">
					<a v-bind:href="linkurl">
						<div class="imgplaceholder"></div>
					</a>
				</div>
				<div v-if="fichedata.imageArray != undefined">
					<div v-if="fichedata.imageArray == 0">
						<a v-bind:href="linkurl" v-if="fichedata.imageArray.length == 0">
							<div class="imgplaceholder"></div>
						</a>
					</div>
					<div v-else>
					  	<slick ref="slick" :options="slickOptions">
							<div v-for="image, index in fichedata.imageThumbArray" v-if="index < 4">
								<a v-bind:href="linkurl">
									<img v-if="fichedata.imageThumbArray.length != 0" class="slide" v-bind:src="image">
								</a>
							</div>
						</slick>
					</div>
				</div>
			</div>
			<a v-bind:href="linkurl">
				<h1 class="title light">{{ decodeHtml(fichedata.short_title) }}</h1>
			</a>
			<h3 class="city light">{{ decodeHtml(fichedata.city) }} ({{ decodeHtml(fichedata.zipcode) }})</h3>
			<div class="description light" v-html="decodeHtmlExcerpt(fichedata.description)"></div>
			<div class="button-container">
				<span v-if="this.$root.isfavouritespage == false">
					<a v-if="isfavourite == false" v-on:click="changefavourite('add')" title="" class="btn favourite semi-bold" v-bind:class="{ 'favourite-disabled': isfavourite }">
						<span v-bind:class="{ 'icon-favourite-active': isfavourite }" class="icon-favourite"></span> ({{favourites}})
					</a>
					<a href="/mijn-favorieten" v-if="isfavourite == true" title="" class="btn favourite semi-bold" v-bind:class="{ 'favourite-disabled': isfavourite }">
						{{ this.translations[1] }} <span v-bind:class="{ 'icon-favourite-active': isfavourite }" class="icon-favourite"></span>
					</a>
				</span>
				<a v-if="this.$root.isfavouritespage == true" v-on:click="changefavourite('remove')" title="" class="btn favourite semi-bold" v-bind:class="{ 'favourite-disabled': isfavourite }">
					{{ this.translations[4] }} <span v-bind:class="{ 'icon-favourite-active': isfavourite }" class="icon-favourite"></span>
				</a>
				<a v-on:click.prevent="clickofferpopup('offer')" title="" class="btn request-offer semi-bold">
					{{ this.translations[3] }} <span class="icon-arrow-right" ></span>
				</a>
			</div>
			<a v-bind:href="linkurl" class="view-link light">
				{{ this.translations[5] }}
				<i class="fa fa-chevron-right" aria-hidden="true"></i>
			</a>
		</div>
	</article>
</template>

<script>
var $ = jQuery.noConflict();

import { EventBus } from '../helper/event.js';
import Slick from 'vue-slick';

export default {
	name: 'fiche',
	props: [
		'fichedataprop',
		'favarray',
		'translations',
		'ipaddressprop',
		'langprop',
	],
	components: {
    	Slick
	},

	data(){
		return{
			fichedata: {},
			favourites: 0,
			isfavourite: false,
			linkurl: null,
			slickOptions: {
                dots: true,
                arrows: true,
                slidesToShow: 1,
				slidesToScroll: 1,
            },
            currenturl: null,
			markerurl: null,
		}
	},

	created(){
		this.getdata();
		this.reInit();

		this.checkiffavourite();
		// insert in list stats if not favourites page
		$('.request-offer').click(function(event) {
			event.stopPropagation();
			$('html, body').addClass('stop-scrolling');
		});
	},

	watch: {
		fichedataprop: function(val){
			this.getdata();
			this.reInit();
		}
	},

	methods: {
		reInit() {
            if (this.$refs.slick) {
                this.$refs.slick.destroy();
            }
            if (this.$refs.slick && !this.$refs.slick.$el.classList.contains('slick-initialized')) {
                this.$refs.slick.create();
            }
        },
		mouseoverfiche(){
			EventBus.$emit('togglemarker', this.fichedata.parent_post_id, true);
		},
		mouseleavefiche(){
			EventBus.$emit('togglemarker', this.fichedata.parent_post_id, false);
		},
		//Decode html to correctly view special chars
		decodeHtml(html) {
			var txt = document.createElement("textarea");
			txt.innerHTML = html;
			return txt.value;
	    },
	    decodeHtmlExcerpt(html) {
			var txt = document.createElement("textarea");
			txt.innerHTML = html;
			txt.value = txt.value.substring(0,120) + '...';
			return txt.value;
	    },
	    getdata(){
	    	this.fichedata = {};
	    	var lang = this.langprop;
			if(lang == 'nl'){	    	
	    		this.fichedata = JSON.parse(this.fichedataprop.json_nl);
	    	}
	    	if(lang == 'fr'){
	    		this.fichedata = JSON.parse(this.fichedataprop.json_fr);
	    	}
	    	if(lang == 'en'){
	    		this.fichedata = JSON.parse(this.fichedataprop.json_en);
	    	}
	    	if (this.fichedata == null){
	    		this.fichedata = JSON.parse(this.fichedataprop.json_nl);
	    	}
	    	this.favourites = this.fichedataprop.favourite;
	    	this.linkurl = '/'+lang+'/venues/' + this.fichedata.slug;

			this.checkiffavourite();
			this.checklabels();

			if (!document.body.classList.contains('page-template-tpl_favourites')){
			    this.insertaction('list');
			}
	    },
	    checkiffavourite(){
			if(this.favarray.indexOf(this.fichedata.post_id) > -1){
				this.isfavourite = true;
			} else{
				this.isfavourite = false;
			}
		},
		checklabels(){
			// 'RECOMMENDED' LABEL
			this.recommended = this.fichedata.recommended_bool;
			// 'NEW' LABEL
			var daysLimitForNewTag 	= 50;
			// yy-mm-dd
			var createdAt 			= this.fichedata.created_at;
			var modifiedTime 		= this.fichedata.modified_time;
			var today 				= this.dateToday();
			var oneDay 				= 24*60*60*1000;

			var startDate = Date.parse(createdAt);
			var endDate = Date.parse(today);
            var timeDiff = endDate - startDate;
            var daysDiff = Math.floor(timeDiff / oneDay);

            if (daysDiff < daysLimitForNewTag){
            	// this.isNewVenue = true;
            	// PUT BACK
            	this.isNewVenue = false;
            } else{
            	this.isNewVenue = false;
            }
		},
		dateToday(){
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!

			var yyyy = today.getFullYear();
			if(dd<10){
			    dd='0'+dd;
			} 
			if(mm<10){
			    mm='0'+mm;
			} 
			var today = yyyy+'/'+mm+'/'+dd;
			return today;
		},

	    changefavourite(addorremove){
	    	if (addorremove == 'add'){
	    		if (this.isfavourite == true) {
		    		window.location = this.langprop+"/mijn-favorieten/";
		    	}
		    	this.favourites = parseInt(this.favourites) + 1;
				this.isfavourite = true;
				EventBus.$emit('favourite', this.fichedata.parent_post_id);
	    	}

	    	if (addorremove == 'remove'){
				this.isfavourite = false;
				EventBus.$emit('removefavourite', this.fichedata.parent_post_id);
	    	}

	    	// update_favourite
	        var formData = new FormData();
			formData.append('action', 'update_favourite');
			formData.append('id',  JSON.stringify(this.fichedata.parent_post_id));
			formData.append('addorremove', addorremove);
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {

	        });
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

		clickofferpopup(){
			var rememberMeCookie = this.readCookie('vo-remember-me');
			if (rememberMeCookie){
				EventBus.$emit('handleRememberMe', rememberMeCookie);
			}
			EventBus.$emit('clickofferpopup', this.fichedata.parent_post_id, this.fichedata.short_title);
	        this.insertaction('email');
		},

		insertaction(action){
			var ipaddress = sessionStorage.getItem("ipaddress");
			var formData = new FormData();
			formData.append('action', 'logstats');
			formData.append('post_id', this.fichedata.post_id);
			formData.append('actionvalue', JSON.stringify(action));
			formData.append('ipaddress', ipaddress);
			formData.append('site_id', '1');
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
	        });
		},
	}
}	
</script>