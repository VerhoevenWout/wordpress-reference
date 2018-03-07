<?php

namespace muller\tax;

class productcategory extends \volta\tax {

	public function __construct($theme){

		$this->name = 'product-categorie';
		$this->readName = 'product categorie';
		$this->pluralName = 'product categorieeën';

        $this->trans = [
            'nl' => 'producten',
            'fr' => 'produits',
            'en' => 'products'
        ];

		//object_type
		$this->object_type = array( 'product' );

		//args
        $this->args['rewrite'] = array( 'hierarchical' => true, 'slug' => 'producten' );

        $this->filters = new \muller\filters\filters($theme);


        
		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}

   
	
	public function get_prodcut_cat_template(){

		$this->getLevel();



		$templateName = $this->theme->config['product-categorie-templates'][$this->level];

        if($this->level == 1){
            if(count(get_term_children($this->taxVars->term_id, $this->name)) == 0){
                $templateName = $this->theme->config['product-categorie-templates'][2];
            }
        }

        if(!empty($_SERVER["QUERY_STRING"])){
            $templateName = $this->theme->config['product-categorie-templates'][2];
        }

        if($this->level == 3 || $this->level == 4){
            $parents = $this->getParentsById($this->taxVars->term_id);

            wp_redirect($parents[1]->url);exit();
        }

		return $this->theme->include_tempalte($templateName);
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

            if($term->parent == $ID){
                $childeren[$term->term_id] = array('term' => $term, 'childeren' => []);
            }else{
                $childeren[$term->parent]['childeren'][] = $term;
            }

           
        }

        return $childeren;
    }


    public function get_filter_products_ajx($filters = false){
        
        if($filters == false){
            $filters = json_decode(stripslashes($_POST['filters']));
            $countquery = json_decode(stripcslashes($_POST['countquery']));
        }
        
        $termidstring = [];
        $termconcatstring = [];
        $metajoins = [];
        
        $count = 0;
        $countmeta = 0;

        foreach ($filters as $key => $filter) {
            $orgKey = $key;
            $key = $key == 'cats' ? 'product-categorie' : $key;
            $key = $key == 'merken' ? 'merk-reeks' : $key;
            $key = $key == 'merkReeks' ? 'merk-reeks' : $key;

            if($key == 'product-categorie' || $key == 'merk-reeks'){
                $count++;
               

                $first = true;
                foreach ($filter as $value) {   
                    if($value){
                        if($first){
                            $termidstring[$key] .= $value;
                            $termconcatstring[$key] .= '"'.$key.'/'.$value.'"';
                            $first = false;
                        }else{
                            $termidstring[$key] .= ','.$value;
                            $termconcatstring[$key] .= ',"'.$key.'/'.$value.'"';
                        }
                    }   
                }
            }elseif(strpos($filter[0], "CUSTOM") === 0){
                $countmeta++;
                $metajoin = ' INNER JOIN mll_postmeta meta'.$countmeta.' ON meta'.$countmeta.'.post_id = p.ID AND( ';
                $firstmeta = true;

                foreach ($filter as $value) {
                    $value = str_replace('CUSTOM', ' ', $value);
                    $value = preg_replace('/.{2}(?=meta\.)/', '', $value);
                    $value = str_replace('meta.', 'meta'.$countmeta.'.' , $value);

                    if($firstmeta){
                        $firstmeta = false;
                        $metajoin .= '('.$value.')';
                    }else{
                        $metajoin .= "OR  (".$value.')';
                    }
                }
                $metajoin .= ')';

                $metajoins[$key] = $metajoin;
            }else{
                $countmeta++;
                $firstmeta = true;
                $metajoin = ' INNER JOIN mll_postmeta meta'.$countmeta.' ON meta'.$countmeta.'.post_id = p.ID AND meta'.$countmeta.'.meta_key = "'.$key.'" and(';
                foreach ($filter as $value) {   
                    if($firstmeta){
                         $firstmeta = false;
                         $metajoin .= ' meta'.$countmeta.'.meta_value =  '.$value.' ';
                    }else{
                         $metajoin .= ' OR meta'.$countmeta.'.meta_value = '.$value.' ';
                    }
                }
                $metajoin .= ')';

                $metajoins[$key] = $metajoin;
            }
        }

        $result = $this->getFilterProductsQuery($termidstring, $termconcatstring, $metajoins, $count, true);
        
        $resultcount = $this->getCountQuery($countquery->all, $result, true);

        foreach ($filters as $key => $filter) {
            $key = $key == 'cats' ? 'product-categorie' : $key;
            $key = $key == 'merken' ? 'merk-reeks' : $key;
            $key = $key == 'merkReeks' ? 'merk-reeks' : $key;

            $termidstringDup = $termidstring;
            $termconcatstringDup = $termconcatstring;
            $metajoinsDup = $metajoins;
            $countqueryDup = $countquery;

            if($key == 'product-categorie'){

                 foreach (json_decode(stripslashes($_POST['allcats'])) as $id) { 
                    if($id){
                        if($first){
                            $termidstringDup[$key] = $termidstringDup[$key].$id;
                            $termconcatstringDup[$key] = $termconcatstringDup[$key].'"'.$key.'/'.$id.'"';
                            $first = false;
                        }else{
                            $termidstringDup[$key] = $termidstringDup[$key].','.$id;
                            $termconcatstringDup[$key] = $termconcatstringDup[$key].',"'.$key.'/'.$id.'"';
                        }
                    }
                }


            }else{
               unset($termidstringDup[$key]);
               unset($termconcatstringDup[$key]);
            }
            unset($metajoinsDup[$key]);

            
           if($key == 'merk-reeks'){
                $countDup = $count - 1;
           }else{
                $countDup = $count;
           }

           $result2 = $this->getFilterProductsQuery($termidstringDup, $termconcatstringDup, $metajoinsDup, $countDup);


           $resultcount2 = $this->getCountQuery($countquery->{$key}, $result2, false);
           $resultcount[0] = array_merge((array)  $resultcount[0], (array) $resultcount2[0]);
        }

        wp_send_json(['products' => $result, 'count' => $resultcount[0]]);
    }


    public function getCountQuery($countquery, $result, $images = false){
        $countquery = $countquery.'WHERE p.ID in (';

        $first = true;
        foreach ($result as $key => $value) {
           if($first){
                $first = false;
                $countquery .= $value->ID;
           }else{
                $countquery .= ','.$value->ID;
           }

           if($images){
                $result[$key]->img = $this->theme->product->getThumbsrc($value->ID);
           }

        }
        $countquery .= ')';
        error_log('INFO Query:'.$countquery);
        global $wpdb;
        $resultcount = $wpdb->get_results($countquery);

        return $resultcount;
    }

    public function getFilterProductsQuery($termidstring, $termconcatstring, $metajoins, $count, $order = false){
        $query = '
            SELECT
            p.post_title, p.post_name, p.ID
            FROM
              mll_posts p
              INNER JOIN mll_term_relationships tr ON p.ID=tr.object_id
              INNER JOIN mll_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
              INNER JOIN mll_terms t ON tt.term_id = t.term_id';

            if($order){
                $query.=' 
                    INNER JOIN mll_postmeta metareeksgewicht ON metareeksgewicht.post_id = p.ID AND metareeksgewicht.meta_key = "reeksgewicht"
                    INNER JOIN mll_postmeta metaartklnr ON metaartklnr.post_id = p.ID AND metaartklnr.meta_key = "intern artikelnr"';
            }

        foreach ($metajoins as $key => $value) {
            $query .= $value;
        }

        $query .='  
            WHERE 1=1
              AND p.post_type = "product"
              AND p.post_status = "publish" AND (';
              
        $query .='
        t.term_id IN ('.implode(',',$termidstring).')
        AND CONCAT(tt.taxonomy,"/", t.term_id) IN (
        '.implode(',', $termconcatstring).'
        ) ';

            
        $query .=' )     
            GROUP BY
              p.ID
            HAVING
              COUNT(DISTINCT tt.taxonomy)='.$count.'
        ';

        if($order){
            $query .= ' ORDER BY
                CAST( metareeksgewicht.meta_value AS SIGNED)  DESC,
                CAST( metaartklnr.meta_value AS SIGNED)  ASC
            ';
        }else{
            $query .=' ORDER BY p.post_date DESC';
        }
        error_log('INFO Query:'.$query);
        global $wpdb;   
        $result = $wpdb->get_results($query);
        return $result;
    }

    public function getfiltercountsquery($filters){
        
        $sums = [];
        $joins = []; 
        $count = 0;

        
        
        foreach ($filters as $key => $filter) {
            $orgKey = $key;
            $key = $key == 'cats' ? 'product-categorie' : $key;
            $key = $key == 'merken' ? 'merk-reeks' : $key;
            $key = $filter['name'] == 'merkReeks' ? 'merk-reeks' : $key;
            


            if($key == 'product-categorie' || $key == 'merk-reeks'){

                foreach ($filter['items'] as $keyitem => $value) {   
                    if($keyitem):
                        $sums[$key][] = $this->gettaxcountquery($orgKey, $key, $value);

                        foreach ($value['childeren'] as $child) {
                            $sums[$key][] = $this->gettaxcountquery($orgKey, $key, $child);
                        }

                    endif;
                }

                $joins[$key] = [];
               
            }elseif($filter['static']){
               //$joins[$key][] = '';
                $count++;

                foreach ($filter['joins'] as $joinkey => $join) {
                    $joins[$key][] .= ' INNER JOIN mll_postmeta '.$joinkey.'_meta'.$count.' ON '.$joinkey.'_meta'.$count.'.post_id = p.ID  AND '.$joinkey.'_meta'.$count.'.meta_key = "'.$join.'" ';
                }

                foreach ($filter['items'] as $keyitem => $value) {   
                    $where = str_replace('meta.', 'meta'.$count.'.' , $value['filter']['value']);
                    $and = strpos($where, 't.term_id') === false ? 'tt.taxonomy = "merk-reeks" AND' : '';
                    $sums[$key][] = 'SUM( '.$and.' '.str_replace('CUSTOM', ' ', $where).') as "'.$orgKey.'-ITEMKEY-'.$keyitem.'"';
                }

            }else{
                $count++;
                $joins[$key][] = 'INNER JOIN mll_postmeta meta'.$count.' ON meta'.$count.'.post_id = p.ID AND meta'.$count.'.meta_key = "'.$filter['name'].'"';

                foreach ($filter['items'] as $keyitem => $value) {   
                    
                    $sums[$key][] = 'SUM( tt.taxonomy = "merk-reeks" AND meta'.$count.'.meta_value = '.$value['filter']['value'].') as "'.$orgKey.'-ITEMKEY-'.$keyitem.'"';
                    
                }

            }
            
        }

       
        $queries = [];
        $filters['all'] = 'all';

        foreach ($filters as $filterkey => $filter) {

            if($filterkey == 'all'){
                $filterkey = 'all';
                $sumDup = $sums;
                $joinDup = $joins;
            }else{
                $filterkey = $filterkey == 'cats' ? 'product-categorie' : $filterkey;
                $filterkey = $filterkey == 'merken' ? 'merk-reeks' : $filterkey;
                $filterkey = $filter['name'] == 'merkReeks' ? 'merk-reeks' : $filterkey;
                $sumDup = [];
                $joinDup = [];
                $sumDup[] = $sums[$filterkey];
                $joinDup[] = $joins[$filterkey];
            }

            $queries[$filterkey] = 'SELECT ';

            $first = true;
            foreach ($sumDup as $key => $sumOrgkey) {
                foreach ($sumOrgkey as $key => $sum) {
                    if($first){
                        $first = false;
                        $queries[$filterkey] .= $sum;
                    }else{
                        $queries[$filterkey] .= ' , '.$sum;
                    }
                }
            }
            $queries[$filterkey] .= ' FROM mll_posts p INNER JOIN mll_term_relationships tr ON p.ID=tr.object_id INNER JOIN mll_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN mll_terms t ON tt.term_id = t.term_id  ';
            foreach ( $joinDup as $key => $join) {
                 foreach ($join as $key => $j) {
                        $queries[$filterkey] .= $j;
                }
            }
        }


        return $queries;
    }


    public function gettaxcountquery($orgKey, $key, $value){

        $ids =  $value['childerenIds'];
        $ids[] = $value['filter']['value'];
        $first = true;
        $termidstring = '';
        $termconcatstring = '';

        foreach ($ids as $id) { 
            if($id){
                if($first){
                    $termidstring = $termidstring.$id;
                    $termconcatstring = $termconcatstring.'"'.$key.'/'.$id.'"';
                    $first = false;
                }else{
                    $termidstring = $termidstring.','.$id;
                    $termconcatstring = $termconcatstring.',"'.$key.'/'.$id.'"';
                }
            }
        }

        $sum = 'SUM(t.term_id IN ('.$termidstring.') AND CONCAT(tt.taxonomy,"/", t.term_id) IN ('.$termconcatstring.')) as "'.$orgKey.'-ITEMKEY-'.$value['filter']['value'].'"';

        return $sum;
    }


    /**
    * Get the taxonomy merken
    *
    */
    public function get_merken($ID = false){

        if(!$ID || $ID == 'false'){
            $ID = $this->taxVars->term_id;  
        }

        $merken = [];

        foreach ($this->get_tax_products($ID)['products'] as $key => $product) {
            $meta = get_post_meta($product->ID);
        


            $merk = $this->theme->product->getMerk($product->ID);

            if(isset($merk->term_id) && !isset($merken['merken'][$merk->slug])):
                $merken['merken'][$merk->slug]['term'] = $merk;
                $merken['merken'][$merk->slug]['thumb'] = $this->getThumb($merk, $ID);
            endif;

                //check overzicht
            $reeksoverzichtName = $this->theme->config['tmp_reeksoverzicht'][$meta['reeksoverzicht'][0]];

            if($reeksoverzichtName){
                foreach(get_the_terms($product->ID, 'merk-reeks') as $term){
                   //$merken[$reeksoverzichtName][$term->term_id]['term'] = $term;
                   //$merken[$reeksoverzichtName][$term->term_id]['thumb'] = $this->getThumb($term, $ID);
                    
                    if(!isset($merken['merken'][$merk->slug]['reeksen'][$term->slug])){
                        $merken['merken'][$merk->slug]['reeksen'][$term->slug]['term'] = $term;
                        $merken['merken'][$merk->slug]['reeksen'][$term->slug]['thumb'] = $this->getThumb($term, $ID, true);
                    }
                   
                }
            }
        }
       // ksort($merken['merken']);

        foreach ($merken['merken'] as $key => $merk) {
           $merken['merken'][$key]['reeksen'] = $this->order($merken['merken'][$key]['reeksen'], 'AltGrp4');
        }

        $merken['merken'] = $this->orderalphb($merken['merken']);
        
        return $merken;
       
    }


    public function getThumb($term, $ID, $dump = false){
        $ID = apply_filters( 'wpml_object_id', $ID, $this->name, TRUE, 'nl' );
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
    
    public function refresh(){
        if($_POST['getmerken']){
            $ID = $this->taxVars->term_id;
            $ID = apply_filters( 'wpml_object_id', $ID, 'product-categorie', TRUE, 'nl' );
            $term = get_term($ID, 'product-categorie');

            $transientkey = '/nl/producten/'.$term->slug.'/-\muller\tax\productCategory / get_merken / merken / false';
            $result = $this->get_merken($term->term_id);
            set_transient($transientkey, $result);  
            header("Refresh:0");
        } 
    }

	
  

    public function getcount($ID){



    }
}