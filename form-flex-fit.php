<style type="text/css" media="screen">
.search-container{
	margin: 18.5em auto 0;
	padding: 1em;
	background: $light-blue;
	font-size: 2.2rem;
	@include transition;
	form{
		width: 100%;
		display: flex;
		flex-direction: row;
		justify-content: space-between;
	}
	select{
		border: 0px solid;
		-webkit-appearance: none;
		-webkit-border-radius: 0px;
		&:after{

		}
	}
	input[type="text"]{
	   	margin: 0 1em;
	   	flex: 1 1 auto;
	}
	button{
		font-size: 1.8rem;
	   	background: $dark-blue;
	   	color: $white;
	   	padding: 0;
		@include hover($green);
		.icon-arrow-right{
			font-size: 1.12rem;
			padding-left: .5em;
			color: $green;
			// @include hoverTransform();
		}
	}
}
</style>

<div class="search-container xlarge-12 large-14 xmedium-20 medium-24 columns">
	<form action="#">
		<select name="venue_type" class="medium-8 columns light">
			<option value="" selected disabled hidden>Je zoekt een locatie voor?</option>
			<option value="vergaderingen">Vergaderingen</option>
			<option value="congres">Congres</option>
			<option value="bedrijfsevent">Bedrijfsevent</option>
		</select>
		<input type="text" name="search" placeholder="Waar?" class="medium-12 columns light">
		<button type="submit" class="medium-6 columns semi-bold">
			Toon Locaties
			<!-- <img class="arrow-right" src="<?php echo get_bloginfo('template_url') ?>/dist/fonts/arrow-right.svg"/> -->
			<span class="icon-arrow-right"></span>
		</button>
	</form>
</div>