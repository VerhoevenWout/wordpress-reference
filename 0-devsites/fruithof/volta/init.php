<?php

namespace Volta;

/**
 * Intialise the theme
 *
 * All classes and hook are intiaded to let the wordpress funciton with the theme.
 *
 */
class init {

	/**
    * The logo for the website in svg
    * @var string
    */
	public $logo;

	/**
    * The wordpress textdomain
    * @var string
    */
	public $textdomain = 'volta_theme';

	

	public function __construct(){

		//Template directory
		$this->temp_dir = get_template_directory();

		//Actions
		add_filter('upload_mimes', array($this, 'cc_mime_types')); 
		add_action('login_enqueue_scripts', array($this, 'volta_custom_login')); 
		add_action( 'wp_enqueue_scripts',  array($this, 'css_js'));
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		//load Header and footer variables 
		$this->load_variables($this->temp_dir.'/header.php');
		$this->load_variables($this->temp_dir.'/footer.php');

		//Filters
		add_filter( 'template_include', array($this, 'load_variables'), 99 );
		add_filter( 'mandrill_payload', array($this, 'addSubaccount'));
		
		//Load logo
		$this->logo();
		$this->folderEmpty();
		$this->folderFull();

		show_admin_bar(false);
	}

	
	/**
	 * Enable svg upload
	 *
	 * @param array $mimes
	 * 
	 */
	public function cc_mime_types($mimes) {
	  $mimes['svg'] = 'image/svg+xml';
	  return $mimes;
	}

	/**
	 * Set Mandrilll subaccount
	 *
	 * In the Mandrill controll panel you can find the subaccounts under outbound -> subaccount, there copy the id of the desired subaccount
	 *
	 * @param array $message
	 * 
	 */
	public function addSubaccount($message) {
	    $message['subaccount'] = $this->mandrillSubaccountId;
	    return $message;
	}
	
	/**
	 * Load base css and javascript 
	 *
	 * Load the style compiled from /dev/assets/sass/style-site.scss file
	 * Load fontawesome from cdn http://fontawesome.io/
	 * Load the javscript compiled from /dev/assets/js/app.js file (compiled with Browserify)
	 *
	 * @param array $message
	 * 
	 */

	function css_js(){

		//css
		
		wp_enqueue_style( 'site-style', get_template_directory_uri() . '/dist/css/style-site.css',false,'1.0','all');

		//js
		wp_enqueue_script( 'font-awesome', 'https://use.fontawesome.com/dc4c50dd8b.js', array (  ), 1.0, true);
		//wp_enqueue_script( 'site-js', get_template_directory_uri() . '/dist/js/app.js', array (  ), 1.0, true);

	}

	/**
	 * Add custom css for login	 
	 *
	 * This css is compiled with sass from the file dev/assets/sass/style-login.scss
	 * 
	 */
	function volta_custom_login() { 
		wp_enqueue_style('login-styles', get_template_directory_uri() . '/dist/css/login-styles.css'); 
	} 

	/**
	 * Set the svg logo for the site
	 * 
	 */
	function logo(){
		$this->logo = file_get_contents( get_template_directory().'/includes/svg/logo.svg');
	}

	function folderEmpty(){
		$this->folderEmpty = file_get_contents( get_template_directory().'/includes/svg/folder-empty.svg');
	}

	function folderFull(){
		$this->folderFull = file_get_contents( get_template_directory().'/includes/svg/folder-full.svg');
	}

	/**
	 * Get a svg
	 *
	 * Get the svg by name, place it in a php file in the /dev/includes/svg folder with the following naming convenion $name.svg.php
	 * Use the exprot svg for web fucntion in Adobe illustrator with inline style!
	 *
	 *@param string $name 
	 */
	function get_svg($name){
		//var_dump($name);die();
		return file_get_contents( get_template_directory().'/includes/svg/'.$name.'.svg');
	}

	/**
	* Enable the option page in ACF
	*
	**/
	function options_page(){
		acf_add_options_page();
	}

	public function load_variables($template){
		//Get the variables to load from the php comments 
		preg_match( "'Variables to load {(.*?)}'si", file_get_contents( $template ), $matches);
		if($matches[1]){
			$variablesToLoad = explode(PHP_EOL, trim($matches[1]));

			foreach ($variablesToLoad as $key => $value) {
				$variablesToLoad[$key] = explode(' / ', trim($value));
			}
		
			foreach ($variablesToLoad as $key => $variable) {	

				$variable[3] = isset($variable[3]) ? $variable[3] : get_the_ID();

				switch ($variable[0]) {
					case 'WP':
						if(!isset($this->WP[$variable[1]])){
							$func = 'get_'.$variable[1]; 
							$this->WP[$variable[1]] = $func($variable[3]);
						}
						break;

					case 'ACF':
						if(!isset($this->ACF[$variable[1]])){
							$this->ACF[$variable[1]] = get_field($variable[1], $variable[2]);
						}
						break;

					case 'menus':
						if(!isset($this->menus[$variable[1]])){
							$this->menus[$variable[1]] = $this->loadmenus($variable[1]);
						}
						break;
					case 'include':
						if(!isset($this->include[$variable[1]])){
							$this->include[$variable[1]] = $this->include_tempalte($variable[1]);
						}
						break;
					default: 
						$variable[2] = trim($variable[2]);

						$end = end(explode('\\', trim($variable[0])));

						if(!isset($this->{$end})){
							$this->{$end} = new $variable[0]($this);
						}

						if(!isset($this->{$variable[2]})){
							if(isset($variable[3])){
								$this->{$variable[2]} = call_user_func_array(array($this->{$end}, $variable[1]), explode(',', $variable[3]));
							}else{
								$this->{$variable[2]} = $variable[0]::$variable[1]();
							}
						}
						
					break;
				}

			}
		}

		return $template;
	}

	/**
	 * Get a php file to include in a template file
	 *
	 * The file hast to be in the /dev/inlcudes directory with the follwing naming convention inc-$name.php
	 *
	 * @param string $name
	 * @return string
	 */
	public function include_tempalte($name){
		$this->load_variables($this->temp_dir.'/includes/inc-'.$name.'.php');
		return $this->temp_dir.'/includes/inc-'.$name.'.php';
	}

	/**
	* Get the Wodpress upload directory
	*
	* @return string
	**/
	public function getUploadDir(){
		$uploadDirArray = wp_upload_dir();
		return $uploadDirArray['basedir'];
	}

	/**
	 * Get the menu by theme_laocation.
	 *
	 * @param string $menuLocation
	 * @return array $menu
	 */
	private function loadmenus($menuLocation){
			
		$menu = wp_nav_menu( array(
			'theme_location' => $menuLocation,
			'container' => 'div',
			'container_class' => $menuLocation,
			'echo' => false
		));
		
		return $menu;
	}

}