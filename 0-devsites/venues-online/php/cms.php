<?php

include 'classes/FicheMeta.php';
include 'classes/SeoPageMeta.php';

add_action('user_new_form', 'enqueue_custom_assets');

function show_user_options() {
	enqueue_custom_assets();

	$user_id = $_GET["user_id"];

	if (!isset($user_id)) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
	}

	$fiches = get_fiches('_fiche_user', $user_id);
?>
	<h2>Fiches</h2>
	<table class="form-table meta-table" id="fiches">
		<tbody>
			<tr>
				<th>Gekoppelde fiches</th>
				<td>
					<div id="owned-fiches" class="owned-meta">
						<ul>
						<?php foreach($fiches as $fiche): ?>
							<li data-id="<?= $fiche->ID ?>"><?= $fiche->post_title ?><span class="lang">(<?= $fiche->language_code ?>)</span><button class="delete"><i class="fa fa-times"></i></button></li>
						<?php endforeach; ?>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<th>Fiches toevoegen</th>
				<td>
					<input type="text" class="regular-text search-fiches search-meta" placeholder="Gelieve 3 of meer karakters in te typen..." />
					<i id="loading" class="fa fa-spinner fa-pulse"></i>
					<div class="results-container">
						<div id="result-fiches" class="result-meta"></div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
<?php
}
add_action( 'show_user_profile', 'show_user_options' ); // if current user is you
add_action( 'edit_user_profile', 'show_user_options' ); // if current user isn't you

/**
 * Save langitude & longitude when a fiche is saved.
 *
 * @param int $post_ID The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
function save_lat_long( $post_ID, $post, $update ) {

    if ( $post->post_type != 'fiche' ) {
        return;
    }

    $meta = get_post_meta($post_ID);

    $current_geocode = $meta['_latlong'];
    $new_geocode = [];

    while( have_rows('adressen', $post_ID) ): the_row();
    	$street 	= 	get_sub_field('straat');
	    $number 	= 	get_sub_field('nummer');
	    $zipcode 	= 	get_sub_field('postcode');
	    $city 		= 	get_sub_field('gemeente');
	    $country 	= 	get_sub_field('land');

	    $address = $country . '+' . $city . '+' . $street . '+' . $number;
	    $address = str_replace(" ", "%20", $address);

	    //$json = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false&key=#################');
	    $json = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
	    $output = json_decode($json);
	    $latitude = $output->results[0]->geometry->location->lat;
	    $longitude = $output->results[0]->geometry->location->lng;

	    $geocode = new stdClass();
	    $geocode->latitude = $latitude;
	    $geocode->longitude = $longitude;

	    array_push($new_geocode, json_encode($geocode));
    endwhile;

    handle_geocode($new_geocode, $current_geocode, '_latlong', $post_ID);

}
add_action( 'save_post', 'save_lat_long', 10, 3 );

function call_custom_meta() {
	new FicheMeta();
	new SeoPageMeta();

	//reference: https://developer.wordpress.org/reference/functions/add_meta_box/
}
add_action( 'load-post.php', 'call_custom_meta' );
//add_action( 'load-post-new.php', 'call_custom_meta' );
//add_action( 'add_meta_boxes',  'call_custom_meta');


function handle_geocode($new, $current, $meta_key, $post_id) {

	$add = [];
	$remove = [];

	if (is_array($current)) {
		$add = array_diff($new, $current);
    	$remove = array_diff($current, $new);
	} else {
		$add = $new;
	}

    foreach ($add as $g) {
      add_post_meta($post_id, $meta_key, $g);
    }

    foreach ($remove as $g) {
      delete_post_meta($post_id, $meta_key, $g);
    }
}