<?php $home = get_page_by_path( 'home' ); ?>

		</div> <!-- END DIV MAIN CONTENT -->

		<footer id="footer" class="">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<p><?php the_field('footer_text', $home->ID) ?></p>
			</div>
		</footer>

	</div>

	<!-- JS ARE LOADED HERE WITH FUNCTION.PHP -->
	<?php wp_footer(); ?>

<!-- Wordpress-friendly way via functions.php -->

<!-- Asynchronous google analytics; this is the official snippet.
	 Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.

<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-XXXXXX-XX']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
-->

</body>

</html>
