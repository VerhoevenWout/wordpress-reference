<?php
global $betrope;

// Template name: Tab lijst

/*
	Variables to load {
		WP / page
		ACF / home_link_text
		ACF / home_link_url
	}
*/

get_header(); 
while ( have_posts() ) : the_post();
?>
	<section class="block column-block column small-12 xmedium-10">
		<header>
			<h1 class="page-title"><?= $voltatheme->WP['page']->post_title; ?></h1>
		</header>
		<div class="wysiwyg">
			<?= apply_filters("the_content", $voltatheme->WP['page']->post_content); ?>
		</div>
	</section>
	<?php if( have_rows('tab_list') ): ?>

		<section class="block tablist-block column small-12 xmedium-8">
			<ul class="tablist">
		 	<?php while ( have_rows('tab_list') ) : the_row(); ?>		 		
		 		<?php $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', get_sub_field('tab_list_title'));  ?>

		 		<li class="tablist-item" id="<?php // echo $slug; ?>">
		 			<a href="#<?php echo $slug; ?>"><?php the_sub_field('tab_list_title'); ?></a> <i class="icon-plus"></i>
			        <div class="item-wrap">
			        	<div>
			        		<?php the_sub_field('tab_list_description'); ?>
			        	</div>
			        </div>
		 		</li>

		    <?php endwhile; ?>
		    </ul>
		</section>

	<?php endif; ?>

<?php 
endwhile;
get_footer(); 
?>