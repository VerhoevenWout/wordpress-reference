<template>
	<div class="search-container columns" v-bind:class="classObject">
		<form action="#" class=''>

			<div class="primary-searchbox">
				<div class="basic-search-params">
					<div class="select-container" v-bind:class="{ 'dropdownIsActive focus-blue': dropdownIsActive.activiteitdropdown }">
						<span class="openSearchDropdown text light" v-on:click="openSearchDropdown('activiteitdropdown')">
							<span v-if="filterdata.taxs.activiteit == 'all'">{{ this.translations[18] }}</span>
							<span v-if="filterdata.taxs.activiteit != 'all'">
								{{ activityvalue }}
							</span>
							<span class="fa fa-chevron-down"></span>
						</span>
						<ul class="light">
							<li v-model="filterdata.taxs.activiteit" v-for="activiteit in taxs.activiteit" v-on:click.prevent="selectIndividualCheckboxValueActivity(activiteit.term_id, 'nosubmit')" v-bind:class="{ 'activeCheckboxValue': activiteit.term_id == filterdata.taxs.activiteit }">
								<input type="checkbox" 
									   v-model="filterdata.taxs.activiteit" 
									   v-bind:value="activiteit.term_id"
									   v-bind:id="activiteit.term_id"
									   class="hidden" 
								>
								<label v-bind:for="activiteit.term_id">
									{{ activiteit.name }}
								</label>
							</li>
							<li v-on:click.prevent="selectIndividualCheckboxValueActivity('all', 'nosubmit')" v-bind:class="{ 'activeCheckboxValue': filterdata.taxs.activiteit == 'all' }">
								<input type="checkbox" 
									   class="hidden" 
								>
								<label>
									{{ this.translations[19] }}
								</label>
							</li>
						</ul>
					</div>

					<input type="text" class="autocomplete1" :placeholder="locatie">
					<!-- <gmap-autocomplete ref="search" class="gmap-autocomplete" @keydown.native.enter.prevent :placeholder="locatie" @place_changed="getAddressData" :componentRestrictions="{country: ['be','nl','fr','de','it','lu','ma','es','tu']}" :types="['(regions)']" :select-first-on-enter="true"></gmap-autocomplete> -->

					<button type="submit" class="btn primary small-24 medium-7 xmedium-6 semi-bold" v-on:click.prevent="setAddressData();">
						{{ this.translations[0] }}
						<span class="icon-arrow-right" ></span>
					</button>
				</div>

				<div class="advanced-search-params">
					<div class="top-part">
						<span class="text light text1">{{ this.translations[20] }}</span>

						<div class="select-container" v-bind:class="{ 'dropdownIsActive focus-blue': dropdownIsActive.activiteitdropdown }">
							<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('activiteitdropdown');">
								<span v-if="filterdata.taxs.activiteit == 'all'">{{ this.translations[18] }}</span>
								<span v-if="filterdata.taxs.activiteit != 'all'">
									{{ activityvalue }}
								</span>
								<span class="fa fa-chevron-down"></span>
							</span>
							<ul class="light">
								<li v-model="filterdata.taxs.activiteit" v-for="activiteit in taxs.activiteit" v-on:click.prevent="selectIndividualCheckboxValueActivity(activiteit.term_id)" v-bind:class="{ 'activeCheckboxValue': activiteit.term_id == filterdata.taxs.activiteit }">
									<input type="checkbox" 
										   v-model="filterdata.taxs.activiteit" 
										   v-bind:value="activiteit.term_id"
										   v-bind:id="activiteit.term_id"
										   class="hidden" 
									>
									<label v-bind:for="activiteit.term_id">
										{{ activiteit.name }}
									</label>
								</li>
								<li v-on:click.prevent="selectIndividualCheckboxValueActivity('all')" v-bind:class="{ 'activeCheckboxValue': filterdata.taxs.activiteit == 'all' }">
									<input type="checkbox" 
										   class="hidden" 
									>
									<label>
										{{ this.translations[19] }}
									</label>
								</li>
							</ul>
						</div>

						<span class="text light text2">in</span>
						<div class="select-container select-container-autocomplete" v-bind:class="{ 'dropdownIsActive focus-blue': dropdownIsActive.locatieDropdown }">
							<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('locatieDropdown')">
								<span v-if="locatie">
									{{ locatie }}
								</span>
								<span v-if="!locatie">
									{{ this.translations[64] }}
								</span>
								<span class="fa fa-chevron-down"></span>
							</span>
							<ul class="light">
								<li class="noPadding">
									<input type="text" class="autocomplete2" :placeholder="locatie">
									<!-- <gmap-autocomplete class="gmap-autocomplete" @keydown.native.enter.prevent :placeholder="locatie" @place_changed="getAddressData" :componentRestrictions="{country: ['be','nl','fr','de','it','lu','ma','es','tu']}" :types="['(regions)']" :select-first-on-enter="true"></gmap-autocomplete> -->
								</li>
							</ul>
						</div>

						<a class="text showparams" v-on:click="resetSearchDropdown()">
							<span>{{ this.translations[66] }}</span>
							<i class="fa fa-sliders" aria-hidden="true"></i>
						</a>

					</div>
					<div class="bottom-part">
						<div class="bottom-part-wrapper">
							<div class="select-container radius" v-bind:class="{ 'dropdownIsActive focus-blue': dropdownIsActive.afstandDropdown }">
								<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('afstandDropdown')">
									<span v-if="filterdata.radius == '1000'">Radius</span>
									<span v-if="filterdata.radius != '1000'">{{ filterdata.radius }}km</span>
									<span class="fa fa-chevron-down"></span>
								</span>
								<ul class="light">
									<li v-on:click.prevent="selectIndividualCheckboxValueRadius('10')" v-bind:class="{ 'activeCheckboxValue': filterdata.radius == '10' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 10km	
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValueRadius('25')" v-bind:class="{ 'activeCheckboxValue': filterdata.radius == '25' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 25km	
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValueRadius('50')" v-bind:class="{ 'activeCheckboxValue': filterdata.radius == '50' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 50km	
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValueRadius('100')" v-bind:class="{ 'activeCheckboxValue': filterdata.radius == '100' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 100km	
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValueRadius('1000')" v-bind:class="{ 'activeCheckboxValue': filterdata.taxs.radius == 'all' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[23] }}
										</label>
									</li>
								</ul>
							</div>


							<div class="select-container persons" v-bind:class="{ 'dropdownIsActive focus-blue': dropdownIsActive.personenDropdown }">
								<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('personenDropdown')">
									<span v-if="filterdata.persons == 'all'">{{ this.translations[9][0].toUpperCase() + this.translations[9].slice(1) }}</span>
									<span v-if="filterdata.persons != 'all'">{{ filterdata.persons }} {{ this.translations[9] }}</span>
									<span class="fa fa-chevron-down"></span>
								</span>
								<ul class="light mobile-offset1">
									<li v-on:click.prevent="selectIndividualCheckboxValuePersons('25')" v-bind:class="{ 'activeCheckboxValue': filterdata.persons == '25' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 25 {{ this.translations[9] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValuePersons('50')" v-bind:class="{ 'activeCheckboxValue': filterdata.persons == '50' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 50 {{ this.translations[9] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValuePersons('100')" v-bind:class="{ 'activeCheckboxValue': filterdata.persons == '100' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 100 {{ this.translations[9] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValuePersons('250')" v-bind:class="{ 'activeCheckboxValue': filterdata.persons == '250' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 250 {{ this.translations[9] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValuePersons('500')" v-bind:class="{ 'activeCheckboxValue': filterdata.persons == '500' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 500 {{ this.translations[9] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValuePersons('500+')" v-bind:class="{ 'activeCheckboxValue': filterdata.persons == '500+' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[24] }} 500 {{ this.translations[9] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValuePersons('all')" v-bind:class="{ 'activeCheckboxValue': filterdata.taxs.persons == 'all' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[23] }}
										</label>
									</li>
								</ul>
							</div>

							<div class="select-container halls" v-bind:class="{ 'dropdownIsActive focus-blue': dropdownIsActive.zalenDropdown }">
								<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('zalenDropdown')">
									<span v-if="filterdata.halls == 'all'">{{ this.translations[10][0].toUpperCase() + this.translations[10].slice(1)}}</span>
									<span v-if="filterdata.halls != 'all'">{{ filterdata.halls }} {{ this.translations[10] }}</span>
									<span class="fa fa-chevron-down"></span>
								</span>
								<ul class="light mobile-offset2">
									<li v-on:click.prevent="selectIndividualCheckboxValueHalls('3')" v-bind:class="{ 'activeCheckboxValue': filterdata.halls == '3' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 3 {{ this.translations[10] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValueHalls('5')" v-bind:class="{ 'activeCheckboxValue': filterdata.halls == '5' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[22] }} 5 {{ this.translations[10] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValueHalls('5+')" v-bind:class="{ 'activeCheckboxValue': filterdata.halls == '5+' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[24] }} 5 {{ this.translations[10] }}
										</label>
									</li>
									<li v-on:click.prevent="selectIndividualCheckboxValueHalls('all')" v-bind:class="{ 'activeCheckboxValue': filterdata.taxs.halls == 'all' }">
										<input type="checkbox" 
											   class="hidden" 
										>
										<label>
											{{ this.translations[23] }}
										</label>
									</li>
								</ul>
							</div>
						</div>

						<div class="secondary-searchbox">
							<div class="select-container small-24 columns" v-bind:class="{ 'dropdownIsActive focus-gray': dropdownIsActive.type_locatieDropdown }">
								<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('type_locatieDropdown')">
									{{ this.translations[15] }}
									<span class="numbercircle"><span>{{ filterdata.taxs.type_locatie.length }}</span></span>
									<span class="fa fa-chevron-down"></span>
								</span>
								<ul class="light">
									<li v-for="type_locatie in taxs.type_locatie">
										<input type="checkbox" 
											   v-model="filterdata.taxs.type_locatie" 
											   v-bind:value="type_locatie.term_id"
											   v-bind:id="type_locatie.term_id"	   
										>
										<label v-bind:for="type_locatie.term_id" >
											{{ type_locatie.name }}
										</label>
									</li>
								<a class="dropdownButton closeDropdown light" v-on:click="resetSearchDropdown">{{ this.translations[28] }}</a>
								<a class="dropdownButton submitDropdown semi-bold" v-on:click="submitSearchDropdown()">{{ this.translations[29] }}</a>
								</ul>
							</div>
							<div class="select-container small-24 columns" v-bind:class="{ 'dropdownIsActive focus-gray': dropdownIsActive.faciliteitDropdown }">
								<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('faciliteitDropdown')">
									{{ this.translations[16] }}
									<span class="numbercircle"><span>{{ filterdata.taxs.faciliteit.length }}</span></span>
									<span class="fa fa-chevron-down"></span>
								</span>
								<ul class="light">
									<li v-for="faciliteit in taxs.faciliteit">
										<input type="checkbox" 
											   v-model="filterdata.taxs.faciliteit" 
											   v-bind:value="faciliteit.term_id"
											   v-bind:id="faciliteit.term_id"	   
										>
										<label v-bind:for="faciliteit.term_id" >
											{{ faciliteit.name }}
										</label>
									</li>
								<a class="dropdownButton closeDropdown light" v-on:click="resetSearchDropdown">{{ this.translations[28] }}</a>
								<a class="dropdownButton submitDropdown semi-bold" v-on:click="submitSearchDropdown()">{{ this.translations[29] }}</a>
								</ul>
							</div>
							<div class="select-container small-24 columns" v-bind:class="{ 'dropdownIsActive focus-gray': dropdownIsActive.liggingDropdown }">
								<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('liggingDropdown')">
									{{ this.translations[0] }}
									<span class="numbercircle"><span>{{ filterdata.taxs.ligging.length }}</span></span>
									<span class="fa fa-chevron-down"></span>
								</span>
								<ul class="light">
									<li v-for="ligging in taxs.ligging">
										<input type="checkbox" 
											   v-model="filterdata.taxs.ligging" 
											   v-bind:value="ligging.term_id"
											   v-bind:id="ligging.term_id"	   
										>
										<label v-bind:for="ligging.term_id" >
											{{ ligging.name }}
										</label>
									</li>
								<a class="dropdownButton closeDropdown light" v-on:click="resetSearchDropdown">{{ this.translations[28] }}</a>
								<a class="dropdownButton submitDropdown semi-bold" v-on:click="submitSearchDropdown()">{{ this.translations[29] }}</a>
								</ul>
							</div>
							<a v-on:click="clearSelection()" class="btn primary clear-selection" title="">{{ this.translations[31] }}</a>
							<div class="mobile-submit-container">
								<a class="btn closeDropdown light" v-on:click="resetSearchDropdown">{{ this.translations[28] }}</a>
								<a class="btn submitDropdown semi-bold" v-on:click="submitSearchDropdown()">{{ this.translations[29] }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="secondary-searchbox small-24 large-16 columns">
				<div class="select-container small-8 columns" v-bind:class="{ 'dropdownIsActive focus-gray': dropdownIsActive.type_locatieDropdown }">
					<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('type_locatieDropdown')">
						{{ this.translations[15] }}
						<span class="numbercircle"><span>{{ filterdata.taxs.type_locatie.length }}</span></span>
						<span class="fa fa-chevron-down"></span>
					</span>
					<ul class="light">
						<li v-for="type_locatie in taxs.type_locatie">
							<input type="checkbox" 
								   v-model="filterdata.taxs.type_locatie" 
								   v-bind:value="type_locatie.term_id"
								   v-bind:id="type_locatie.term_id"	   
							>
							<label v-bind:for="type_locatie.term_id" >
								{{ type_locatie.name }}
							</label>
						</li>
					<a class="dropdownButton closeDropdown light" v-on:click="resetSearchDropdown">{{ this.translations[28] }}</a>
					<a class="dropdownButton submitDropdown semi-bold" v-on:click="submitSearchDropdown()">{{ this.translations[29] }}</a>
					</ul>
				</div>
				<div class="select-container small-8 columns" v-bind:class="{ 'dropdownIsActive focus-gray': dropdownIsActive.faciliteitDropdown }">
					<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('faciliteitDropdown')">
						{{ this.translations[16] }}
						<span class="numbercircle"><span>{{ filterdata.taxs.faciliteit.length }}</span></span>
						<span class="fa fa-chevron-down"></span>
					</span>
					<ul class="light">
						<li v-for="faciliteit in taxs.faciliteit">
							<input type="checkbox" 
								   v-model="filterdata.taxs.faciliteit" 
								   v-bind:value="faciliteit.term_id"
								   v-bind:id="faciliteit.term_id"	   
							>
							<label v-bind:for="faciliteit.term_id" >
								{{ faciliteit.name }}
							</label>
						</li>
					<a class="dropdownButton closeDropdown light" v-on:click="resetSearchDropdown">{{ this.translations[28] }}</a>
					<a class="dropdownButton submitDropdown semi-bold" v-on:click="submitSearchDropdown()">{{ this.translations[29] }}</a>
					</ul>
				</div>
				<div class="select-container small-8 columns" v-bind:class="{ 'dropdownIsActive focus-gray': dropdownIsActive.liggingDropdown }">
					<span class="openSearchDropdown text semi-bold" v-on:click="openSearchDropdown('liggingDropdown')">
						{{ this.translations[0] }}
						<span class="numbercircle"><span>{{ filterdata.taxs.ligging.length }}</span></span>
						<span class="fa fa-chevron-down"></span>
					</span>
					<ul class="light">
						<li v-for="ligging in taxs.ligging">
							<input type="checkbox" 
								   v-model="filterdata.taxs.ligging" 
								   v-bind:value="ligging.term_id"
								   v-bind:id="ligging.term_id"	   
							>
							<label v-bind:for="ligging.term_id" >
								{{ ligging.name }}
							</label>
						</li>
					<a class="dropdownButton closeDropdown light" v-on:click="resetSearchDropdown">{{ this.translations[28] }}</a>
					<a class="dropdownButton submitDropdown semi-bold" v-on:click="submitSearchDropdown()">{{ this.translations[29] }}</a>
					</ul>
				</div>
				<a v-on:click="clearSelection()" class="btn primary clear-selection" title="">{{ this.translations[31] }}</a>
			</div>

			<div class="mobile-params-overlay"></div>

		</form>
	</div>

</template>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABxEL5TeJO7-jdW4YYveUdxIwVGLkMjH8"></script> -->
<!-- <script src="https://apis.google.com/js/api.js" type="text/javascript"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/places.js@1.4.18"></script> -->


<script>
var $ = jQuery.noConflict();


var places = require('places.js');
import { EventBus } from '../helper/event.js';
import postcodes from '../data/zipcode-belgium.json';
import md5 from 'md5';

export default {
	name: 'search',
	props: [
		'search-active',
		'translations',
		'langprop',
		'searchprop',
	],

	data(){
		return{
			dropdownIsActive: {
				activiteitdropdown: false,
				locatieDropdown: false,
				afstandDropdown: false,
				personenDropdown: false,
				zalenDropdown: false,
				type_locatieDropdown: false,
				faciliteitDropdown: false,
				liggingDropdown: false
			},
			postcodes: postcodes, 
			locationdata: null,
			locatie: 'Brussel',
			taxs: {
				activiteit: {},
				faciliteit: {},
				ligging: {},
				type_locatie: {}
			},
			filterdata : {
				lat : '50.8503396',
				lng : '4.351710300000036',
				radius : '1000',
				persons : 'all',
				halls : 'all',
				taxs :{
					activiteit: 'all', 
					faciliteit: [],
					ligging: [],
					type_locatie: []
				}
			},
			lang: null,
		}
	},

	computed: {
		classObject: function () {
			return {
			  'small-20 medium-20 xmedium-20 large-16 xlarge-12': !this.searchActive ,
			  'large-24': this.searchActive
			}
		}
	},

	created(){
		if (this.langprop){
			this.lang = this.langprop;
		} else{
			var urlpath = window.location.pathname.split('/');
			this.lang = urlpath[1];
		}
		this.setPlaceholder();
		this.gettaxs();
	},

	mounted() {
		EventBus.$on('getfiches', this.getfiches);
		EventBus.$on('clickDocument', this.clickDocument);
		this.initAutocomplete();
	},

	methods: {
		initAutocomplete(){
			var searchLanguage;
			if (this.lang == 'fr'){
				searchLanguage = 'fr'
			} else if(this.lang == 'en'){
				searchLanguage = 'en'
			}else{
				searchLanguage = 'nl'
			}

			var placesAutocomplete1 = places({
				container: document.querySelector('.autocomplete1'),
				countries: ['be','nl','fr','de','it','lu','ma','es','tu'],
				language: searchLanguage,
			});
			var placesAutocomplete2 = places({
				container: document.querySelector('.autocomplete2'),
				countries: ['be','nl','fr','de','it','lu','ma','es','tu'],
				language: searchLanguage,
			});

			var vm = this;
			placesAutocomplete1.on('change', function getAddressData(e) {
				console.log(e.suggestion);
				vm.locationdata = e.suggestion;
				vm.locatie = vm.locationdata.name;
				vm.filterdata.lat = vm.locationdata.latlng.lat;
				vm.filterdata.lng = vm.locationdata.latlng.lng;
			});
			placesAutocomplete2.on('change', function getAddressData(e) {
				console.log(e.suggestion);
				vm.locationdata = e.suggestion;
				vm.locatie = vm.locationdata.name;
				vm.filterdata.lat = vm.locationdata.latlng.lat;
				vm.filterdata.lng = vm.locationdata.latlng.lng;
			});

			$('.autocomplete1, .autocomplete2').on('keyup', function (e) {
			    if (e.keyCode == 13) {
					vm.submitSearchDropdown();
			    }
			});
		},
		setAddressData(){
			if (this.locationdata != null){
			    this.locatie = this.locationdata.name;
				this.filterdata.lat = this.locationdata.latlng.lat;
				this.filterdata.lng = this.locationdata.latlng.lng;
			}
			this.submitSearchDropdown();
		},

		setPlaceholder(){
			if (this.lang == 'fr'){
				this.locatie = 'Bruxelles';
			} else if(this.lang == 'en'){
				this.locatie = 'Brussels';
			}else{
				this.locatie = 'Brussel';
			}
		},
		clickDocument(){
			this.resetSearchDropdown();
		},

		clearSelection(){
			this.filterdata.taxs.faciliteit 	= [];
			this.filterdata.taxs.ligging 		= [];
			this.filterdata.taxs.type_locatie 	= [];
			this.submitSearchDropdown();
		},

		checkSeoSearchContent(){
			if (this.searchprop){
				this.locatie = this.searchprop[1];

				this.filterdata.lat = this.searchprop[3];
				this.filterdata.lng = this.searchprop[4];

				if (typeof this.searchprop[0] === 'object'){
					this.filterdata.taxs.activiteit = this.searchprop[0].term_id;
				} else{
					this.filterdata.taxs.activiteit = this.searchprop[0];
				}

				if (this.searchprop[2] == 'all'){
					this.filterdata.taxs.type_locatie = [];
				} else{
					if (typeof this.searchprop[2] === 'object'){
						this.filterdata.taxs.type_locatie = [ this.searchprop[2].term_id ];
					} else{
						this.filterdata.taxs.type_locatie = [ this.searchprop[2] ];
					}
				}
				this.setActivityValue();
				this.getfiches('nospoof');
			} else{
				this.check404data();
			}
		},
		check404data(){
			var data404 = this.readCookie('vo-404-data');
			if(data404){
				var formData = new FormData();
				formData.append('action', 'post_hash_data');
				formData.append('hash', data404);

				this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
					if (response.body){
						if (response.body[0].type == 'searchresult'){
							document.title = 'Search | Venues Online';
							
							this.filterdata = JSON.parse(response.body[0].url_params).searchdata;
							this.setActivityValue();

							this.locatie = JSON.parse(response.body[0].url_params).location;
							this.getfiches();
							this.eraseCookie('vo-404-data');
						}
						if (response.body[0].type == 'favresult'){
							// => SHARED FAV RESULT
							this.createCookie('vo-shared-fav', JSON.parse(response.body[0].url_params), 1);
							window.location = this.lang+"/mijn-favorieten";
						}
						if (response.body[0].type == 'sharedfavresult'){
							// console.log(response.body[0].url_params);
							this.createCookie('vo-shared-fav', JSON.parse(response.body[0].url_params), 1);
							window.location = this.lang+"/mijn-favorieten";
						}
					}
		        });
			}
		},

		setActivityValue(){
			if (this.filterdata.taxs.activiteit){
				if (this.filterdata.taxs.activiteit == 'all'){
					this.activityvalue = 'all';
				} else{
					this.activityvalue = this.taxs.activiteit[this.filterdata.taxs.activiteit].name;
				}
			}
		},

		resetBottomPart(){
			$('.showparams').removeClass('showparams-active');
			$('.bottom-part').removeClass('bottom-part-show');
			$('.mobile-params-overlay').removeClass('mobile-params-overlay-show');
		},

		firepopup(){
			var policycookie = this.readCookie('vo-policycookie');
			if (policycookie == 'Cookies accepted'){
				setTimeout(function(){
					$('.popup-container-2').removeClass('popup-container-2-hide');
				}, 30000);
			}
		},

		setspoofurl(){
			var urlstring = window.location.origin + '/'+this.lang;
	    	history.replaceState(null, null, urlstring);
			var filterdata = {
				searchdata: this.filterdata,
				location: this.locatie,
			}
			var hash = md5(JSON.stringify(filterdata));

			var formData = new FormData();
			formData.append('action', 'post_hash_data');
			formData.append('hash', hash);
			formData.append('filterdata', JSON.stringify(filterdata));
			formData.append('type', '"searchresult"');

			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body){
					history.replaceState(null, null, urlstring+'/'+hash);
					this.createCookie('vo-404-data', hash, 1);

					sessionStorage.setItem("page-search-result", urlstring+'/'+hash);
				} else{
					console.log('setspoofurl() response failed');
				}
	        });
		},
		openSearchDropdown(dropdownElement){
			if (this.dropdownIsActive[dropdownElement] == true) {
				this.resetSearchDropdown();
				$('.results').removeClass('blurObject');
			} else{
				this.resetSearchDropdown();
				this.dropdownIsActive[dropdownElement] = true;
				$('.results').addClass('blurObject');
			}
		},
		resetSearchDropdown(){
			for (var key in this.dropdownIsActive) {
				this.dropdownIsActive[key] = false;
			}
			$('.results').removeClass('blurObject');
		},
		gettaxs(){
			var formData = new FormData();
			formData.append('action', 'get_taxs');
			formData.append('lang', this.lang);
			formData.append('taxs', JSON.stringify(this.taxs));
			
			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				this.taxs = response.body;
				this.checkSeoSearchContent();
	        });
		},
		selectIndividualCheckboxValueActivity(selectedValue, submitvalue){
			this.filterdata.taxs.activiteit = selectedValue;
			if (selectedValue != 'all'){
				this.activityvalue = this.taxs.activiteit[selectedValue].name;
			}

			if (submitvalue == undefined){
				this.submitSearchDropdown();
			}
			console.log('selectIndividualCheckboxValueActivity');
			this.resetSearchDropdown();
		},
		selectIndividualCheckboxValuePersons(selectedValue){
			this.filterdata.persons = selectedValue;
			this.submitSearchDropdown();
		},	
		selectIndividualCheckboxValueRadius(selectedValue){
			this.filterdata.radius = selectedValue;
			this.submitSearchDropdown();
		},
		selectIndividualCheckboxValueHalls(selectedValue){
			this.filterdata.halls = selectedValue;
			this.submitSearchDropdown();
		},
		submitSearchDropdown(){
			document.title = 'Search | Venues Online';
	    	EventBus.$emit('enableloading');
			this.resetSearchDropdown();
			this.getfiches();
			this.firepopup();
			this.resetBottomPart();
		},
		getfiches(spoof){
			this.resetSearchDropdown();
	        var formData = new FormData();
			formData.append('action', 'get_event_fiches');
			formData.append('language', this.lang);
			formData.append('filterdata', JSON.stringify(this.filterdata));
			var ipaddress = sessionStorage.getItem("ipaddress");
			formData.append('ipaddress', ipaddress);

			this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
				if (response.body) {
					EventBus.$emit('getfichecount', this.filterdata);
					EventBus.$emit('setfiches', response.body, this.filterdata, this.locatie, this.taxs, this.translations);
					if (spoof != 'nospoof'){
						this.setspoofurl();
					}
				} else{
					console.log('getfiches: search.vue/getfiches error');
				}
	        });
		},
	
		createCookie(name,value,days){
		    var expires = "";
		    if (days) {
		        var date = new Date();
		        date.setTime(date.getTime() + (days*24*60*60*1000));
		        expires = "; expires=" + date.toUTCString();
		    }
		    document.cookie = name + "=" + value + expires + "; path=/";
		    // document.cookie = name + "=" + value + expires;
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
		eraseCookie(name){
		    this.createCookie(name,"",-1);
		},
		capitalizeFirstLetter(string){
		    return string.charAt(0).toUpperCase() + string.slice(1);
		},
	}
}
</script>