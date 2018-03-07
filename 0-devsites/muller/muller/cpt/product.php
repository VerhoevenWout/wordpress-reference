<?php

namespace muller\cpt;

class product extends \volta\cpt {

	public function __construct($theme){

		$this->name = 'product';
		$this->readName = 'product';
		$this->pluralName = 'producten';

		//Args
		$this->args['has_archive'] = false;
		$this->args['menu_icon'] = 'dashicons-products';
		$this->args['supports'] = array( 'custom-fields', 'title', 'editor', 'excerpt');
		$this->args['rewrite'] = array('slug' => '');
		$this->args['show_in_rest'] = true;

		$this->removeSlug();

		 //actions
        add_action( 'wp_ajax_get_products', array($this, 'get_products_ajx'));
        add_action( 'wp_ajax_nopriv_get_products', array($this, 'get_products_ajx'));

        add_action( 'wp_ajax_get_products_img', array($this, 'getThumbsrcAjx'));
        add_action( 'wp_ajax_nopriv_get_products_img', array($this, 'getThumbsrcAjx'));

		// Execute parent constructor.
		parent::__construct($theme);
		
		$this->create();
	}

	public function getMerkreeks($ID){
		if($merk = wp_get_post_terms($ID, 'merk-reeks')[0]){
			$merk->url = get_term_link($merk->term_id);
			
			if(isset($merk->parent)){
				$merken = $this->theme->merkReeks->getParents($merk);
				
				$merken = array_reverse($merken);
			}else{
				$merken = [];
			}

			$merken[] = $merk;
			
			return $merken;
		}else{
			return false;
		}
	}

	public function getMerk($ID){
		$merkreeks = $this->getMerkreeks($ID);

		$merk = $merkreeks[0];
		
		$transId = apply_filters( 'wpml_object_id',  $merk->term_id,  'merk-reeks',  true,  'nl' );

		$merk->logo = $this->theme->merkReeks->getlogo($transId, 'medium');

		return $merk;
	}

	public function getCat($ID, $parents = false){
		if($cats = wp_get_post_terms($ID, 'product-categorie')){
			$finalCats = [];
			
			foreach($cats as $cat){
				$cat->url = get_term_link($cat->term_id);
				
				if($parents && isset($cat->parent)){
					$parents =  $this->theme->productCategory->getParents($cat);
					array_unshift($parents, $cat);

					$finalCats[] = array_reverse($parents);
				}else{
					$finalCats[] = $cat;
				}
			}
			return $finalCats;

		}else{
			return false;
		}
	}

	public function getExtra($ID){

		if($webReeks = wp_get_post_terms($ID, 'web-reeks')[0]){

			return $this->theme->webReeks->get_tax_products($webReeks->term_id)['products'];

		}
	}

	public function getAltProducts($ID){

		if($alt = get_post_meta($ID, 'alternatieven')[0]){
			$altIds = explode('/', $alt);

			return $this->get_by_internal_id($altIds);
		}

	}

	public function getTechnicalInfo(){
		$this->getPostMeta();
		
		$technical = [];
		$empty = true;
		
		foreach ($this->postMeta as $key => $meta) {
			if(in_array($key, $this->theme->config['technical']) && $meta[0] != ''  && ($meta[0] != '0' || $key == 'status art.' )){

				$left = $key;
					
				switch ($key) {
					case 'intern artikelnr':
						$left = 'Artikelnummer';
						$right = $this->formatnr($meta[0]);
						break;
					case 'PAL':
						$left = 'aantal per pallet';
						$right = $meta[0];
						break;
					case 'hout':
						$left = 'houtsoort';
						$right = $meta[0];
						break;
					case 'status art.':
						$left = 'Status product';
						$right = lcfirst($this->theme->config['status art.'][$meta[0]]);
						break;

					case 'verpakking':
						$right = $this->theme->config['verpakking'][$meta[0]];
						break;
					
					case 'ean/dun code':
						$left = 'Ean code';
						$right = sprintf( "%d",str_replace(',', '', $meta[0]));
					    
					    break;
					case 'dikte staal mm':
						$left = 'dikte staal';
						$right = $meta[0].' mm';
						
						break;
					case 'inhoud (cl)':
						if($meta[0] >= 100){
							$meta[0] = $meta[0]/100;
							$right = $meta[0].' l';
						}else{
							$right = $meta[0].' cl';
						}

						$left = 'inhoud';

						break;
					case 'diameter (mm)':
						if($meta[0] >= 100){
							$meta[0] = $meta[0]/10;
							$right = $meta[0].' cm';
						}else{
							$right = $meta[0].' mm';
						}

						$left = 'diameter';

						break;
					case 'lengte (mm)':
					case 'breedte (mm)':
					case 'hoogte (mm)':
						
						if($meta[0] >= 1000){
							$meta[0] = $meta[0]/1000;
							$right = $meta[0].' m';
						}else{
							$meta[0] = $meta[0]/10;
							$right = $meta[0].' cm';
						}

						$left = str_replace(' (mm)', '', $key);

						break;
					case 'alle warmtebronnen incl. inductie':
					case 'alle warmtebronnen excl. inductie':
					case 'geschikt voor oven':
					case 'enkel geschikt voor gas':
					case 'microgolf':
					case 'antikleef':
					case 'ovenvast':
					case 'Vaatwasbestendig':
						$left = $meta[0];
						$right = '';

						break;
					case 'vaatwasmachinebestendig':
						$left = $meta[0];
						$right = '';

						break;
					default:
						$left = $key;
						$right = $meta[0];
						break;
				}

				$technical[lcfirst($left)] = $right;

				
				
				$empty = false;
			}
		}

		if(ICL_LANGUAGE_CODE != 'nl'){
			$totrans = '"'.implode('","', array_keys($technical)).'","'.implode('","', $technical).'"';

			$query = 'SELECT LOWER(nl), fr, en FROM mll_custom_trans WHERE nl in ('.$totrans.')';

			global $wpdb; 
			$trans = $wpdb->get_results($query, 'OBJECT_K');
		}

		$technicalhtml = '<ul>';

		foreach ($technical as $left => $right) {	

			if(isset($trans[$left])){
				$left = $trans[strtolower($left)]->{ICL_LANGUAGE_CODE};
			}

			if($right == ''){
				$technicalhtml .= '<li>'.lcfirst($left).'</li>';
			}else{

				if(isset($trans[$right])){
					$right = $trans[strtolower($right)]->{ICL_LANGUAGE_CODE};
				}

				$technicalhtml .= '<li>'.lcfirst($left).': '.$right.'</li>';
			}
		}

		$technicalhtml .= '</ul>';
		if($empty === false){
			return $technicalhtml;
		}else{
			return false;
		}
		
	}

	public function getManual($ID){

		$manual = false;

		if($pdfs = get_post_meta($ID, 'pdfs')){
			$pdfs = unserialize($pdfs[0]);

			foreach ($pdfs as $key => $pdf) {

				if (strpos($pdf, 'NL') !== false) {
				    $manual = '//s3-eu-west-1.amazonaws.com/muller-kitchenandtableware-webimages/'.$pdf;
				}
			}
		}
		
		return $manual;
	}

	public function getImages($ID, $size = 'medium'){

		$ID = apply_filters( 'wpml_object_id',  $ID,  $this->name,  true,  'nl' );

		if($images = get_post_meta($ID, 'images')){
			$images = unserialize(get_post_meta($ID, 'images')[0]);
			
			if (wp_get_attachment_image($value['ID'], $size)){
				foreach ($images as $key => $value) {
					$images[$key]['img'] = wp_get_attachment_image($value['ID'], $size);
				}
			}

			if(!$images['HB']){
				$images['HB'] = ['img' => '<img src="/wp-content/themes/muller/dist/img/beeld-categorie-230.jpg" />'];
			}
			return $images;

		}else{

			return ['HB' => ['img' => '<img src="/wp-content/themes/muller/dist/img/beeld-categorie-230.jpg" />']];
			
		}
		
	}

	public function getThumbsrcAjx(){
		wp_send_json($this->getThumbsrc($_POST['id']));
	}

	public function getThumbsrc($ID, $size = 'medium'){

		$awslink = '//s3-eu-west-1.amazonaws.com/muller-kitchenandtableware-webimages/';

		$ID = apply_filters( 'wpml_object_id',  $ID,  $this->name,  true,  'nl' );
		$thumb = "/wp-content/themes/muller/dist/img/beeld-categorie-230.jpg";

		if($images = get_post_meta($ID, 'images')){
			$images = unserialize(get_post_meta($ID, 'images')[0]);

			if($images['thumb']){
				$imgsrc = $images['thumb'];
			}else{
				$imgsrc = $images['HB'];
			}


			if($imgsrc){
				return $awslink.urlencode($imgsrc);
			}else{
				return $thumb;
			}

		}else{
			return $thumb;
		}

	}



	public function getImagesGrid($ID){
		//$images = $this->getImages($ID, 'large');
		$ID = apply_filters( 'wpml_object_id',  $ID,  $this->name,  true,  'nl' );
		$images = unserialize(get_post_meta($ID, 'images')[0]);
		

		//Get imagegrid
		$imagesGrid = [];



		//Get hb image
		$imagesGrid['HB'] = $this->imgHtml($images['HB'], 1);

		//Get pack images
		if(isset($images['pack'])){
			$imagesGrid['pack'] = $this->imgHtml($images['pack']);
		}elseif(isset($images['reppack'])){
			$imagesGrid['pack'] = $this->imgHtml($images['reppack']);
		}	


		$sliders = [
			'EB' => '<li>'.$this->imgHtml($images['HB']).'</li>'
		];

		foreach ($images['EB'] as $key => $image) {

			$imagesGrid['grid'] .= $this->imgHtml($image);			
			$sliders['EB'] .= '<li>'.$this->imgHtml($image).'</li>';	
		} 

		if(isset($imagesGrid['grid'])){
			$imagesGrid['html'] = '<div class="productimagegrid" v-if="$mq.resize && $mq.above(\'46em\')" >';

			$imagesGrid['html'] .= '
					<div class="full">
						'.$imagesGrid['grid'].'
					</div>
				</div>';
		}

		//Get  xl slider

		if(isset($images['EB_XL'])){
			foreach ($images['EB_XL'] as $key => $value) {
				$sliders['XL'] .= '<li>'.$this->imgHtml($value).'</li>'; 
			}
		} 

		return ['imagegrid' => $imagesGrid, 'sliders' => $sliders];
	}


	public function imgHtml($src, $vuestyle = false){

		if($vuestyle){
			$vuestyle = 'v-bind:style="{left: getleft('.$vuestyle.')}"';
		}else{
			$vuestyle = '';
		}

		$imgSrc = '//s3-eu-west-1.amazonaws.com/muller-kitchenandtableware-webimages/'.$src;

		return '<img src="'.$imgSrc.'" />';
	}

	public function getrelatedProducts($ID){
		$altProducts = $this->getAltProducts($ID);
		$extra = $this->getExtra($ID);
		$arrow = $this->theme->get_svg('arrow-big');

		foreach ($extra as $key => $product) {
			
			if($product->ID == $ID){
				unset($extra[$key]);
			}
		
		}

		$pagesCount = ceil(count($extra)/6);

		if($pagesCount == 0){
			return false;
		}else{
			return $this->create_html($pagesCount, $extra, $ID);
		}	
	}

	public function getrecentProducts($ID){

		// define the new value to add to the cookie
		$recent_products = $ID;

		// if the cookie exists, read it and unserialize it. If not, create a blank array
		if(array_key_exists('recent', $_COOKIE)) {
		    $productids = $_COOKIE['recent'];
		    $productids = unserialize($productids);
		} else {
		    $productids = [];
		}

		// add the value to the array and serialize
		array_unshift($productids, $recent_products);
		// if( count($productids) > 5){
		// 	$productids = array_slice($productids, -5);
		// };


		// save the cookie
		setcookie('recent', serialize($productids), time()+3600, "/");

		$productids = array_unique($productids);

		foreach ($productids as $key => $productid) {
			if($product->ID != $ID){
				$productids[$key] = apply_filters( 'wpml_object_id',  $productid,  $this->name,  true,  'nl' );
			}else{
				unset($productids[$key]);
			}
		}

		$arrow = $this->theme->get_svg('arrow-big');

		$args = array(
			'post_type' => $this->name,
			'posts_per_page' => -1,
			'offset'=> 1,
			'post__in' => $productids
		);

		$products = get_posts($args);

		$pagesCount = ceil(count($products)/6);

		if($pagesCount == 0){
			return false;
		}else{
			return $this->create_html($pagesCount, $products, $ID, 'recent');
		}

	}

	public function create_html($pagesCount, $products, $ID, $type = 'serie'){
		$pagesCount;

		if($type == 'serie'){
			$text = __('More in this series:', 'muller');
		}else{
			$text = 'recent bekeken:';
		}

		$width = 100/($pagesCount*2);
		$pages = [];

		$related = '<ul style="width: '.$pagesCount.'00%">';
		$i = 0;
		$iRow = 1;
		$arrow = $this->theme->get_svg('arrow-big');
		$arrowgray = $this->theme->get_svg('arrow-big-gray');

		foreach ($products as $key => $product) {
			if($product->ID != $ID){
				$i++;
				$pages[$iRow] .= '<li style="width: '.$width.'%" ><a href="'.get_permalink($product->ID).'"><div class="rect"><div class="container"><img src="'.$this->getThumbsrc($product->ID).'"/></div></div><span>'.$product->post_title.'</span></a></li>';
				
				if ($i % 2 == 0 ) {
					if($iRow == 3){
						$iRow = 1;
					}else{
						$iRow ++;
					}
				}
			}
		}

		foreach ($pages as $key => $page) {
			
			$related .= '<li><ul>'.$page.'</ul></li>';
			
		}
		if($type == 'serie'){
		$radios = '';
		$labels = '';

		if($pagesCount > 1):
			for ($i=1; $i <= $pagesCount*2 ; $i++) { 
				
				$checked = $i == 1 ? 'checked' : '';

				$radios .= '<input '.$checked.' type="radio" name="relatedslider" id="'.$type.'-relatedslider'.$i.'">';
				$labels .= '<label  for="'.$type.'-relatedslider'.$i.'">'.$arrow.'</label>';
			}

			$grays = '<div class="gray-left">'.$arrowgray.'</div><div class="gray-right">'.$arrowgray.'</div>';
		endif;
		


		$related .= '</ul>';

		return '<div class="related pagecount-'.$pagesCount.'"><div class="overflow"><h3>'.__($text, 'muller').'</h3>'.$radios.$related.$labels.$grays.'</div></div>';
		}else{
			return '<div class="related recent"><div class="overflow"><h3>'.__($text, 'muller').'</h3>'.$related.'</div></div>';
		}
	}

	public function get_productsInfo($products, $taxName){

		foreach($products as $key => $product){
			
			$products[$key]->cats = [];

			//tax
			if (get_the_terms($product->ID, $taxName)){
				foreach(get_the_terms($product->ID, $taxName) as $term){
					$products[$key]->cats[] = $term->term_id;
				}
			}

			//metadata
			foreach(get_post_meta($product->ID) as $metaKey => $meta){
				$products[$key]->{str_replace(' ', '_', $metaKey)} = $meta[0];
			}

			//images
			if($images = $this->getImages($product->ID)){
				$products[$key]->images = $images;
			}

		}

		// var_dump($products); die();

		return $products;
	}


	public function get_by_terms($taxIds, $taxName){

		$args = array(
			'post_type' => $this->name,
			'posts_per_page' => -1,
			'suppress_filters' => false,
			'offset'=> 1,
			'tax_query' => array(
				array(
					'taxonomy' => $taxName,
					'fields' => 'term_id',
					'terms' => $taxIds
				)
			)
		);
		$products = get_posts($args);

		return $this->get_productsInfo($products, $taxName);
		
	}

	public function get_by_internal_id($ids){

		$args = array(
			'post_type' => $this->name,
			'posts_per_page' => -1,
			'offset'=> 1,
			'meta_query' => array(
			    // meta query takes an array of arrays, watch out for this!
			    array(
			        'key'     => 'intern artikelnr',
			        'value'   => $ids,
			        'compare' => 'IN'
			    )
			)
		);
		$products = get_posts($args);
		return $this->get_productsInfo($products, $theme->productCategory->name);
	}
	

	public function getVideo(){
		$this->getPostMeta();

		$finalVideo = false;

		foreach (explode('#', $this->postMeta['Bijlage'][0]) as $key => $video) {
			$video = explode(',', $video);

			if((strtolower($video[2]) ==  ICL_LANGUAGE_CODE || !isset($video[2]))&& $video[0] == 'VM'){
				$finalVideo = $video[1];
			}
		}

		return $finalVideo;
	}

	public function getLink(){
		$this->getPostMeta();

		$finalVideo = false;

		foreach (explode('#', $this->postMeta['Bijlage'][0]) as $key => $link) {
			$link = explode(',', $link);
			if(strtolower($link[3]) ==  ICL_LANGUAGE_CODE && $link[0] == 'WS'){
				$text = $link[1];
				$url = $link[2];
			}
		}

		return ['text' => $text, 'url' => $url];
	}

	public function formatnr($nr, $ID = false){

		if($ID){
			$nr = get_post_meta($nr, 'intern artikelnr')[0];
		}

		return strlen($nr) == 5 ? '0'.$nr : $nr;
	}

	public function get_products_ajx(){

		global $wpdb;

		if ($_POST['offerteid']) {
			$offerteid = $_POST['offerteid'];
			$sqlselect = "
				SELECT cart FROM mll_orders WHERE id =".$offerteid."
			";
			$cart = $wpdb->get_results($sqlselect)[0];
			$cart = json_decode($cart->cart);

			$productids = [];

			$nlcart = [];

			foreach ($cart as $key => $value) {
				$productids[] = $value->ID;
				$nlcart[apply_filters( 'wpml_object_id',  $value->ID,  'product',  true , 'nl')] = $value->count;
			}

			if ($productids != null){
				$args = array(
					'post_type' => $this->name,
					'posts_per_page' => -1,
					'offset'=> 1,
					'post__in' => $productids
				);
				$products = get_posts($args);
			}

			foreach ($products as $key => $product) {
				$products[$product->ID] = $products[$key];

				$nl_product_ID = apply_filters( 'wpml_object_id',  $product->ID,  'product',  true , 'nl');
				$products[$product->ID]->nlID = $nl_product_ID;
				$products[$product->ID]->count = $nlcart[$nl_product_ID];


				unset($products[$key]);
			}
			
			$products = $this->get_productsInfo($products, $theme->productCategory->name);

			return wp_send_json($products);
		} 
		else{
			error_log('else');
			$cart = json_decode(stripslashes($_POST['cart']));

			$productids  = [];
			foreach ($cart as $key => $value){
				$productids[] = apply_filters( 'wpml_object_id',  $key,  'product',  true );
			}

			if ($productids != null){
				$args = array(
					'post_type' => $this->name,
					'posts_per_page' => -1,
					'offset'=> 1,
					'post__in' => $productids
				);
				$products = get_posts($args);
			}

			// Create new cart object with id's in NL to make countvalue available in all languages
			// $nl_cart_item_obj = new \stdClass();
			// foreach ($cart as $key => $cartcount) {
			// 	$nl_cart_item_ID = icl_object_id($key, 'post', false, 'nl');
			// 	$nl_cart_item_obj->$nl_cart_item_ID = $cartcount;
			// }
			// error_log(json_encode($nl_cart_item_obj));

			foreach ($products as $key => $product) {
				$nl_product_ID = apply_filters( 'wpml_object_id',  $product->ID,  'product',  true , 'nl');
				$products[$product->ID] = $products[$key];
				$products[$product->ID]->nlID = $nl_product_ID;
				$products[$product->ID]->count = $cart->{$nl_product_ID};

				unset($products[$key]);
			}
			$products = $this->get_productsInfo($products, $theme->productCategory->name);

			return wp_send_json($products);
		}
	}

	public function getshareurls($ID){
		$orgID = $ID;
		$id = apply_filters( 'wpml_object_id',  $ID,  $this->name,  true,  'nl' );
		$currenturl = 'https://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$img = urlencode($this->getThumbsrc($id));
		$title = urlencode($this->theme->WP['post']->post_title);
		
		$urls = [];

		$urls['facebook'] = 'https://www.facebook.com/sharer.php?u='.$currenturl;

		$urls['pinterest'] = 'https://pinterest.com/pin/create/bookmarklet/?media='.$img.'&url='.$currenturl.'&description='.$title;

		$urls['twitter'] = 'https://twitter.com/share?url='.wp_get_shortlink($orgID).'&text='.$title.'&hashtags=#Mullerkitchenandtableware';

		return $urls;
	}
}








