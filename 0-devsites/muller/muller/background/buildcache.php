<?php

namespace muller\background;

class buildcache extends \volta\wpbackgroundprocess {

	public function __construct($theme){

		$this->theme = $theme;

		parent::__construct();
	}

	/**
	 * @var string
	 */
	protected $action = 'buildcache';

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
		
		error_log('buildcache term id: '.$data['id'].PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/build-cache.log");
		error_log('term id '.$data['id']);
		$this->theme->filters->get_tax_products_ajx($data['id'], 'nl');

		if($data['landing']){

			$transientkey = '/nl/producten/'.$data['slug'].'/-\muller\tax\productCategory / get_tax_childeren / childeren / false';

			$result = $this->theme->productCategory->get_tax_childeren($data['id']);

			set_transient($transientkey, $result);

			$transientkey = '/nl/producten/'.$data['slug'].'/-\muller\tax\productCategory / get_merken / merken / false';

			$result = $this->theme->productCategory->get_merken($data['id']);

			set_transient($transientkey, $result);	
			update_term_meta($data['id'], 'menu_merken', $result);
		}

		$langs = array(
			1 => ['wpml' => 'en', 'catslug' => '/en/products/'], 
			2 => ['wpml' => 'fr', 'catslug' => '/fr/products/']
		);

		foreach ($langs as $langKey => $lang) {
			 $sitepress->switch_lang($lang['wpml']);

			 $langTerm = get_term($data['id'], 'product-categorie');
			 
			 $this->theme->filters->get_tax_products_ajx($langTerm->term_id, $lang['wpml']);

			if($data['landing']){

				$transientkey = $lang['catslug'].$langTerm->slug.'/-\muller\tax\productCategory / get_tax_childeren / childeren / false';

				$result = $this->theme->productCategory->get_tax_childeren($langTerm->term_id);

				set_transient($transientkey, $result);

				$transientkey = $lang['catslug'].$langTerm->slug.'/-\muller\tax\productCategory / get_merken / merken / false';

				$result = $this->theme->productCategory->get_merken($langTerm->term_id);

				set_transient($transientkey, $result);
				update_term_meta($langTerm->term_id, 'menu_merken', $result);
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
		
		update_option('import_progress_buildcache', [0 => 'complete', 1 => time()] ,false);

	}

}