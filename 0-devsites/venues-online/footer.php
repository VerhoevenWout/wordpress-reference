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

<?php get_template_part('templates/partials/popup-offer') ?>
<?php get_template_part('templates/partials/popup-question') ?>
<?php get_template_part('templates/partials/popup-social') ?>

<footer>
	<div class="row expanded align-middle">
		<div class="small-24 medium-8 columns footer-copyright">
			<span>
				&copy;
				<?php echo date('Y'); ?>
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
				<?php echo the_field('footer_volta', 'option') ?> <span class="seperator">|</span> <a href="https://volta.be" title="Volta" class="bold">Volta</a>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php wp_footer(); ?> 

</body>
</html>