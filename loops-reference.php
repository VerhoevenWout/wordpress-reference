<?php

// REPEATER LOOP IMAGE
<?php if( have_rows('banner_images') ): ?>
<div class="banner-slider">
  <?php while( have_rows('banner_images') ): the_row(); ?>
		<?php $photo = get_sub_field('banner_image');
		if ($photo) : ?>
		<div class="">
			<div class="banner-img-overlay"></div>
			<div class="banner-img" style="background:transparent url('<?php echo $photo; ?>') center top no-repeat; background-size:cover;"></div>
		</div>
		<?php endif; ?>
	<?php endwhile; ?>
</div>
<?php endif; ?>
