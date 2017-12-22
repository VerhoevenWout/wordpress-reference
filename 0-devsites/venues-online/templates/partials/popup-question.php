<?php 
	global $translations; 
	global $lang;
?>

<div class="popup-container questionpopup row expanded">
	<div class="popup medium-12 columns">
		<div class="top">
			<img class="logo main-logo" src="<?php echo get_bloginfo('template_url') ?>/dist/img/main-logo.svg" alt="">
			<img class="popup-container-close" src="<?php echo get_bloginfo('template_url') ?>/dist/img/close-button-no-bg.png" alt="close">
		</div>
		<span class="heading"><?= $translations[41] ?></span>
		
		<?php if($lang == 'fr'): ?>
			<?php echo do_shortcode('[gravityform id="4" title="false" description="false"]') ?>
		<?php elseif($lang == 'en'): ?>
			<?php echo do_shortcode('[gravityform id="5" title="false" description="false"]') ?>
		<?php else: ?>
			<?php echo do_shortcode('[gravityform id="2" title="false" description="false"]') ?>
		<?php endif; ?>
	</div>
</div>