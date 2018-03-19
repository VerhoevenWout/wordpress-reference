<style type="text/css" media="screen">
	#return-to-top {
	    position: fixed;
	    bottom: 2em;
	    right: 2em;
	    background: $red;
	    width: 4em;
	    height: 4em;
	    text-align: center;
	    display: block;
	    text-decoration: none;
	    border-radius: 35px;
	    opacity: 0;
	    transition: all 0.2s;
	    z-index: 9999;
	    &:hover {
	        opacity: 1!important;
	        cursor: pointer;
	        i {
	            color: #fff;
	            transform: translateY(-5px);
	        }
	    }
	    i {
	        color: #fff;
	        margin: 0;
	        position: relative;
	        font-size: 3rem;
	        padding: .4em 0;
	        -webkit-transition: all 0.3s ease;
	        -moz-transition: all 0.3s ease;
	        -ms-transition: all 0.3s ease;
	        -o-transition: all 0.3s ease;
	        transition: all 0.3s ease;
	    }
	}
	.return-to-top-show{
	    opacity: .8!important;
	}
</style>

<div id="return-to-top"><i class="fa fa-angle-up"></i></div>

<script>
	$(window).scroll(function() {
	    if ($(this).scrollTop() >= 200) {        // If page is scrolled more than 50px
	        $('#return-to-top').addClass('return-to-top-show');    // Fade in the arrow
	    } else {
	        $('#return-to-top').removeClass('return-to-top-show');   // Else fade out the arrow
	    }
	});
	$('#return-to-top').click(function() {
	    $('body,html').animate({
	        scrollTop : 0
	    }, 500);
	});
</script>