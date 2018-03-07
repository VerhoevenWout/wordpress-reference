<?php

namespace muller\background;

class urltax extends \volta\wpbackgroundprocess {

	public function __construct($theme, $taxName){

		$this->theme = $theme;
		$this->taxName = $taxName;

		$this->action = $this->action.$this->taxName;

		parent::__construct();
	}

	/**
	 * @var string
	 */
	protected $action = 'urltax';

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
		
		global $sitepress;
        $sitepress->switch_lang('nl');

		$term = get_term($data['ID'], $data['name']);

		
		$this->updateslug($term, sanitize_title($term->name));

		

		$langs = array(
			1 => ['wpml' => 'en', 'csv' => 'GrpDescE'], 
			2 => ['wpml' => 'fr', 'csv' => 'GrpDescF']
		);

		foreach ($langs as $langKey => $lang) {
			//Check if translation exists
			$termTrans = apply_filters( 'wpml_object_id', $data['ID'], $data['name'], false, $lang['wpml']  );
			
			if($termTrans){
        		$sitepress->switch_lang($lang['wpml']);
				$term = get_term($termTrans, $data['name']);
				$this->updateslug($term, $langKey.'-'.sanitize_title($term->name), $langKey);
			}

		}

		//error_log('Update slug: '.$data['ID'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/url-tax.log");
		update_option('import_progress_cleanurls', [0 => $data['count'], 1 => $data['counttotal']] ,false);

		

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
		
		error_log('Complete url tax '.$this->taxName.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/url-tax.log");

		$orderfunctions = [
			'product-categorie' => 'urlMerkReeksCat',
			'merk-reeks' => 'urltaxWebReeks'
		];

		if(isset($orderfunctions[$this->taxName])){
			$count = wp_count_terms($this->taxName, ['hide_empty' => false]);

			if($this->taxName == 'merk-reeks'){
				$count = $count + wp_count_terms('product-categorie', ['hide_empty' => false]);
			}
			$this->theme->importpage->{$orderfunctions[$this->taxName]}($count);
		}else{
			update_option('import_progress_cleanurls', [0 => 'complete', 1 => time()],false);
		}
		
	}

	function the_slug_exists($slug, $tax) {
    global $wpdb;
	   if($wpdb->get_row("SELECT * FROM mll_terms t 
JOIN mll_term_taxonomy tt on t.term_id = tt.term_id and taxonomy = '".$tax."'
WHERE t.slug = '".$slug."' ", 'ARRAY_A')) {
	        return true;
	    } else {
	        return false;
	    }
	}


	function updateslug($term, $sanitize_title, $langKey = false){

		if($term->slug != $sanitize_title){
			
			if(!$this->the_slug_exists($sanitize_title, $term->taxonomy)){
				$newslug = $sanitize_title;
			}else{
				if($term->parent){
					$parent = get_term($term->parent, $term->taxonomy);
					$words = explode(' ', $parent->name);

					$intials = '';

					foreach ($words as $word) {
						$intials .= $word[0];
					}

					if($langKey){
						$newslug = $langKey.'-'.$intials.'-'.sanitize_title($term->name);
					}else{
						$newslug = $intials.'-'.$sanitize_title;
					}
					
					
				}else{
					error_log('ERROR: '.$term->term_id.' / '.$term->slug.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/url-tax.log");
				}
			}

			if($term->slug != $newslug){
				$update = wp_update_term(	
				  $term->term_id, // the term 
				  $term->taxonomy, // the taxonomy
				  array(
				    'slug' => $newslug
				  )
				);
				error_log( print_r($update, TRUE) );
				error_log('Update slug: '.$term->term_id.' / '.$newslug.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/url-tax.log");
			}

		}

	}

}