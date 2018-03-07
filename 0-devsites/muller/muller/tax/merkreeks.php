<?php

namespace muller\tax;

class merkReeks extends \volta\tax {

	public function __construct($theme){

		$this->name = 'merk-reeks';
		$this->readName = 'Merkreeks';
		$this->pluralName = 'Merkreeksen';

    $this->trans = [
          'nl' => 'merken',
          'fr' => 'marques',
          'en' => 'brands'
      ];

		//object_type
		$this->object_type = array( 'product' );

		//args
		$this->args['rewrite'] = array( 'hierarchical' => true, 'slug' => 'merken' );

		//actions
        add_action( 'wp_ajax_get_merk_products', array($this, 'get_merk_products_ajx'));
        add_action( 'wp_ajax_nopriv_get_merk_products', array($this, 'get_merk_products_ajx'));	
	
		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}


	public function get_prodcut_cat_template(){

		$this->getLevel();

		$templateName = $this->theme->config['merkreeks-templates'][$this->level];

	    if($this->level == 2 || $this->level == 3){
	        $parents = $this->getParentsById($this->taxVars->term_id);

	        //wp_redirect($parents[1]->url);exit();
	    }

		return $this->theme->include_tempalte($templateName);
	}

	  /**
    * Get the taxonomy childeren with their products over ajax
    *
    */
    public function get_merk_products_ajx(){

       if(isset($_POST['term_id'])){

       		if($products = get_transient('get_merk_products_ajx_'.$_POST['term_id'])){

       		}else{
       			$products = $this->get_tax_products($_POST['term_id']);
       			set_transient('get_merk_products_ajx_'.$_POST['term_id']);
       		}
          

            wp_send_json($products);

       }else{
            return false;
       }
    
    }

    public function getlogo($termid, $size){
    	$logo = get_term_meta($termid, 'logo_s3');

      if(empty($logo)){
        return false;
      }else{
        return '<img src="//s3-eu-west-1.amazonaws.com/muller-kitchenandtableware-webimages/'.$logo[0].'">';
      }
    }

    /**
    * Get the  merken
    *
    */
    public function get_merken($all = false){

        if($all == 'true'){
            $taxs = $this->get_level_1();  
        }else{
            $taxs = $this->get_children();
        }

        $merken = [];

        foreach ($taxs as $key => $merk) {
        	$merken[$merk->term_id]['term'] = $merk;
            $merken[$merk->term_id]['thumb'] = get_field('merk_reeks_foto', 'merk-reeks_'.$merk->term_id);

            if(!$merken[$merk->term_id]['thumb']){
                $transId = apply_filters( 'wpml_object_id',  $merk->term_id,  $this->name,  true,  'nl' );
                $merken[$merk->term_id]['thumb'] = get_field('merk_reeks_foto', 'merk-reeks_'.$transId);
            }
           if(!$merken[$merk->term_id]['reeksen']){

               // foreach(get_the_terms($merk->term_id, 'merk-reeks') as $term){
                    $merk_reeksen_ids = get_term_children( $merk->term_id, $this->name );

                    foreach ($merk_reeksen_ids as $key => $child) {
                        $term = get_term_by( 'id', $child, $this->name);
                        $merken[$merk->term_id]['reeksen'][$term->term_id]['term'] = $term;
                        $merken[$merk->term_id]['reeksen'][$term->term_id]['thumb'] = $this->getThumb($term, $transId);
                    }
                //}
            }
        }

       
        if($all != 'true'){
          $merken = $this->order($merken);
        }

        foreach ($merken as $key => $merk) {
           $merken[$key]['reeksen'] = $this->order($merken[$key]['reeksen'], 'AltGrp4');
        }

        return $merken;

    }

    public function getThumb($term, $ID){
        $term_id = apply_filters( 'wpml_object_id', $term->term_id, 'merk-reeks', TRUE, 'nl' );
        $thumb = get_field('merk_reeks_foto', 'merk-reeks_'.$term_id);
        if( have_rows('categorie_foto', 'merk-reeks_'.$term_id) ):
            while ( have_rows('categorie_foto', 'merk-reeks_'.$term_id) ) : the_row();
                if(get_sub_field('merk_reeks_categorie_foto_tax') == $ID){
                    $thumb = get_sub_field('merk_reeks_categorie_foto_foto');
                    break;
                }
            endwhile;
        endif;
        
        return $thumb;
    }

    /**
    * Get the  sidebarmenu
    *
    */
    public function getsidebar(){

      $this->get_current();
 
      $parents = $this->getParentsById($this->taxVars->term_id);
      $merk = end($parents);


      $childeren = $this->get_tax_childeren($merk->term_id);
      $childeren = $this->order($childeren);

      foreach ($childeren as $key => $child) {
        if($child['childeren']){
            $childeren[$key]['childeren'] = $this->order($child['childeren'], 'AltGrp4');
        }
      }

      return ['parent' => $merk, 'childeren' => $childeren];
    }

    

     /**
    * Get the current taxonomy childeren
    *
    */
    public function get_tax_childeren($ID = false){

        if(!$ID || $ID == 'false'){
            $ID = $this->taxVars->term_id;  
        }

        $childrenIds = get_term_children($ID, $this->name);
        $childeren = [];
        foreach ($childrenIds as $key => $child) {
            $term = get_term_by( 'id', $child, $this->name );
            if($term):
              if($term->parent == $ID){
                  $childeren[$term->term_id] = array('term' => $term, 'childeren' => []);
              }else{
                  $childeren[$term->parent]['childeren'][] = $term;
              }
           endif;
        }

        return $childeren;
    }

    /**
     * Get Attachments
     */
    public function getAttachments(){

      $id = apply_filters( 'wpml_object_id',  $this->taxVars->term_id,  $this->name,  true,  'nl' );

      $attachments = [];

      $attachments['website'] = get_term_meta($id, 'website')[0];
      $attachments['videos'] = get_term_meta($id, 'vimeopage')[0];
      $catalogus = get_term_meta($id, 'catalogus')[0];

      $attachments['catalogus'] = [];
      foreach ($catalogus as $key => $value) {
        $publitas = json_decode($this->url_get_contents('https://api.publitas.com/v1/groups/muller/publications/'.$key.'.json'));
        if(isset($publitas->spreads[0]->pages)){
          $attachments['catalogus'][$key] = [
            'image' => 'https://view.publitas.com'.$publitas->spreads[0]->pages[0].'-at800.jpg',
            'text' => $value
        ];
        }
      }

      return $attachments; 
    }

    function url_get_contents ($Url) {
      if (!function_exists('curl_init')){ 
          die('CURL is not installed!');
      }
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $Url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $output = curl_exec($ch);
      curl_close($ch);
      return $output;
  }

}