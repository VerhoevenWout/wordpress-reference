<?php

namespace voltatheme\cpt;

class contact extends \volta\cpt {

	public function __construct($theme){

		$this->name = 'contact';
		$this->readName = 'contact';
		$this->pluralName = 'contacten';

		//Args
		$this->args['menu_icon'] = 'dashicons-admin-links';
		$this->args['supports'] = array( 'custom-fields', 'title');

		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}
}
