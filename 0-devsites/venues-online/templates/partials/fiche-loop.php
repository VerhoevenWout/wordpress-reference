<?php
	$meta = get_post_meta( $p->ID );
	$location = $meta['adressen_0_gemeente'][0];
	$url = external_url( $p->ID );
	$name = $meta['naam'][0];
	$email = $meta['emailadres'][0];

	$parentid = icl_object_id($p->ID);
	$thumbs = get_field('venue_gallery', $parentid);

	$permalink = get_permalink( $p->ID );

	if (!$location) {
		$location = $meta['gemeente'][0];

		if (!$location) {
			$location = '&nbsp;';
		}
	}

	$column_width = 12 / $columns;
	$column_class = 'large-' . $column_width;

	$label_quote = 'Request a quote';

	if (strpos($term->name, 'vacatures') !== false || strpos($term->slug, 'vacatures') !== false) {
		$label_quote = 'More information';
	}
?>

<?php if (isset($include_row) && $include_row == true): ?>
<div class="row">
<?php endif; ?>



<div class="xmedium-6 small-24 columns fiche <?php if ($featuredPost == true): echo "featured-fiche"; endif; ?>">
	<div class="inner-fiche">
		<div class="img-container">
			<a href="<?= $permalink ?>">
				<img src="<?php echo $thumbs[0]['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
			</a>
		</div>
		<div class="content-container">
			<h3 class="heading"><?= $p->post_title ?></h3>
			<?php if($stats_view!=1): ?>
				<a href="#" data-log="true" data-type="email" data-post="<?=$p->ID?>" class="btn btn-medium btn-icon externallink quotation" data-popup="true" data-target="quotation-popup" data-referer="<?= $permalink ?>" data-address="<?= $email ?>" data-name="<?= $name ?>"><i class="s s-arrow-full-circle-right"></i><span><?= _e($label_quote, 'captions') ?></span></a>
				<a href="<?= $permalink ?>" class="readmore"><i class="s s-arrow-full-circle-right"></i><span><?= _e('Read more', 'captions') ?></span></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php if (isset($include_row) && $include_row == true): ?>
</div>
<?php endif; ?>