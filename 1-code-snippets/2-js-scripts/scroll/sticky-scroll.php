<script>
	
	// --------------------------------------------------------------------
	// SIDEBAR FIXED ON HITTING TOP AND RELATIVE ON BOTTOM
	if (document.body.className.match('single-venues')){
		// medium
    	if (window.innerWidth > 764){
    		var topOffset = 40;
    		var bottomOffset = 65;
			var topvalue = '155px';
			var bottomvalue = '-110px';
    	}
		// xmedium
    	if (window.innerWidth > 956){
    		var topOffset = 70;
    		var bottomOffset = 65;
			var topvalue = '190px';
			var bottomvalue = '-115px';
    	}
	} else{
		// medium
		if (window.innerWidth > 764){
			var topOffset = 50;
			var bottomOffset = 75;
			var topvalue = '50px';
			var bottomvalue = '0';
		}
		// xmedium
    	if (window.innerWidth > 956){
			var topvalue = '50px';
			var bottomvalue = '0';
		}
	}

	if ($('.sidebar').length) {
		var sidebar = $('.sidebar');
		var seoblock = $('.seo-block');
	    var offset = sidebar.offset();
	    var offsetSeoblock = seoblock.offset();
	    var topPadding = 0;
	    $(window).scroll(function() {
	    	if (window.innerWidth > 764) {
	    		if ($(window).scrollTop() > offset.top - topOffset) {
		            sidebar.css({
		                'position': 'fixed',
		                'top': topvalue,
		                'bottom': '',
		            });
		            var bottomPos = $(window).scrollTop() + $(window).height()
		        	if ( (sidebar.offset().top + sidebar.height()) >= offsetSeoblock.top - bottomOffset ) {
			            sidebar.css({
			                'position': 'absolute',
			                'top': '',
			                'bottom': bottomvalue,
			            });
			        } 
		        } else {
		            sidebar.css({
		                'position': '',
		                'top': '',
			            'bottom': '',
		            });
		        }
	    	}
	    });
	}

</script>