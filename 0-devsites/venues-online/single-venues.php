<?php
	get_header();

	// get_fiche_data() in searchtable.php
	global $lang;
	
	if ($lang){
		if ($lang == 'nl'){
			$original_post_id = get_the_ID();
		}
		else{
			$original_post_id = icl_object_id(get_the_ID(),'post',false,'nl');
		}
	} else{
		$original_post_id = get_the_ID();
	}

	$resultarray = get_fiche_data($original_post_id);

	global $translations;
	global $translations_json;
?>
	
<div class="row expanded">
	<div class="small-24 expanded go-back-container">
		<div class="button-container">
			<a class="btn go-back-external semi-bold goBack">
				<span class="icon-arrow-left" ></span><?= $translations[45] ?>
			</a>	
		</div>
	</div>
	<div class="single-fiche small-24 large-16 columns">

		<?php if($lang == 'fr'): ?>
			<selectedfiche :fichedataprop="<?= jsonToProp($resultarray['json_fr']) ?>" :translations='<?= jsonToProp($translations_json) ?>' :favarrayprop="favarray" :favouritesprop="<?= $resultarray['favourite'] ?>" :ipaddressprop="ipaddress" :langprop="lang"></selectedfiche>
		<?php elseif($lang == 'en'): ?>
			<selectedfiche :fichedataprop="<?= jsonToProp($resultarray['json_en']) ?>" :translations='<?= jsonToProp($translations_json) ?>' :favarrayprop="favarray" :favouritesprop="<?= $resultarray['favourite'] ?>" :ipaddressprop="ipaddress" :langprop="lang"></selectedfiche>
		<?php else: ?>
			<selectedfiche :fichedataprop="<?= jsonToProp($resultarray['json_nl']) ?>" :translations='<?= jsonToProp($translations_json) ?>' :favarrayprop="favarray" :favouritesprop="<?= $resultarray['favourite'] ?>" :ipaddressprop="ipaddress" :langprop="lang"></selectedfiche>
		<?php endif; ?>

	</div>
	<div class="map-container noPadding small-8 columns selectedfiche-map">
		<gmap-map 
			style="width: 100%; height: 100%; position: absolute; left:0; top:0"
	        :center="getposition(singlelat, singlelng)"
	        :zoom="16"
	        :options="{styles: mapsstyle, gestureHandling: 'greedy'}"
	    >	
	    	<gmap-marker
				:clickable="true"
				:position="getposition(singlelat, singlelng)"
				icon='/wp-content/themes/venues-online/dist/img/single-logo-marker.png'
		    ></gmap-marker>
	    </gmap-map>
	</div>
</div>
<div class="row expanded">
	<div class="map-container map-container-mobile noPadding small-24 columns selectedfiche-map">
		<gmap-map 
			style="width: 100%; height: 100%; position: absolute; left:0; top:0"
	        :center="getposition(singlelat, singlelng)"
	        :zoom="16"
	        :options="{styles: mapsstyle}"
	    >	
	    	<gmap-marker
				:clickable="true"
				:position="getposition(singlelat, singlelng)"
				icon='/wp-content/themes/venues-online/dist/img/single-logo-marker.png'
		    ></gmap-marker>
	    </gmap-map>
	</div>
</div>

<?php get_template_part('templates/partials/seoblock') ?>

<?php get_footer(); ?>