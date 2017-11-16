<!-- click-outside-hide -->

<style type="text/css" media="screen">
.bookingspopup-container{
	position: fixed;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	background: rgba(0,0,0,.7);
	z-index: 999999999999999;

	opacity: 0;
	@include transition(.5s);
	@include selectDisable();
	.bookingspopup{
		position: absolute;
		top: 1em;
		left: 0;
		right: 0;
		height: 80%;
		background: white;
		margin: auto;
		box-shadow: 0px 1px 13px 4px rgba(0, 0, 0, 0.25);
		font-size: 10rem;
	}
}

.bookingspopup-container-enable{
	opacity: 1;
	@include selectEnable();
}
</style>

<div class="bookingspopup-container row expanded">
	<div class="bookingspopup small-8 columns">
		FORM
	</div>
</div>

<script src="/javascripts/application.js" type="text/javascript" charset="utf-8" async defer>
	
	openbookingspopup(){
		$('.bookingspopup-container').addClass('bookingspopup-container-enable');
		
		var mouse_is_inside;
		$('.bookingspopup').hover(function(){ 
	    	mouse_is_inside=true; 
	    }, function(){ 
	        mouse_is_inside=false; 
	    });

	    $('body').mouseup(function(){ 
	        if(! mouse_is_inside){
				$('.bookingspopup-container').removeClass('bookingspopup-container-enable');
	        }
	    });
	}

</script>