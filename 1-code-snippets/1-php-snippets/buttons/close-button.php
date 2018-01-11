<style type="text/css" media="screen">
	.container{
		position: relative;
	}
	.close{
		position: absolute;
		width: 20px;
		top: 0;
		right: 0;
		margin: 1em;
		transition: all .3s;
		&:hover{
			cursor: pointer;
			transform: rotate(90deg);
		}
	}
</style>

<img class="close" src="<?php echo get_bloginfo('template_url') ?>/dist/img/close.svg" alt="close">
<img target=".sub-blok-container" class="close" src="<?php echo get_bloginfo('template_url') ?>/dist/img/close.svg" alt="close">

<script type="text/javascript" charset="utf-8" async defer>
	
	$('.close').click(function(){

	});

	$('.close').click(function(){
		$(this).parent().closest('div').removeClass('show-sub-blok-container');
	});

	$('.close').click(function(){
		var target = $(this).attr('target');
		$(target).removeClass('show-sub-blok-container');
	});

</script>






