<?php

namespace muller\cpt;

class nieuws extends \volta\cpt {
	public function __construct($theme){

		$this->name = 'nieuws';
		$this->readName = 'nieuws';
		$this->pluralName = 'nieuws';

		//Args
		$this->args['has_archive'] = true;
		// $this->args['menu_icon'] = 'dashicons-nieuws';
		$this->args['supports'] = array( 'custom-fields', 'title', 'editor', 'excerpt');
		$this->args['rewrite'] = array('slug' => 'nieuws');
		$this->args['show_in_rest'] = false;

		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}
}








