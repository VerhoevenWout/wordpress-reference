<?php 

namespace muller;

require 'lib/aws/aws-autoloader.php';

use Aws\S3\S3Client;

class awshelper {

	/**
	 * Types of images for a product
	 *
	 * array $menus
	 */
	public $imagekeys = array(
		'HB_XL' => '_HB_XL_', 
		'HB' => '_HB_',
		'thumb' => '_thumb_',
		'pack' => '_pack_', 
		'reppack' => '_reppack_',
		'EB_XL' => '_EB_XL_',
		'EB' => '_EB_'
	);

	public function __construct($theme){

		$this->theme = $theme;

	}

	public function getImgProductsSingle($ID){
		if($_POST['getaws']){
			$this->getImgProducts($ID, true);
		}
	}

	
	public function getImgProducts($ID, $refresh = fasle){

		//Get the intern artikel nr
		$artikelNr = get_post_meta($ID , 'intern artikelnr')[0];
		//Get merk taxiomoy
		$merk = wp_get_post_terms($ID, 'merk-reeks')[0];

		//Get merk name
		$merk = $this->get_term_top_most_parent($merk->term_id, 'merk-reeks');
		$merk->name = html_entity_decode($merk->name);

		$foldermerkname = iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$merk->name);
		$foldermerkname = preg_replace('#[^-\w]+#', '', $foldermerkname);

		//Delte images from server 
		//Check if imagemeta exists otherwise set empty array.
		$imagesMeta = get_post_meta($ID, 'images');

		if($imagesMeta){
			$imagesMeta = unserialize($imagesMeta[0]);

			foreach ($imagesMeta as $key => $value) {
				if(isset($value['ID'])){
					wp_delete_attachment($value['ID']);
				}
			}
		}


		//Connect to S3
		$s3Client = S3Client::factory(array(
		    'credentials' => array(
		        'key'    => 'AKIAJPNKNZOFE5V3NK2Q',
		        'secret' => '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',
		    ),
		    'region' => 'eu-west-1',
		    'version' => 'latest'
		));

		//Check logo 
		$iterator = $s3Client->getIterator('ListObjects', array(
		    'Bucket' => 'muller-kitchenandtableware-webimages', 
		    "Prefix" => $foldermerkname."/logo"
		));

		foreach ($iterator as $object) {
			if(stripos($object['Key'], '.png') &&  !stripos($object['Key'], '@2x')){
				update_term_meta($merk->term_id, 'logo_s3', $object['Key']);
			}
		}

		$iterator = $s3Client->getIterator('ListObjects', array(
		    'Bucket' => 'muller-kitchenandtableware-webimages', 
		    "Prefix" => $foldermerkname."/"
		));

		$imagesMeta = [];
		$pdfMeta = [];
		$i = 0;
		foreach ($iterator as $object) {

			$filename = str_replace('-', '_', $object['Key']);

			$stripos =  stripos($filename, $artikelNr);
		    if($stripos &&  stripos($filename, '.jpg')){

		    	// $imagesMeta[$object['Key']] = $object['Key'];

		    	// foreach ($this->imagekeys as $key => $imagekey) {
		    	// 	if(stripos($filename, $imagekey) && !strpos($object['Key'], $imagekey.'XL_')){
		    	// 		$imagesMeta[$key] = $object['Key'];
		    	// 		unset($imagesMeta[$object['Key']]);
		    	// 	}
		    	// }
		    	foreach ($this->imagekeys as $key => $imagekey) {
		    		if(stripos($filename, $imagekey)){
		    			switch ($key) {
		    				case 'EB':
		    				case 'EB_XL':
		    					$orderLetter = substr( $filename, $stripos+strlen($artikelNr), 1);

		    					if(!ctype_alpha($orderLetter)){
		    						$i++;
		    						$orderLetter = $i;
		    					}

		    					if(!isset($imagesMeta[$key])){
		    						$imagesMeta[$key] = [];
		    					}

		    					$imagesMeta[$key][$orderLetter] = $object['Key'];

		    					break;
		    				
		    				default:
		    					
		    					$imagesMeta[$key] = $object['Key'];

		    					break;
		    			}

		    			break;
		    		}
		    	}

		    }

		    if(stripos($filename, $artikelNr) &&  stripos($filename, '.pdf')){
		    	$pdfMeta[] = $object['Key'];
		    }
		}

		if(isset($imagesMeta['EB'])){
			ksort($imagesMeta['EB']);
		}

		if(isset($imagesMeta['EB_XL'])){
			ksort($imagesMeta['EB_XL']);
		}

		if(isset($imagesMeta['HB_XL'])){
			if(is_array($imagesMeta['EB_XL'])){
				array_unshift($imagesMeta['EB_XL'], $imagesMeta['HB_XL']);
			}else{
				$imagesMeta['EB_XL'] = [0 => $imagesMeta['HB_XL']];
			}
			unset($imagesMeta['HB_XL']);
		}

		if(count($imagesMeta) == 0){
			error_log('No image for product: '.$artikelNr.'/'.$ID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-now-imgs-aws.log");
		}

		update_post_meta($ID, 'images', serialize($imagesMeta));	
		update_post_meta($ID, 'pdfs', serialize($pdfMeta));	

		$thumbsrc = $this->theme->product->getThumbsrc($ID);
		update_post_meta($ID, 'thumbsrc', $thumbsrc);


		$langs = array(
			1 => ['wpml' => 'en'], 
			2 => ['wpml' => 'fr']
		);

		foreach ($langs as $langKey => $lang) {
			$langID = apply_filters( 'wpml_object_id',  $ID,  'product',  true,  $lang['wpml'] );
			update_post_meta($langID, 'thumbsrc', $thumbsrc);
		}

		if($refresh){
			//clear cache
			global $wpdb;
			$wpdb->query( 
				$wpdb->prepare( 
					"
			         DELETE FROM mll_options
					 WHERE option_name LIKE '%getproductsquery%'
					", []
			        )
			);
			//refresh
			header("Refresh:0");
		}
	}

	// determine the topmost parent of a term
	protected function get_term_top_most_parent($term_id, $taxonomy){
	    // start from the current term
	    $parent  = get_term_by( 'id', $term_id, $taxonomy);
	    // climb up the hierarchy until we reach a term with parent = '0'
	    while ($parent->parent != '0'){
	        $term_id = $parent->parent;

	        $parent  = get_term_by( 'id', $term_id, $taxonomy);
	    }
	    return $parent;
	}

	public function getdup(){

		//Connect to S3
		$s3Client = S3Client::factory(array(
		    'credentials' => array(
		        'key'    => 'AKIAJPNKNZOFE5V3NK2Q',
		        'secret' => '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',
		    ),
		    'region' => 'eu-west-1',
		    'version' => 'latest'
		));

		$iterator = $s3Client->getIterator('ListObjects', array(
		    'Bucket' => 'muller-kitchenandtableware-webimages'
		));

		$imagekeys = array(
			'HB_XL' => '_HB_XL_', 
			'thumb' => '_thumb_',
			'pack' => '_pack_', 
			'reppack' => '_reppack_',
			'EB_XL' => '_EB_XL_'
		);

		foreach ($iterator as $object) {
			$filename = str_replace('-', '_', $object['Key']);

		    if( stripos($filename, '.jpg')){
				$count = 0;
				foreach ($imagekeys as $key => $imagekey) {
			    	if(stripos($filename, $imagekey)){
			    		$count++;
			    	}
			    }

			   if(stripos($filename, '_HB_') && !stripos($filename, '_HB_XL')){
			   		$count++;
			   }

			   if(stripos($filename, '_EB_') && !stripos($filename, '_EB_XL')){
			   		$count++;
			   }

			   if($count > 1){
			   	error_log($filename.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/s3-dubbel-code.log");
			   }
			}

		}
		var_dump('getdup done!');
		die();

	}

}