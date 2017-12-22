<?php 
include 'php/cpt.php';
//Functions to build the searchtable
include 'php/searchtable.php';
// Functions to build SEO-metabox
include 'php/general.php';
global $translations;
global $translations_json;
global $lang;

// IMPORTANT!!
// Disable url autocomplete to make sure it goes to 404
remove_filter('template_redirect', 'redirect_canonical');

function external_url($id) {
	return get_site_url() . '/external/?id=' . $id;
}

/**
* Enable the option page in ACF
*
**/
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
	acf_add_options_sub_page('Footer');
	acf_add_options_sub_page('Contact');
	acf_add_options_sub_page('Vertalingen');
}

// ----------------------------------------------------------------------
// GRAVITY FORMS ADD VENUE ID AND EMAIL
add_filter( "gform_pre_submission_1", "add_venue_id", 9 ); // NL
add_filter( "gform_pre_submission_6", "add_venue_id", 9 ); // FR
add_filter( "gform_pre_submission_7", "add_venue_id", 9 ); // EN
function add_venue_id( $form ){
    $venue_id = $_POST['input_15'];
    $venue_email = get_field('venue_email', $venue_id);
	if ($venue_email == null || $venue_email == '') {
		$_POST['input_17'] = bloginfo('admin_email');
		// $_POST['input_17'] = 'wout@volta.be';
	} else{
		// THIS IS THE CLIENTS EMAIL
		$_POST['input_17'] = $venue_email;
		// THIS IS A TEST EMAIL
		// $_POST['input_17'] = 'support@volta.be';
	}
}
// ----------------------------------------------------------------------
// GRAVITY FORMS REMEMBER ME
$remember_me_data;
add_filter("gform_after_submission_1",'after_submission', 10, 2);
add_filter("gform_after_submission_6",'after_submission', 10, 2);
add_filter("gform_after_submission_7",'after_submission', 10, 2);
function after_submission($entry, $form){
	$_POST['input_17'] = '';
	$remember_me = $entry['12.1'];
	if ($remember_me != '') {
		$remember_me_data = array(
		    'would_like' 	=> $_POST['input_3'],
		    'name' 			=> $_POST['input_2'],
		    'company' 		=> $_POST['input_4'],
		    'phone' 		=> $_POST['input_5'],
		    'email' 		=> $_POST['input_6'],
		    'looking_for' 	=> $_POST['input_7'],
		    'persons' 		=> $_POST['input_8'],
		    'date' 			=> $_POST['input_9']
		);
		$remember_me_data = json_encode($remember_me_data);
	} else{
		$remember_me_data = null;
	}
	setcookie("vo-remember-me", $remember_me_data, time() + 3600, '/');
}
// ----------------------------------------------------------------------
// GRAVITY FORMS RESET FORM
// Dont forget to redirect to page in backend settings
add_filter( 'gform_confirmation_1', 'custom_confirmation', 3, 4 );
add_filter( 'gform_confirmation_6', 'custom_confirmation', 3, 4 );
add_filter( 'gform_confirmation_7', 'custom_confirmation', 3, 4 );

add_filter( 'gform_confirmation_2', 'custom_confirmation', 3, 4 );
add_filter( 'gform_confirmation_4', 'custom_confirmation', 3, 4 );
add_filter( 'gform_confirmation_5', 'custom_confirmation', 3, 4 );

add_filter( 'gform_confirmation_3', 'custom_confirmation', 3, 4 );
add_filter( 'gform_confirmation_10', 'custom_confirmation', 3, 4 );
add_filter( 'gform_confirmation_11', 'custom_confirmation', 3, 4 );
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {
	$lang = ICL_LANGUAGE_CODE;
	if ($lang == 'fr'){
		$translation_group = acf_get_fields(1653161);
	} elseif($lang == 'en'){
		$translation_group = acf_get_fields(1653125);
	} else{
		$translation_group = acf_get_fields(1653089);
	}

	$translations = [];
	foreach ( $translation_group as $field ) {
		$field_value = get_field( $field['name'], 'option' );
		if ( $field_value && !empty( $field_value ) ) {
			array_push($translations, $field_value);
		}
	}
	$offer_confirmation = $translations[65];

	echo '<div id="popup-container-confirmation" class="popup-container-confirmation offerpopup row expanded">';
		echo '<div class="popup small-12 xmedium-10 xlarge-8 columns">';
			echo '<div class="top"><img class="logo main-logo" src="https://venues-online.com/wp-content/themes/venues-online/dist/img/main-logo.svg"alt=""></div>';
			echo $offer_confirmation;
		echo '</div>';
	echo '</div>';
   	echo 	'<script type="text/javascript">
				var d = document.getElementById("popup-container-confirmation");
	   			setTimeout(function(){
					d.className += " hide-popup-container-confirmation";
	   			}, 2000);
	   			setTimeout(function(){
					d.remove();
	   			}, 2500);
			</script>';
}

// ----------------------------------------------------------------------
// REGISTER MENUS
function register_my_menus() {
    register_nav_menus(
      	array('main-menu' => __( 'main menu' ),)
    );
}
add_action( 'init', 'register_my_menus' );

// ----------------------------------------------------------------------
// ACF GOOGLE MAPS FIX
add_action('acf/fields/google_map/api', function($api){
$api['key'] = 'AIzaSyABxEL5TeJO7-jdW4YYveUdxIwVGLkMjH8';
return $api;
});

// ----------------------------------------------------------------------
// OVERRIDE 404-STATUS
function pilau_override_404( $template = null, $type = 'page' ) {
	global $wp_query;
	// Change type of query
	$wp_query->is_404 = false;
	$type_property = "is_$type";
	if ( property_exists( $wp_query, $type_property ) )
		$wp_query->$type_property = true;
	// Make sure HTTP status is good
	status_header( '200' );
	// Load template?
	if ( $template ) {
		$template_found = locate_template( $template, true );
		if ( $template_found )
			exit;
	}
}

// ----------------------------------------------------------------------
// REMOVE ADMIN BAR
add_filter('show_admin_bar', '__return_false');

// ----------------------------------------------------------------------
// REMOVE POSTTYPE FROM SLUG
// First, we will remove the slug from the permalink:
function na_remove_slug( $post_link, $post, $leavename ) {
    if ( 'venues' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    return $post_link;
}
add_filter( 'post_type_link', 'na_remove_slug', 10, 3 );
// Just removing the slug isn't enough. Right now, you'll get a 404 page because WordPress only expects posts and pages to behave this way. You'll also need to add the following:
function na_parse_request( $query ) {
    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'venues', 'page' ) );
    }
}
add_action( 'pre_get_posts', 'na_parse_request' );

// ----------------------------------------------------------------------
// GENERATE SITEMAP
function generate_sitemap(){
    // include class
    include 'php/Class/SitemapGenerator.php';
    
    // create object
    $sitemap = new SitemapGenerator("/");

	function switch_sidebar_language($lang){
	global $sitepress;
	 $sitepress->switch_lang('$lang', true);
	}
	switch_sidebar_language('en');

	$activity_terms = get_terms( array(
	'taxonomy' => 'activiteit',
	'hide_empty' => false,
	) );
	$type_location_terms = get_terms( array(
	'taxonomy' => 'type_locatie',
	'hide_empty' => false,
	) );

	// $cities_nl = "Antwerpen","Gent","Charleroi","Luik","Brussel","Brugge","Namen","Leuven","Bergen","Mechelen","Aalst","La-Louvière","Hasselt","Kortrijk","Sint-Niklaas","Oostende","Doornik","Genk","Seraing","Roeselare","Moeskroen","Verviers","Dendermonde","Beringen","Turnhout","Vilvoorde","Lokeren","Sint-Truiden","Herstal","Geel","Ninove","Halle","Waregem","Châtelet","Ieper","Lier","Lommel","Waver","Tienen","Binche","Geraardsbergen","Menen","Bilzen","Ottignies","Tongeren","Oudenaarde","Deinze","Aarschot","Aarlen","Aat","Herentals","Izegem","Nijvel","Harelbeke","Zinnik","Andenne","Zottegem","Ronse","Mortsel","Maaseik","Gembloers","Diest","Saint","Fleurus","Scherpenheuvel","'s-Gravenbrakel","Hoei","Hoogstraten","Eeklo","Torhout";
	// $cities_fr = "Anvers","Gand","Charleroi","Liege","Bruxelles","Bruges","Namur","Louvain","Mons","Malines","Alost","La-Louvière","Courtrai","Hasselt","Saint-Nicolas","Ostende","Tournai","Genk","Seraing","Roulers","Verviers","Mouscron","Termonde","Beringen","Turnhout","Vilvorde","Saint-Trond","Lokeren","Herstal","Geel","Ninove","Hal","Waregem","Chatelet","Ypres","Lierre","Lommel","Wavre","Tirlemont","Menin","Binche","Grammont","Bilzen","Ottignies-Louvain-La-Neuve","Tongres","Audenarde","Deinze","Aarschot","Ath","Arlon","Herentals","Izegem","Harelbeke","Nivelles","Soignies","Andenne","Renaix","Zottegem","Mortsel","Maaseik","Gembloux","Tubize","Diest","Saint-Ghislain","Fleurus","Montaigu-Zichem","Braine-le-Comte","Huy","Eeklo","Hoogstraten","Torhout";
	// $cities_en = "Antwerp","Ghent","Charleroi","Liège","Brussel","Bruges","Namur","Mons","Leuven","Mechelen","Aalst","La-Louvière","Kortrijk","Hasselt","Sint-Niklaas","Ostend","Tournai","Genk","Seraing","Roeselare","Verviers","Mouscron","Dendermonde","Beringen","Turnhout","Sint-Truiden","Lokeren","Vilvoorde","Waregem","Ninove","Châtelet","Geel","Ypres","Halle","Lier","Menen","Binche","Wavre","Lommel","Tienen","Geraardsbergen","Bilzen","Tongeren","Ottignies-Louvain-La-Neuve","Oudenaarde","Deinze","Aarschot","Ath","Izegem","Arlon","Harelbeke","Herentals","Soignies","Zottegem","Mortsel","Andenne","Nivelles","Ronse","Maaseik","Diest","Saint-Ghislain","Fleurus","Scherpenheuvel-Zichem","Gembloux","Braine-le-Comte","Huy","Poperinge","Eeklo","Torhout";

	foreach ($activity_terms as $key => $value) {
		echo "<pre>";
		echo $value->name;
		echo "</pre>";
		foreach ($type_location_terms as $key => $value) {
			echo "<pre>";
			echo $value->name;
			echo "</pre>";
		}
	}

	function addSubaccount($message) {
	    $subaccount_id = 'staging.venues-online';
	    $message['subaccount'] = $subaccount_id;
	    return $message;
	}
	add_filter('mandrill_payload', 'addSubaccount');
}