<?php 
	global $translations; 
	global $lang;
?>

<div class="popup-container offerpopup row expanded">
	<div class="popup small-12 xmedium-10 xlarge-8 columns">
		<div class="top">
			<img class="logo main-logo" src="<?php echo get_bloginfo('template_url') ?>/dist/img/main-logo.svg" alt="">
			<img class="popup-container-close" src="<?php echo get_bloginfo('template_url') ?>/dist/img/close-button-no-bg.png" alt="close">
		</div>
		<?php if($lang == 'fr'): ?>
			<?php echo do_shortcode('[gravityform id="6" title="false" description="false"]') ?>
		<?php elseif($lang == 'en'): ?>
			<?php echo do_shortcode('[gravityform id="7" title="false" description="false"]') ?>
		<?php else: ?>
			<?php echo do_shortcode('[gravityform id="1" title="false" description="false"]') ?>
		<?php endif; ?>
	</div>
</div>