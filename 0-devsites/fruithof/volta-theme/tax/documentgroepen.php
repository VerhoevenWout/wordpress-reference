<?php

namespace voltatheme\tax;

class documentgroepen extends \volta\tax {

	public function __construct($theme){

		$this->name = 'document-groepen';
		$this->readName = 'Documentgroep';
		$this->pluralName = 'Documentgroepen';

		//object_type
		$this->object_type = array( 'document', 'privatedocument' );

		//args
		$this->args['rewrite'] = array( 'hierarchical' => true );
	
		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}

}