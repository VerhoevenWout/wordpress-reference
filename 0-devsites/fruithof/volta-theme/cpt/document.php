<?php

namespace voltatheme\cpt;

class document extends \volta\cpt {

	public function __construct($theme){

		$this->name = 'document';
		$this->readName = 'document';
		$this->pluralName = 'documenten';

		//Args
		$this->args['menu_icon'] = 'dashicons-media-document';
		$this->args['supports'] = array( 'custom-fields', 'title');

		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}
}
