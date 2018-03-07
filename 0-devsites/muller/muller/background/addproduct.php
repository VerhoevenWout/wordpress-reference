<?php

namespace muller\background;

class addproduct extends \volta\wpbackgroundprocess {

	public function __construct($theme){


		$this->theme = $theme;

		parent::__construct();
	}
	
	/**
	 * @var string
	 */
	protected $action = 'addproduct';

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
		$data = $data['args'];

		$args = array(
		    'meta_key' => 'intern artikelnr',
		    'meta_value' => $data['meta_input']['intern artikelnr'],
		    'post_type' => 'product',
		    'post_status' => 'publish',
		    'posts_per_page' => -1
		);
		$post = get_posts($args);

		
		$ID = false;

		if(isset($post[0]->ID)){
			$ID = apply_filters( 'wpml_object_id', $post[0]->ID, 'product', FALSE, 'nl');
		}

		if($ID){
			

			$data['post_content'] = preg_replace("/^•+(.*)?/im","<ul><li>$1</li></ul>",$data['post_content']);
			$data['post_content'] = preg_replace("/(\<\/ul\>\n(.*)\<ul\>*)+/","",$data['post_content']);
			$data['post_content'] = preg_replace('/\[img(.*?)\](.*?)\[\/img\]/iU', "<img src='img/$2' alt='$1' class='textimage'>", $data['post_content']);
			
			//Update title and content
			$insertReturn = wp_update_post(array(
				'ID' => $ID,
				'post_title' => $data['post_title'],
				'post_content' => $data['post_content']
			));


			//Update post meta
			foreach ($data['meta_input'] as $metaKey => $metaValue) {
				update_post_meta($ID, $metaKey, $metaValue);
			}
			
			//Update taxs
			foreach ($data['tax_input'] as $taxName => $taxIds) {
				wp_set_object_terms($ID, $taxIds, $taxName, false);			
			}

			error_log('Update product: '.$data['post_title'].$productID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-products.log");
		}else{
			$insertReturn = wp_insert_post($data);
			$ID = $insertReturn;
			error_log('Insert product: '.$data['post_title'].$productID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-products.log");
		}

		$this->theme->awshelper->getImgProducts($ID);

		//Otherlanguages

		$langs = array(
			1 => ['wpml' => 'en', 'csvtitel' => 'artikelnaam EN', 'csvcontent' => 'commerciële omschrijving EN'], 
			2 => ['wpml' => 'fr', 'csvtitel' => 'artikelnaam FR', 'csvcontent' => 'commerciële omschrijving FR']
		);


		$orgData = $data;

		foreach ($langs as $langKey => $lang) {

			$transCatIds = [];

			foreach ($orgData['tax_input'] as $key => $taxs) {
				
				if(is_array($taxs)){
					$transCatIds[$key] = [];
					foreach ($taxs as $tax) {
						$termTrans = apply_filters( 'wpml_object_id',$tax, $key, false, $lang['wpml']);
						$transCatIds[$key][] =  $termTrans;
					}
				}else{
					$termTrans = apply_filters( 'wpml_object_id',$taxs, $key, false, $lang['wpml']);
					$transCatIds[$key] = $termTrans;
				}	

			}



			if( $orgData['meta_input'][$lang['csvtitel']] != ''):
			
			$data['post_title'] = $orgData['meta_input'][$lang['csvtitel']];
			$data['post_content'] = $orgData['meta_input'][$lang['csvcontent']];

			
			$data['post_content'] = preg_replace("/^•+(.*)?/im","<ul><li>$1</li></ul>",$data['post_content']);
			$data['post_content'] = preg_replace("/(\<\/ul\>\n(.*)\<ul\>*)+/","",$data['post_content']);
			$data['post_content'] = preg_replace('/\[img(.*?)\](.*?)\[\/img\]/iU', "<img src='img/$2' alt='$1' class='textimage'>", $data['post_content']);
			
			$prodTrans = apply_filters( 'wpml_object_id',$insertReturn, 'product', false, $lang['wpml']);
			
			if(!$prodTrans){
				
				$data['tax_input'] = $transCatIds;

				$insertReturnTrans = wp_insert_post($data);

				
		        global $sitepress;
				// Get original post's "trid" (translation ID)
				$trid = $sitepress->get_element_trid( $insertReturn, 'post_product' );

				// Tell WPML the second post is a translation of the first
				$sitepress->set_element_language_details( $insertReturnTrans, 'post_product', $trid, $lang['wpml'] );

				error_log('Insert product '.$lang['wpml'].' : '.$data['post_title'].$productID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-products.log");

			}else{

				$data['tax_input'] = $transCatIds;

				//Update title and content
				$insertReturn = wp_update_post(array(
					'ID' => $prodTrans,
					'post_title' => $data['post_title'],
					'post_content' => $data['post_content']
				));


				//Update post meta
				foreach ($data['meta_input'] as $metaKey => $metaValue) {
					if($metaValue === 0){
						$metaValue = '0';
					}
					update_post_meta($prodTrans, $metaKey, $metaValue);
				}

				//Update taxs
				foreach ($data['tax_input'] as $taxName => $taxIds) {
					wp_set_post_terms($prodTrans, $taxIds, $taxName, false);			
				}

				error_log('Update product '.$lang['wpml'].' : '.$data['post_title'].$productID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-products.log");

			}

			endif;

		}
		

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
		
		$this->theme->importpage->importProducts($this->offset+10);
		
		// Show notice to user or perform some other arbitrary task...
	}

}