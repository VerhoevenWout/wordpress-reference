<?php

namespace voltatheme\tax;

class contactgroepen extends \volta\tax {

	public function __construct($theme){

		$this->name = 'contact-groepen';
		$this->readName = 'Contactgroep';
		$this->pluralName = 'Contactgroepen';

		//object_type
		$this->object_type = array( 'contact' );

		//args
		$this->args['rewrite'] = array( 'hierarchical' => true );
	
		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}

}