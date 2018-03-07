<?php

namespace muller\background;

class deletetax extends \volta\wpbackgroundprocess {

	public function __construct($theme, $taxName){

		$this->theme = $theme;
		$this->taxName = $taxName;

		$this->action = $this->action.$this->taxName;

		parent::__construct();
	}

	/**
	 * @var string
	 */
	protected $action = 'deletetax';

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
		
		

		$count = $this->theme->{$data['class']}->get_term_post_count($data['ID']);
		$term = get_term($data['ID'], $data['name']);

		//error_log($count.' products in '.$data['ID'].' - '.$term->name );

		if($count == 0 || $term->name == '9999'){
			

			$langs = array(
				1 => ['wpml' => 'en', 'csv' => 'GrpDescE'], 
				2 => ['wpml' => 'fr', 'csv' => 'GrpDescF']
			);

			foreach ($langs as $langKey => $lang) {
				//Check if translation exists
				$termTrans = apply_filters( 'wpml_object_id', $data['ID'], $data['name'], false, $lang['wpml']);
				if($termTrans){
					wp_delete_term( $termTrans, $data['name'] );
					error_log('deleted: '.$lang['wpml'].' - '.$termTrans.' from '.$data['name'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/delete-tax.log");
				}

			}

			wp_delete_term( $data['ID'], $data['name'] );

			//Get the array with the csv id's and Wordpress id's
			$termIds = unserialize(get_option($data['name'].'_import'))['termIds'];
			$key = array_search( $data['ID'] ,$termIds);
			unset($termIds[$key]);
			update_option($data['name'].'_import', serialize(array('time' => time(), 'termIds' => $termIds)), false);

			error_log('deleted: '.$data['ID'].' from '.$data['name'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/delete-tax.log");

		}
		update_option('import_progress_cleantaxs', [0 => $data['count'], 1 => $data['counttotal']] ,false);

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
		
		error_log('Complete delete tax '.$this->taxName.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/delete-tax.log");

		$orderfunctions = [
			'product-categorie' => 'deleteMerkReeksCat',
			'merk-reeks' => 'deleteTaxWebReeks'
		];

		if(isset($orderfunctions[$this->taxName])){
			$count = wp_count_terms($this->taxName, ['hide_empty' => false]);

			if($this->taxName == 'merk-reeks'){
				$count = $count + wp_count_terms('product-categorie', ['hide_empty' => false]);
			}
			$this->theme->importpage->{$orderfunctions[$this->taxName]}($count);
		}else{
			update_option('import_progress_cleantaxs', [0 => 'complete', 1 => time()],false);
		}

		// if($this->taxName == 'merk'){
		// 	$this->theme->importpage->importMerken();
		// }elseif($this->taxName == 'productCategory'){
		// 	$this->theme->importpage->importProductCategories();
		// }
		

		// Show notice to user or perform some other arbitrary task...
	}

}