<?php global $translations; ?>
<?php $home = get_page_by_path( 'home' ); ?>

<div class="popup-container-2 popup-container-2-hide">

	<img class="popup-container-2-close" src="<?php echo get_bloginfo('template_url') ?>/dist/img/close-button.png" alt="close">

	<h4 class="heading"><?php echo the_field('home_questionsection_heading', $home->ID )?></h4>
	<div class="input-container">
		<a title="" class="popup-button question-popup-button">
			<?= $translations[38] ?>
			<span class="icon-magnify"></span>
		</a>
	</div>
	<h4 class="heading sub-heading"><?php echo the_field('home_questionsection_subheading', $home->ID )?></h4>

</div>