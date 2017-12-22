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
?>
