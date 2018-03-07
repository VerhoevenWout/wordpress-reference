<?php
/**
 * The Template for displaying archives
 */

	get_header();

	global $queried_object;
	global $current_subcategory;

	$args = array(
			'tax_query' => array(
				array(
					'taxonomy' => $current_subcategory->taxonomy,
					'field'    => 'term_id',
					'terms'    => $current_subcategory->term_id
				)
			),
			'post_type'			=> 'producten',
		);

	$products = get_posts($args);

	// ACF Gallery & Blocks toevoegen
	foreach ($products as $product) {
		$product->gallery 	= get_field('product_gallerij', $product->ID);
		$product->blocks 	= get_field('tekstblokken', $product->ID);
	}
?>

<div class="page-overlay gray-bg-gradient row has-content-menu <?= $siteIsLeunen ? 'leunen' : 'ortho' ; ?>">

	<?php include get_template_directory() . '/includes/inc-content-menu.php'; ?>

	<div id="content-wrapper">

		<!-- Productcategorie titel -->
		<h1 class="productcategory-title"><?= $queried_object->name; ?></h1>

		<!-- Productcategorie beschrijving -->

		<?php if ($queried_object->description): ?>
			<div class="productcategory-desc">
				<?= $queried_object->description; ?>
			</div>
		<?php endif ?>

		<?php if ($products): ?>

			<ul class="product-list">

			<?php foreach ($products as $product): ?>

				<li class="product-item">

					<!-- gallery sidebar -->
					<?php if ($product->gallery): ?>
						
						<aside class="image-sidebar">
							<?php foreach ($product->gallery as $img): ?>
								<img src="<?= $img['url']; ?>" alt="<?= $img['alt']; ?>" class="product-image">
							<?php endforeach ?>
						</aside>

					<?php endif ?>

					<article class="product-blocks">
						<!-- product blocks -->
						<?php foreach ($product->blocks as $block): ?>
							<h2><?= $block['tekstblok_titel']; ?></h2>
							<div class="product-body"><?= $block['tekstblok_body']; ?></div>
						<?php endforeach ?>
					</article>
					
					<?php if ($product->post_content): ?>
						<div class="product-content">
							<?= $product->post_content; ?>
						</div>	
					<?php endif ?>
				
				</li>

			<?php endforeach ?>

			</ul>
		<?php else: ?>
			<div class="no-products"><?php _e('No products found', 'leunen-content'); ?></div>
		<?php endif; ?>

	</div>
</div>
<?php get_footer(); ?>