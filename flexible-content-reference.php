<?php while(have_rows('flexible_content')): the_row('flexible_content');?>
	<?php if( get_row_layout() == 'before_and_after' ): ?>
		<div class="before-and-after-container">
			<p>PRIMA</p>
			<a href="<?php $image = get_sub_field('before_field'); echo $image['sizes']['large']; ?>" data-featherlight="image"><div class="before-and-after before" style="background:transparent url('<?php $image = get_sub_field('before_field'); echo $image['sizes']['large']; ?>') center top no-repeat; background-size:cover;"></div></a>
		</div>
		<div class="before-and-after-container">
			<p>DOPO</p>
			<a href="<?php $image = get_sub_field('after_field'); echo $image['sizes']['large']; ?>" data-featherlight="image"><div class="before-and-after after" style="background:transparent url('<?php $image = get_sub_field('after_field'); echo $image['sizes']['large']; ?>') center top no-repeat; background-size:cover;"></div></a>
		</div>
	<?php endif; ?>
	<?php if( get_row_layout() == 'full_width_picture' ): ?>
		<a href="<?php $image = get_sub_field('full_width_picture_field'); echo $image['sizes']['large']; ?>" data-featherlight="image"><img src="<?php $image = get_sub_field('full_width_picture_field'); echo $image['sizes']['large'];?>"></a>
	<?php endif; ?>
<?php endwhile; ?>
