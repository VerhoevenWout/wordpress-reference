<style type="text/css" media="screen">
.arrow-up {
	width: 0; 
	height: 0; 
	border-left: 20px solid transparent;
	border-right: 20px solid transparent;
	border-bottom: 20px solid $dark-gray;
}

.arrow-down {
	width: 0; 
	height: 0; 
	border-left: 20px solid transparent;
	border-right: 20px solid transparent;
	border-top: 20px solid $dark-gray;
}

.sub-blok-arrow{
	position: absolute;
	left: 0;
	right: 0;
	bottom: -20px;
	margin: auto;
	display: none;
}
</style>

<span class="sub-blok-arrow arrow-up sub-blok-arrow-<?php echo $key ?>"></span>

<script type="text/javascript" charset="utf-8" async defer>
	
	var $ = require('jquery');

	$('.open-dropdown-trigger').click(function(){
		var subBlokDataID = $(this).attr('sub-blok-data-id');
		
		$('.sub-blok-container').removeClass('show-js-element');
		$('.sub-blok-arrow').removeClass('show-js-element');

		$('.sub-blok-container-' + subBlokDataID).addClass('show-js-element');
		$('.sub-blok-arrow-' + subBlokDataID).addClass('show-js-element');
	});

	$('.close').click(function(){
		var target = $(this).attr('target');
		$(target).removeClass('show-js-element');
		$(target).removeClass('show-js-element');
	});

</script>