<?php

namespace muller\background;

class deletepost extends \volta\wpbackgroundprocess {

	public function __construct($theme){

		$this->theme = $theme;

		parent::__construct();
	}

	/**
	 * @var string
	 */
	protected $action = 'deletepost';

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
	protected function task( $artikelnr ) {
		
		error_log($artikelnr);

		$query = 'SELECT p.ID, metaartklnr.meta_value
		FROM mll_posts p
		INNER JOIN mll_postmeta metaartklnr ON metaartklnr.post_id = p.ID AND metaartklnr.meta_key = "intern artikelnr" AND metaartklnr.meta_value = "'.$artikelnr.'"
		INNER JOIN mll_icl_translations trans on trans.element_id = p.ID and trans.element_type = "post_product" and trans.language_code = "nl"';

		global $wpdb; 
		$results = $wpdb->get_results($query, 'ARRAY_A');

		$ID = $results[0]['ID'];

		error_log($ID);
		
		$langs = array(
			1 => ['wpml' => 'en'], 
			2 => ['wpml' => 'fr'], 
			3 => ['wpml' => 'nl']
		);

		foreach ($langs as $langKey => $lang) {
			$langID = apply_filters( 'wpml_object_id',  $ID,  'product',  true,  $lang['wpml'] );
			wp_delete_post( $langID, true );
			error_log('deleted: '.$langID.' from producten in '.$lang['wpml']);
		}


		// wp_delete_post( $ID, true );
		// error_log('deleted: '.$ID.' from producten in nl');
		
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
		
		update_option('import_progress_deleteProducts', [0 => 'complete', 1 => time()] ,false);

		error_log('Complete delete producten');


		// Show notice to user or perform some other arbitrary task...
	}

}