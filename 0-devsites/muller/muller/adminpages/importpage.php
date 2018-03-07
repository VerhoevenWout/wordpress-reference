<?php

namespace muller\adminpages;

class importpage extends \volta\adminpage 
{
  	



    public function __construct($theme)
    {
        $this->page_title = 'Import';
        $this->capability = 'import';
        $this->menu_slug = 'import-page';

        $this->csvTable = $this->getCsvTable($theme->config['import']['csvs'], $theme->getUploadDir().'/import/');

        // Execute parent constructor.
        parent::__construct($theme);

		
		$this->deleteProduct = new \muller\background\deletepost($theme);
        
        $this->addproductcat = new \muller\background\addproductcat($theme, 'merk');
        $this->addmerk = new \muller\background\addmerk($theme);
        $this->addproduct = new \muller\background\addproduct($theme);
        $this->buildcache = new \muller\background\buildcache($theme);
        $this->getproductimg = new \muller\background\getproductimg($theme);
        $this->updatemeta = new \muller\background\updatemeta($theme);
        // $this->getproductpdfs = new \muller\background\getproductpdfs($theme);

        $this->deleteTaxProductCat = new \muller\background\deletetax($theme, 'product-categorie');
        $this->deleteTaxMerkReeks = new \muller\background\deletetax($theme, 'merk-reeks');
        $this->deleteTaxWebReeks = new \muller\background\deletetax($theme, 'web-reeks');

        $this->urlTaxProductCat = new \muller\background\urltax($theme, 'product-categorie');
        $this->urlTaxMerkReeks = new \muller\background\urltax($theme, 'merk-reeks');
        $this->urlTaxWebReeks = new \muller\background\urltax($theme, 'web-reeks');

        $this->importHelper = new \muller\importHelper($theme);

        add_action( 'wp_ajax_upload_csv', array($this, 'uploadCsvs') );
        add_action( 'wp_ajax_get_csvs_table', array($this, 'getCsvTableAjax') );
        add_action( 'wp_ajax_start_import', array($this, 'startImport') );
        add_action( 'wp_ajax_pollprogress', array($this, 'pollprogress') );
     	add_action( 'wp_ajax_get_imgs', array($this, 'getProductImage') );
     	add_action( 'wp_ajax_get_imgs', array($this, 'getProductImage') );

     	//$this->getnewmeta();

    }	

	public function uploadCsvs(){

		$checkCsv = $this->importHelper->checkCsv($_FILES['file']);

		if($checkCsv[0] == 'error'){
			header("HTTP/1.0 400 Bad Request");
    		echo $checkCsv[1];
		}else{
			wp_send_json($checkCsv[1], 200);
		}
		wp_die();	
	}
	

	public function startImport(){
		  
		$producten = get_posts([
			'post_type' => 'product', 
			'posts_per_page' => -1,
			'suppress_filters' => false
		]);

		$count = count($producten);

		update_option('import_count_products', $count ,false);
		
		$this->{$_POST['importfunctionname']}(0);

		wp_die();
	}

	public function getcsvwithoffset($importname, $offset, $interval){

		$csvname = $this->theme->config['import']['csvnames'][$importname];
  
		$importHelper = new \muller\importHelper($this->theme);
		$csvData = $importHelper->processCsv($csvname);
		$count = count($csvData);

		error_log('Import '.$importname.', offset: '.$offset.'/'.$count);
		$csvData = array_splice($csvData, $offset, $interval);

		if(count($csvData) == 0){
			update_option('import_progress_'.$importname, [0 => 'complete', 1 => time()] ,false);
			return false;
		}else{
			update_option('import_progress_'.$importname, [0 => $offset, 1 => $count] ,false);
			return $csvData;
		}
		
	}

	public function getproductswithoffset($importname, $offset, $interval){

		$count = get_option('import_count_products');

		$producten = get_posts([
			'post_type' => 'product', 
			'posts_per_page' => $interval, 
			'offset' => $offset, 
			'suppress_filters' => false
		]);

		error_log('Import '.$importname.', offset: '.$offset.'/'.$count);
		
		if(count($producten) == 0){
			update_option('import_progress_'.$importname, [0 => 'complete', 1 => time()] ,false);
			return false;
		}else{
			update_option('import_progress_'.$importname, [0 => $offset, 1 => $count] ,false);
			return $producten;
		}

	}

	public function pollprogress(){

		$importname = $_POST['import_function'];

		$progress =  get_option('import_progress_'.$importname);

		wp_send_json($progress);
	}


	public function cleantaxs(){

		$this->deleteProductCat(0, $count);
	}

	public function getcounttaxtotal(){
		$count = 0;
		$count = $count + wp_count_terms('product-categorie', ['hide_empty' => false]);
		$count = $count + wp_count_terms('merk-reeks', ['hide_empty' => false]);
		$count = $count + wp_count_terms('web-reeks', ['hide_empty' => false]);

		return $count;
	}

	public function deleteProductCat($count){
		$counttotal = $this->getcounttaxtotal();
		$taxs = $this->theme->productCategory->getAll();
		$name = $this->theme->productCategory->name;

		foreach ( $taxs as $id ) {
			$count = $count + 1;
			$this->deleteTaxProductCat->push_to_queue( array('ID' => $id, 'name' => $name, 'class' => 'productCategory','count' => $count, 'counttotal' => $counttotal));
		}

		$this->deleteTaxProductCat->save()->dispatch();

	}

	public function deleteMerkReeksCat($count){
		$counttotal = $this->getcounttaxtotal();
		$taxs = $this->theme->merkReeks->getAll();
		$name = $this->theme->merkReeks->name;

		foreach ( $taxs as $id ) {
			$count = $count + 1;
			$this->deleteTaxMerkReeks->push_to_queue( array('ID' => $id, 'name' => $name, 'class' => 'merkReeks','count' => $count, 'counttotal' => $counttotal));
		}

		$this->deleteTaxMerkReeks->save()->dispatch();
	}

	public function deleteTaxWebReeks($count){
		error_log('start: deleteTaxWebReeks');
		$counttotal = $this->getcounttaxtotal();
		$taxs = $this->theme->webReeks->getAll();
		$name = $this->theme->webReeks->name;

		foreach ( $taxs as $id ) {
			$count = $count + 1;
			$this->deleteTaxWebReeks->push_to_queue( array('ID' => $id, 'name' => $name, 'class' => 'webReeks','count' => $count, 'counttotal' => $counttotal));
		}

		$this->deleteTaxWebReeks->save()->dispatch();
	}

	public function cleanurls(){

		$this->urlProductCat(0, $count);
	}

	public function urlProductCat($count){
		$counttotal = $this->getcounttaxtotal();
		$taxs = $this->theme->productCategory->getAll();
		$name = $this->theme->productCategory->name;

		foreach ( $taxs as $id ) {
			$count = $count + 1;
			$this->urlTaxProductCat->push_to_queue( array('ID' => $id, 'name' => $name, 'class' => 'productCategory','count' => $count, 'counttotal' => $counttotal));
		}

		$this->urlTaxProductCat->save()->dispatch();

	}

	public function urlMerkReeksCat($count){
		$counttotal = $this->getcounttaxtotal();
		$taxs = $this->theme->merkReeks->getAll();
		$name = $this->theme->merkReeks->name;

		foreach ( $taxs as $id ) {
			$count = $count + 1;
			$this->urlTaxMerkReeks->push_to_queue( array('ID' => $id, 'name' => $name, 'class' => 'merkReeks','count' => $count, 'counttotal' => $counttotal));
		}

		$this->urlTaxMerkReeks->save()->dispatch();

	}

	public function urltaxWebReeks($count){
		$counttotal = $this->getcounttaxtotal();
		$taxs = $this->theme->webReeks->getAll();
		$name = $this->theme->webReeks->name;
		
		foreach ( $taxs as $id ) {
			$count = $count + 1;
			$this->urlTaxWebReeks->push_to_queue( array('ID' => $id, 'name' => $name, 'class' => 'webReeks','count' => $count, 'counttotal' => $counttotal));
		}

		$this->urlTaxWebReeks->save()->dispatch();

	}



	public function deleteProducts(){
		        	
		$artikelNrs = $this->importHelper->getCsvArtiklnrs();

		$query = 'SELECT p.ID, metaartklnr.meta_value
		FROM mll_posts p
		INNER JOIN mll_postmeta metaartklnr ON metaartklnr.post_id = p.ID AND metaartklnr.meta_key = "intern artikelnr"  
		INNER JOIN mll_icl_translations trans on trans.element_id = p.ID and trans.element_type = "post_product" and trans.language_code = "nl"';

		global $wpdb; 
		$results = $wpdb->get_results($query, 'ARRAY_A');

		$ids = [];
		foreach ($results as $key => $value) {
			$ids[$value['ID']] = $value['meta_value'];
		}

		$deleteprod = array_diff($ids, $artikelNrs);

		foreach ( $deleteprod as $id ) {
			$this->deleteProduct->push_to_queue( $id );
		}

		$this->deleteProduct->save()->dispatch();

	}

	public function importProductCategories($offset){
		//Get the data from the GrpStruc.csv
		$csvData = $this->getcsvwithoffset('importProductCategories', $offset, 10);
		if($csvData == false){
			exit;
		}

		//Reorder the csv data by category hierarchies
		$catsToImport = array();

		foreach($csvData as $key => $data){

			for ($i=1; $i < 6 ; $i++) { 
				
				if($data['AltGrp'.$i] == '' || $i == 5){
					
					if($data['AltGrp5'] != ''){
						$i == 5 ? $i++ : $i;
					}
					
					$lvl = $i-2;
					$GrpStrucTax = $this->theme->config['import']['GrpStruc-tax'][$data['AltGrp1']];
					$catsToImport[$GrpStrucTax]['hierarchy-'.$lvl][] = $data;
					break;
				}

			}
			
		}

		//Import the categories, from hierarchy 1 to 4
		//update_option('product_category_import', serialize(array('time' => time(), 'termIds' => array())), false);

		foreach ($catsToImport as $taxName => $tax) {
		
 
			for ($i=1; $i < 5 ; $i++) { 
				if(isset($catsToImport[$taxName]['hierarchy-'.$i])):
					foreach ($catsToImport[$taxName]['hierarchy-'.$i] as $key => $term) {
						$term['hierarchy'] = $i;
						$this->addproductcat->push_to_queue( array('data' => $term, 'taxName' => $taxName, 'offset' => $offset) );
					}
				endif;
			}

		}
		
		$this->addproductcat->save()->dispatch();
	}

	public function importMerken($offset){
		//Get the data from the GrpStruc.csv
		$csvData = $this->getcsvwithoffset('importMerken', $offset, 10);
		if($csvData == false){
			exit;
		}

		//Filter only brands where Group1 start with 5
		$merkToImport = array('hierarchy-1' => array(), 'hierarchy-2' => array());


		foreach($csvData as $key => $data){

			if($data['Group2'] == ''){
				$merkToImport['hierarchy-1'][] = $data;
			}else{
				$merkToImport['hierarchy-2'][] = $data;
			}
			
		}
		
		//Import the categories, from hierarchy 1 to 4
		//update_option('merk_import', serialize(array('time' => time(), 'termIds' => array())), false);
		
		
		$pushed = false;
		foreach ($merkToImport['hierarchy-1'] as $key => $term) {
			
			for ($i=1; $i < 11 ; $i++) { 
				error_log($term['Attachment'.$i]);
				if(strpos($term['Attachment'.$i], 'vimeopage') || strpos($term['Attachment'.$i], 'vimeopage') === 0 || strpos($term['Attachment'.$i], 'Vimeopage') || strpos($term['Attachment'.$i], 'Vimeopage') === 0){
					$pushed = true;
					$this->addmerk->push_to_queue( array($term['Attachment'.$i], 'vimeo', $term['Group1'], $offset) );
				}

				if(strpos($term['Attachment'.$i], 'website') || strpos($term['Attachment'.$i], 'website') === 0 || strpos($term['Attachment'.$i], 'Website') || strpos($term['Attachment'.$i], 'Website') === 0){
					$pushed = true;
					$this->addmerk->push_to_queue( array($term['Attachment'.$i], 'website', $term['Group1'], $offset) );
				}
				if(strpos($term['Attachment'.$i], 'catalogus') || strpos($term['Attachment'.$i], 'catalogus') === 0 || strpos($term['Attachment'.$i], 'Catalogus') || strpos($term['Attachment'.$i], 'Catalogus') === 0){
					$pushed = true;
					$this->addmerk->push_to_queue( array($term['Attachment'.$i], 'catalogus', $term['Group1'], $offset) );
				}
			}
			
		}
		
		if($pushed){
			$this->addmerk->save()->dispatch();
		}else{
			$this->importMerken($offset+10);
		}
		
	}

	public function importProducts($offset){
		//Get the data from the GrpStruc.csv
		$csvData = $this->getcsvwithoffset('importProducts', $offset, 10);
		if($csvData == false){
			exit;
		}

		$productCategoryTermIds = unserialize(get_option('product-categorie_import'))['termIds'];
		$merkReeksTermIds = unserialize(get_option('merk-reeks_import'))['termIds'];
		$webReeksTermIds = unserialize(get_option('web-reeks_import'))['termIds'];
		//$merkTermIds = unserialize(get_option('merk_import'))['termIds'];

		foreach ( $csvData as $key => $data) {
			//Get the categories
			$catIds = [
				'product-categorie' => [],
				'merk-reeks' => '',
				'web-reeks' => ''
			];

			for ($i=1; $i < 4; $i++) { 
				$AltGrpConcat = 
					ltrim($data['thema '.$i], '0').'-'.
					ltrim($data['productgroep '.$i], '0').'-'.
					ltrim($data['productsubgroep '.$i], '0').'-'.
					ltrim($data['subtype '.$i], '0');

				if(isset($productCategoryTermIds[$AltGrpConcat])){
					$catIds['product-categorie'][] = $productCategoryTermIds[$AltGrpConcat];
				}
			}

			if($data['merkreeks'] == '9999'){
				$data['merkreeks'] = '';
			}

			//Get the Merkreeks
			$merkReeksConcat = ltrim($data['merkgroep (merk)'], '0').'-'.
							   ltrim($data['merksubgroep'], '0').'-'.
							   ltrim($data['merkreeks'], '0').'-';

			if(isset($merkReeksTermIds[$merkReeksConcat])){
				$catIds['merk-reeks'] = $merkReeksTermIds[$merkReeksConcat];
			}else{
				error_log('merkreeks not found for '.$data['artikelnaam NL']);
			}

			//Get the Webreek
			$webReeksConcat = ltrim($data['merkgroep (reeks)'], '0').'-'.
							  ltrim($data['webreeks'], '0').'-'.
							  ltrim($data['websubreeks'], '0').'-';

			if(isset($webReeksTermIds[$webReeksConcat])){
				$catIds['web-reeks'] = $webReeksTermIds[$webReeksConcat];
			}else{
				error_log('webreeks not found for '.$data['artikelnaam NL']);
			}

			//Add the merk taxonomy
			// if(isset($merkTermIds[$data['merk'].'-'.$data['subgroep']])){
			// 	$catIds['merk'] = $merkTermIds[$data['merk'].'-'.$data['subgroep']];
			// }else{
			// 	error_log('merk not found for '.$data['artikelnaam NL']);
			// }
		
			//Set Data
			$args = array(
				'post_title' => $data['artikelnaam NL'],
				'post_content' => $data['commerciële omschrijving NL'],
				'tax_input' => $catIds,
				'post_type' => 'product',
				'post_status' => 'publish'
			);

			//Remove from the used data so it won't end up in the meta data
			unset($data['artikelnaam NL']);
			unset($data['commerciële omschrijving NL']);
			unset($data['thema 1']);
			unset($data['productgroep 1']);
			unset($data['productsubgroep 1']);
			unset($data['subtype 1']);
			unset($data['thema 2']);
			unset($data['productgroep 2']);
			unset($data['productsubgroep 2']);
			unset($data['subtype 2']);
			unset($data['thema 3']);
			unset($data['productgroep 3']);
			unset($data['productsubgroep 3']);
			unset($data['subtype 3']);

			//Set the meta data
			$args['meta_input'] = $data;
			
			$this->addproduct->push_to_queue( array('args' => $args, 'offset' => $offset ));
		}

		$this->addproduct->save()->dispatch();

	}


	public function getProductImages($offset){
		
		
		$producten = $this->getproductswithoffset('getProductImages', $offset, 10);
		if($producten == false){
			exit;
		}
		
		if(count($producten) == 0){
			error_log('All products images imported');
			exit;
		}
		
		$pushed = false;
		foreach ($producten as $key => $product) {
			
			$this->getproductimg->push_to_queue( array('productID' => $product->ID, 'offset' => $offset ) );
		}

		$this->getproductimg->save()->dispatch();
		
	}

	// public function getProductImage(){

	// 	$this->getproductimg->push_to_queue( array('productID' => $_POST['ID'], 'offset' => false ) );

	// 	$this->getproductimg->save()->dispatch();

	// }


	// public function getProductPdfs($offset){

	// 	$producten = $this->getproductswithoffset('getProductImages', $offset, 5);
	// 	if($producten == false){
	// 		exit;
	// 	}

	// 	foreach ($producten as $key => $product) {

	// 		$this->getproductpdfs->push_to_queue( array('productID' => $product->ID, 'offset' => $offset ) );

	// 	}

	// 	$this->getproductpdfs->save()->dispatch();
		
	// }

	
	public function getCsvTableAjax(){
		$this->getCsvTable($this->theme->config['import']['csvs'], $this->theme->getUploadDir().'/import/');

		wp_send_json($this->csvTable);
	}

	public function getCsvTable($csvs, $dir){

		$html = '<table><tr><th>Filename</th><th>OK ?</th><th>Upload date</th></tr>';

		foreach ( $csvs as $key => $csv) {
			
			$html .= '<tr><td>'.$key.'</td>';

			$fileUrl = $dir.$key;
			$fileExists = file_exists($fileUrl);

			if($fileExists){
				$html .= '<td>V</td>';
			}else{
				$html .= '<td>X</td>';
			}

			if($fileExists){
				$fileTime = \filemtime($fileUrl);
				$fileTime = date('F d Y H:i:s', $fileTime);

				$html .= '<td>'.$fileTime.'</td></tr>';
			}else{
				$html .= '<td></td></tr>';
			} 

		}

		$html .= '</table>';

		return $html;
	}

	public function buildcache(){

		$cats = $this->theme->productCategory->get_level_1();

		global $wpdb; 
        $query = 'DELETE from mll_options where option_name LIKE "%_transient_muller_filter%"';
        $result = $wpdb->get_results($query);

		foreach ($cats as $key => $cat) {
			error_log('push to queue '.$cat->term_id);
			$this->buildcache->push_to_queue( array('id' => $cat->term_id, 'slug' => $cat->slug, 'landing' => true) );

			$childeren = $this->theme->productCategory->get_tax_childeren($cat->term_id);

			foreach ($childeren as $key => $child) {
				if(isset($child['term'])){
					error_log('push to queue '.$child['term']->term_id);
					$this->buildcache->push_to_queue( array('id' => $child['term']->term_id, 'slug' => $child['term']->slug, 'landing' => false) );
				}
			}

		}

		$this->buildcache->save()->dispatch();
	}


	public function gettranslations(){

		$csvData = $this->importHelper->processCsv('SpecMst.csv');

		$csvs = [];
		$insertTrans = [];

		foreach ($csvData as $key => $value) {
			$csvs[] = $value['SpecFile'];

			$insertTransTmp = [];
			$insertTransTmp['nl'] = $value['SpecDescN'];
			$insertTransTmp['fr'] = $value['SpecDescF'];
			$insertTransTmp['en'] = $value['SpecDescE'];

			$insertTrans[] = $insertTransTmp;
		}

		$csvData = $this->importHelper->processCsv('ParmMst.csv'); 

		foreach ($csvData as $key => $value) {
			$csvs[] = $value['ParmFile'];

			$insertTransTmp = [];
			$insertTransTmp['nl'] = $value['SpecDescN'];
			$insertTransTmp['fr'] = $value['SpecDescF'];
			$insertTransTmp['en'] = $value['SpecDescE'];

			$insertTrans[] = $insertTransTmp;
		}

		foreach ($csvs as $key => $csv) {
			$csvData = $this->importHelper->processCsv($csv);

			foreach ($csvData as $key => $value) {

				$insertTransTmp = [];
				$insertTransTmp['nl'] = $value['ParmCdeDescN'];
				$insertTransTmp['fr'] = $value['ParmCdeDescF'];
				$insertTransTmp['en'] = $value['ParmCdeDescE'];

				$insertTrans[] = $insertTransTmp;
			}
		}

		global $wpdb; 

		foreach ($insertTrans as $key => $value) {
			var_dump($wpdb->insert('mll_custom_trans',$value));
		}
		
		die();

	}

	public function getnewmeta(){

		$csvData = $this->importHelper->processCsv('meta_update.csv');

		foreach ($csvData as $key => $value) {
			
			$this->updatemeta->push_to_queue( array('value' => $value ) );
		}

		
		$this->updatemeta->save()->dispatch();
		var_dump('Updated meta');
		die();
	}
   
}