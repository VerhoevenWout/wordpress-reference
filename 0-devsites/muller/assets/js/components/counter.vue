<template>
	<li id="counter">
		<div class="quantity">
			<span>{{ inputvalue }}</span>
			<div  class="quantity-nav">
				<div v-on:click='countup' class="quantity-button quantity-up">
					<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#85878a;stroke-miterlimit:10"></polyline></svg>
				</div>
				<div v-on:click='countdown' class="quantity-button quantity-down">
					<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#85878a;stroke-miterlimit:10"></polyline></svg>
				</div>
			</div>
		</div>
		<div v-on:click='addtocart()' class="add-button">
			<i v-show="typeof cart.cart[id] === 'undefined'" class="fa fa-shopping-cart" aria-hidden="true"></i><span v-show="typeof cart.cart[id] === 'undefined'" >{{ add }}</span>
			<i v-show="typeof cart.cart[id] !== 'undefined'" class="fa fa-check" aria-hidden="true"></i><span v-show="typeof cart.cart[id] !== 'undefined'">{{ added }}</span>
		</div>
	</li>
</template>

<script>
	var Vue = require('vue');

	export default {
		name: 'counter',

		props: ['count', 'id', 'add', 'added'],

		data: function () {
    		return {
				step: 1,
				inputvalue: 1, 
				cart: {},
			}
		},

		created: function() {
			this.step = this.count;
			this.inputvalue = this.count
			if (window.localStorage.getItem('cart')){
				var cart = window.localStorage.getItem('cart');
				cart = JSON.parse(cart);
				if(Object.keys(cart).length === 0 && cart.constructor === Object){
					this.cart = {
						cart: {},
						naam: '',
						opmerking: ''
					};
				}else{
					this.cart = cart;

					if(this.cart.cart[this.id] !== undefined){
						this.inputvalue = this.cart.cart[this.id];
					}
				}
			} else{
				this.cart = {
					cart: {},
					naam: '',
					opmerking: ''
				};
			}
		},

		methods: {
			countup: function(){
				this.inputvalue += this.step;

				if(this.cart.cart[this.id] !== undefined){
					this.addtocart();
				}
			},
			countdown: function(){
				if(this.inputvalue > this.step){
					this.inputvalue -= this.step;

					if(this.cart.cart[this.id] !== undefined){
						this.addtocart();
					}
				}
			}, 
			addtocart: function(){	
				this.$set(this.cart.cart, this.id, this.inputvalue);
				window.localStorage.setItem('cart', JSON.stringify(JSON.parse(JSON.stringify(this.cart))) );
			}
		} 
	}

</script>