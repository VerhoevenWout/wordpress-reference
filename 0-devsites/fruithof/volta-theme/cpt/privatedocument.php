<?php

namespace voltatheme\cpt;

class privatedocument extends \volta\cpt {

	public function __construct($theme){

		$this->name = 'private document';
		$this->readName = 'private document';
		$this->pluralName = 'private documenten';

		//Args
		$this->args['menu_icon'] = 'dashicons-media-document';
		$this->args['supports'] = array( 'custom-fields', 'title');

		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}
}