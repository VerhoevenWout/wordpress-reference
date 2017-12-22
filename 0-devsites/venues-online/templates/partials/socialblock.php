<?php 
	global $translations;
	global $translations_json;
	global $lang;
?>

<?php $home = get_page_by_path( 'home' ); ?>

<div class="row expanded">
	<div class="block social-block columns">
		<h3 class="heading text-center sub-heading regular">
			<?php echo the_field('social_section_heading', $home->ID )?>
		</h3>
		<div class="input-container small-20 medium-12 large-8 columns">
			<a title="" class="popup-button social-popup-button">
				Email
				<span class="icon-arrow-right-2"></span>
			</a>
		</div>
		<div class="icons-block">
			<h4 class="heading text-center regular">
				<?php echo the_field('home_socialicons_text', $home->ID )?>
			</h4>
			<?php if( get_field('contact_facebook_link', 'option') ): ?>
				<a href='<?php echo the_field('contact_facebook_link', 'option') ?>' target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			<?php endif; ?>

			<?php if( get_field('contact_twitter_link', 'option') ): ?>
				<a href='<?php echo the_field('contact_twitter_link', 'option') ?>' target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<?php endif; ?>

<!-- 			<?php if( get_field('contact_linkedin_link', 'option') ): ?>
				<a href='<?php echo the_field('contact_linkedin_link', 'option') ?>' target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
			<?php endif; ?> -->

			<?php if( get_field('contact_instagram_link', 'option') ): ?>
				<a href='<?php echo the_field('contact_instagram_link', 'option') ?>' target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			<?php endif; ?>
		</div>
	</div>
</div>