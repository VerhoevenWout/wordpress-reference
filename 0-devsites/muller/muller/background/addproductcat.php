<?php

namespace muller\background;

class addproductcat extends \volta\wpbackgroundprocess {

	public function __construct($theme){

		$this->theme = $theme;

		parent::__construct();
	}
	
	/**
	 * @var string
	 */
	protected $action = 'addproductcat';

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param mixed $item Queue item to iterate over
	 *
	 * @return mixed
	 */
	protected function task( $data ) {
		$taxName = $data['taxName'];
		$this->offset = $data['offset'];
		$data = $data['data'];		


		//Get the array with the csv id's and Wordpress id's
		$termIds = unserialize(get_option($taxName.'_import'))['termIds'];

		
		//Remove leading zero's
		$data['AltGrp2'] = ltrim($data['AltGrp2'], '0');
		$data['AltGrp3'] = ltrim($data['AltGrp3'], '0');
		$data['AltGrp4'] = ltrim($data['AltGrp4'], '0');
		$data['AltGrp5'] = ltrim($data['AltGrp5'], '0');

		if($data['AltGrp4'] != '9999'):
		
		//Make the serie of id's from the csv's 
		$AltGrpConcat = $data['AltGrp2'].'-'.$data['AltGrp3'].'-'.$data['AltGrp4'].'-'.$data['AltGrp5'];
		
		//Get the csv's ids from the parent cat
		$iplus1 = $data['hierarchy']+1;
		$temp = $data['AltGrp'.$iplus1];
		$data['AltGrp'.$iplus1] = '';
		$AltGrpConcatParent = $data['AltGrp2'].'-'.$data['AltGrp3'].'-'.$data['AltGrp4'].'-'.$data['AltGrp5'];
		$data['AltGrp'.$iplus1] = $temp;
		
		//Check if the parent exists 
		if(isset($termIds[$AltGrpConcatParent])){
			$parent_term_id = $termIds[$AltGrpConcatParent];
		}else{
			$parent_term_id = 0;
		}

		//check if the term already exists, if so update instead of insert
		if(isset($termIds[$AltGrpConcat])){
			error_log('update cat '.$termIds[$AltGrpConcat].' - '.$data['GrpDescN'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-categories.log");
		
			
			$slug = $this->getslug($termIds[$AltGrpConcat]);

			$insertReturn = wp_update_term(	
			  $termIds[$AltGrpConcat], // the term 
			  $taxName, // the taxonomy
			  array(
			  	'name' => $data['GrpDescN'],
			    'parent'=> $parent_term_id, 
			    'slug' => $slug
			  )
			);

		}else{
			error_log('insert cat '.$data['GrpDescN'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-categories.log");
			$insertReturn = wp_insert_term(	
			  $data['GrpDescN'], // the term 
			  $taxName, // the taxonomy
			  array(
			    'parent'=> $parent_term_id
			  )
			);
		}
		
		if(is_array($insertReturn)){
			update_term_meta($insertReturn['term_id'], 'csvData', $data);
			$termIds[$AltGrpConcat] = $insertReturn['term_id'];

			if($data['hierarchy'] == 1){
				update_term_meta($insertReturn['term_id'], 'AltGrp2', $data['AltGrp2']);
			}

		}else{
			error_log('import error for '.$taxName.' ->'.$AltGrpConcat.' -> '.$data['GrpDescN'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-categories.log");
			$insertReturn = wp_insert_term(	
			  $data['GrpDescN'].' - dubbel -'.$AltGrpConcat, // the term 
			  $taxName, // the taxonomy
			  array(
			    'parent'=> $parent_term_id
			  )
			);

			if(is_array($insertReturn)){
				error_log('Error dubbel - insert - '.$data['GrpDescN'].' - dubbel'.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-categories.log");
				update_term_meta($insertReturn['term_id'], 'csvData', serialize($data));
				$termIds[$AltGrpConcat] = $insertReturn['term_id'];
			}
		}

		update_option($taxName.'_import', serialize(array('time' => time(), 'termIds' => $termIds)), false);

		$langs = array(
			1 => ['wpml' => 'en', 'csv' => 'GrpDescE'], 
			2 => ['wpml' => 'fr', 'csv' => 'GrpDescF']
		);

		foreach ($langs as $langKey => $lang) {
		
			//Check if translation exists
			$termTrans = apply_filters( 'wpml_object_id',$insertReturn['term_id'], $taxName, false, $lang['wpml']);

			if(!$termTrans){

				//Insert translted term
				$insertReturnTrans = wp_insert_term(	
				  $data[$lang['csv']], // the term 
				  $taxName, // the taxonomy
				  array(
				    'parent'=> apply_filters( 'wpml_object_id',$parent_term_id, $taxName, false, $lang['wpml'])
				  )
				);
			
				if(is_array($insertReturnTrans)){
					error_log('insert cat '.$lang['wpml'].' '.$data[$lang['csv']].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-categories.log");
				}else{

					if($data[$lang['csv']] == ''){
						$data[$lang['csv']] = $data['GrpDescN'].'-'.$lang['wpml'];
					}

					//Insert translted term
					$insertReturnTrans = wp_insert_term(	
					  $data[$lang['csv']], // the term 
					  $taxName, // the taxonomy
					  array(
					    'parent'=> apply_filters( 'wpml_object_id',$parent_term_id, $taxName, false, $lang['wpml']), 
					    'slug' => $langKey.'-'.$data[$lang['csv']]
					  )
					);

					error_log('insert cat '.$lang['wpml'].' extra -en '.$data[$lang['csv']].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-categories.log");
				}
				

				//Attach original with translation
				// https://wpml.org/wpml-hook/wpml_element_type/
		        $wpml_element_type = apply_filters( 'wpml_element_type', $taxName );
		        // get the language info of the original post
		        // https://wpml.org/wpml-hook/wpml_element_language_details/
		        $get_language_args = array('element_id' => $insertReturn['term_id'], 'element_type' => $taxName );
		        $original_post_language_info = apply_filters( 'wpml_element_language_details', null, $get_language_args );
		        $set_language_args = array(
		            'element_id'    => $insertReturnTrans['term_id'],
		            'element_type'  => $wpml_element_type,
		            'trid'   => $original_post_language_info->trid,
		            'language_code'   => $lang['wpml'],
		            'source_language_code' => $original_post_language_info->language_code
		        );
		 
		        do_action( 'wpml_set_element_language_details', $set_language_args );

			}else{
				

				$slug = $this->getslug($termTrans);

				if($data[$lang['csv']] == ''){
					$data[$lang['csv']] = $data['GrpDescN'].'-'.$lang['wpml'];
				}
				
				$insertReturnTrans = wp_update_term(	
				  $termTrans, // the term 
				  $taxName, // the taxonomy
				  array(
				  	'name' => $data[$lang['csv']],
				    'parent'=> apply_filters( 'wpml_object_id',$parent_term_id, $taxName, false, $lang['wpml']), 
				    'slug' => $langKey.'-'.$data[$lang['csv']]
				  )
				);

				error_log('update cat '.$termTrans.' - '.$lang['wpml'].' '.$data[$lang['csv']].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-categories.log");

			}
		}

		endif;
		//error_log('Added product categorie: '.$data['GrpDescN']);
		return false;
	}

	/**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();

		$this->theme->importpage->importProductCategories($this->offset+10);
		//error_log('Completed import product categories.');

		//$this->theme->importpage->deleteMerkCat();
		// Show notice to user or perform some other arbitrary task...
	}

	protected function getslug($id){
		global $sitepress;
		remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
		$slug = get_term_by('term_taxonomy_id',$id, $taxName)->slug;
		add_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1, 1 );

		return $slug;
	}

}