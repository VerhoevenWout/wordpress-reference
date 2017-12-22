<?php
    /**
    * Template Name: Sitemap
    */
	get_header();

?>

<div class="content row expanded">
	<div class="small-24 columns" >
		<div class="row">
			<div class="small-24 xmedium-8 columns" >
				<h2>Pages</h2>
				<ul>
					<?php
					// Add pages you'd like to exclude in the exclude here
						wp_list_pages(
							array(
							'exclude' => '1652813,1652841,1652599,1652719',
							'title_li' => '',
							)
						);
					?>
				</ul>
			</div>
			<div class="small-24 xmedium-8 columns" >
				<h2>Venues</h2>
				<?php
					$posts = get_posts([
					  'post_type' => 'venues',
					  'post_status' => 'publish',
					  'numberposts' => -1,
					  "suppress_filters" => false,
					  'fields' => 'ids' // Only get IDs
					]);

					echo '<ul>';
					foreach( $posts as $post ){
					    echo '<li><a title="'.get_the_title($post).'" href="'.get_permalink($post).'">'.get_the_title($post).'</a></li>';
					}
					echo '</ul>';
				?> 
			</div>
			<div class="small-24 xmedium-8 columns" >
				<h2>Overview</h2>
				<?php  
					$activity_terms = get_terms( array(
					'taxonomy' => 'activiteit',
					'hide_empty' => false,
					) );
					$type_location_terms = get_terms( array(
					'taxonomy' => 'type_locatie',
					'hide_empty' => false,
					) );

					if (ICL_LANGUAGE_CODE){
						$lang = ICL_LANGUAGE_CODE;
					} else{
						$lang = 'nl';
					}
					if ($lang == 'fr') {
						$cities = ["Anvers","Gand","Charleroi","Liege","Bruxelles","Bruges","Namur","Louvain","Mons","Malines","Alost","La-Louvière","Courtrai","Hasselt","Saint-Nicolas","Ostende","Tournai","Genk","Seraing","Roulers","Verviers","Mouscron","Termonde","Beringen","Turnhout","Vilvorde","Saint-Trond","Lokeren","Herstal","Geel","Ninove","Hal","Waregem","Chatelet","Ypres","Lierre","Lommel","Wavre","Tirlemont","Menin","Binche","Grammont","Bilzen","Ottignies-Louvain-La-Neuve","Tongres","Audenarde","Deinze","Aarschot","Ath","Arlon","Herentals","Izegem","Harelbeke","Nivelles","Soignies","Andenne","Renaix","Zottegem","Mortsel","Maaseik","Gembloux","Tubize","Diest","Saint-Ghislain","Fleurus","Montaigu-Zichem","Braine-le-Comte","Huy","Eeklo","Hoogstraten","Torhout"];
					} elseif($lang == 'en'){
						$cities = ["Antwerp","Ghent","Charleroi","Liège","Brussel","Bruges","Namur","Mons","Leuven","Mechelen","Aalst","La-Louvière","Kortrijk","Hasselt","Sint-Niklaas","Ostend","Tournai","Genk","Seraing","Roeselare","Verviers","Mouscron","Dendermonde","Beringen","Turnhout","Sint-Truiden","Lokeren","Vilvoorde","Waregem","Ninove","Châtelet","Geel","Ypres","Halle","Lier","Menen","Binche","Wavre","Lommel","Tienen","Geraardsbergen","Bilzen","Tongeren","Ottignies-Louvain-La-Neuve","Oudenaarde","Deinze","Aarschot","Ath","Izegem","Arlon","Harelbeke","Herentals","Soignies","Zottegem","Mortsel","Andenne","Nivelles","Ronse","Maaseik","Diest","Saint-Ghislain","Fleurus","Scherpenheuvel-Zichem","Gembloux","Braine-le-Comte","Huy","Poperinge","Eeklo","Torhout"];
					} else{
						$cities = ["Antwerpen","Gent","Charleroi","Luik","Brussel","Brugge","Namen","Leuven","Bergen","Mechelen","Aalst","La-Louvière","Hasselt","Kortrijk","Sint-Niklaas","Oostende","Doornik","Genk","Seraing","Roeselare","Moeskroen","Verviers","Dendermonde","Beringen","Turnhout","Vilvoorde","Lokeren","Sint-Truiden","Herstal","Geel","Ninove","Halle","Waregem","Châtelet","Ieper","Lier","Lommel","Waver","Tienen","Binche","Geraardsbergen","Menen","Bilzen","Ottignies","Tongeren","Oudenaarde","Deinze","Aarschot","Aarlen","Aat","Herentals","Izegem","Nijvel","Harelbeke","Zinnik","Andenne","Zottegem","Ronse","Mortsel","Maaseik","Gembloers","Diest","Saint","Fleurus","Scherpenheuvel","'s-Gravenbrakel","Hoei","Hoogstraten","Eeklo","Torhout"];
					}

					echo '<ul>';
					foreach ($activity_terms as $key => $value){
						$activity_term = $value->name;
						foreach ($cities as $key => $value){
							$city = $value;
							foreach ($type_location_terms as $key => $value){
								$type_location_term = $value->name;
								$url = $activity_term.'/'.$city.'/'.$type_location_term;
								$title = $activity_term.' '.$city.' '.$type_location_term;
								echo '
							    <li>
									<a href="/'.$lang.'/'.$url.'" title="'.$title.'">'.$title.'</a>
								</li>';
							}
						}
					}
					echo '</ul>';
				?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
