<style type="text/css" media="screen">
	.disabled{
		opacity: 0;
		transform: translateY(2em);
    	pointer-events: none;
	}
</style>

<div class="password-protect">
	<!-- inner code -->
</div>

<script>
	$(document).mouseup(function(e){
	    var container = $('.password-popup');
	    if (!container.is(e.target) && container.has(e.target).length === 0){
			$('.password-popup').addClass('disabled');
	    }
	});
</script>