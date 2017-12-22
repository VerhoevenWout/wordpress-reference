<?php
/**
 * The template for displaying the footer
 *
 */

global $translations;
global $translations_json;
global $lang;

$home = get_page_by_path( 'home' );

?>

</div> <!-- End Pagewrap -->
<footer>
	<div class="row expanded">
		<!-- <div class="small-24 icons-block">
			<h4 class="heading regular">
				<?= $translations[39] ?>
			</h4>
			<?php if( get_field('contact_facebook_link', 'option') ): ?>
				<a href='<?php echo the_field('contact_facebook_link', 'option') ?>' target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			<?php endif; ?>

			<?php if( get_field('contact_twitter_link', 'option') ): ?>
				<a href='<?php echo the_field('contact_twitter_link', 'option') ?>' target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<?php endif; ?>

			<?php if( get_field('contact_linkedin_link', 'option') ): ?>
				<a href='<?php echo the_field('contact_linkedin_link', 'option') ?>' target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
			<?php endif; ?>

			<?php if( get_field('contact_instagram_link', 'option') ): ?>
				<a href='<?php echo the_field('contact_instagram_link', 'option') ?>' target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			<?php endif; ?>
		</div> -->
	</div>
	<div class="row expanded align-middle">
		<div class="small-24 medium-8 columns footer-copyright">
			<span>
				<?php echo the_field('footer_copyright', 'option') ?>
			</span>
		</div>
		<div class="small-24 medium-8 columns text-center footer-links">
			<?php if ( !empty(get_field('footer_repeater_links', 'option')) ) :
			while(have_rows('footer_repeater_links', 'option')): the_row();?>
				<a href="<?php echo the_sub_field('link_repeater_links_url', 'option'); ?>" title=""><?php echo the_sub_field('link_repeater_links_text', 'option'); ?></a>
		    <?php endwhile;
			endif; ?>
		</div>
		<div class="small-24 medium-8 columns footer-credits">
			<span class="text-left regular">
				<?php echo the_field('footer_volta', 'option') ?> <span class="seperator">|</span> <a href="" title="" class="bold">Volta</a>
			</span>
		</div>
	</div>
</footer>



<?php
	global $translations;
	global $lang;
	$policycookie = $_COOKIE["vo-policycookie"];
?>
<?php if(!$policycookie):?>
	<div class="cookies-message cookies-message-hide row expanded">
		<p class="sub-heading">
			<?= $translations[32] ?>
		</p>
		<div class="link-container">
			<a class="btn primary cookies-accept">
				<?= $translations[33] ?><span class="icon-arrow-right" ></span>
			</a>
		</div>
	</div>
<?php endif; ?>



<!-- build:js dist/js/vendor.js -->
<!-- bower:js -->
<!-- endbower -->
<!-- endbuild -->

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlu17PuCOggAb8q65PiJ2RhOkIwEzUxto"></script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php wp_footer(); ?> 

<?php get_template_part('templates/partials/popup-offer') ?>
<?php get_template_part('templates/partials/popup-question') ?>
<?php get_template_part('templates/partials/popup-social') ?>

</body>
</html>