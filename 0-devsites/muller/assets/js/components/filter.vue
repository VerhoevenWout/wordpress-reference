<template>
	<div v-show='filtersactive'>
		<h4 v-on:click='togglefilter(true)' v-show='filterdata.title' v-bind:class="{ active: isActive && !loading, 'loading': loading}">
		<svg   id="arrow-cross" v-bind:class="{ active: isActive }" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.96 6.25">
				<title>Naamloos-3</title>
				<rect class='line1' x="7.5" y="-0.5" width="1.04" height="7.76" transform="translate(4.57 -4.93) rotate(45)" />
				<rect class='line2' x="2.76" y="-0.5" width="1.04" height="7.76" transform="translate(-1.6 3.07) rotate(-45)" />
			</svg>
		<div class='loading'
		>
			<div class='spin'></div>
		</div>
			{{ filterdata.title }}
		</h4>
		<ul v-show="Object.keys(filterdata.items).length > 0" v-bind:class="{ active: isActive && !loading, 'filterloader': filterloader}">
			<li v-for="(item, index) in filterdata.items"  v-if="(index != '' )" v-bind:style="{ order: item.order }"  v-bind:class="{ disabled:  getcount(index) == '(0)' }">
				<input  :disabled="getcount(index) == '(0)' || filterloader == true" @change="notify(item, false, index)" v-model="checkedfilter" type="checkbox" v-bind:id="getvalue(item.filter, index)+filterdata.name" v-bind:value="getvalue(item.filter, index)" />
				<label v-bind:for="getvalue(item.filter, index)+filterdata.name">{{ decodeHtml(item.filter.name) }}<span >{{ getcount(index) }}</span></label>
				<ul v-if='havechilderen(item.childeren)' v-bind:class="{ merkennosub: (termparent != 0 && termparent != 7 && termid != 7 && filterdata.name == 'merken') }">
					<li v-for="(child, childindex) in item.childeren" v-bind:class="{ disabled:  getcount(child.filter.value) == '(0)'}"
					   v-bind:style="{ order: child.order }" 
					>
						<input  :disabled="getcount(index) == '(0)' || filterloader == true" @change="notify(child, item.filter.value)" v-model="checkedfilter" v-bind:id="getvalue(child.filter, childindex)" type="checkbox" v-bind:value="getvalue(child.filter, childindex)"  />
						<label v-bind:for="getvalue(child.filter, childindex)">{{ decodeHtml(child.filter.name) }} <span>{{ getcount(child.filter.value) }}</span></label>
					</li>
				</ul>
				<div v-show='item.subfilters.show' v-if="item.subfilters" class='subfilters'>
					<productfilter v-for="subfilter in item.subfilters.filters" :filterdata='subfilter' :subfilter='[filterdata.name, index, item.subfilters.show]' :filtersactive='filtersactive' ></productfilter>
				</div>
			</li>
		</ul>
	</div>
</template>

<script>
	var urlParams = require('url-params');
	import { EventBus } from '../helper/event.js';
	import 'url-search-params-polyfill';


	export default {
		name: 'productfilter',

		props: ['filterdata', 'subfilter', 'filterkey', 'termparent', 'filtersactive', 'countloader' ,'filterloader', 'termid'],

		data: function(){
			return{
				isActive: false,
				checkedfilter: [],
				labelkey: '', 
				count: {},
				interacted: false, 
				loading: false
			}
		},

		 watch: {
		    countloader: function (newQuestion) {
		     	if(this.countloader == false){
		     		this.loading = false;
		     	}
		    }
		},

		created: function() {

			if(this.subfilter != false){
			 	this.filterdata.name = this.filterdata.name+'_'+this.subfilter[1];
			}
		
			if(this.filterdata.name == 'cats'){
				this.isActive = true;
			}
   			
			EventBus.$on('checkparams', this.checkparams);
			EventBus.$on('updatecount', this.updatecount);
			EventBus.$on('updatecheckfilter', this.updatecheckfilter);
		},
		methods: {
			//When filter checkbox is changed 
			notify: function(item, parent, index){

				var filter = item.filter;

				var urlstring = window.location.href;
				var url = urlParams.remove(urlstring, 'page');

				EventBus.$emit('seturl', url);

				if(this.filterdata.type == 'tax'){
					var id = filter.value;
				}else{
					var id = index;
				}

				if(typeof filter != "undefined"){

					if(this.checkedfilter.indexOf(id) != -1){						

						this.check(item);

					}else{

						this.uncheck(item);
					}
				
				}

			}, 
			//When filter checkbox is checked
			check(item){
				
				this.togglesubfilter(item, true);
						
				if(typeof item.childerenIds != "undefined" ){

					for (var key in item.childerenIds) {
						this.checkedfilter.push(parseInt(item.childerenIds[key]));
					}

				}

				this.toQ(this.checkedfilter, this.filterdata.name);
							
				
			},
			//When filter checkbox is unchecked
			uncheck(item){

				this.togglesubfilter(item, false);

				if(typeof item.childerenIds != "undefined" ){
					this.checkedfilter = this.checkedfilter.filter( function( el ) {
					  return !item.childerenIds.includes( String(el) );
					} );
				}




				this.toQ(this.checkedfilter, this.filterdata.name);
				

			},
			//Send filter change to Q 
			toQ(checkedfilter, name){
				
				//Get other merkreeks items if merkreeks
				if(this.filterdata.name == 'merkReeks'){
					var merkreeks = this.filterkey;
				}else{
					var merkreeks = false;
				}

				EventBus.$emit('addtofilterQ', checkedfilter, name, merkreeks);
				
			},
			//Get the count string from the count object
			getcount: function(index){

				if(this.subfilter != false){
				 	var filterkey = this.filterdata.name;
				}else{
					var filterkey = this.filterkey;
				}

				if(typeof this.count[filterkey+'-ITEMKEY-'+index] == 'undefined'){
					return '';
				}else{
					return '('+this.count[filterkey+'-ITEMKEY-'+index]+')';
				}
				

			}, 
			//Enable subfilters under certain cat filters 
			togglesubfilter: function(filter, state){

				if(typeof filter.subfilters != "undefined"  && this.termparent != 0){
					filter.subfilters.show = state;



					if(state == false){

						for(var key in filter.subfilters.filters){
							EventBus.$emit('setactive', filter.subfilters.filters[key].name, true);
						}	

					}else{

						for(var key in filter.subfilters.filters){
							EventBus.$emit('setactive', filter.subfilters.filters[key].name);
						}	
					
					}
				}

			},
			//Open/close the filder sibar panel and get the count for the filters 
			'togglefilter': function(server = true, active = false){
				var urlstring = window.location.href;
				
				if(this.isActive == false || active == true){

					if(server){
						this.loading = true;
					}

					this.isActive = true;
					
					EventBus.$emit('setactive', this.filterkey);
					
					var newUrl = urlParams.add(urlstring, this.filterkey);
					EventBus.$emit('seturl', newUrl);

					if(server == true){
						EventBus.$emit('getcountfromserver');	
					}
			
				}else{
					this.isActive = false;
					EventBus.$emit('setactive', this.filterkey, true);
					
					var newUrl = urlParams.remove(urlstring, this.filterkey);
					EventBus.$emit('seturl', newUrl);

					if(this.checkedfilter.length > 0){
						this.checkedfilter = [];
						this.toQ(this.checkedfilter, this.filterdata.name);
					}
				}

				
			}, 
			//CHeck if filter has childeren
			'havechilderen': function(childeren){
				if(childeren == undefined){
					return false;
				}else{
					
					if(childeren[0] == undefined && this.filterkey == 'cats'){
						return false;
					}else{
						return true;
					}
					
				}

			},
			//Check the url params to check the correct filters 
			'checkparams': function(){
				var urlstring = window.location.href;
				var url = new URL(urlstring);
				var params = new URLSearchParams(url.search);

				if(params.has(this.filterdata.name)){

					if(this.subfilter == false){
						this.togglefilter(true, true);
					}
					
					params = params.get(this.filterdata.name).split(' ');


					for (var key in params) {
						
						if( params[key] != 'true'){
							var itemkey = params[key].replace(new RegExp('"', "g"), '');
							var value = false;
							var filter = false;

							if(this.filterdata.type == 'tax'){
								if(this.filterdata.items[itemkey] != undefined){
									var value = this.filterdata.items[itemkey].filter.value
								}else{
									for (var key2 in this.filterdata.items) {
										if(Object.values(this.filterdata.items[key2].childerenIds).indexOf(itemkey) > -1){
											if(this.filterdata.name == 'merken'){
												var childindex = itemkey;
											}else{
												var childindex = Object.values(this.filterdata.items[key2].childerenIds).indexOf(itemkey);
											}
											
											var value = false;
											if(this.filterdata.items[key2]['childeren'] !== undefined ){
												if(this.filterdata.items[key2].childeren[childindex] !== undefined){
													value = this.filterdata.items[key2].childeren[childindex].filter.value;
													var filter = this.filterdata.items[key2].childeren[childindex];
												}
											}
										}
									}

								}
							}else{
								var value = itemkey;
							}

							if(value != false){
						 		this.checkedfilter.push(value);
						 		if(filter != false){
						 			this.check(filter ,false);
						 		}else{
						 			this.check(this.filterdata.items[itemkey] ,false);
						 		}
						 	}
					 	}
					}

				}else if(this.checkedfilter.length > 0){

					this.checkedfilter = [];
					this.toQ(this.checkedfilter, this.filterdata.name);
				}				

			},
			//Update the count object 
	    	'updatecount': function(count){
	    		if(this.interacted){
	    			this.interacted = false;

	    			if(this.checkedfilter.length == 0){
	    				this.count = count;
	    			}

	    		}else{
	    			this.count = count;
	    		}
	    		
	    	},
	    	//Decode html to correctly view special chars
	    	decodeHtml: function (html) {
		      var txt = document.createElement("textarea");
		      txt.innerHTML = html;
		      return txt.value;
		    },
		    //Update the checkfilter array to check and uncheck the input boxes 
		    updatecheckfilter(name, newfilters){
		    	if(this.filterdata.name == name){
		    		this.checkedfilter = newfilters;
		    	}
		    },
		    //Get the value for a filter
		    getvalue(filter, index){
		    	if(typeof this.filterdata.static == 'undefined'){
		    		return filter.value;
		    	}else{
		    		return index;
		    	}
		    }
		} 
	}

</script>