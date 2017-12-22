<?php

namespace voltatheme\cpt;

class team extends \volta\cpt {

	public function __construct($theme){

		$this->name = 'team';
		$this->readName = 'teamlid';
		$this->pluralName = 'teamleden';

		//Args
		$this->args['menu_icon'] = 'dashicons-admin-links';
		$this->args['supports'] = array( 'title', 'editor', 'thumbnail');

		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}
}
