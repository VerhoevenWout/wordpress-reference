<?php

namespace muller\background;

class addmerk extends \volta\wpbackgroundprocess {

	public function __construct($theme){

		$this->theme = $theme;

		parent::__construct();
	}
	
	/**
	 * @var string
	 */
	protected $action = 'addmerk';

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

		$this->offset = $data[3];	

		//Get the term
		$args = array(
		    'taxonomy'   => 'merk-reeks',
		    'hide_empty' => false,
		    'meta_query' => array(
		         array(
		            'key'       => 'AltGrp2',
		            'value'     => ltrim($data[2], '0'),
		            'compare'   => '='
		         )
		    )
		);
		$term = get_terms($args);

		if(isset($term[0])){


			//For video codes
			if($data[1] == 'vimeo'){

				//Get vimeo ID
				$exploded = explode('#', $data[0]);
				

			
				//Update meta
				update_term_meta($term[0]->term_id, 'vimeopage', $exploded[0]);
				error_log('vimeopage update for '.$term[0]->term_id);
			}

			if($data[1] == 'website'){

				//Get vimeo ID
				$exploded = explode('#', $data[0]);
				

			
				//Update meta
				update_term_meta($term[0]->term_id, 'website', $exploded[0]);
				error_log('website update for '.$term[0]->term_id);
			}

			//For catalogus (publitas) codes
			if($data[1] == 'catalogus'){
				error_log('start catalogus updates for '.$term[0]->term_id);
				//Get publitas slug and title
				$exploded = explode('#', $data[0]);

				//Get or create catalogus array
				if($catalogus = get_term_meta($term[0]->term_id, 'catalogus')[0]){
					$catalogus[$exploded[0]] = $exploded[1];
				}else{
					$catalogus = [];
					$catalogus[$exploded[0]] = $exploded[1];	
				}

				//Update meta
				update_term_meta($term[0]->term_id, 'catalogus', $catalogus);
				error_log('catalogus updates for '.$term[0]->term_id);
			}




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
		
		//$this->theme->importpage->importMerken($this->offset+10);

		//$this->theme->importpage->deleteProducts();
		// Show notice to user or perform some other arbitrary task...
	}

}