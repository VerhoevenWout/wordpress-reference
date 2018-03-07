<?php

namespace muller\background;

class getproductpdfs extends \volta\wpbackgroundprocess {

	public function __construct($theme){

		$this->theme = $theme;
		$this->ftpTree = $this->getFtpTree()['./Muller website/Merken'];

		parent::__construct();
	}
	
	/**
	 * @var string
	 */
	protected $action = 'getproductpdfs';

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param mixed $item Queue item to iterate over
	 *
	 * @return mixed
	 */
	protected function task( $data ) {
		$this->offset = $data['offset'];
		$productID = $data['productID'];
		error_log('import for product with ID: '.$productID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
		//Get the intern artikel nr
		$artikelNr = get_post_meta($productID , 'intern artikelnr')[0];
		//Get merk taxiomoy
		$merk = wp_get_post_terms($productID, 'merk-reeks')[0];
		if($merk){ 

			$merk = $this->get_term_top_most_parent($merk->term_id, 'merk-reeks');
			$merk->name = html_entity_decode($merk->name);

			$foldermerkname = iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$merk->name);
			$foldermerkname = preg_replace('#[^-\w]+#', '', $foldermerkname);

			//Get the merk folder
			$merkFolder = $this->ftpRecursiveFileListing($this->ftpConnection, './Muller website/Merken/'.$foldermerkname.'/Productfoto\'s '.$foldermerkname);

			//If a folder with the brand name exist on the ftp server
			if(isset($merkFolder)){

				//Get the pdfs from the brand folder with the artikelNr in the name
				$pdfs = array_filter($merkFolder, function ($var) use ($artikelNr) { 
					return (stripos($var, $artikelNr) &&  stripos($var, '.pdf')); 
				});

				//Check if imagemeta exists otherwise set empty array.
				$pdfsMeta = get_post_meta($productID, 'pdfs');

				if($pdfsMeta){
					$pdfsMeta = unserialize($pdfsMeta[0]);
				}else{
					$pdfsMeta = array();
				}

				//Check if there pdfs found
				if(count($pdfs) != 0){
					
					foreach ($pdfs as $key => $pdf) {

						//Get last modified date
						$pdfUrl = './Muller website/Merken/'.$foldermerkname.'/Productfoto\'s '.$foldermerkname.'/'.$pdf;
						$timeStampLastMod = ftp_mdtm($this->ftpConnection, $pdfUrl);

					
						$pdfsMetakey = $pdf;
					
						if( !isset($pdfsMeta[$pdfsMetakey]['lastMod']) ||
							(isset($pdfsMeta[$pdfsMetakey]['lastMod']) && $pdfsMeta[$pdfsMetakey]['lastMod'] < $timeStampLastMod)
							){
							
							$attachmentID = $this->insertImageFromFtp($pdf, $productID, $pdfUrl);

							if($attachmentID === false){
								error_log($pdf.' error inserting image, ID: '.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
							}else{
								if(isset($pdfsMeta[$pdfsMetakey]['lastMod'])){
									wp_delete_attachment($pdfsMeta[$pdfsMetakey]['ID']);
								}
							
								$pdfsMeta[$pdfsMetakey] = array('ID' => $attachmentID, 'lastMod' => $timeStampLastMod);

								error_log($pdf.' inserted, ID: '.$attachmentID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
							}

						}else{
							error_log('Pdf already in db'.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
						}
						
					}

					update_post_meta($productID, 'pdfs', serialize($pdfsMeta));
				}else{
					error_log('no pdfs for '.$merk->name.'-'.$artikelNr.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
				}

				//check if existing pdfs needs to be deleted
				if(count($pdfs) != 0 && count($pdfsMeta) != 0){
					foreach ($pdfsMeta as $key => $pdfMeta) {
						if(!array_search($key, $pdfs) && $key != 'HB'){
							error_log('Pdf deleted ->'.$key);
							wp_delete_attachment($pdfMeta['ID']);
							unset($pdfsMeta[$key]);
						}
					}

					update_post_meta($productID, 'pdfs', serialize($pdfsMeta));
				}


			}else{
				error_log('no Parent Merk for '.$productID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
			}
		}else{
			error_log('no Merk for '.$productID.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
		}

		return false;
	}

	protected function insertImageFromFtp($pdf, $productID, $pdfUrl){

		//Get pdfs from ftp to tmp folder
		ftp_get($this->ftpConnection, $this->theme->getUploadDir().'/tmp/'.$pdf , $pdfUrl, FTP_BINARY);
		
		//Import image in wordpress media library
		//$html = media_sideload_image(get_site_url().'/wp-content/uploads/tmp/'.$pdf, $productID);

		// Set variables for storage
		$file_array['name'] = basename($this->theme->getUploadDir().'/tmp/'.$pdf);
		$file_array['tmp_name'] = $this->theme->getUploadDir().'/tmp/'.$pdf;
	 
		// do the validation and storage stuff
		$pdfID = media_handle_sideload( $file_array, $post_id, 'PDF Name' );

		if(is_wp_error($pdfID)){
			error_log('is wp error'.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
			return false;
		}else{
			return $pdfID;
		}	
	}

	/**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();
		
		$this->theme->importpage->getProductpdfs($this->offset+5);
		error_log('complete getproductpdfs'.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
		// Show notice to user or perform some other arbitrary task...
	}

	protected function getFtpTree(){
		// set up basic connection
		$this->ftpConnection = ftp_connect($this->theme->config['ftp']['location']);

		// login with username and password
		$login_result = ftp_login($this->ftpConnection, $this->theme->config['ftp']['login'], $this->theme->config['ftp']['password']);


		return $this->ftpRecursiveFileListing($this->ftpConnection, './Muller website/Merken');
	}

	protected function ftpRecursiveFileListing($ftpConnection, $path) { 
	    $allFiles = array(); 
	    $contents = ftp_nlist($ftpConnection, $path); 

	    if($contents){
		    foreach($contents as $currentFile) { 
		        // assuming its a folder if there's no dot in the name 
		        
		        if (strpos($currentFile, '.') === false) { 
		            $this->ftpRecursiveFileListing($ftpConnection, $currentFile); 
		        } 
		        $allFiles[] = substr($currentFile, strlen($path) + 1); 
		    } 
		}else{
			error_log('error ftpRecursiveFileListing '.$path.PHP_EOL, 3, wp_upload_dir()['basedir']."/logs/import-pdfs.log");
		}
	    return $allFiles; 
	} 

	protected function pippin_get_image_id($pdf_url) {
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $pdf_url )); 
	        return $attachment[0]; 
	}


	// determine the topmost parent of a term
	protected function get_term_top_most_parent($term_id, $taxonomy){
	    // start from the current term
	    $parent  = get_term_by( 'id', $term_id, $taxonomy);
	    // climb up the hierarchy until we reach a term with parent = '0'
	    while ($parent->parent != '0'){
	        $term_id = $parent->parent;

	        $parent  = get_term_by( 'id', $term_id, $taxonomy);
	    }
	    return $parent;
	}
}