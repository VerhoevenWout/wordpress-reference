<?php

namespace muller;

/**
 * Intialise the theme
 *
 * All classes and hook are intiaded to let the wordpress funciton with the theme.
 *
 */
class menushelper {

	public function __construct($theme){

		$this->theme = $theme;

		$this->getActive();

		add_action( 'wp_ajax_get_sub_cat_menu', array($this, 'GetSubCatMenu_ajx'));	
		add_action( 'wp_ajax_nopriv_get_sub_cat_menu', array($this, 'GetSubCatMenu_ajx'));	
	}

	/**
	 * Get the active tax and post
	 *
	 *
	 *
	 */
	private function getactive(){
			$this->theme->active = [];
			
 
			$prevslug = explode('/', rtrim($_SERVER['HTTP_REFERER'], '/'));
		
			if (substr(end($prevslug), 0, 1) === '?'){
				array_pop($prevslug);
			} 

			$slugterms = [
				'merken' => 'merkReeks', 
				'producten' => 'productCategory', 
				'brands' => 'merkReeks',
				'products' => 'productCategory',
				'marques' => 'merkReeks',
				'produits' => 'productCategory'
			];

			foreach ($slugterms as $key => $value) {
				if($prevslug[4] == $key){
					$breadcrumbCat = [];
					$breadcrumbCat[0] = $value;
					$breadcrumbCat[1] = get_term_by('slug', end($prevslug), $this->theme->{$breadcrumbCat[0]}->name);
				}
			}

			

			$this->theme->active['postType'] = get_class($this->theme->currentObject);

			if(get_class($this->theme->currentObject) == 'WP_Post'){
				//Check for cookie 
				if($breadcrumbCat && ( ( $breadcrumbCat[1]->term_id ==  $this->theme->currentObject->ID && $breadcrumbCat[0] == 'productCategory' ) || $breadcrumbCat[0]  == 'merkReeks') ){
					
					$this->theme->active['productcat'][0] = $breadcrumbCat[1];
					$this->theme->active['productcat'][0]->url = get_term_link($this->theme->active['productcat'][0]->term_id);
					$this->theme->active['productcat']['parents'] = $this->theme->{$breadcrumbCat[0]}->getParents($this->theme->active['productcat'][0]);

				}else{
					$this->theme->cats = $this->theme->product->getCat($this->theme->currentObject->ID, true);
					$this->theme->active['productcat'] = $this->theme->cats[0];
				}
				
			}else{
				$this->theme->active['productcat'][0] = $this->theme->currentObject;

				if($this->theme->currentObject->taxonomy == 'merk-reeks'){
					$taxclass = 'merkReeks';
				}else{
					$taxclass = 'productCategory';
					
				}

				//setcookie('breadcrumbCat', $taxclass.'-'.$this->theme->active['productcat'][0]->term_id, time()+3600, "/");

				$this->theme->active['productcat']['parents'] = $this->theme->{$taxclass}->getParents($this->theme->active['productcat'][0]);
			}

	}

	/**
	 * Get the hoofcatemenu
	 *
	 *
	 *
	 */
	public function getHoofdCatMenu(){
		$menu = '';

		$parents = $this->theme->productCategory->get_level_1();

		$parents = $this->theme->productCategory->orderOld($parents, 'AltGrp2');

		$this->theme->productCategory->order($parents, 'AltGrp2');

		$menu = '<ul class="column small-12 hoofdcat-menu ">';
		$menu .= $this->getHoofdCatMenuItems($parents);
		
		$menu .= '</ul>';
		return $menu;
	}


	/**
	 * Get the hoofcatemenuitem
	 *
	 *
	 *
	 */
	public function getHoofdCatMenuItems($items, $getChilderen = true){
		$menuitem = '';

		foreach($items as $item):

			if(!is_object($item)){
				$item = $item['term'];
			}

			$childeren = get_terms($this->theme->productCategory->name, ['parent' => $item->term_id]);

			$childeren = $this->theme->productCategory->order($childeren, 'AltGrp3'); 

			$active = $this->theme->active['productcat'][0]->term_id == $item->term_id  || $this->theme->active['productcat']['parents'][0]->term_id == $item->term_id ? 'active' : '';
			$menuitem .= '
			<li  v-bind:class="{ open: activeItem == '.$item->term_id.' }" class="'.$active.'" >
				<a ';  

			if($childeren && $getChilderen){
				$menuitem .= ' v-on:click.prevent="opensubmenu('.$item->term_id.', \''.get_term_link($item, 'product-categorie').'\' )" ';
			}

			$menuitem .= ' href="'.get_term_link($item, 'product-categorie').'">'.$item->name.'</a>';

			if($childeren && $getChilderen){

				$langsslugs = array(
					'nl' => '/nl/producten/',
					'en' => '/en/products/', 
					'fr' => '/fr/products/'
				);
				// $merkentrans = get_transient($langsslugs[ICL_LANGUAGE_CODE].$item->slug.'/-\muller\tax\productCategory / get_merken / merken / false');
				$merkentrans = get_term_meta($item->term_id, 'menu_merken')[0];
				$merken = ['merken' => $merkentrans['merken']]; 

				$count = count($merken);
				$columns = 8/($count+1);		
				
				$menuitem .= '
					<div class="subcatmenu">
						<div class="inner row align-center">
							<header class="header small-12 column">
								<i v-on:click="closesubmenu()">'.$this->theme->get_svg('arrow-small').'</i>
								<label  for="menu-radio" class="hamburger open" v-on:click.prevent="closemenu()">
								  <span></span><span></span><span></span>
								</label>
								';

				// if ($merken){
				// 	foreach ($merken as $key => $merk) {
				// 		$menuitem .= '<h3 class="small large-'.$columns.'" >'.ucfirst($key).'</h3>';						
				// 	}
				// }
						
				
					$classsplit = count($childeren) > 99 ? 'split' : '';		
					$columncats = count($childeren) > 99 ? 4 : 4;					
				$menuitem .= '
							</header>
							<div class="small-12 xlarge-'.$columncats.' column">
							<h3  ><a href="'.get_term_link($item, 'product-categorie').'">'.$item->name.'</a></h3>
							<ul class="'.$classsplit.'">
				';
				$menuitem .= $this->getHoofdCatMenuItems($childeren, false);
				$menuitem .= '</ul></div>';

				// MERKEN
				if ($merken){
					// Sort sidebar merken alphabetically
					//usort($merken['merken'], function($a, $b){
					  //  return strcmp(strtolower($a['term']->name), strtolower($b['term']->name));
					//});
					$classsplit = count($merken['merken']) > 19 && count($childeren) < 20 ? 'split' : '';		
					$columnmerken = count($merken['merken']) > 19 && count($childeren) < 20  ? 4 : 3;		
					$menuitem .= '<div class=" xlarge-'.$columnmerken.' column"><h3>'.__("Merken", "Muller").'</h3><ul class="'.$classsplit.'">';
					foreach ($merken['merken'] as $key => $merk) {
						$url_slug = get_term_link($item, 'product-categorie').'/?merken='.$merk['term']->term_id;
						$menuitem .= '<li>
						<a href="'.$url_slug.'">'.$merk['term']->name.'</a>
						</li>';
					}
					$menuitem .= '</ul></div>';
				}
				
				$menuitem .= '<div class="product-in-kijker small-12 xlarge-3 column">';
				$productInKijkerUrl = get_field('product_category_in_de_kijker_url', 'product-categorie_'.$item->term_id);
				if ($productInKijkerUrl) {
					$transid = apply_filters( 'wpml_object_id',  $item->term_id,  $this->theme->productCategory->name,  true,  'nl' );
					$productInKijkerImage = get_field('product_category_in_de_kijker_thumbnail', 'product-categorie_'.$transid)['url'];
					if ($productInKijkerImage) {
						$productInKijkerImage = $productInKijkerImage;
					} else{
						$productInKijkerImage = "/wp-content/themes/muller/dist/img/beeld-categorie-230.jpg";
					}
					
					$productInKijkerTekst = get_field('product_category_in_de_kijker_tekst', 'product-categorie_'.$item->term_id);
					$menuitem .= '<a href="'.$productInKijkerUrl.'" title="Product in de kijker url" target="_blank">';
					$menuitem .= '<img src="'.$productInKijkerImage.'" alt="">';
					$menuitem .= '<p>'.$productInKijkerTekst.'</p>';
					$menuitem .= '</a>';
					$menuitem .= '</div>';
				}

				$menuitem .='
						</div>
					</div>
				';
			}

			$menuitem .= '</li>';

		endforeach;

		return $menuitem;
	}

	/**
	 * Get the Sidebar Product cat menu
	 *
	 *
	 *
	 */
	public function getSubCatMenu($allLevels = true, $termid = false){
		$menu = '';

		if(!$termid){
			$termid = $this->theme->active['productcat'][1]->term_id;
		}


		$childeren = $this->theme->productCategory->get_tax_childeren($termid);

		$childeren = $this->theme->productCategory->order($childeren, 'AltGrp3'); 

		if(!empty($childeren)){

			$menu = '<ul class="column small-12 subcat-menu row">';

			foreach($childeren as $child):
				if(isset($child['term'])):
					$active = $this->theme->active['productcat'][2]->term_id == $child['term']->term_id ? 'active' : '';
					$menu .= '<li v-on:click.prevent="getsubcatmenu('.$child['term']->term_id .')" class="'.$active.'" ><a href="'.get_term_link($child['term'], 'product-categorie').'">'.$child['term']->name.'</a>';

					if(count($child['childeren']) != 0 && $allLevels === true){
						$menu .= '<ul>';
						foreach ($child['childeren'] as $subcat) {
								$activesub = $this->theme->active['productcat'][3]->term_id == $subcat->term_id ? 'active' : '';
								$menu .= '<li class="'.$activesub.'" ><a href="'.get_term_link($subcat->slug, 'product-categorie').'">'.$subcat->name.'</a>';
						}
						$menu .= '</ul>';
					}

					$menu .= '</li>';
				endif;
			endforeach;
				
			$menu .= '</ul>';
			return $menu;

		}else{
			return false;
		}
	}

	public function GetSubCatMenu_ajx(){	

		$childeren = $this->theme->productCategory->get_tax_childeren($_POST['term_id']);

		foreach ($childeren as $key => $value) {
			if(!isset($value['term'])){
				unset($childeren[$key]);
			}
		}

		return wp_send_json(array('menu' => $childeren, 'current' => get_term($_POST['term_id'])));


		//return wp_send_json(array('html' => $this->getSubCatMenu(false, $_POST['term_id'])));

	}

	/**
	 * Get the breadcrumb
	 *
	 *
	 *
	 */
	public function getBreadcrumb(){

		$arrow = $this->theme->get_svg('arrow-small');

		$breadcrumb = '<ul><li><a href="/">Home</a><i class="circle">'.$arrow.'</i></li>';

		if($this->theme->currentObject->name == 'nieuws'){
			$breadcrumb .= '<li>'.get_the_title(apply_filters( 'wpml_object_id',  61373,  'page',  true)).'</li>';
		}
		if($this->theme->currentObject->post_type == 'nieuws'){
			$breadcrumb .= '<li><a href="'.get_post_type_archive_link('nieuws').'">'.get_the_title(apply_filters( 'wpml_object_id',  61373,  'page',  true)).'</a><i class="circle">'.$arrow.'</i></li>';
		}

		if($this->theme->currentObject->taxonomy == 'merk-reeks'){
			$breadcrumb .= '<li><a href="'.get_permalink($this->theme->getbytemplate('tpl-merken')).'">'.get_the_title($this->theme->getbytemplate('tpl-merken')).'</a>'.$arrow.'</li>';
		}

		$count = count($this->theme->active['productcat']);
		if(isset($this->theme->active['productcat']['parents'])){
			$productcats = array_merge(array_reverse($this->theme->active['productcat']['parents']), $this->theme->active['productcat']);
		}else{
			$productcats = $this->theme->active['productcat'];
		}

		$level = 1;
		foreach ( $productcats as $key => $productcat) {
			if(get_class($productcat) == 'WP_Term'){

				if(!isset($productcats->url)){
					$url = get_term_link($productcat->term_id);
				}else{
					$url = $productcats->url;
				}

				if($level > 2){
					$breadcrumb .= '<li><a href="'.$parenturl.'?cats='.$productcat->term_id.'">'.$productcat->name.'</a>'.$arrow.'</li>';
				}else{
					$breadcrumb .= '<li><a href="'.$url.'">'.$productcat->name.'</a>'.$arrow.'</li>';
				}

				if($level == 2){
					$parenturl = $url;
				}
				

				$level++;
			}
		}

		if($this->theme->currentObject->post_title){
			$breadcrumb .= '<li>'.$this->theme->currentObject->post_title.'</li>';
		}

		$breadcrumb .= '</ul>';


		return $breadcrumb;
	}

}