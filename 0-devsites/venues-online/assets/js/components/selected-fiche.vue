<template>
	<article class="selected-fiche expanded row">

	  	<slick ref="slick" :options="slickOptions">
			<div v-if="fichedata.imageArray" v-for="image, index in fichedata.imageArray">
				<img v-img:group class="slide" v-bind:src="image">
			</div>
			<div v-if="fichedata.imageArray.length == 0" class="imgplaceholder"></div>
		</slick>

		<div class="top small-24 columns row">
			<div class="small-24 medium-15 columns">
				<h1 class="heading light">{{ decodeHtml(fichedata.short_title) }}</h1>
				<div class="tax-container small-24 columns row">
					<div class="icon-container">
						<span class="icon icon-location"></span>
						<span>{{ decodeHtml(fichedata.zipcode) }} {{ decodeHtml(fichedata.city) }}</span>
					</div>
					<div class="icon-container">
						<span class="icon icon-persons"></span>
						<span>{{ decodeHtml(fichedata.persons_min) }} {{ this.translations[8] }} {{ decodeHtml(fichedata.persons_max) }} {{ this.translations[9] }}</span>
					</div>
					<div class="icon-container">
						<span class="icon icon-halls"></span>
						<span>{{ decodeHtml(fichedata.halls) }} {{ this.translations[10] }}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="small-24 medium-9 xlarge-6 medium-order-1 columns relative">
			<div class="sidebar">
				<p class="heading">
					{{ this.translations[11] }}
				</p>
				<p class="sub-heading light">
					{{ this.translations[12] }}
				</p>
				<div class="button-container">
					<a v-on:click="clickofferpopup()" title="" class="btn request-offer semi-bold">
						{{ this.translations[3] }} <span class="icon-arrow-right" ></span>
					</a>
					
					<a v-if="isfavourite == false" v-on:click="makefavourite()" title="" class="btn favourite semi-bold" v-bind:class="{ 'favourite-disabled': isfavourite }">
						<span v-bind:class="{ 'icon-favourite-active': isfavourite }" class="icon-favourite"></span> ({{favourites}})
					</a>
					<a v-if="isfavourite == true" v-on:click="makefavourite()" title="" class="btn favourite semi-bold" v-bind:class="{ 'favourite-disabled': isfavourite }">
						{{ this.translations[1] }} <span v-bind:class="{ 'icon-favourite-active': isfavourite }" class="icon-favourite"></span>
					</a>
				</div>

				<div class="button-container contact-container">
					<p class="heading">
						{{ this.translations[13] }}
					</p>
					<ul class="sub-heading light address" v-if="fichedata.address.length == 2">
						<li>{{ fichedata.address[0] }}</li>
						<li>{{ fichedata.address[1] }}</li>
					</ul>
					<ul class="sub-heading light address" v-if="fichedata.address.length >= 3">
						<li>{{ fichedata.address[0] }} {{ fichedata.address[1] }}</li>
						<li>{{ fichedata.zipcode }} {{ fichedata.city }}</li>
					</ul>
					<a v-if="!showphonebool" class="view-link" v-on:click="showphone()" title="" data-log="false" data-type="phone" data-post="{!! $post->ID !!}">{{ this.translations[6] }}</a>
					<a :href="'tel:' + fichedata.phone" class="phonenumber" v-if="showphonebool">{{ fichedata.phone }}</a>
				</div>

				<div class="button-container external-link">
					<a v-bind:href="fichedata.external_link" target="_blank" title="" class="btn request-website semi-bold">
						{{ this.translations[7] }} <span class="icon-arrow-right"></span>
					</a>
					<a v-bind:href="this.socialMediaLink" target="_blank" title="" class="btn request-fb semi-bold">
						Facebook Link <span class="icon-arrow-right"></span>
					</a>
				</div>
					<!-- <a title="" v-on:click="visitwebsite()" class="btn request-offer semi-bold">
						{{ this.translations[7] }} <span class="icon-arrow-right"></span>
					</a> -->

				<div class="button-container share-container">
					<span>Share</span>
					<a v-on:click="shareCountIncrement('facebook')" v-bind:href="facebookShareLink" target="_blank" title="facebook share" class="btn share semi-bold">
						<i class="fa fa-fw fa-facebook"></i>
						({{ this.facebookShareCount }})
					</a>
					<a v-on:click="shareCountIncrement('twitter')" v-bind:href="twitterShareLink" target="_blank" title="twitter share" class="btn share semi-bold">
						<i class="fa fa-fw fa-twitter"></i>
						<!-- ({{ this.twitterShareCount }}) -->
					</a>
					<a v-on:click="shareCountIncrement('linkedin')" v-bind:href="linkedinShareLink" target="_blank" title="linkedin share" class="btn share semi-bold">
						<i class="fa fa-fw fa-linkedin"></i>
						<!-- ({{ this.twitterShareCount }}) -->
					</a>
				</div>

			</div>
		</div>
		<div class="small-24 medium-15 xlarge-17 medium-order-0 columns">
			<div class="description light" v-html="decodeHtml(fichedata.description)" v-if="fichedata.description"></div>

			<div class="tax-box-container">
				<div class="tax-box" v-if="fichedata.activities">
					<span class="heading semi-bold">{{ this.translations[14] }}</span>
					<ul class="sub-heading">
						<li v-for="key in fichedata.activities">
							{{ key.name }}
						</li>
					</ul>
				</div>
				<div class="tax-box" v-if="fichedata.type_location">
					<span class="heading semi-bold">{{ this.translations[15] }}</span>
					<ul class="sub-heading">
						<li v-for="key in fichedata.type_location">
							{{ key.name }}
						</li>
					</ul>
				</div>
				<div class="tax-box" v-if="fichedata.facilities">
					<span class="heading semi-bold">{{ this.translations[16] }}</span>
					<ul class="sub-heading">
						<li v-for="key in fichedata.facilities">
							{{ key.name }}
						</li>
					</ul>
				</div>
				<div class="tax-box" v-if="fichedata.location">
					<span class="heading semi-bold">{{ this.translations[17] }}</span>
					<ul class="sub-heading">
						<li v-for="key in fichedata.location">
							{{ key.name }}
						</li>
					</ul>
				</div>
			</div>

			<div class="description sub-description light" v-html="decodeHtml(fichedata.detailed_description)" v-if="fichedata.detailed_description"></div>

			<div v-if="fichedata.capacity_table != ''">
				<a v-if="!showcapacitybool" class="view-link" v-on:click="showcapacity()" title="" data-log="false" data-type="capacity" data-post="{!! $post->ID !!}">{{ this.translations[34] }}</a>
				<div v-if="showcapacitybool" class="sub-description light" v-html="decodeHtml(fichedata.capacity_table)"></div>
			</div>

		</div>
	</article>
</template>

<script>
var $ = jQuery.noConflict();

import { EventBus } from '../helper/event.js';
import Slick from 'vue-slick';

export default {
	
	name: 'selectedfiche',
	props: [
		'fichedataprop',
		'favarrayprop',
		'favouritesprop',
		'translations',
		'ipaddressprop',
	],
	components: {
    	Slick,
	},

	data(){
		return{
			fichedata: {},
			favourites: null,
			isfavourite: false,
			showphonebool: false,
			slickOptions: {
                dots: true,
                arrows: true,
                slidesToShow: 3,
				slidesToScroll: 3,
                responsive: [
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 764,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					}
				],
            },
            seopages: [],
            showcapacitybool: false,
            pageUrl: window.location.href,

            facebookShareCount: 0,
            twitterShareCount: 0,
            socialMediaLink: null,
		}
	},

	created(){
		this.getdata();
		var favcookie = this.readCookie('vo-fav');
		var favcookiedata = JSON.parse(favcookie);
		var favarray = favcookiedata;
		if (favarray){
			if(favarray.indexOf(this.fichedata.post_id) > -1){
				this.isfavourite = true;
			} else{
		    	this.isfavourite = false;
			}
		}
	    this.insertaction('view');

	    this.createSocialMediaLink(); 
	    this.createShareLink();
	    this.getShareData();
	},

	watch: {
		fichedataprop: function (val){
			this.getdata();
		},
	},

	methods: {
		createSocialMediaLink(){
			var socialMediaLink = this.fichedata.social_media_link.match(/\bhttps?:\/\/\S+/gi).toString().replace(/"/g,'')
			socialMediaLink = socialMediaLink.split(',')[0];

			console.log(socialMediaLink);

			this.socialMediaLink = socialMediaLink;
		},
		createShareLink(){
			var vm = this;
			var url = window.location.href;
			url = url.replace('.loc/', '.com/');
			url = encodeURI(url);
			
			this.facebookShareLink = 'https://www.facebook.com/sharer.php?u='+url;
			this.twitterShareLink = 'https://twitter.com/intent/tweet?text=&url='+url;
			this.linkedinShareLink = 'https://www.linkedin.com/shareArticle?mini=true&url='+url;
		},
		getShareData(){
			var vm = this;
			var url = window.location.href;
			url = url.replace('.loc/', '.com/');

			// FACEBOOK API
			var data = {
				//fields: 'id,share,og_object{engagement{reaction_count},likes.summary(true).limit(0),comments.limit(0).summary(true)}',
				id: url
			}
	        this.$http.get('https://graph.facebook.com/', {params: data})
	        .then(function (response){
                console.log('%c' + 'Response Facebook', 'color: white; font-size: 18px;');
                console.log(response);
                var facebookShareCount = response.body.share.share_count;
                this.facebookShareCount = facebookShareCount;
            }, function(error){ console.log(error); });

   //          // TWITTER API
			// var data = {
			// 	url: url
			// }
	  //       this.$http.get('https://public.newsharecounts.com/count.json', {params: data})
	  //       .then(function (response){
   //              console.log('%c' + 'Response Twitter', 'color: white; font-size: 18px;');
   //              var twitterShareCount = response.body.count;
   //              this.twitterShareCount = twitterShareCount;
   //          }, function(error){ console.log(error); });

		},
		shareCountIncrement(socialService){
			if(socialService == 'facebook'){
				this.facebookShareCount = this.facebookShareCount + 1;
			} else if(socialService == 'twitter'){
				this.twitterShareCount = this.twitterShareCount + 1;
			} else if(socialService == 'linkedin'){
				this.linkedinShareCount = this.linkedinShareCount + 1;
			}
		},
		getdata(){
	    	this.fichedata = this.fichedataprop;
	    	this.favourites = this.favouritesprop;

	    	var latlngvalues = {
	    		lat: this.fichedata.lat,
	    		lng: this.fichedata.lng,
	    	}

	    	var address = this.fichedata.address;
			var addressSplit = address.split(',');
			this.fichedata.address = addressSplit;

	    	EventBus.$emit('setsinglemarkerlatlng', latlngvalues);
	    	EventBus.$emit('disableloading');

	    	console.log(this.fichedata.post_id);
	    },
	    makefavourite(){
	    	if (this.isfavourite == true) {
	    		window.location = "/mijn-favorieten/";
	    	}

	    	this.favourites = parseInt(this.favourites) + 1;
			this.isfavourite = true;
			EventBus.$emit('favourite', this.fichedata.post_id);
			
	        var formData = new FormData();
			formData.append('action', 'update_favourite');
			formData.append('id',  JSON.stringify(this.fichedata.post_id));
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
	        });
	    },

		//Decode html to correctly view special chars
		decodeHtml(html) {
			var txt = document.createElement("textarea");
			txt.innerHTML = html;
			return txt.value;
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
			EventBus.$emit('clickofferpopup', this.fichedata.parent_post_id, this.fichedata.short_title);
	        this.insertaction('email');
		},
		showphone(){
			this.showphonebool = true;
	        this.insertaction('phone');
		},
		showcapacity(){
			this.showcapacitybool = true;
	        this.insertaction('capacity');
		},
		visitwebsite(){
	        this.insertaction('visit');

	        // go to external link template and pass fichedata.external_link
			var urlpath = window.location.pathname.split('/');
			var lang = urlpath[1];

	        var url = this.fichedata.external_link;
	        // url = url.replace(/^(http?:\/\/)?(www\.)?/,'');
	        // url = url.replace(/^(https?:\/\/)?(www\.)?/,'');
	        // url = '//' + url;

	        var parent_post_id = this.fichedata.parent_post_id;
	        var short_title = this.fichedata.short_title;

			// localStorage.setItem("external_link_url", url);
			// localStorage.setItem("external_link_post_id", parent_post_id);
			// localStorage.setItem("external_link_short_title", short_title);

			window.location.href = '/' + lang + '/external-link/?id='+parent_post_id+'&url='+url+'&title='+short_title+'';
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








