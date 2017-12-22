<?php 

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////////////////////////      ////////////      //////////
//////////////////////////     ///////////      ///////////
///////////////////////////     /////////      ////////////
////////////////////////////     ///////      /////////////
////////////////////////////      //////     //////////////
//////////////////////////////     ////     ///////////////
///////////////////////////////     //     ////////////////
////////////////////////////////          /////////////////
/////////////////////////////////        //////////////////
//////////////////////////////////      ///////////////////
///////////////////////////////////    ////////////////////
////////////////////////////////////  /////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

require get_template_directory().'/includes/autoload.php';

add_action('init', 'class_loader');
add_action('init', 'load_the_theme');


add_theme_support( 'post-thumbnails', array( 'team' ) ); 


function volta_custom_styles() {

    wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js');
    wp_enqueue_script( 'main', get_template_directory_uri() . '/dist/js/main.bundle.js', array (  ), 1.0, true);

}
add_action( 'wp_enqueue_scripts', 'volta_custom_styles' );


// Create WP menu's
function register_menu() {
  register_nav_menu('hoofd-menu',__( 'Hoofdmenu' ));
  register_nav_menu('footer-menu',__( 'Footermenu' ));
}
add_action( 'init', 'register_menu' );

/**
 * Autoload the custom theme classes
 */
function class_loader()
{
    // Create a new instance of the autoloader
    $loader = new Psr4AutoloaderClass();
    
    // Register this instance
    $loader->register();
    
    // Add our namespace and the folder it maps to
    $loader->addNamespace('volta', get_template_directory() . '/volta');
    $loader->addNamespace('voltatheme', get_template_directory() . '/volta-theme');
}


function load_the_theme(){

    global $voltatheme;
	$voltatheme = new voltatheme\init;

}

// Function to add link shortcodes to posts and pages
function boekonline_link_shortcode() {
    return '<a href="http://groepspraktijkfruithof.digitalewachtkamer.be/" class="btn btn-boekonline" title="Boek online" target="_blank">
                <i class="icon-chairs"></i>
                <span>
                    <small>afspraak?</small><strong>Boek online</strong>
                </span>
            </a>';
}
add_shortcode('boekonline', 'boekonline_link_shortcode');


function secretariaat_link_shortcode() {
    return '<a href="tel:003234401925" class="btn btn-secretariaat" title="Secretariaat"> secretariaat <strong>03/440.19.25</strong> <small>07:30u - 19:00u</small> </a>';
}
add_shortcode('secretariaat', 'secretariaat_link_shortcode');

function vanwacht_link_shortcode() {
    return '<a href="tel:090010512" class="btn btn-vanwacht" title="Huisarts van wacht">huisarts van wacht <strong>0900/10.512</strong> <small>avond / nacht / weekend</small></a>';
}
add_shortcode('vanwacht', 'vanwacht_link_shortcode');


function link_shortcode($params, $content = null) {

    extract(shortcode_atts(array(
        'url' => ''
    ), $params));

  return '<a href="' . esc_attr($url) . '" class="read-more">' . $content . '</a><i class="icon-arrow-right"></i>';
}
add_shortcode('link','link_shortcode');

function infolink_shortcode($params, $content = null) {

    extract(shortcode_atts(array(
        'url' => ''
    ), $params));

  return '<a href="' . esc_attr($url) . '" class="info-link" target="_blank"><i class="icon-link"></i>' . $content . '</a>';
}
add_shortcode('infolink','infolink_shortcode');

function btn_download_shortcode($params, $content = null) {

    extract(shortcode_atts(array(
        'url' => ''
    ), $params));

  return '<br><a href="' . esc_attr($url) . '" class="btn btn-download"><i class="icon-download"></i>' . $content . '</a>';
}
add_shortcode('download_knop','btn_download_shortcode');


// Google map fix

function my_acf_init() {
    
    acf_update_setting('google_api_key', ' AIzaSyB7fP2vODlBzM3qYtLay9jBLqNraRZst_s');
}

add_action('acf/init', 'my_acf_init');


function prevent_google_maps_api_conflict() {
  if ( get_current_screen()->post_type == 'google_maps' ) {
    wp_dequeue_script( 'acf-input-google-map-extended' );
    wp_deregister_script( 'acf-input-google-map-extended' );
  }
}
add_action( 'acf/input/admin_enqueue_scripts', 'prevent_google_maps_api_conflict', 100 );


// Automatically select parents when checking a taxonomy in the admin.
add_action('save_post', 'assign_parent_terms', 10, 2);

function assign_parent_terms($post_id, $post){

    if($post->post_type != 'document')
        return $post_id;

    // get all assigned terms   
    $terms = wp_get_post_terms($post_id, 'document-groepen' );
    foreach($terms as $term){
        while($term->parent != 0 && !has_term( $term->parent, 'document-groepen', $post )){
            // move upward until we get to 0 level terms
            wp_set_post_terms($post_id, array($term->parent), 'document-groepen', true);
            $term = get_term($term->parent, 'document-groepen');
        }
    }
}

// Allow specific file types
function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
    $mime_types['ott'] = 'application/vnd.oasis.opendocument.text-template'; //Adding ott files,
    $mime_types['zip'] = 'application/zip'; //Adding zip files
    $mime_types['gz'] = 'application/x-gzip';//Adding gzip files
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);

function sort_alphabetical($a, $b) {
    return strcmp($a->post_title, $b->post_title);
}
function sort_rang($a, $b) {
    $c = strcmp($b->contact_rang, $a->contact_rang);
    return $c;
}




// Put private document uploads in different upload folder (and prevent access by url)
add_filter('upload_dir', 'cgg_upload_dir');
function cgg_upload_dir($dir){
    if (!isset($_REQUEST['action']) || 'upload-attachment' !== $_REQUEST['action']) {
        return $dir;
    }

    // make sure we have a post ID
    if (!isset($_REQUEST['post_id'])){
        return $dir;
    }

    // modify the path and url.
    $type = get_post_type($_REQUEST['post_id']);

    $uploads = apply_filters("{$type}_upload_directory", $type);
    $dir['path'] = path_join($dir['basedir'], $uploads);
    $dir['url'] = path_join($dir['baseurl'], $uploads);
    return $dir;
    
    // if ($type != 'privatedocument') {
    //     return $dir;
    // } else{
    //     $uploads = apply_filters("{$type}_upload_directory", $type);
    //     $dir['path'] = path_join($dir['basedir'], $uploads);
    //     $dir['url'] = path_join($dir['baseurl'], $uploads);
    //     return $dir;
    // }
}


function doc_validate_submit(){
    
}




























