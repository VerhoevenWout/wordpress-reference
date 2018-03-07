<?php

namespace volta;

class adminpage
{
    
    /**
    * The name of the page title
    * @var string
    */
    public $page_title;

    /**
    * The name of the menu title
    * @var string
    */
    public $menu_title;

    /**
    * The capability that is required to acces the page
    * @var string
    */
    public $capability;

    /**
    * The slug for the page, has to be unique, will also be used for the template 
    * @var string
    */
    public $menu_slug;

    /**
    * The position in the admin menui 
    * @var int
    */
    public $position = null;

     /**
    * The icon used for the menu -> https://developer.wordpress.org/resource/dashicons
    * @var string
    */
    public $icon = 'dashicons-admin-generic';

  
    public function __construct($theme)
    {

        $this->theme = $theme;

        if(!$this->menu_title){
            $this->menu_title = $this->page_title;
        }

        add_action('admin_menu', array($this, 'init_page'));
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts'));

        $this->process_handler();
                
    }

    /**
     * Process handler
     */
    public function process_handler() {
        if ( ! isset( $_GET['process'] ) || ! isset( $_GET['_wpnonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'process') ) {
            return;
        }

        if ( $_GET['process'] ) {
            $this->{$_GET['process']}();
        }
    }

    /**
    * Initialise the admin page
    *  
    * The html will be loaded from templates/tpl-admin-$menu_slug.php
    **/
    public function init_page(){
        
        add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array($this, 'getHtml'), $this->icon_url, $this->position );
    }


    /**
    * Load the html for the admin page
    *  
    * The html will be loaded from templates/tpl-admin-$menu_slug.php
    **/
    public function getHtml(){
       require get_template_directory().'/templates/tpl-admin-'.$this->menu_slug.'.php';

    }

    /**
    * Load the scripts for the admin page
    *  
    * The html will be loaded from templates/tpl-admin-$menu_slug.php
    *
    * @param string $hook
    **/
    public function enqueue_scripts($hook){

        if('toplevel_page_'.$this->menu_slug == $hook){
            wp_enqueue_script( 'script_adminpage_'.$this->menu_slug, get_template_directory_uri() . '/dist/js/admin-'.$this->menu_slug.'.bundle.js' );
            wp_register_style( 'script_adminpage_'.$this->menu_slug, get_template_directory_uri() . '/dist/css/admin-'.$this->menu_slug.'.css', false, '1.0.0' );
            wp_enqueue_style( 'script_adminpage_'.$this->menu_slug );
        }

    }


}