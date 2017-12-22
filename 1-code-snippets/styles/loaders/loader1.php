<!-- As on venues-online -->

<style type="text/css" media="screen">
	.loading-overlay{
		position: fixed;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		background: white;
		z-index: 99999999;

		opacity: 1;
		transition: all .3s;
		.loading{
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			height: 3em;
	  		width: 3em;
			margin: auto;
	    	animation: rotate 3s cubic-bezier(.36,.07,.19,.97) infinite;

	    	border: 1px solid rgba(0, 0, 0, 0.2);
			border-top-color: rgba(0, 0, 0, 0.7);
			border-radius: 50%;
		}
	}

	@keyframes rotate {
		0%{
		transform: rotate(0deg);
		}
		100%{
		transform: rotate(2160deg);
		}
	}

	.loading-overlay-hide{
		opacity: 0;
	    @include selectDisable;
	}

	@mixin selectDisable{
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-o-user-select: none;
		user-select: none;
		pointer-events: none;
	}
	@mixin selectEnable{ 
		-webkit-user-select: text;
		-khtml-user-select: text; 
		-moz-user-select: text;
		-o-user-select: text;
		user-select: text;
		pointer-events: all;
	}

</style>

<div class="loading-overlay" v-bind:class="{ 'loading-overlay-hide': loading == false }">
	<i class="loading"></i>
</div>