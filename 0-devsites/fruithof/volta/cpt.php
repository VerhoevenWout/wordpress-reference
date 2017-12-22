<?php

namespace Volta;

/**
 * Intialise a custom post type
 *
 */
class cpt {

	/**
    * The name of the custom post type
    * @var string
    */
	public $name;

	/**
    * The name used in the admin for labels etc of the custom post type
    * @var string
    */
	public $readName;

	/**
    * The plural name used in the admin for labels etc of the custom post type
    * @var string
    */
	public $pluralReadName;

	/**
    * The variable of the current  posttype
    * @var array
    */
	public $postVars;

	/**
    * The meta variable of the current  posttype
    * @var array
    */
	public $postMeta;

	/**
    * The init class of the current
    * @var /volta/init
    */
	private $theme;

	/**
    * The options used to register the post type
    * @var array
    */
	public $args = array(
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => false,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => false,		
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'page',
			);

	
	public function __construct($theme){

		$this->theme = $theme;

		$this->name = strtolower($this->name);
		$this->Readname = strtolower($this->readName);
		$this->pluralReadName = strtolower($this->pluralName);
		$this->theme->textdomain = strtolower($this->theme->textdomain);

		if($this->metaboxes){
			$this->initMetaboxes();
		}

	}

	/**
	* Registers the post type in Wordpress
	*
	**/
	public function create(){

		$labels = array(
			'name'                  => _x( ucfirst($this->pluralReadName), 'Post Type General Name', $this->theme->textdomain ),
			'singular_name'         => _x( ucfirst($this->readName), 'Post Type Singular Name', $this->theme->textdomain ),
			'menu_name'             => __( ucfirst($this->pluralReadName), $this->theme->textdomain ),
			'name_admin_bar'        => __( ucfirst($this->readName), $this->theme->textdomain ),
			'parent_item_colon'     => __( 'Parent Item:', $this->theme->textdomain ),
			'all_items'             => __( 'Alle '.$this->pluralReadName, $this->theme->textdomain ),
			'add_new_item'          => __( 'Maak nieuwe '.$this->readName , $this->theme->textdomain ),
			'add_new'               => __( 'Maak nieuwe '.$this->readName , $this->theme->textdomain ),
			'new_item'              => __( 'Nieuwe '.$this->readName , $this->theme->textdomain ),
			'edit_item'             => __( 'Bewerk '.$this->readName , $this->theme->textdomain ),
			'update_item'           => __( ucfirst($this->readName).' bijwerken', $this->theme->textdomain ),
			'view_item'             => __( 'Bekijk '.$this->readName , $this->theme->textdomain ),
			'search_items'          => __( 'Zoek '.$this->readName , $this->theme->textdomain ),
			'not_found'             => __( 'Niet gevonden', $this->theme->textdomain ),
			'not_found_in_trash'    => __( 'Niet gevonden in prullenmand', $this->theme->textdomain ),
			'items_list'            => __( ucfirst($this->pluralReadName).' lijst', $this->theme->textdomain ),
			'items_list_navigation' => __( '$this->readName lijst navigatie ', $this->theme->textdomain ),
			'filter_items_list'     => __( 'Filter '.$this->pluralReadName.' lijst', $this->theme->textdomain ),
		);

		$this->args['label'] = __( $this->readName, $this->theme->textdomain );
		$this->args['labels'] = $labels;

		\register_post_type( $this->name, $this->args );
	}

	/**
    * Update or set a option for the post type, used by register_post_type
    *
    * @var string $argument
    * @var string $option
    */
	public function setPtArg($argument, $option){

		$this->args[$argument] = $option;

	}	

	/**
    * Remove the publish metabox in the admin for this post type
    *
    */
	public function removePublish(){

		add_action( 'add_meta_boxes', array($this, 'my_remove_publish_metabox' ));

	}

	/**
    * Remove the publish metabox in the admin for this post type
    *
    */
	public function my_remove_publish_metabox() {

	    remove_meta_box( 'submitdiv', $this->name , 'side' );

	}

	/**
    * Get the posts in this post type
    *
    * @var array 
    */
	public function get_posts($args = array()){
		$args['post_type'] = $this->name;

		return get_posts($args);
	}

	/**
    * Get the variable for the current post 
    *
    * @var array 
    */
	public function getPostVars(){

		$this->postVars = get_post();
		
	}

	/**
    * Get the meta variable for the current post
    *
    * @var array 
    */
	public function getPostMeta(){

		
		$this->getPostVars();
		
		$this->postMeta = get_post_meta($this->postVars->ID);
		
	}


	/**
    * Undercept the save action for this post type in the admin
    *
    * Calls the saveCpt function in a filter
    */
	public function underceptSave(){

		$this->newPostData = array();
		$this->newPostMeta = array();
		$this->updatePostMeta = array();

		add_filter( 'wp_insert_post_data', array($this, 'saveCpt'), 10 , 2 );
		
	}	

	/**
    * Save the data changed in the admin 
    *
    * @var array $data
	* @var array $postArr
    */
	public function saveCpt($data, $postArr){

		if($postArr['post_type'] == $this->name){

			$this->getPostMeta();
			
			$func = 'save'.ucfirst($this->name);
			$this->$func($postArr, $_REQUEST);

			foreach ($this->newPostData as $key => $value) {
				$data[$key] = $value;
			}

			foreach ($this->newPostMeta as $key => $value) {
				add_post_meta($postArr['ID'], $key , $value );
			}

			foreach ($this->updatePostMeta as $key => $value) {
				update_post_meta($postArr['ID'], $key , $value );
			}

		}

		return $data;
	}

	/**
    * Initiate the metaboxes classes to add meta boxes to the admin for this posttype
    *
    * Calls the add_custom_meta_boxes function throug a action
    */
	public function initMetaboxes(){

		foreach ($this->metaboxes as $box) {
			$classname = '\metaboxes\\'.$box;
			$boxname = $box.'Metabox';
			$this->$boxname = new $classname($this);
		}

		add_action('add_meta_boxes', array( $this, 'add_custom_meta_boxes' ));

	}

	/**
    * Initiate the metaboxes classes to add meta boxes to the admin for this posttype
    *
    */
	public function add_custom_meta_boxes(){

		$this->getPostMeta();

		foreach ($this->metaboxes as $box) {
			$classname = '\metaboxes\\'.$box;
			$boxname = $box.'Metabox';

			if($this->$boxname->showBox()){
				add_meta_box($this->$boxname->name, $this->$boxname->title, array( $this->$boxname, "custom_meta_box_markup"), $this->name , $this->$boxname->context, "high", null);
			}
		}
	}


}