<style>

#cookie-banner {
	position: fixed;
	right: 1em; bottom: 1em;
	background-color: $primary;
	color: $white;
	border-radius: 5px;
	padding: 1.5em;
	z-index: 99;
	max-width: 30em;
	margin-left: 1em;
	font-size: .9em;

	a {
		color: $white;
		font-weight: $bold;

		&:hover {
			color: $secundary;
		}
	}

	#cookie-close {
		position: absolute;
		top: -3em;
		right: 0;
		padding: 1.5em 0;
		cursor: pointer;

		span {
			height: .2em;
			width: 2em;
			background-color: $primary;
			display: block;
			transform: rotate(45deg);

			&:before {
				height: .2em;
				width: 2em;
				background-color: $primary;
				display: block;
				transform: rotate(-90deg);
				content: " ";
			}
		}
		&:hover {
			span:before {
				background-color: $red;
			}
		}
	}
}
	
</style>

<?php if(!isset($_COOKIE['visited'])) : ?>
  <div id="cookie-banner">
    <div class="container">
      <span>
        <?php _e('This website uses cookies. By continuing to browse this website, you are agreeing to the use of cookies. Read our <a href="/general-conditions" target="_blank">general conditions</a> for more information on cookies.', 'Cookie'); ?>
      </span>
        <div id="cookie-close">
          <span class="cross"></span>
        </div>
    </div>
  </div>
<?php endif; ?> 

<script>
	'use strict';
	var $ = require('jquery');
	$( document ).ready(function() {
		function getCookie(cname) {
		    var name = cname + "=";
		    var ca = document.cookie.split(';');

		    for (var i=0; i < ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0)==' ') c = c.substring(1);
		        if (c.indexOf(name) === 0) return c.substring(name.length,c.length);
		    }

		    return false;
		}

		function setCookie(cname, cvalue) {
			var d = new Date();
		    d.setTime(d.getTime() + (9000*24*60*60*1000));
		    var expires = "expires="+d.toUTCString();
		    
		    document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/;secure;";  //secure werkt enkel over https 
		}

		$('#cookie-close').click(function() {
			$('#cookie-banner').hide('fast');

			setCookie('visited', 'yes');
		});
	});
</script>