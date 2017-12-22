<div class="row">
	<?php if ( !empty(get_field('sponsor_repeater', $home->ID)) ) :
	while(have_rows('sponsor_repeater', $home->ID)): the_row();?>
			<div class="sponsor-image-container">
				<img class="sponsor-image" src="<?php echo the_sub_field('sponsor_image'); ?>" alt="">
			</div>
    <?php endwhile;
	endif; ?>
</div>