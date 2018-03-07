<template>
	<div class='product-slider'>
		<a class="slider-arrow left" v-on:click="move('left')"><svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#231f20;stroke-miterlimit:10"/></svg></a>
		<div class='overflow'>
		<ul v-bind:style='sliderstyle' >
			<li v-for='image in images2' ><img v-bind:src='image[0]'></li>
		</ul>
		</div>
		<a class="slider-arrow right" v-on:click="move('right')"><svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#231f20;stroke-miterlimit:10"/></svg></a>
	</div>
</template>

<script>
	var Vue = require('vue');

	export default {
		name: 'slider',

		props: ['images'],

		data: function () {
    		return {
				imagecount: 0,
				currentimg: 0,
				sliderstyle: {
					'transform' : 'translate3d(0%, 0px, 0px)',
					'width' : '100%'
				}, 
				imgstyle: {
					'width' : '100%'
				},
				images2: {}
			}
		},

		created: function() {
			var images = JSON.parse(this.images);
			this.imagecount = images.length;

			for (var i = 0; i < this.imagecount; i++) {
			   images[i][4] = i;
			   Vue.set(this.images2, i, images[i]);
			}			

			var width = this.imagecount*100;
			var widthimg = 100/this.imagecount;
			this.sliderstyle['width'] = width+'%';
			//this.imgstyle['width'] = widthimg+'%';
		},
		
		methods: {
			move: function(direction){

				if(direction == 'right'){
					this.currentimg = this.currentimg+1;	
				}else{
					this.currentimg = this.currentimg-1;
				}
				
				var vw = this.currentimg*(100/this.imagecount);
				this.sliderstyle['transform'] = 'translate3d(-'+vw+'%, 0px, 0px)';
 			}
		} 
	}

</script>