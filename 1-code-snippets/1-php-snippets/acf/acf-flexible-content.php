<?php
/* Loop through a Flexible Content field and display it's content with different views for different layouts */

while(has_sub_field("content")): ?>
	<?php if(get_row_layout() == "paragraph"): // layout: Content ?>
		<div>
			<?php the_sub_field("content"); ?>
		</div>
	<?php elseif(get_row_layout() == "file"): // layout: File ?>
		<div>
			<a href="<?php the_sub_field("file"); ?>" ><?php the_sub_field("name"); ?></a>
		</div>
	<?php elseif(get_row_layout() == "featured_posts"): // layout: Featured Posts ?>
		<div>
			<h2><?php the_sub_field("title"); ?></h2>
			<?php the_sub_field("content"); ?>

			<?php if(get_sub_field("posts")): ?>
				<ul>
				<?php foreach(get_sub_field("posts") as $p): ?>
					<li><a href="<?php echo get_permalink($p->ID); ?>"><?php echo get_the_title($p->ID); ?></a></li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	<?php endif; ?>
<?php endwhile; ?>


<!-- OR -->


<?php if( have_rows('flex_text') ): ?>
<?php while ( have_rows('flex_text') ) : the_row(); ?>

	<?php if( get_row_layout() == 'flex_text_full' ): ?>
		<div class="row section">
			<div class="columns small-12">
				<p>
					<?php the_sub_field('flex_text_full_width') ?>
				</p>
			</div>
		</div>
	<?php elseif( get_row_layout() == 'flex_image_left' ):  ?>
		<div class="row section">
			<div class="columns small-12 medium-6 xmedium-4">
				<?php $image = get_sub_field('flex_image_left_image')['url'] ?>
				<img src="<?= $image ?>" alt="">
			</div>
			<div class="columns small-12 medium-6 xmedium-8">
				<p>
					<?php the_sub_field('flex_image_left_text') ?>
				</p>
			</div>
		</div>
	<?php elseif( get_row_layout() == 'flex_image_right' ):  ?>
		<div class="row section">
			<div class="columns small-12 medium-6 xmedium-8">
				<p>
					<?php the_sub_field('flex_image_right_text') ?>
				</p>
			</div>
			<div class="columns small-12 medium-6 xmedium-4">
				<?php $image = get_sub_field('flex_image_right_image')['url'] ?>
				<img src="<?= $image ?>" alt="">
			</div>
		</div>
	<?php endif; ?>

<?php endwhile; ?>
<?php endif; ?>
