<?php

  function custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/assets/css/custom-style-login.css" />';
  }
  add_action('login_head', 'custom_login');

  function logo_login_URL_removal() {
    return 'http://thewebkitchen.co.uk';
  }
  add_filter( 'login_headerurl', 'logo_login_URL_removal' );

  function login_custom_title() {
    return 'THE WEB KITCHEN';
  }
  add_filter( 'login_headertitle', 'login_custom_title' );

?>
