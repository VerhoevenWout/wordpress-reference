<?php

namespace muller\background;

class getproductimg extends \volta\wpbackgroundprocess {

	public function __construct($theme){

		$this->theme = $theme;

		parent::__construct();
	}
	
	/**
	 * @var string
	 */
	protected $action = 'getproductimg';

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
		$this->offset = $data['offset'];
		// $csvData = $this->theme->importHelper->getartklnrs();

		// $artikelNr = get_post_meta($data['productID'] , 'intern artikelnr')[0];
		// if(!isset($csvData[$artikelNr])){
		// 	wp_delete_post($data['productID']);
		// 	error_log('Error Delete product: '.$artikelNr.'/'.$data['productID'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-imgs.log");

		// 	$langs = array(
		// 		1 => ['wpml' => 'en', 'csvtitel' => 'artikelnaam EN', 'csvcontent' => 'commerciële omschrijving EN'], 
		// 		2 => ['wpml' => 'fr', 'csvtitel' => 'artikelnaam FR', 'csvcontent' => 'commerciële omschrijving FR']
		// 	);

		// 	foreach ($langs as $langKey => $lang) {
		// 		$prodTrans =  apply_filters( 'wpml_object_id', $data['productID'], 'product', true, $lang['wpml']);

		// 		if($prodTrans){
		// 			wp_delete_post($prodTrans);
		// 			error_log('Error Delete product '.$lang['wpml'].': '.$artikelNr.'/'.$prodTrans.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-imgs.log");
		// 		}
		// 	}


		// }else{
		// 	error_log('No Delete product: '.$artikelNr.'/'.$data['productID'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-imgs.log");
			$this->theme->awshelper->getImgProducts($data['productID']);
		//}

		

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
		error_log('complete getproductimg'.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-imgs.log");

		//if($this->offset != false){
		$this->theme->importpage->getProductImages($this->offset+10);
		//}
		
		// Show notice to user or perform some other arbitrary task...
	}


}