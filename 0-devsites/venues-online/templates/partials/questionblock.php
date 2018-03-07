<?php 
	global $translations;
	global $translations_json;
	global $lang;

?>

<?php 
	$home = get_page_by_path( 'home' ); 
	$home = get_page(icl_object_id($home->ID, 'page', true, $lang));
?>

<div class="row expanded">
	<div class="block question-block columns">
		<img v-if="isactive" class="logo main-logo" src="<?php echo get_bloginfo('template_url') ?>/dist/img/main-logo.svg" alt="">
		<h3 class="heading text-center columns light">
			<?php echo the_field('home_questionsection_heading', $home->ID )?>
		</h3>

		<div class="input-container small-20 medium-12 large-8 columns">
			<a title="" class="popup-button question-popup-button">
				<?= $translations[38] ?>
				<span class="icon-arrow-right-2"></span>
			</a>
		</div>
		<h3 class="heading text-center sub-heading columns light">
			<?php echo the_field('home_questionsection_subheading', $home->ID )?>
		</h3>
	</div>
</div>