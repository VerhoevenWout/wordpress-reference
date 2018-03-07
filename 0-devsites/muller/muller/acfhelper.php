<?php

namespace muller;

/**
 * Intialise the theme
 *
 * All classes and hook are intiaded to let the wordpress funciton with the theme.
 *
 */
class acfhelper {

	public function __construct($theme){

		$this->theme = $theme;
		add_action( 'edited_term',array($this, 'wpse_edited_term'), 10, 3 );


		add_filter('acf/location/rule_types', array($this, 'acf_location_rules_types'));
		add_filter('acf/location/rule_operators', array($this, 'acf_location_rules_operators'));
		add_filter('acf/location/rule_values/taxonomy_depth', array($this, 'acf_location_rules_values_taxonomy_depth'));
		add_filter('acf/location/rule_match/taxonomy_depth', array($this, 'acf_location_rules_match_taxonomy_depth'), 10, 3);
	}

	
	public function acf_location_rules_types( $choices )
	{
	    $choices['Other']['taxonomy_depth'] = 'Taxonomy Depth';
	    return $choices;
	}
	//MATCHING OPERATORS
	
	public function acf_location_rules_operators( $choices )
	{
	    //BY DEFAULT WE HAVE == AND !=
	    $choices['<'] = 'is less than';
	    $choices['>'] = 'is greater than';
	    return $choices;
	}
	//POPULATE LIST WITH OPTIONS
	
	public function acf_location_rules_values_taxonomy_depth( $choices )
	{
	    for ($i=0; $i < 6; $i++)
	    {
	        $choices[$i] = $i;
	    }
	    return $choices;
	}
	//MATCH THE RULE
	
	public function acf_location_rules_match_taxonomy_depth( $match, $rule, $options )
	{
	    $depth = (int) $rule['value'];
	    if(isset($_GET['page']) && $_GET['page'] == "shopp-categories" && isset($_GET['id']))
	    {
	        $term_depth = (int) count(get_ancestors($_GET['id'], 'shopp_category'));
	    }
	    elseif(isset($_GET['taxonomy']) && isset($_GET['tag_ID']))
	    {
	        $term_depth = (int) count(get_ancestors($_GET['tag_ID'], $_GET['taxonomy']));
	    }
	    if($rule['operator'] == "==")
	    {
	        $match = ($term_depth == $depth);
	    }
	    elseif($rule['operator'] == "!=")
	    {
	        $match = ($term_depth != $depth);
	    }
	    elseif($rule['operator'] == "<")
	    {
	        $match = ($term_depth < $depth);
	    }
	    elseif($rule['operator'] == ">")
	    {
	        $match = ($term_depth > $depth);
	    }
	    return $match;
	}

	function wpse_edited_term(  $term_id, $tt_id, $taxonomy  ) {
	    
	    if($taxonomy == 'product-categorie'){

	    	if(get_term($term_id, $taxonomy)->parent){
	    		$parent = get_term($term_id, $taxonomy)->parent;
	    	}else{
	    		$parent = $term_id;
	    	}

    		$transname =  str_replace(get_site_url(), '', get_term_link($parent,$taxonomy)).'-\muller\menushelper / getSubCatMenu / subcatmenu / false';
    		delete_transient($transname);
    	}
    	
	}


	

}