<?php 

namespace muller;

class init extends \volta\init {


	/**
	 * Menu locations used in the theme
	 *
	 * array $menus
	 */
	public $menus = array(
		array('hoofd-menu', 'Hoofdmenu'),
		array('footer-menu', 'Footermenu'),
		array('lang-menu', 'Languagemenu'),
		array('account-menu', 'Accountmenu')
	);

	/**
	 * Mandrill subaccount id
	 *
	 * string $menus
	 */
	public $mandrillSubaccountId = 'volta-dev';

	public $version = '1.1.3';


	public function __construct(){

		// Execute parent constructor.
		parent::__construct();

		$this->setupPostTypes();
		$this->setupTaxonomies();

		flush_rewrite_rules();

		//Filters
		if( stristr( $_SERVER['SERVER_NAME'], "loc" ) || stristr( $_SERVER['SERVER_NAME'], "xip.io" ) ) {
			add_filter('https_ssl_verify', '__return_false');
			add_filter('https_local_ssl_verify', '__return_false');
		}


		
		//actions
		add_action( 'wp_enqueue_scripts',  array($this, 'css_js_muller'));
		add_action( 'wpseo_add_opengraph_images', array($this,'yoast_add_images') );

		//Classes
		//$this->menushelper = new menushelper($this);
		$this->awshelper = new awshelper($this);
		$this->filters = new \muller\filters\filters($this);
		$this->acfhelper = new acfhelper($this);
		$this->userhelper = new userhelper($this);
		$this->homehelper = new homehelper($this);
		$this->searchhelper = new searchhelper($this);
		$this->importHelper = new \muller\importHelper($this);
	
		if(is_admin()){
			$this->adminConstruct();
		}
		
	}


	private function adminConstruct(){

		$this->importpage = new adminpages\importpage($this);

	}

	/**
	 * Setup the costum post types for the theme
	 *
	 * Init the posttypes based on the /volta/cpt 
	 *
	 */
	private function setupPostTypes(){
		
		$this->product = new cpt\product($this);
		$this->nieuws = new cpt\nieuws($this);

	}


	/**
	 * Setup the costum taxonomies for the theme
	 *
	 * Init the taxonomies based on the /volta/tax 
	 *
	 */
	private function setupTaxonomies(){

		$this->productCategory = new tax\productCategory($this);		

		//$this->merk = new tax\merk($this);	

		$this->merkReeks = new tax\merkreeks($this);

		$this->webReeks = new tax\webreeks($this);	

	}

	/**
	 * Get page by tempalte
	 */
	public function getbytemplate($tplname){

		$pages = get_pages(array(
		    'meta_key' => '_wp_page_template',
		    'meta_value' => 'templates/'.$tplname.'.php'
		));

		foreach($pages as $page){
		    return get_page(apply_filters( 'wpml_object_id', $page->ID, 'page' ));
		}

	}


	/**
	 * Enquee the css js based on template/archive/cpt etc
	 *
	 */
	public function css_js_muller(){

		wp_register_style( 'slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', false, $this->version );
		wp_register_style( 'typekit', '//use.typekit.net/hqs2fuw.css', false, $this->version );

		wp_enqueue_style( 'typekit' );

		wp_enqueue_script( 'nav', get_template_directory_uri() . '/dist/js/nav.bundle.js', array (  ), $this->version, true);
		wp_enqueue_script( 'animations', get_template_directory_uri() . '/dist/js/animations.bundle.js', array (  ), $this->version, true);
		
		if(is_tax($this->productCategory->name)){
			$this->productCategory->getLevel();
			$level = $this->productCategory->level;
			if($level == 2 || isset($_GET['merken']) ||  ($level == 1 && count(get_term_children($this->productCategory->taxVars->term_id, $this->productCategory->name)) == 0)){
				wp_enqueue_script( 'product-filter', get_template_directory_uri() . '/dist/js/product-filter.bundle.js', array (  ), $this->version, true);
			}

			if($level == 1 ){
				wp_enqueue_script( 'blokken', get_template_directory_uri() . '/dist/js/blokken.bundle.js', array (  ), $this->version, true);
				wp_enqueue_style( 'slick' );
			}
		}

		if(is_tax($this->merkReeks->name)){
			$this->merkReeks->getLevel();
			if($this->merkReeks->level == 2 || $this->merkReeks->level == 3 ){
				wp_enqueue_script( 'merk-filter', get_template_directory_uri() . '/dist/js/merk-filter.bundle.js', array (  ), $this->version, true);
			}

			if($this->merkReeks->level == 1){
				wp_enqueue_script( 'blokken', get_template_directory_uri() . '/dist/js/blokken.bundle.js', array (  ), $this->version, true);
				wp_enqueue_style( 'slick' );
			}
		}

		if(is_singular('product') ){
			wp_enqueue_script( 'single-product', get_template_directory_uri() . '/dist/js/single-product.bundle.js', array (  ), $this->version, true);
				wp_enqueue_style( 'slick' );
		}

		if(is_page_template('templates/tpl-winkelmand.php')){

			wp_enqueue_script( 'cart', get_template_directory_uri() . '/dist/js/cart.bundle.js', array (  ), $this->version, true);

		}

		if(is_page_template('templates/tpl-profiel.php')){

			wp_enqueue_script( 'profile', get_template_directory_uri() . '/dist/js/profile.bundle.js', array (  ), $this->version, true);

		}

		if(is_page_template('templates/tpl-search.php')){

			wp_enqueue_script( 'profile', get_template_directory_uri() . '/dist/js/search.bundle.js', array (  ), $this->version, true);
				wp_enqueue_style( 'slick' );

		}

		if(is_page_template('templates/tpl-merken.php')){

			wp_enqueue_script( 'profile', get_template_directory_uri() . '/dist/js/blokken.bundle.js', array (  ), $this->version, true);
			wp_enqueue_style( 'slick' );

		}

	}

	public function yoast_add_images($object){
		if(is_singular('product') ){
			$id = apply_filters( 'wpml_object_id',  get_the_ID(),  $this->product->name,  true,  'nl' );
			$image =  'https:'.$this->product->getThumbsrc($id);
			$sizes = getimagesize($image);

			if($sizes[0] < 200 || $sizes[1] < 200){
				$image = 'https://s3-eu-west-1.amazonaws.com/muller-kitchenandtableware-webimages/'.$this->product->getImages($id)['HB'];
				$sizes = getimagesize($image);
			}

			global $wpseo_og;
			$wpseo_og->og_tag( 'og:image:width', $sizes[0] );
			$wpseo_og->og_tag( 'og:image:height', $sizes[1] );
			$object->add_image( $image );
		}
	}

}