<?php

namespace muller\filters;

class filters{

    /**
    * The name of transient cashing for the filters 
    * @var string
    */
    private $transientbasekey = 'muller_filters';

     /**
    * The time of transient cashing for the filters 
    * @var string
    */
    private $transienttime = '365 * DAY_IN_SECONDS';

    public function __construct($theme){

        $this->theme = $theme;
        $this->querybuilder = new filterquerybuilder();

        add_action( 'wp_ajax_get_tax_products', array($this, 'get_tax_products_ajx'));
        add_action( 'wp_ajax_nopriv_get_tax_products', array($this, 'get_tax_products_ajx'));

        add_action( 'wp_ajax_get_filter_products', array($this, 'get_filter_products_ajx'));
        add_action( 'wp_ajax_nopriv_get_filter_products', array($this, 'get_filter_products_ajx'));

        add_action( 'wp_ajax_get_filter_counts', array($this, 'get_filter_counts_ajx'));
        add_action( 'wp_ajax_nopriv_get_filter_counts', array($this, 'get_filter_counts_ajx'));

        add_action( 'wp_ajax_get_merk_products', array($this, 'get_merk_products_ajx'));
        add_action( 'wp_ajax_nopriv_get_merk_products', array($this, 'get_merk_products_ajx'));
    }

    
    /**
    * Get the taxonomy filters and base queries for filtering over ajax
    *
    */
    public function get_tax_products_ajx($ID = false, $lang = false){

        global $sitepress;
        if($lang){
             $sitepress->switch_lang($lang);
        }else{
             $sitepress->switch_lang($_POST['lang']);
        }


        $sendjson = false;

        if(!$ID){
            if(!isset($_POST['term_id'])){

                $error = 'ERROR: no term_id in get_tax_products_ajx';
                error_log($error);
                return wp_send_json($error);

            }else{
                $ID = $_POST['term_id'];
                $sendjson = true;
            }
        }
       
        //Init return array
        $return = [];
        // Get the products to get the filters 
        // Check for cache
        $transKey = $this->transientbasekey.'_filters_'.$ID;
        if(!$return['filters'] = get_transient($transKey)){

            //Get products from taxonomy product-category by id
            $returnJson = $this->theme->productCategory->get_tax_products($ID);

            //Get the filters
            $return['filters'] = $this->addFilters($returnJson['products'], $returnJson['filters'], $ID);
            //Cache
            set_transient($transKey, $return['filters']);
        
        }

        $transKey = $this->transientbasekey.'_filters_queries'.$ID;
        if(!$return['countquery'] = get_transient($transKey)){

            //Get the queries for the filters
            $return['countquery'] =  $this->querybuilder->getfilterbasequery($return['filters']);
            //Cache
            set_transient($transKey, $return['countquery']);
        
        }

        if($sendjson){
           wp_send_json($return);
        }

    }


    /**
    * Get the filter based on products 
    *
    */
    public function addFilters($products, $filters, $term_id){

        $allFilters = $filters;

        $filtersfromconfig = $this->getfiltersfromconfig($term_id);

        foreach ($filtersfromconfig as $key => $value) {
            $allFilters[$key] = $value;
        }


        $filtersfromconfigcats = [];
        foreach ($allFilters['cats']['items'] as $key => $item) {
           
           $filtersfromconfigitem = $this->getfiltersfromconfig($key, false);
           if(!empty($filtersfromconfigitem)){
                 $filtersfromconfigcats[$key]['filters'] = $this->getfiltersfromconfig($key, false); 
           }
            
        }

        foreach ($products as $key => $product):
            
            $meta = get_post_meta($product->ID);

            //Get tax (reeksen + merken) filters
            $merkReeks = $this->addtaxfilters($product, $meta, $allFilters);
            $product->merkReeks = $merkReeks['keys'];
            $product->merken = $merkReeks['keys'];
            $allFilters = $merkReeks['allFilters'];

            foreach ($product->cats as $key => $cat) {
                foreach($this->theme->productCategory->getParents(get_term($cat, $this->theme->productCategory->name)) as $newcat):
                    $product->cats[] = $newcat->term_id;
                endforeach;
            }

            foreach ($filtersfromconfig as $key => $value) {
               //$allFilters = $this->addFilterbyName($key, $product, $meta, $allFilters);

                if(!$value['static']){
                    $allFilters[$key] = $this->addFilterbyName($key, $product, $meta, $allFilters[$key]);
                }
            }

            foreach ($filtersfromconfigcats as $key => $item) {
               //$allFilters['cats']['items'][$key]['subfilters'] = $this->addFilterbyName($key, $product, $meta, $allFilters);
                foreach ($item['filters'] as $keyfilter => $value) {

                    if(!$value['static']){
                        $filtersfromconfigcats[$key]['filters'][$keyfilter] = $this->addFilterbyName($keyfilter, $product, $meta,  $value, $key);
                    }
                }
               
            }
            

        endforeach;

        foreach ($filtersfromconfigcats as $key => $value) {

            foreach ($value['filters'] as $filterkey => $filter) {
                $value['filters'][$filterkey]['subfilter'] = $key;
            }
           $allFilters['cats']['items'][$key]['subfilters'] = ['show' => false, 'filters' => $value['filters']];
        }

        //Sort meta filters
        foreach ($allFilters as $key => $filter) {

           if($filter['type'] == 'meta'){
                ksort($filter['items'], SORT_NUMERIC);
            }

            $i = 1; 
            foreach ( $filter['items'] as $key2 => $value) {
                $allFilters[$key]['items'][$key2]['order'] = $i;
                $i++;
            }


            if($filter['type'] == 'tax' && $filter['name'] != 'cats'){
                $orderdmerken = $this->theme->merkReeks->orderalphb($allFilters[$key]['items'], 'filter');
                $i = 0;
                $allFilters[$key]['items'] = [];
                foreach ( $orderdmerken as $key2 => $value) {
                    $i++;
                    $allFilters[$key]['items'][$value['filter']['value']] = $value;
                    $allFilters[$key]['items'][$value['filter']['value']]['order'] = $i;
                  
                    if(isset($allFilters[$key]['items'][$value['filter']['value']]['childeren'])){
                        
                    $orderdchildmerken = $this->theme->merkReeks->order($allFilters[$key]['items'][$value['filter']['value']]['childeren'], 'AltGrp4');
                    //     // $orderdchildmerken = [];

                    //     foreach ($allFilters[$key]['items'][$value['filter']['value']]['childeren'] as $childid => $child) {
                    //         $transId = apply_filters( 'wpml_object_id',  $childid,  'merk-reeks',  true,  'nl' );
                    //         $csvData = get_term_meta($transId, 'csvData', true);
                    //         if(isset($orderdchildmerken[$csvData['AltGrp4']])){
                                
                    //         }
                    //         $orderdchildmerken[$csvData['AltGrp4']] = $child;
                    //     }


                    $allFilters[$key]['items'][$value['filter']['value']]['childeren'] = [];
                    //     $ii = 0;
                    //     ksort($orderdchildmerken);
                    foreach ( $orderdchildmerken as $key3 => $value2) {
                            $ii++;
                            $allFilters[$key]['items'][$value['filter']['value']]['childeren'][$value2['filter']['value']] = $value2;
                            $allFilters[$key]['items'][$value['filter']['value']]['childeren'][$value2['filter']['value']]['order'] = $ii;
                    }

                   }

                }
            }

            
        }

       

        $allFilters['cats']['items'] = $this->orderCats($allFilters['cats']['items']);

        foreach ($allFilters['cats']['items'] as $key => $item) {
            $allFilters['cats']['items'][$key]['childeren'] = $this->orderCats($item['childeren'], true);
        }

        if(count($allFilters['merken']['items']) == 1){
            unset($allFilters['merken']);
        }

        return $allFilters;
    }

    

     /**
    * Order cats filters
    *
    */
    public function orderCats($filters, $childeren = false){

        //sort tax filters
        $orderdTaxs = [];
        $orderTaxsSortkey = [];

        foreach ($filters as $key => $value) {

            if($childeren){
                $key = $value['filter']['value'];
            }
           
            $transId = apply_filters( 'wpml_object_id',  $key,  $this->theme->productCategory->name,  true,  'nl' );
            $csvData = get_term_meta($transId, 'csvData', true);
            $sortkey = get_field('merkreeks_sortkey', $this->theme->productCategory->name.'_'.$transId);

            if($sortkey){
               $orderTaxsSortkey[$sortkey] = $value;
            }else{
                $altGrp = $csvData['AltGrp5'];
                if(!$altGrp){
                     $altGrp = $csvData['AltGrp4'];

                    if(!$altGrp){
                        $altGrp = $csvData['AltGrp3'];
                    }
                }
               $orderdTaxs[$altGrp] = $value;
            }
        }

        ksort($orderTaxsSortkey);
        ksort($orderdTaxs);

        $orderd = $orderTaxsSortkey + $orderdTaxs;
        
        

       if($childeren){
            $i = 0; 
            foreach ( $orderd as $key => $value) {
                $filters[$i] = $value;
                $i++;
            }
       }else{
            $i = 1; 
            foreach ( $orderd as $key => $value) {
                $filters[$value['filter']['value']]['order'] = $i;
                $i++;
            }
        }
    
        return $filters;
    }
            

    /**
    * Add filters based on the product taxonomy
    *
    */
    public function addtaxfilters($product, $meta, $allFilters){

        $keys = [];    
        $reeksoverzichtName = false;

        // return $allFilters;
        if($meta['reeksoverzicht'][0] != ''){
            $reeksoverzichtName = $this->theme->config['tmp_reeksoverzicht'][$meta['reeksoverzicht'][0]];

           
        }

        if(!isset($allFilters['merken'])){
            $allFilters['merken'] = ['title' => $this->getfiltertrans('Merken'), 'type' => 'tax', 'name' => 'merken', 'items' => [] ];
        }

        $merk = $this->theme->product->getMerk($product->ID);

        if(isset($allFilters['merken']['items'][$merk->term_id])){
            $allFilters['merken']['items'][$merk->term_id]['filter']['count']++;
        }else{
            $allFilters['merken']['items'][$merk->term_id]['filter']['count'] = 1;
            $allFilters['merken']['items'][$merk->term_id]['filter']['name'] = $merk->name;
            $allFilters['merken']['items'][$merk->term_id]['filter']['value'] = $merk->term_id;
            $allFilters['merken']['items'][$merk->term_id]['filter']['type'] = 'tax';
            $allFilters['merken']['items'][$merk->term_id]['childerenIds'] = get_term_children($merk->term_id, 'merk-reeks');
        }

        $keys[] = $merk->term_id;
       
        foreach(get_the_terms($product->ID, 'merk-reeks') as $term){
            $keys[] = $term->term_id;
           
            if($reeksoverzichtName){
                if(!isset( $allFilters['merken']['items'][$merk->term_id]['childeren'])){
                    $allFilters['merken']['items'][$merk->term_id]['childeren'] = [];
                }
                    $temp = ['filter' => []];

                    $temp['filter']['count'] = 1;
                    $temp['filter']['name'] = $term->name;
                    $temp['filter']['value'] = $term->term_id;
                    $temp['filter']['type'] = 'tax';

                    $allFilters['merken']['items'][$merk->term_id]['childeren'][$term->term_id] = $temp;
               
            }
            
        }
       
        return array('allFilters' => $allFilters, 'keys' => $keys);

    }

    /**
    * Get custom filters from the config.php file for a product-category
    *
    */
    public function getfiltersfromconfig($term_id, $parents = true){

       $filters = [];
       $filtersfromconfig = [];

       if($parents):
            if(isset($this->theme->productCategory->getParentsById($term_id)[1])){
                $parentId = $this->theme->productCategory->getParentsById($term_id)[1]->term_id;
                $parentId = apply_filters( 'wpml_object_id', $parentId, 'product-categorie', TRUE, 'nl' );

                if(isset($this->theme->config['filters'][$parentId])){
                    $filtersfromconfig = array_merge($filtersfromconfig, $this->theme->config['filters'][$parentId]);
                }
            }
        endif; 


        if(isset($this->theme->config['filters'][apply_filters( 'wpml_object_id', $term_id, 'product-categorie', TRUE, 'nl' )])){

            $filtersfromconfig = array_merge($filtersfromconfig, $this->theme->config['filters'][apply_filters( 'wpml_object_id', $term_id, 'product-categorie', TRUE, 'nl' )]);
            
        }
      

        foreach ($filtersfromconfig as $key => $value) {
            
            if(is_array($value)){

                foreach ($value['items'] as $key2 => $item) {
                   $value['items'][$key2]['filter']['name'] = $this->getfiltertrans($item['filter']['name']);
                }

                $title = explode('-', $key)[0];
                $items = $value['items'];
                $joins = $value['joins'];
                $static = true;
                $name = explode('-', $key)[1];
                $key = explode('-', $key)[1];
                $type = 'static';
            }else{
                $title = $value;
                $items = [];
                $static = false;
                $joins = false;
                $name = $key;
                $type = 'meta';
            }

            if(!isset($allFilters[$key])){
                $filters[$key] = ['title' => $this->getfiltertrans($title), 'name' => $name, 'items' => $items, 'static' => $static, 'joins' => $joins, 'type' => $type ];
            }

        }

        return $filters;

    }
          
    /**
     * Add filters based on meta_value name
     */
    public function addFilterbyName($name, $product, $meta, $filter, $term_id = false){

        if($meta[$name][0] != '' && ($term_id == false || has_term($term_id, 'product-categorie', $product)) || $this->post_is_in_descendant_category($term_id, $product) ){

           if(isset($filter['items'][$meta[$name][0]])){
                $filter['items'][$meta[$name][0]]['filter']['count'] = $filter['items'][$meta[$name][0]]['filter']['count']+1;
            }else{
                $filter['items'][$meta[$name][0]]['filter']['count'] = 1;
                $filter['items'][$meta[$name][0]]['filter']['name'] = $this->getfiltertrans($meta[$name][0]);
                $filter['items'][$meta[$name][0]]['filter']['value'] = '"'.$meta[$name][0].'"';
            }
        }

        return $filter;

    }

    /**
     * Get the tarnslation for filter item name
     */
    public function getfiltertrans($name){

        $query = 'SELECT * FROM mll_custom_trans WHERE nl ="'.$name.'"';

        global $wpdb; 
        error_log('INFO QUERY: '.$query);
        $result = $wpdb->get_results($query);

        if(isset($result[0])){
            global $sitepress;
            return $result[0]->{$sitepress->get_current_language()};
        }else{
            return $name;
        }
    }


    /**
     * Get the products for the filter page by ajax
     */
    public function get_filter_products_ajx($filters = false){
        
        global $sitepress;
        $sitepress->switch_lang($_POST['lang']);
       
        //Get the products query
        $resultproducts = $this->getproductfiltervar('getproductsquery');
        

        //Get the counts for the filters
        $resultcountquery = $this->getproductfiltervar('getcountquery')[0];

        wp_send_json(['products' => $resultproducts, 'count' => $resultcountquery]);
    }

    /**
     * Get the products for the merk page
     */
    public function get_merk_products_ajx($filters = false){
        global $sitepress;
        $sitepress->switch_lang($_POST['lang']);

        $checkedfilters = [];
        $checkedfilters['merken'] = get_term_children($_POST['termid'], 'merk-reeks');
        $checkedfilters['merken'][] = $_POST['termid'];
        $queries = json_decode(stripcslashes($_POST['countquery']));
       
        //Get the products query
        $resultproducts = $this->doquery('getproductsquery', $checkedfilters, $queries, false, 'merken');
        

        wp_send_json(['products' => $resultproducts]);
    }

    /**
     * Get the filter counts for the filter page by ajax
     */
    public function get_filter_counts_ajx($filters = false){

        global $sitepress;
        $sitepress->switch_lang($_POST['lang']);

        //Get the counts for the filters
        $resultcountquery = $this->getproductfiltervar('getcountquery')[0];


        wp_send_json(['count' => $resultcountquery]);
    }


    /**
     * Get the values from the post from product-filters.js
     */
    public function getproductfiltervar($name){


        //Get te javascript variables, if checkfildters is empty inject all categories
        $checkedfilters = json_decode(stripslashes($_POST['filters']));
        $allcats = json_decode(stripslashes($_POST['allcats']));
        if(!isset($checkedfilters->cats)){
            $checkedfilters->cats =  $allcats;
        } 
        $queries = json_decode(stripcslashes($_POST['countquery']));

        return $this->doquery($name, $checkedfilters, $queries, $allcats);
    }

    /**
     * Execute a query 
     */
    public function doquery($name, $checkedfilters, $queries, $allcats, $merkorproduct = 'products'){

        $url = $_POST['url'];   
        $transKey = str_replace(get_site_url().'/', $this->transientbasekey.'_'.$name.'_', $url);

        if(!$result = get_transient($transKey)){
            $query = $this->querybuilder->{$name}($checkedfilters, $queries, (array) $allcats, $merkorproduct);

            global $wpdb; 
            error_log('INFO QUERY: '.$query);
            $result = $wpdb->get_results($query);

            set_transient($transKey, $result);
        }

        return $result;
    }

    /**
     * Tests if any of a post's assigned categories are descendants of target categories
     *
     * @param int|array $cats The target categories. Integer ID or array of integer IDs
     * @param int|object $_post The post. Omit to test the current post in the Loop or main query
     * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
     * @see get_term_by() You can get a category by name or slug, then pass ID to this function
     * @uses get_term_children() Passes $cats
     * @uses in_category() Passes $_post (can be empty)
     * @version 2.7
     * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
     */
    function post_is_in_descendant_category( $cat, $_post = null ) {
            // get_term_children() accepts integer ID only
            $descendants = get_term_children( (int) $cat, 'product-categorie' );
            if ( $descendants && has_term( $descendants, 'product-categorie', $_post ) ){
                return true;
            }
        
        return false;
    }
    

}