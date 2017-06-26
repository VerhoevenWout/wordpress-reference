<?php

	require_once ('lib/load-jquery.php');
	require_once ('lib/load-js.php');
	require_once ('lib/remove-header-junk.php');
  // require_once ('ies/html5reset.php');
  require_once ('lib/general.php');
  require_once ('lib/no-self-pings.php');
  require_once ('lib/remove-trackbacks-from-comments.php');

	//ADDING GOOGLE FONT
	function load_fonts() {
	  wp_register_style('fergus_fonts', 'https://fonts.googleapis.com/css?family=Titillium+Web:300,300i,400');
	  wp_enqueue_style( 'fergus_fonts');
	}
	add_action('wp_print_styles', 'load_fonts');

	// CHANGE PASSWORD PROTECT COOKIE TTL (0 turns the default 10-day-cookie into session)
	add_filter('post_password_expires', '__return_zero');

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

	// UPDATE SITE URL
	update_option('siteurl','http://fergus.clients.twkmedia.eu');
	update_option('home','http://fergus.clients.twkmedia.eu');

	// GFORM SCROLL TO ERROR
	add_filter( 'gform_confirmation_anchor', '__return_true' );

	// FAVICON
	// function blog_favicon() {
	// echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('wpurl').'http://cdn.wpbeginner.com/favicon.ico" />';
	// }
	// add_action('wp_head', 'blog_favicon');


	// ACTIVE MENU
	add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
	function special_nav_class ($classes, $item) {
	  if (in_array('current-menu-item', $classes) ){
	      $classes[] = 'active ';
	  }
	  return $classes;
	}
