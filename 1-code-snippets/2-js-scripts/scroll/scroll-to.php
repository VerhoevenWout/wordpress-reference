<script>
	var anchorTop = $('[url_value = '+activeItem+']').offset().top;
	if (anchorTop > 450){
	    scrollToObject(anchorTop);
	}

	function scrollToObject(anchorTop){
	    $body.animate({
	        scrollTop: anchorTop
	    }, 500);
	    return false;
	}
</script>