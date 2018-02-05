<?php

// ----------------------------------------------------------------------
// REGISTER MENUS
function register_my_menus() {
    register_nav_menus(
      	array('main-menu' => __( 'main menu' ),)
    );
}
add_action( 'init', 'register_my_menus' );