<?php
global $muller;

/*
	Variables to load {
		menus / footer-menu		
		menus / hoofd-menu
	}
*/
?>
</main>

<div id="footer-search" >
	<div class="row">
		<div class="columns small-12 mailchimp">
			<h3><?= __('Be the first to know!<br>Sign up to receive our newsletter.', 'muller');?></h3>
			<?php if(ICL_LANGUAGE_CODE == 'fr'): ?>
				<?= do_shortcode('[mc4wp_form id="62655"]');?>
			<?php elseif(ICL_LANGUAGE_CODE == 'en'): ?>
				<?= do_shortcode('[mc4wp_form id="62670"]');?>
			<?php else: ?>
				<?= do_shortcode('[mc4wp_form id="62509"]');?>
			<?php endif; ?>
			<span><?= __('Our email newsletter will keep you informed about all our novelties and events delivered right to your inbox. We will not share or pass on your email address to third parties.', 'muller');?></span>
		</div>
	</div>
	<div class='row'>
		<div class="columns small-12 footer-search">
			<div>
			<form class='search' method="get" action="<?= get_permalink($muller->tplsearch->ID);?>">
				<div class="inner">
					<input type="text" name="query" placeholder="<?= _e('What are you looking for?', 'muller') ?>" />
					<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</form>

			<?php 
				$link = get_permalink(get_page_by_path('contact')->ID);
				// $link = icl_object_id( $id, 'post', true, $lang );
			?>
			<a href='<?= $link ?>'>
				<?= _e('Questions? Contact us!', 'muller');?>
			</a>
			</div>
		</div>
	</div>
</div>

<footer id='mainfooter' class='main'>
	<div class='row '>
	<section class='columns small-12 medium-8 left'>
		<?= $muller->menus['footer-menu'];?>
		<span>&copy; Muller 
			- 
			<a href="<?= get_permalink(get_page_by_path('privacy')) ?>" title=""><?php _e('Privacy policy') ?></a> 
			- 
			<a href="<?= get_permalink(get_page_by_path('cookie')) ?>" title=""><?php _e('Cookie policy') ?></a>
		</span>

	</section>
	<section class='columns small-12 medium-4 right'>
		<ul class='share'>
			<li><a href='#'><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
			<li><a href='#'><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
		</ul>
	</section>
	</div>
</footer>

<div id="return-to-top"><svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#FFFFFF;stroke-miterlimit:10"/></svg></div>

<!-- WP footer -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.min.js"></script>
<?php wp_footer(); ?>
</div>
</body>
</html>