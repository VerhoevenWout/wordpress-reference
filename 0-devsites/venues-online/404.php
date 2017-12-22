<?php

	$url = $_SERVER[REQUEST_URI];
	$root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

	// = Old venue/seopage from google index
	if(substr($url, -5)=='.html'){
		$pieces = explode("-", $url);
		// product pages
		if(count($pieces)>3&&is_numeric($pieces[3])){
			$webpartnerid = $pieces[3];
			$posts = get_posts_by_webpartnerid($webpartnerid, 'venues');


			if(count($posts)==1){
				foreach($posts as $post){
					$currentpage = get_permalink($post->ID);
				}
			}
		}
		// keyword pages
		elseif(count($pieces)>1&&is_numeric($pieces[1])){
			$webpartnerid = 'S' . $pieces[1];
			$posts = get_seo_posts_by_webpartnerid($webpartnerid, 'post_seopage');

			if(count($posts)==1){
				foreach($posts as $post){
					$currentpage = get_permalink($post->ID);
				}
			}
		}
		if($currentpage){
			wp_redirect($currentpage,301);
			exit;
		}
	}

	// NEW SEO PAGE ------------------------------------------------------------------------------------------------
	$url_split = explode('/', $url);
	$url_split_count = count($url_split);
	if ($url_split_count == 4 || $url_split_count == 5 || $url_split_count == 6){
		$root_position 			= strtolower($url_split[0]);
		$lang_position 			= strtolower($url_split[1]);
		$activity_position 		= strtolower($url_split[2]);
		$city_position 			= strtolower($url_split[3]);
		$type_location_position = strtolower($url_split[4]);

		$activity_taxs = get_terms( array(
		    'taxonomy' => 'activiteit',
		    'hide_empty' => false,
		) );
		$type_location_taxs = get_terms( array(
		    'taxonomy' => 'type_locatie',
		    'hide_empty' => false,
		) );
		
		// = NEW SEO PAGE ------------------------------------------------------------------------------------------------
		foreach ($activity_taxs as $key => $activity_tax) {
			if (strtolower($activity_tax->slug) == $activity_position) {
				$activity_value = strtolower($activity_tax->name);
				$activity_tax = strtolower($activity_tax->term_id);
				break;
			} else{
				$activity_tax = '';
			}
		}

		if ($type_location_position == ''){
			$type_location_tax = 'all';
		} else{
			foreach ($type_location_taxs as $key => $type_location_tax) {
				if (strtolower($type_location_tax->slug) == $type_location_position) {
					$type_location_value = strtolower($type_location_tax->name);
					$type_location_tax = strtolower($type_location_tax->term_id);
					break;
				} else{
					$type_location_tax = 'all';
				}
			}
		}

		if ($activity_tax && $type_location_tax){
			// GET LAT LNG FROM DB
			global $wpdb;
			$sql = "
			    SELECT zip, city, lat, lng
			    FROM wp_zipcodes
			    WHERE city LIKE '".$city_position."'
			";

			$latlngresult = $wpdb->get_results($sql);
			if ($latlngresult) {
				$search_values 		= [$activity_value, $city_position, $type_location_value];
				$search_parameters 	= json_encode([$activity_tax, $city_position, $type_location_tax, $latlngresult[0]->lat, $latlngresult[0]->lng]);
				$page_title 		= ucfirst($activity_value).' '.ucfirst($city_position).' '.ucfirst($type_location_value);

				add_filter( 'body_class', function( $classes ) {
			       return array_merge( $classes, array( 'new-seo-page' ) );
			   	});
				pilau_override_404();
				include 'templates/tpl_home.php';
				die();
			}
		}
	}

	// = Hash ----------------------------------------------------------------------------------------------------------------
	$lang_position = $url_split[1];
	$hash_position = $url_split[2];
	$secondary_position = $url_split[3];

	// check if hash exists
	global $wpdb;
	$sqlcheck = "
	    SELECT url_params, type
	    FROM wp_url_hash_table 
	    WHERE hash LIKE '".$hash_position."'
	";
	error_log($sqlcheck);
    $result = $wpdb->get_results($sqlcheck);

	if( (count($result) != 0) && ($secondary_position == null) ){
		pilau_override_404();
	
		setcookie("vo-404-data", $hash_position, time() + 3600 ,'/');
		
		add_filter( 'body_class', function( $classes ) {
	       return array_merge( $classes, array( 'tpl_home' ) );
	   	});
		include 'templates/tpl_home.php';
		die();
	}


	$home = get_page_by_path( 'home' );
	global $translations;

	$repeater = get_field( 'header_background_repeater', $home->ID);
	$rand = rand(0, (count($repeater) - 1));
	$random_image = $repeater[$rand]['background'];
get_header(); ?>

	<div id='vue-search' v-bind:class="{ 'search-active': isactive }">
		<div class="row expanded">
			<img class="top-banner-background" src="<?php echo $random_image ?>" alt="background"/>
			<div class="top-banner-background top-banner-background-overlay"></div>

			<div class="top-banner columns">
				<img class="logo single-logo single-logo-out-view" src="<?php echo get_bloginfo('template_url') ?>/dist/img/single-logo.svg" alt="">
				
				<div class="centered">
					<h1>
						<?= $translations[40] ?>
					</h1>
				</div>
				
			</div>
		</div>

		<?php if(!$search_parameters): ?>
			<?php get_template_part('templates/partials/questionblock') ?>
			<?php get_template_part('templates/partials/socialblock') ?>
		<?php endif; ?>
		
		<?php get_template_part('templates/partials/newseoblock') ?>
		
	</div>
	<div class="row expanded">
		<div class="seo-block"></div>
	</div>

<?php get_footer(); ?>