<?php

namespace muller\tax;

class webReeks extends \volta\tax {

	public function __construct($theme){

		$this->name = 'web-reeks';
		$this->readName = 'Webreeks';
		$this->pluralName = 'Webreeksen';

		//object_type
		$this->object_type = array( 'product' );

		//args
		$this->args['rewrite'] = array( 'hierarchical' => true );
	
		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}

}