<?php

namespace voltatheme\tax;

class teamfunctions extends \volta\tax {

	public function __construct($theme){

		$this->name = 'team-functions';
		$this->readName = 'Functie';
		$this->pluralName = 'Functies';

		//object_type
		$this->object_type = array( 'team' );

		//args
	
		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}

}