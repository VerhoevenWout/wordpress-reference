<?php

// ----------------------------------------------------------------------
// ADD SOCIAL SHARING DATA
if ( class_exists( 'WPSEO_OpenGraph_Image' ) ) {
	add_filter( 'wpseo_opengraph', function () {
		$lang = ICL_LANGUAGE_CODE;

		// Find the main id of the NL venue
		$main_id = icl_object_id($post_id,'post',false,'nl');
		if ($lang == 'nl' && $main_id == null){
			$main_id = $post_id;
		} elseif($lang == 'fr' && $main_id == null){
			return;
			error_log('main_id null');
		} elseif($lang == 'en' && $main_id == null){
			return;
			error_log('main_id null');
		}
		$galleryArray 		= get_field('venue_gallery', $main_id);
		$thumbImage 		= $galleryArray[0]['url'];

		$thumbImageWidth 	= $galleryArray[0]['width'];
		$thumbImageHeight 	= $galleryArray[0]['height'];
		$description 		= strip_tags(get_field('venue_description',$post_id));

		global $wpseo_og;
		$wpseo_og->og_tag( 'og:image', $thumbImage );
		$wpseo_og->og_tag( 'og:image:width', $thumbImageWidth );
		$wpseo_og->og_tag( 'og:image:height', $thumbImageHeight );
		$wpseo_og->og_tag( 'og:description', $description );
	}, 32);
}

// GET GALLERY LARGE SIZES
$thumbImage 		= $galleryArray[0]['sizes']['large'];
$thumbImageWidth 	= $galleryArray[0]['sizes']['large-width'];
$thumbImageHeight 	= $galleryArray[0]['sizes']['large-height'];

// GET THUMBNAIL
$thumbImage 		= get_the_post_thumbnail_url();
$thumbImageWidth 	= get_post_thumbnail_size()[0];
$thumbImageHeight 	= get_post_thumbnail_size()[1];

// GET THUMBNAIL MEDIUM SIZE
$thumbImage = wp_get_attachment_image_src(get_post_thumbnail_id($post_array->ID), 'medium');
// returns
// [0]=>
// string(70) "https://localicious.loc/wp-content/uploads/Freshproduce6-2-300x200.jpg"
// [1]=>
// int(300)
// [2]=>
// int(200)
// [3]=>
// bool(true)



// IF ABOVE DOESN'T WORK
// ----------------------------------------------------------------------
// SET OG:IMAGE SIZE 
add_filter( 'wpseo_opengraph_image', 'change_image' );
function change_image( $image ) {
	$thumbImage = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'large')[0];
	$image = $thumbImage;
  	return $image;
}