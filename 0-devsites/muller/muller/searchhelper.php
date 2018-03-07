<?php

namespace muller;

/**
 * Intialise the theme
 *
 * All classes and hook are intiaded to let the wordpress funciton with the theme.
 *
 */
class searchhelper {

	public function __construct($theme){

		$this->theme = $theme;

		add_action( 'wp_ajax_search_products', array($this, 'search_products_ajx'));
        add_action( 'wp_ajax_nopriv_search_products', array($this, 'search_products_ajx'));

	}

	public function search_products_ajx(){

		global $sitepress;
        $sitepress->switch_lang($_POST['lang']);
        
		if(ctype_digit($_POST['search'])){
			$search = (int)$_POST['search'];
		}else{
			$search = $_POST['search'];
		}

		$query->query_vars['s'] = $search;
		$query->query_vars['posts_per_page'] = -1;
		$results = relevanssi_do_query($query);

		foreach ($results as $key => $value) {
			$results[$key]->img = $this->theme->product->getThumbsrc($value->ID);
		}

		wp_send_json(['results' => $results]);
	}
	
}