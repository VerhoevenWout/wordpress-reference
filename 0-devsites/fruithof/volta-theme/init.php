<?php 

namespace voltatheme;

class init extends \volta\init {


	/**
	 * Mandrill subaccount id
	 *
	 * string $menus
	 */
	public $mandrillSubaccountId = 'volta-dev';


	public function __construct(){

		// Execute parent constructor.
		parent::__construct();

		$this->setupPostTypes();

		$this->options_page();

		$this->setupTaxonomies();


		//Filters


		//actions
		

	}

	/**
	 * Setup the costum post types for the theme
	 *
	 * Init the posttypes based on the /volta/cpt 
	 *
	 */
	private function setupPostTypes(){

		$this->document = new cpt\document($this);
		$this->privatedocument = new cpt\privatedocument($this);

		$this->contact = new cpt\contact($this);
		$this->team = new cpt\team($this);
	}

	/**
	 * Setup the costum taxonomies for the theme
	 *
	 * Init the taxonomies based on the /volta/tax 
	 *
	 */
	private function setupTaxonomies(){

		$this->teamFunctions = new tax\teamfunctions($this);
		$this->contactGroepen = new tax\contactgroepen($this);
		$this->documentGroepen = new tax\documentgroepen($this);

	}

}