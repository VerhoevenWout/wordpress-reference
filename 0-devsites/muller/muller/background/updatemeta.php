<?php

namespace muller\background;

class updatemeta extends \volta\wpbackgroundprocess {

	public function __construct($theme){

		$this->theme = $theme;

		parent::__construct();
	}
	
	/**
	 * @var string
	 */
	protected $action = 'updatemeta';

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
		//$this->offset = $data['offset'];
		
		
		global $wpdb; 
		$query = "UPDATE mll_postmeta m1
					JOIN mll_postmeta m2 ON m2.post_id = m1.post_id AND m2.meta_key = 'intern artikelnr'  AND m2.meta_value = '".$data['value']['artikelnr']."'
					set m1.meta_value  = '".$data['value']['newdata']."'
					WHERE m1.meta_key = '".$data['value']['meta']."'";
		$result = $wpdb->get_results($query);
		
		error_log('udpated meta '.$data['value']['artikelnr']);
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
		error_log('complete updatemeta');

		//if($this->offset != false){
		//$this->theme->importpage->getProductImages($this->offset+10);
		//}
		
		// Show notice to user or perform some other arbitrary task...
	}


}