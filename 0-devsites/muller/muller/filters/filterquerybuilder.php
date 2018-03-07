<?php

namespace muller\filters;

	

class filterquerybuilder{

	/**
    * The filter name relation to the worpress cat name
    * @var array
    */
    private $wpnamenames = ['merkReeks' => 'merk-reeks', 'merken' => 'merk-reeks', 'cats' => 'product-categorie'];

    /**
    * The subfilters in rotation when building countquery
    * @var array
    */
    private $subfilters = [];
		
	/**
	 * Get the basic comparision, join and comparison queries for the filters
	 *
	 */
	public function getfilterbasequery($filters){

		$queries = [];

		$count = 0;
		foreach ($filters as $filterkey => $filter) {
			$count++;

			$queries[$filterkey] = [
				'comparisons' => [],
				'sumkeys' => [],
				'join' => str_replace('metaX', 'meta'.$count, $this->getjoin($filterkey, $filter)),
				'subfilters' => [], 
				'name' => $filter['name']
			];

			

			foreach ($filter['items'] as $filteritemkey => $filteritem) {
				
				$queries[$filterkey]['comparisons'][$filteritemkey] = $this->getcomparision($filteritemkey, $filteritem, $filter['type'], $filter['name'], $count);
				$queries[$filterkey]['sumkeys'][$filteritemkey] = $this->getsumkeys($filteritemkey, $filter['type'], $filterkey);
				

				//Get the child filters  query data
				foreach ($filteritem['childeren'] as $childkey => $child) {
					$queries[$filterkey]['comparisons'][$child['filter']['value']] = $this->getcomparision($child['filter']['value'], $child, $filter['type'], $filter['name'], $count);
					$queries[$filterkey]['sumkeys'][$child['filter']['value']] = $this->getsumkeys($child['filter']['value'], $filter['type'], $filterkey);
				}


				//Get the subfilter query data
				foreach ($filteritem['subfilters']['filters'] as $subfilterkey => $subfilter) {
					$count++;
					//Check if already exists 
					$subfilterkey =  $subfilterkey.'_'.$filteritemkey;
					
					$queries[$subfilterkey]['join'] = str_replace('metaX', 'meta'.$count, $this->getjoin($subfilterkey, $subfilter));
					$queries[$filterkey] ['subfilters'][] = $subfilterkey; 
					$queries[$subfilterkey]['termids'] =   array_map('intval', $filteritem['childerenIds']);
					$queries[$subfilterkey]['termids'][] = $filteritemkey;
					$queries[$subfilterkey]['termid'][] = $filteritemkey;

					foreach ($subfilter['items'] as $subfilteritemkey => $subfilteritem) {
						$queries[$subfilterkey]['comparisons'][$subfilteritemkey] = $this->getcomparision($subfilteritemkey, $subfilteritem, $subfilter['type'], $subfilterkey, $count, $queries[$subfilterkey]['termids']);
						$queries[$subfilterkey]['sumkeys'][$subfilteritemkey] = $this->getsumkeys($subfilteritemkey, $subfilter['type'], $subfilterkey, $filteritemkey);
					}
				}
			}

		}

		return $queries;

	}


	/**
	 * Get the query to calculate the filter counts
	 */
	public function getcountquery($checkedfilters, $queries, $allcats, $merkorproduct = 'products'){

		$sums = [];
		$joins = [];

		$wheres = $this->checkedfilterswhere($checkedfilters, $queries);
		$this->subfilters = $queries->cats->subfilters;

		//Get the joins ans sum for each filter
		foreach ($queries as $key => $queryvars) {



			if($sum = $this->getsums($key, $queryvars, $checkedfilters, $wheres, $queries)){
				$sums[] = $sum;
			}

			//If cats add the all categories (speeds op query)
			if($key == 'cats'){
				 $queryvars->join .= ' AND tt.term_id IN('.implode(' , ', $allcats).')';
			}

			$joins[] = $queryvars->join;
		}
		
		//Remove duplicate joins
		$joins = array_unique($joins);

		$query .='SELECT '.implode(' , ', $sums).' FROM mll_posts p INNER JOIN mll_icl_translations trans ON p.ID = trans.element_id and trans.language_code = "'.ICL_LANGUAGE_CODE.'" and trans.element_type = "post_product" '.implode('', $joins).' ';
		
		return $query;
	}

	/**
	 * Get the query for the filterd products 
	 */
	public function getproductsquery($checkedfilters, $queries, $allcats, $merkorproduct = 'products'){
		$joins = [];
		$joinfortaxs = [];
		$wheres = $this->checkedfilterswhere($checkedfilters, $queries);

		if($wheres['cats'] != ''){
			$wherequery[] = $wheres['cats'];
		}

		//Extra sorting query
		$extrasorting = ['join' => '', 'order' => ''];

		if($merkorproduct == 'merken'){
			$metareeksgewicht = 'merksortkey';
			$extrasorting['join'] = 'INNER JOIN mll_postmeta metareeksgewicht2 ON metareeksgewicht2.post_id = p.ID AND metareeksgewicht2.meta_key = "merkreeks"';
			$extrasorting['order'] = 'CAST( metareeksgewicht2.meta_value AS SIGNED)  ASC,';
		}else{
			$metareeksgewicht = 'reeksgewicht';
		}

		foreach ($checkedfilters as $filterkey => $value) {
			if($filterkey != 'cats'){
				if(isset($queries->{$filterkey}->termids)){
				 	$joins[$filterkey] = $queries->{$filterkey}->join;
				}elseif($this->getwpsqlname($filterkey)){
					$joins['Merk'] = "INNER JOIN mll_term_relationships trMerk ON p.ID=trMerk.object_id INNER JOIN mll_term_taxonomy ttMerk ON trMerk.term_taxonomy_id = ttMerk.term_taxonomy_id and ttMerk.taxonomy = 'merk-reeks'";
					$wherequery[] = $wheres[$filterkey];
				}else{
					$joins[$filterkey] = $queries->{$filterkey}->join.' AND ('.$wheres[$filterkey].')';
					unset($wheres[$filterkey]);
				}
			}
		}

		$query = 'SELECT  p.post_title, p.post_name, p.ID, thumbsrc.meta_value as img FROM mll_posts p '.implode(' ', $joins).' 
			'.$queries->cats->join.'
			LEFT JOIN mll_postmeta thumbsrc ON thumbsrc.post_id = p.ID AND thumbsrc.meta_key = "thumbsrc"
			INNER JOIN mll_postmeta metareeksgewicht ON metareeksgewicht.post_id = p.ID AND metareeksgewicht.meta_key = "'.$metareeksgewicht.'"
			'.$extrasorting['join'].'
			INNER JOIN mll_postmeta metaartklnr ON metaartklnr.post_id = p.ID AND metaartklnr.meta_key = "intern artikelnr"  
			INNER JOIN mll_icl_translations trans on trans.element_id = p.ID and trans.element_type = "post_product" and trans.language_code = "'.ICL_LANGUAGE_CODE.'"
			WHERE ' .implode('AND', $wherequery).'
			GROUP BY p.ID
			ORDER BY
			'.$extrasorting['order'].'
			CAST( metareeksgewicht.meta_value AS SIGNED)  ASC,
			CAST( metaartklnr.meta_value AS SIGNED)  ASC
		';

		return $query;
	}

	/**
	 * get the where clause based on the checkedfilters
	 */
	public function checkedfilterswhere($checkedfilters, $queries){

		$wheres = [];

	
		foreach ($checkedfilters as $filterkey => $filter) {
			

			// 	//Check if tax or meta
			if($this->getwpsqlname($filterkey)){
				
				if(!isset($joinfortaxs[$filterkey])){
					$joinfortaxs[$filterkey] =  (array) $filter;
				}else{
					$joinfortaxs[$filterkey] = array_merge($joinfortaxs[$filterkey], (array) $filter);
				}
				
			}elseif(isset($queries->{$filterkey}->termids)){
				
				$subwheres = [];
				foreach ($filter as $key => $value) {
					$subwheres[] = '( '.$queries->{$filterkey}->comparisons->{str_replace('"', '', $value)}.' AND tt.term_id in('.implode(',', $checkedfilters->cats).')) ';  
				}
				if(!isset($wheres['cats'][$queries->{$filterkey}->termid[0]])){
					$wheres['cats'][$queries->{$filterkey}->termid[0]] = ' ( '.implode(' or ', $subwheres).' ) ';
				}else{
					$wheres['cats'][$queries->{$filterkey}->termid[0]] .= ' and ( '.implode(' or ', $subwheres).' ) ';
				}

				$joinfortaxs['cats'] = array_diff($joinfortaxs['cats'], $queries->{$filterkey}->termids);

			}else{
				$subwheres = [];
				foreach ($filter as $key => $value) {
					$subwheres[] .= '( '.$queries->{$filterkey}->comparisons->{str_replace('"', '', $value)}.' ) ';
				}
				$wheres[$filterkey] = ' ( '.implode(' or ', $subwheres).' ) ';
			}
			
		}
		if(isset($wheres['cats'])){
			$catsstring = implode(' or ', $wheres['cats']);	
		}else{
			$catsstring = false;
		}
		$wheres['cats'] = '';
			

		//Add tax type to wheres
		foreach ($joinfortaxs as $filterkey => $joinfortax) {
			$name = $this->getwpsqlname($filterkey);
			if(count($joinfortax) > 0){
				$wheres[$filterkey] = '( tt'.$name['sqlname'].'.term_id in('.implode(',', $joinfortax).') ) ';
			}
		}


		if($catsstring){
			$wheres['cats'] = $wheres['cats'] == '' ? '' : ' or '.$wheres['cats'];
			$wheres['cats'] = $catsstring.$wheres['cats'];
		}
		
		return $wheres;
	}

	/**
	 * Get sum query line
	 */
	public function getsums($filterkey, $queryvars, $checkedfilters, $wheres = false, $queries){
		$sums = [];	
		if($queryvars->name == 'merkReeks'){
			$filterkey = $queryvars->name; 
		}

		if(in_array($filterkey, $this->subfilters) || $filterkey == 'cats'){
			foreach($this->subfilters as $subfilterkey){
				//unset($wheres[$subfilterkey]);
				if($filterkey != 'cats' && 
					$subfilterkey != $filterkey && 
					isset($checkedfilters->{$subfilterkey}) && 
					$queries->{$subfilterkey}->termid == $queryvars->termid
			 	){
					foreach ($checkedfilters->{$subfilterkey} as $key => $value) {
						$wheres[] = '( '.$queries->{$subfilterkey}->comparisons->{$value}.' )';
					}
					
				}
			}

			if($filterkey != 'cats'){
				$wheres[] = '( tt.term_id in('.implode(',', $checkedfilters->cats).') )';

			}

			unset($wheres['cats']);
		}

		unset($wheres[$filterkey]);
		if($wheres and count($wheres) > 0){
			$wheres = ' AND ( '.implode(' AND ', $wheres).' ) ';
		}else{
			$wheres = ' ';
		}

		foreach ($queryvars->sumkeys as $filterkey => $sumkey) {
			
			$sums[] = 'count( DISTINCT (case when '.$queryvars->comparisons->{$filterkey}.' '.$wheres.'  then p.ID else null end  )) as "'.$sumkey.'" ';
			
		}

		if(count($sums) == 0){
			return false;
		}else{
			return implode(' , ', $sums);
		}
		
	}


	/**
	 * Get te sum queries for filteritems
	 *
	 */
	public function getcomparision($filteritemkey, $filteritem, $type, $filtername, $count, $termids = false){

		$comparision = '';

		switch ($type) {
			case 'tax':

				$names = $this->getwpsqlname($filtername);
				
				$ids = $this->getfilteritemids($filteritemkey, $filteritem);
				$comparision = 'tt'.$names['sqlname'].'.term_id IN('.implode(' , ', $ids).' )';

				break;

			case 'static':
			$termquery = '';
				if($termids){
					$termquery .= ' AND tt.term_id in('.implode(',', $termids).')'; 
				}
				$comparision = str_replace('_meta.', '_meta'.$count.'.', $filteritem['filter']['value']).' '.$termquery;; 
				break;
			
			case 'meta':
				$termquery = '';
				if($termids){
					$termquery .= ' AND tt.term_id in('.implode(',', $termids).')'; 
				}
				$comparision = 'meta'.$count.'.meta_value = '.$filteritem['filter']['value'].' '.$termquery;

				break;
		}
		
		return $comparision;

	}

	/**
	 * Get te sum queries name(keys) for filteritems
	 *
	 */
	public function getsumkeys($filteritemkey, $type, $filtername, $subfiltercat = false){

		$sums = '';

		switch ($type) {
			case 'tax':

				$sums = $filtername.'-ITEMKEY-'.$filteritemkey;

				break;

			case 'static':

				$sums = $filtername.'-ITEMKEY-'.$filteritemkey;
				
				break;
			
			case 'meta':
				$sums = $filtername.'-ITEMKEY-'.$filteritemkey;

				break;
		}
		
		return $sums;

	}

	/**
	 * Get te joins queries for filteritems
	 *
	 */
	public function getjoin($filterkey, $filter){

		$join = '';

		switch ($filter['type']) {
			case 'tax':

				$names = $this->getwpsqlname($filter['name']);

				$join = 'INNER JOIN mll_term_relationships tr'.$names['sqlname'].' ON p.ID=tr'.$names['sqlname'].'.object_id 
						  INNER JOIN mll_term_taxonomy tt'.$names['sqlname'].' ON tr'.$names['sqlname'].'.term_taxonomy_id = tt'.$names['sqlname'].'.term_taxonomy_id and tt'.$names['sqlname'].'.taxonomy = "'.$names['wpname'].'"';

				break;

			case 'static':
				 foreach ($filter['joins'] as $key => $j) {
				 	$join .= ' INNER JOIN mll_postmeta '.$key.'_metaX ON '.$key.'_metaX.post_id = p.ID AND '.$key.'_metaX.meta_key = "'.$j.'" ';
				 }
				break;
			
			case 'meta':
				$join = ' INNER JOIN mll_postmeta metaX ON metaX.post_id = p.ID AND metaX.meta_key = "'.$filter['name'].'" ';

				break;
		}
		
		return $join;

	}


	/**
	 * Get array with unique id with chidleren from filteritem converted to int
	 */
	private function getfilteritemids($filteritemkey, $filteritem){
		//Merge filter id with childeren ids
		$ids[] = $filteritemkey;
		
		if(isset($filteritem['childerenIds'])){
			$ids = array_merge($ids, $filteritem['childerenIds']);
		}
		//Convert to int and remove duplicates 
		$ids = array_map('intval', $ids);
		$ids = array_unique($ids);

		return $ids;
	}

	/**
	 * Get the correct conversion for name sql or wp 
	 */
	private function getwpsqlname($name){
		if(isset($this->wpnamenames[$name])){
			$names = [];
			$names['wpname'] = $this->wpnamenames[$name];
			$names['sqlname'] = $names['wpname'] == 'product-categorie' ? '' : 'Merk';

			return $names;
		}else{
			return false;
		}
	}


}