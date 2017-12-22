<?php 
	$activity 		= $search_values[0];
	$city 			= $search_values[1];
	$type_location 	= $search_values[2];

	global $lang;
?>
<?php if ($lang != 'fr'):?>
<div class="row expanded">
	<div class="seoblock-text small-24 columns">
		
		<!-- SEO TEXT 1 -->
		<h1 class="seo-text-lead">
			<?php echo ucfirst($activity) ?>
			<?php while(have_rows('seo_text1_field_2', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text1_field_2_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($type_location == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text1_field_2_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php echo the_field('seo_text1_field_3', 'option'); ?>
			<?php echo ucfirst($city) ?>.

		</h1>
		<p class="seo-text-paragraph">
			<?php while(have_rows('seo_text1_field_1', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text1_field_1_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($activity == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text1_field_1_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php while(have_rows('seo_text1_field_2', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text1_field_2_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($type_location == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text1_field_2_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php echo the_field('seo_text1_field_3', 'option'); ?>
			<?php echo ucfirst($city) ?>?

			<?php while(have_rows('seo_text1_field_4', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text1_field_4_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($activity == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text1_field_4_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php while(have_rows('seo_text1_field_2', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text1_field_2_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($type_location == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text1_field_2_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php echo the_field('seo_text1_field_6', 'option'); ?>
			<?php echo ucfirst($city) ?>.
		</p>

		<!-- SEO TEXT 2 -->
		<h2 class="seo-text-sublead">
			<?php while(have_rows('seo_text2_header_field_1', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text2_field_1_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($activity == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text2_field_1_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php while(have_rows('seo_text1_field_2', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text1_field_2_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($type_location == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text1_field_2_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php echo the_field('seo_text1_field_3', 'option'); ?>
			<?php echo ucfirst($city) ?>.

		</h2>

		<p class="seo-text-paragraph">
			<?php while(have_rows('seo_text2_field_1', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text2_field_1_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($activity == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text2_field_1_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php while(have_rows('seo_text1_field_1', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text1_field_1_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($type_location == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text1_field_1_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>
			
			<?php echo the_field('seo_text2_field_3', 'option'); ?>

			<?php while(have_rows('seo_text2_field_4', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text2_field_4_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($activity == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text2_field_4_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php echo the_field('seo_text2_field_5', 'option'); ?>
			<?php echo ucfirst($city) ?>

			<?php echo the_field('seo_text2_field_6', 'option'); ?>

			<?php while(have_rows('seo_text2_field_2', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text2_field_2_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($type_location == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text2_field_2_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php echo the_field('seo_text2_field_7', 'option'); ?>
		</p>

		<!-- SEO TEXT 3 -->
		<h2 class="seo-text-sublead">
			<?php echo the_field('seo_text3_header_field_1', 'option'); ?>
		</h2>
		<p class="seo-text-paragraph">
			<?php while(have_rows('seo_text3_field_1', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text3_field_1_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($activity == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text3_field_1_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php while(have_rows('seo_text1_field_2', 'option')): the_row(); ?>
				<?php 
					$fieldvalue = get_sub_field('seo_text1_field_2_keuze', 'option');
					$fieldvalue = $fieldvalue->name;
					$fieldvalue = strtolower($fieldvalue);
				?>
				
				<?php if ($type_location == $fieldvalue): ?>
					<?php echo the_sub_field('seo_text1_field_2_vertaling', 'option'); ?>
				<?php endif ?>
			<?php endwhile; ?>

			<?php echo the_field('seo_text3_field_2', 'option'); ?>
			<?php echo ucfirst($city) ?>
			<?php echo the_field('seo_text3_field_3', 'option'); ?>
		</p>
	</div>
</div>
<?php endif ?>
