<?php

namespace muller\tax;

class merk extends \volta\tax {

	public function __construct($theme){

		$this->name = 'merk';
		$this->readName = 'Merk';
		$this->pluralName = 'merken';

		//object_type
		$this->object_type = array( 'product' );

		//args
		$this->args['rewrite'] = array( 'hierarchical' => true );

		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}


	public function import(){

		$this->deleteAll();
		
		//Get the data from the GrpStruc.csv
		$csvData = \muller\importHelper::processCsv('GrpMst.csv');

		//Filter only brands where Group1 start with 5
		$merkToImport = array('hierarchy-1' => array(), 'hierarchy-2' => array());

		foreach($csvData as $key => $data){

			if($data['Group2'] == ''){
				$merkToImport[] = $data;
			}
			
		}
		
		//Import the categories, from hierarchy 1 to 4
		$termIds = array();

		foreach ($merkToImport as $key => $term) {
		
			$insertReturn = wp_insert_term(
			  $term['GrpDescN'], // the term 
			  $this->name // the taxonomy
			);

			if(is_array($insertReturn)){
				add_term_meta($insertReturn['term_id'], 'csvData', serialize($term));
				$termIds[$term['Group1']] = $insertReturn['term_id'];
			}

		}		


		update_option('merk_import', serialize(array('time' => time(), 'termIds' => $termIds)), false);

		var_dump('Import merken done!');
		die();
	}

	

}