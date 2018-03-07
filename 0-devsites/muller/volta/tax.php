<?php

namespace Volta;

/**
 * Intialise a custom taxonomy
 *
 */
class tax {

	/**
    * The name of the custom taxonomy
    * @var string
    */
	public $name;

	/**
    * The name used in the admin for labels etc of the custom taxonomy
    * @var string
    */
	public $readName;

	/**
    * The plural name used in the admin for labels etc of the custom taxonomy
    * @var string
    */
	public $pluralReadName;

	/**
    * The variable of the current  taxtype
    * @var array
    */
	public $taxVars;

	/**
    * The meta variable of the current  taxtype
    * @var array
    */
	public $taxMeta;

	/**
    * The init class of the current
    * @var /volta/init
    */
	public $theme;

	/**
    * The object to attach te taxonomy to
    * @var array
    */
	public $object_type;

    /**
    * The slug translation
    * @var array
    */
    public $trans;

    /**
    * The options used to register the taxonomy
    * @var array
    */
	public $args = array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
			);

	
	public function __construct($theme){

		$this->theme = $theme;

		$this->name = strtolower($this->name);
		$this->Readname = strtolower($this->readName);
		$this->pluralReadName = strtolower($this->pluralName);
		$this->theme->textdomain = strtolower($this->theme->textdomain);

         add_filter('term_link', array($this,'term_link_filter'), 10, 3);

	}

	/**
	* Registers the taxonomy in Wordpress
	*
	**/
	public function create(){

		$labels = array(
			'name'              => _x( ucfirst($this->pluralReadName), 'taxonomy general name' ),
			'singular_name'     => _x( ucfirst($this->readName), 'taxonomy singular name' ),
			'search_items'      => __( 'Search '.$this->pluralReadName ),
			'all_items'         => __( 'All '.$this->pluralReadName ),
			'parent_item'       => __( 'Parent '.$this->readName ),
			'parent_item_colon' => __( 'Parent '.$this->readName.':' ),
			'edit_item'         => __( 'Edit '.$this->readName ),
			'update_item'       => __( 'Update '.$this->readName ),
			'add_new_item'      => __( 'Add New '.$this->readName ),
			'new_item_name'     => __( 'New '.$this->readName.' Name' ),
			'menu_name'         => __( ucfirst($this->pluralReadName) ),
		);

		$this->args['label'] = __( $this->readName, $this->theme->textdomain );
		$this->args['labels'] = $labels;

		\register_taxonomy( $this->name, $this->object_type, $this->args );
	}

	/**
    * Update or set a option for the taxonomy, used by register_taxonomy
    *
    * @var string $argument
    * @var string $option
    */
	public function setTxArg($argument, $option){

		$this->args[$argument] = $option;

	}

	/**
    * Get all terms from this taxonomy
    *
    */
	public function getAll(){
		$terms = get_terms( array( 'taxonomy' => $this->name, 'fields' => 'ids', 'hide_empty' => false) );
		
    	return $terms;
	}

	/**
    * Delete all terms from this taxonomy
    *
    */
	public function deleteAll(){
		$terms = $this->getAll();
		
    	foreach ( $terms as $value ) {
    		wp_delete_term( $value, $this->name );
  	 	}
	}

	/**
    * Get all parents from taxonomy
    *
    */
    public function getParents($term){

        $parents = array();

        while (isset($term->parent)) {
            $term = get_term_by('id', $term->parent, $this->name);
            if($term){
                $term->url = get_term_link($term->term_id);
                $parents[] = $term;
            }
        }

        return $parents;
    }

    /**
    * Get all parents from taxonomy
    *
    */
    public function getParentsById($termId){

        $parents = array();

        $term = get_term_by('id', $termId, $this->name);
        $term->url = get_term_link($term->term_id);
        $parents[] = $term;

        while (isset($term->parent)) {
            $term = get_term_by('id', $term->parent, $this->name);
            if($term){
                $term->url = get_term_link($term->term_id);
                $parents[] = $term;
            }
        }

        return $parents;
    }

    /**
    * Get the current taxonomy
    *
    */
    public function get_current(){

  		$this->taxVars = get_queried_object();

  		return $this->taxVars; 

    }

     /**
    * Get the current taxonomy childeren
    *
    */
    public function get_children(){

        $this->get_current();
    	//return get_term_children($this->taxVars->term_id, $this->name);
        return get_terms($this->name, ['parent' => $this->taxVars->term_id]);
    }

    /**
    * Get the level of the category
    *
    **/
    public function getLevel(){

        if(!$this->taxVars){
            $this->get_current();
        }

        $this->level = count(get_ancestors($this->taxVars->term_id, $this->name)) + 1;
    }

    /**
    * Get the current taxonomy childeren with their products
    *
    */
    public function get_tax_products($ID = false){
        
        if(!$ID){
            $ID = $this->taxVars->term_id;  
        }

        $childrenIds = get_term_children($ID, $this->name);
        $childeren = [];
        $taxIds = [];
        $childrenIdsFinal = [];
        $childrenIdsFinal[] = $ID;

        foreach ($childrenIds as $key => $child) {
            
            $term = get_term_by( 'id', $child, $this->name );
            $termfilter = array('count' => $term->count, 'name' => $term->name, 'value' => $term->term_id);

            if($term->parent == $ID){
                $childeren[$term->term_id] = array('filter' => $termfilter, 'childeren' => [], 'childerenIds' => get_term_children($term->term_id, $this->name));
            }else{
                $termfilter['childeren'] = $term->childeren;
                $childeren[$term->parent]['childeren'][] = ['filter' => $termfilter, 'childerenIds' => get_term_children($term->term_id, $this->name)];
                //$childeren[$term->parent]['childerenIds'][] = $term->term_id;
            }

            $childrenIdsFinal[] = $term->term_id;
            $childrenIdsFinal = array_merge($childrenIdsFinal, get_term_children($term->term_id, $this->name));
            $taxIds[] = $term->term_id;         

        }

        //Fix counts for terms
        foreach ($childeren as $key => $child) {


           if($child['filter']['count'] == 0 && count($child['childeren']) == 0 || !isset($child['filter']['count'])){
                unset($childeren[$key]);
           }

           if(count($child['childeren']) > 0){
                foreach ($child['childeren'] as $keychildOfChild => $childOfChild) {
                   //$childeren[$key]['filter']['count'] = $childeren[$key]['filter']['count'] +  $childOfChild['filter']['count'];
                }
           }
        }

        $taxIds[] = $ID;

        $products = $this->theme->product->get_by_terms($taxIds, $this->name);

        foreach ($childrenIdsFinal as $key => $value) {
           if(!$value){
                unset($childrenIdsFinal[$key]);
           }
        }

        return array(
            'filters' => array(
                'cats' => array(
                    'items' => $childeren,
                    'name' => 'cats', 
                    'childerenIds' => $childrenIdsFinal,
                    'type' => 'tax'
                )
            ), 
            'products' => $products
        );
    }

    /**
    * Get the first level of categories 
    *
    */
    public function get_level_1(){
        return get_terms($this->name, ['parent' => 0]);

    }

    /**
     * Funtion to get post count from given term or terms and its/their children
     * http://wordpress.stackexchange.com/questions/207923/count-posts-in-category-including-child-categories
     *
     * @param (int|array|string) $term Single integer value, or array of integers or "all"
     * @param (array) $args Array of arguments to pass to WP_Query
     * @return $q->found_posts
     *
     */
    function get_term_post_count( $term = '', $args = [] )
    {

        $taxonomy = $this->name;

        // Lets first validate and sanitize our parameters, on failure, just return false
        if ( !$term )
            return false;

        if ( $term !== 'all' ) {
            if ( !is_array( $term ) ) {
                $term = filter_var(       $term, FILTER_VALIDATE_INT );
            } else {
                $term = filter_var_array( $term, FILTER_VALIDATE_INT );
            }
        }


        if ( $args ) {
            if ( !is_array ) 
                return false;
        }

        // Now that we have come this far, lets continue and wrap it up
        // Set our default args
        $defaults = [
            'posts_per_page' => 1,
            'fields'         => 'ids'
        ];

        if ( $term !== 'all' ) {
            $defaults['tax_query'] = [
                [
                    'taxonomy' => $taxonomy,
                    'terms'    => $term
                ]
            ];
        }
        $combined_args = wp_parse_args( $args, $defaults );
        $q = new \WP_Query( $combined_args );

        // Return the post count
        return $q->found_posts;
    }

     public function getBanner(){
        $ID = $this->taxVars->term_id;  

        $bannerfields = $this->getBannerFields($ID);

        if(!$bannerfields){
            $transId = apply_filters( 'wpml_object_id',  $ID,  $this->name,  true,  'nl' );
            $bannerfields = $this->getBannerFields($transId);
        }

        $picture = '<picture>

                    <source media="(max-width: 46.9em)" type="image/jpg"
                srcset="'.$bannerfields['banner_mobile_s'].' 1x, '.$bannerfields['banner_mobile_h'].' 2x">

                    <source media="(min-width: 46.9em)" type="image/jpg"
                srcset="'.$bannerfields['banner_desktop_s'].' 1x, '.$bannerfields['banner_desktop_h'].' 2x,">

                    <img src="'.$bannerfields['banner_desktop_s'].'" alt="">

                </picture><p>'.$bannerfields['banner_tekst'].'</p>';

        $intro = [
            'titel' => get_field('intro_titel',$this->name.'_'.$ID),
            'tekst' => get_field('intro_tekst',$this->name.'_'.$ID)
        ];

        return ['picture' => $picture, 'intro' => $intro];
    }


    public function getBannerFields($ID){
        $bannerfields = [];
        $bannerfields['banner_mobile_s'] = get_field('mobile_low_res', $this->name.'_'.$ID)['url'];
        $bannerfields['banner_mobile_h'] = get_field('mobile_high_res', $this->name.'_'.$ID)['url']; 
        $bannerfields['banner_desktop_s'] = get_field('desktop_low_res', $this->name.'_'.$ID)['url'];
        $bannerfields['banner_desktop_h'] = get_field('desktop_high_res', $this->name.'_'.$ID)['url'];
        $bannerfields['banner_tekst'] = get_field('banner_tekst', $this->name.'_'.$ID);
        foreach ($bannerfields as $key => $field) {
           if($field === null){
             return false;
           }
        }

        return $bannerfields;
    }

    /**
     * Change the slug based on trans array
     */
    function term_link_filter( $url, $term, $taxonomy ) {
       if(isset($this->trans[ICL_LANGUAGE_CODE])){
            $url = str_replace($this->trans['nl'].'/', $this->trans[ICL_LANGUAGE_CODE].'/', $url);
       }
        
       return $url;
    }

    public function order($Taxs, $orderkey = 'AltGrp3'){
       
    //   $orderdTaxs = [];
    //   $orderTaxsSortkey = [];

    //   foreach ($Taxs as $key => $value) {
        
        
    //     if(is_object($value)){
    //       $term = $value;
    //     }else{
    //       $term = $value['term'];
    //     }

    //     $transId = apply_filters( 'wpml_object_id',  $term->term_id,  $this->name,  true,  'nl' );
    //     $csvData = get_term_meta($transId, 'csvData', true);
    //     $sortkey = get_field('merkreeks_sortkey', $this->name.'_'.$transId);
        

    //     if($sortkey){
    //        $orderTaxsSortkey[$sortkey] = $value;
    //     }else{
    //        $orderdTaxs[$csvData[$orderkey]] = $value;
    //     }
       
    //   }
      
    //   ksort($orderTaxsSortkey);
    //   ksort($orderdTaxs);
      
    //   return  $orderTaxsSortkey + $orderdTaxs;

        $orderdTaxs = [];

        $AltGrp1 = [];
        $AltGrp2 = [];
        $AltGrp3 = [];
        $AltGrp4 = [];
        $AltGrp5 = [];
        $orderdTaxs = [];
        $orderTaxsSortkey = [];
       
        foreach ($Taxs as $key => $value){

            if(is_object($value)){
              $termmid = $value->term_id;
            }else{
              if(isset($value['filter'])){
                $termmid = $value['filter']['value'];
              }else{
                $termmid = $value['term']->term_id;
              }
              
            }

            $transId = apply_filters( 'wpml_object_id',  $termmid,  $this->name,  true,  'nl' );
            $csvData = get_term_meta($transId, 'csvData', true);
            $sortkey = get_field('merkreeks_sortkey', $this->name.'_'.$transId);
           
            $AltGrp1[$key] = intval($csvData['AltGrp1']);
            $AltGrp2[$key] = intval($csvData['AltGrp2']);
            $AltGrp3[$key] = intval($csvData['AltGrp3']);
            $AltGrp4[$key] = intval($csvData['AltGrp4']);
            $AltGrp5[$key] = intval($csvData['AltGrp5']);

            if($sortkey){
                $AltGrp5[$key] = intval($sortkey);

                if(isset($orderTaxsSortkey[$sortkey])){
                    $sortkey= $sortkey+1;
                }
                $orderTaxsSortkey[$sortkey] = $value;
                
            }else{
                $AltGrp5[$key] = intval($csvData['AltGrp5']);
                $orderdTaxs[$key] = $value;
            }
            
            
        }

        ksort($orderTaxsSortkey);
        array_multisort($AltGrp1, SORT_ASC, $AltGrp2, SORT_ASC,$AltGrp3, SORT_ASC,$AltGrp4, SORT_ASC,$AltGrp5, SORT_ASC, $orderdTaxs);
        

        return $orderTaxsSortkey + $orderdTaxs;
    }

    public function orderOld($Taxs, $orderkey = 'AltGrp3'){
       
      $orderdTaxs = [];
      $orderTaxsSortkey = [];

      foreach ($Taxs as $key => $value) {
        
        
        if(is_object($value)){
          $term = $value;
        }else{
          $term = $value['term'];
        }

        $transId = apply_filters( 'wpml_object_id',  $term->term_id,  $this->name,  true,  'nl' );
        $csvData = get_term_meta($transId, 'csvData', true);
        $sortkey = get_field('merkreeks_sortkey', $this->name.'_'.$transId);
        

        if($sortkey){
           $orderTaxsSortkey[$sortkey] = $value;
        }else{
           $orderdTaxs[$csvData[$orderkey]] = $value;
        }
       
      }
      
      ksort($orderTaxsSortkey);
      ksort($orderdTaxs);
      
      return  $orderTaxsSortkey + $orderdTaxs;
    }

    public function orderalphb($array, $keyname = 'term'){
        // Sort sidebar merken alphabetically
        usort($array, function($a, $b)  use ($keyname){

            $aval = is_array($a[$keyname]) ? $a[$keyname]['name'] : $a[$keyname]->name;
            $bval = is_array($b[$keyname]) ? $b[$keyname]['name'] : $b[$keyname]->name;

            return strcmp(strtolower($this->transliterateString($aval)), strtolower($this->transliterateString($bval)));
        });
        return $array;
    }

    public function transliterateString($txt) {
        $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
        return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
    }

}