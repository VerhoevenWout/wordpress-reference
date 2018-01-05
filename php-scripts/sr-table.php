<!-- 
	This script pulls a [table] tag out of the database cell content and replaces it with the actual table.
	It pulls the table from the webpage and insert this into a new cell. 
	It also removes <h3>Capaciteit</h3>

	Used for VenuesOnline
 -->


<?php
	include_once('simple_html_dom.php');
	
    $input 		= fopen('/Users/stagair/Desktop/venues.csv', 'r');  //open for reading
	$output 	= fopen('/Users/stagair/Desktop/venues-output.csv', 'w'); //open for writing
	$search 	= "[table]";
	$search2 	= "<h3>Capaciteit</h3>";
	$counter 	= 1;

	while(false !== ($data = fgetcsv($input)) and ($counter < 2000)){  //read each line as an array
		echo $counter . '<br/>';
		$idColumn 			= $data[0];
		$pageIdColumn 		= $data[1];
		$categoryIdColumn 	= $data[2];
		$titleColumn 		= $data[3];
		$informationColumn 	= $data[5];

		if (strpos($informationColumn, '[table]') !== false) {
			$url = 'http://www.venues-online.com/nl-' . $pageIdColumn . '-' . $categoryIdColumn . '-' . $idColumn;

			$content = file_get_contents($url);
			$doc = new DOMDocument();
			$doc->loadHTML($content);
			$tables = $doc->getElementsByTagName('table');
			foreach($tables as $table) {
			    $tableElement = $doc->saveHTML($table); 
			    echo $tableElement;
			}
			$informationColumn = str_replace($search, '', $informationColumn);
			$informationColumn = str_replace($search2, '', $informationColumn);
			$data[5] = $informationColumn;
			$data[6] = $tableElement;

			$tableElement = '';
		}

	   	//write modified data to new file
	   	fputcsv( $output, $data);
		$counter++;
	}

	//close both files
	fclose( $input );
	fclose( $output );



