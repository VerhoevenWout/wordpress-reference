<?php
    /**
    * Template Name: Venues
    */
	get_header();

	// get_fiche_data() in searchtable.php
	$resultarray = get_fiche_data(get_the_ID());
	// var_dump($resultarray);

	function jsonToProp($data){
	    return htmlentities($data);
	}

	global $translations;
	global $translations_json;

?>
	
<div class="row expanded">
	<?php echo $favarray ?>
	<div class="single-fiche small-24 large-16 columns" >
		<selectedfiche :fichedataprop="<?= jsonToProp($resultarray['json_nl']) ?>" :favarrayprop="favarray" :favouritesprop="<?= $resultarray['favourite'] ?>" :langprop="lang"></selectedfiche>
	</div>
	<div class="map-container noPadding small-8 columns selectedfiche-map">
		<gmap-map 
			style="width: 100%; height: 100%; position: absolute; left:0; top:0"
	        :center="{lat: mapcenter.lat, lng: mapcenter.lng}"
	        :zoom="12"
	        :options="{styles: mapsstyle}"
	    >	
	    	<gmap-marker
				:key="index"
				v-for="(f, index) in fiches"
				:position="getposition(f.lat, f.lng)"
				:clickable="true"
				icon='/wp-content/themes/venues-online/dist/img/single-logo-marker.png'
		    ></gmap-marker>
	    </gmap-map>
	</div>
</div>

<?php get_template_part('templates/partials/seoblock') ?>

<?php get_footer(); ?>