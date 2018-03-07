<?php
    /**
    * Template Name: External Link
    */

	add_filter( 'body_class', function( $classes ) {
	    return array_merge( $classes, array( 'hide-overlay' ) );
	} );
	get_header();

	global $translations;
	global $translations_json;
?>
	
<div class="row expanded">
	<div class="small-24 expanded go-back-container">
		<div class="button-container">
			<a class="btn go-back-external semi-bold goBack">
				<span class="icon-arrow-left" ></span><?= $translations[45] ?>
			</a>

			<a class="btn request-offer semi-bold" v-on:click.prevent="clickofferpopup(externalLinkPostId, externalLinkShortTitle)">
				<?= $translations[3] ?><span class="icon-arrow-right" ></span>
			</a>
		</div>
	</div>
	
	<!-- <iframe src="https://www.vandervalkantwerpen.be/en"></iframe> -->
	<iframe v-bind:src="externalLinkUrl"></iframe>

</div>

<?php get_template_part('templates/partials/seoblock') ?>

<?php get_footer(); ?>