<!-- IN HEADER -->

<!-- Analytics -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-114299202-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-114299202-1');
</script>

<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-114299202-1', 'auto');
</script>
<!-- End Google Analytics -->




<!-- IN SCRIPT -->
<script>
	var $ = require('jquery');
	module.exports = function(){
		$( document ).ready(function() {

			// PAGEVIEW ON LANDING
			var url = location.href;
			ga('send', 'pageview', url);

			// PAGEVIEW ON CLICKS
	    	$('.btn-read-more').on('click', function(event) {
	    		var value = $(this).closest('li').attr('url_value');
				ga('send', {
				  hitType: 'event',
				  eventCategory: 'btn_'+value,
				  eventAction: 'click',
				  eventLabel: 'this is a new click',
				});
			});
	    	$('.btn-back').on('click', function(event) {
				ga('send', {
				  hitType: 'event',
				  eventCategory: 'btn_jaarprogramma',
				  eventAction: 'click',
				  eventLabel: 'this is a new click',
				});
			});

		});
	}
</script>