<?php

/* ======================================================================

    Load JS v3.0
    Load theme JavaScript file.
    Learn more: http://codex.wordpress.org/Function_Reference/wp_register_script

 * ====================================================================== */

function load_theme_js() {

    // Register and load js
	wp_register_script('modernizr-js', get_template_directory_uri() . '/assets/js/modernizr-2.6.2.min.js', false, null, false);
	wp_enqueue_script('modernizr-js');

	wp_register_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.js', false, null, true);
	wp_enqueue_script('bootstrap-js');

	// wp_register_script('script-js', get_template_directory_uri() . '/assets/js/script.min.js', false, null, true);
	// wp_enqueue_script('script-js');

}
add_action('wp_enqueue_scripts', 'load_theme_js');

// ======================================================================================
// OR ===================================================================================
// ======================================================================================

// ADDING STYLES/SCRIPTS
function add_scripts() {
  wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/assets/js/bootstrap.js', array( 'jquery' ), '', true );
  wp_register_style( 'bootstrap-style', get_template_directory_uri() . '/assets/css/bootstrap.css');
  wp_enqueue_style( 'bootstrap-style' );
  wp_register_style( 'hamburger-style', get_template_directory_uri() . '/assets/css/hamburgers.css');
  wp_enqueue_style( 'hamburger-style' );
  wp_register_style( 'custom-style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style( 'custom-style' );
  wp_register_script( 'script-jquery', get_template_directory_uri() . '/assets/js/jquery-1.9.1.min.js', '', true  );
  wp_enqueue_script( 'script-jquery' );
  wp_enqueue_script( 'vimeo-api', 'https://player.vimeo.com/api/player.js', false );
  wp_enqueue_script( 'vimeo-api' );
  wp_register_script( 'script-custom', get_template_directory_uri() . '/assets/js/script.js', '', true  );
  wp_enqueue_script( 'script-custom' );
}
add_action( 'wp_enqueue_scripts', 'add_scripts' );













function wptuts_scripts_load_cdn()
{
    // Deregister the included library
    wp_deregister_script( 'jquery' );
     
    // Register the library again from Google's CDN
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', array(), null, false );
     
    // Register the script like this for a plugin:
    wp_register_script( 'custom-script', plugins_url( '/js/custom-script.js', __FILE__ ), array( 'jquery' ) );
    // or
    // Register the script like this for a theme:
    wp_register_script( 'custom-script', get_template_directory_uri() . '/js/custom-script.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wptuts_scripts_load_cdn' );




?>



