<?php 

namespace muller;

class importHelper {

	public function __construct($theme){

		$this->theme = $theme;

	}

	/**
	 * Process a csv file to an array 
	 *
	 * The csv file hast to be located in the wp-content/uploads/import folder
	 *
	 * @param string $filename
	 * @return array $csvData
	 */
	public function processCsv($filename){
		
		if($filename == 'export_web.csv'){
			
			$csvDataWeb = [];

			for ($i=1; $i < 3; $i++) { 
				$csvDataWeb[$i] = $this->getcsvdata('export_web_'.$i.'.csv');
				unset($csvDataWeb[$i][0]);
			}
			
			$csvData = array_merge($csvDataWeb[1], $csvDataWeb[2]);

		}else{
			$csvData = $this->getcsvdata($filename);
		}

		return $csvData;
	}

	public function getcsvdata($filename){
		$file = fopen($this->theme->getUploadDir().'/import/'.$filename, 'r');
		$row = -1;
		$csvData = array();
		$columns = array();

		while(($data = fgetcsv($file, 9999, ';', '"')) !== FALSE) {
			$num = count($data);

			if($row == -1){
				for ($c=0; $c < $num; $c++) {
		            $columns[$c] = $data[$c];
		        }

		        $orgNum = $num;

			}else{
			
				if($orgNum == $num){
					for ($c=0; $c < $num; $c++) {
			            //$csvData[$row][ iconv( "ISO-8859-1", "UTF-8",$columns[$c])] = iconv( "ISO-8859-1", "UTF-8", $data[$c]);
			       		
						//$data[$c] = preg_replace("/^•+(.*)?/im","<ul><li>$1</li></ul>",$data[$c]);
						//$data[$c] = preg_replace("/(\<\/ul\>\n(.*)\<ul\>*)+/","",$data[$c]);
						//$data[$c] = utf8_encode($data[$c]);

			       		
			       		$csvData[$row][ iconv( "Windows-1252", "UTF-8", $columns[$c])] = iconv( "Windows-1252", "UTF-8", $data[$c]);
			        }
		    	}
			}

			$row++;
		}

		unset($data);

		return $csvData;
	}



	/**
	 * Process a csv file to get artiklnrs
	 *
	 * The csv file hast to be located in the wp-content/uploads/import folder
	 *
	 * @param string $filename
	 * @return array $csvData
	 */
	public function getCsvArtiklnrs(){

		$file = fopen($this->theme->getUploadDir().'/import/export_web.csv', 'r');
		$row = -1;
		$csvData = array();
		$columns = array();

		while(($data = fgetcsv($file, 9999, ';', '"')) !== FALSE) {
			$num = count($data);

			$csvData[] = $data[0];

			$row++;
		}

		return $csvData;
	}



	/**
	* Check if the csv file hast the right amounnt of columsn in every row
	* 
	* Config is saved in the muller/config.php -> import['csvs'] (key == name => value row count)
	*
	* @param array $file
	*/
	public function checkCsv($file){

		if(isset($this->theme->config['import']['csvs'][$file['name']])){

			move_uploaded_file($file['tmp_name'], $this->theme->getUploadDir().'/import/tmp/'.$file['name']);

			$handle = fopen($this->theme->getUploadDir().'/import/tmp/'.$file['name'], 'r');
			$row = 0;
			$error = false;
			
			while(($data = fgetcsv($handle, 1000, ';', '"')) !== FALSE) {
				$num = count($data);
				$numConfig= $this->theme->config['import']['csvs'][$file['name']];

				if($num != $numConfig){
					unlink($this->theme->getUploadDir().'/import/tmp/'.$file['name']);
					$error = array('error', 'Csv file has '.$num.' columns instead off '.$numConfig.' on row '.$row);
					break;
				}

				$row++;
			}

			if($error){

				return $error;

			}else{
				
				copy($this->theme->getUploadDir().'/import/tmp/'.$file['name'], $this->theme->getUploadDir().'/import/'.$file['name']);
				unlink($this->theme->getUploadDir().'/import/tmp/'.$file['name']);
				
				return array('succes', $file['name']);
			}

		}else{

			return array('error', 'Csv filename not found');

		}

	}


	public function getartklnrs(){
		$csvData = $this->processCsv('export_web.csv');

		$artklnrs = [];

		foreach ($csvData as $key => $value) {
			$artklnrs[$value['intern artikelnr']] = '';
		}

		return $artklnrs;
	}

}