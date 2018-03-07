<?php 
    /**
    * Template Name: VO
    OLD SEO PAGES
    */

	$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $resultarray = get_fiches_by_seopages($current_url);

	global $translations;
	global $translations_json;

get_header(); ?>
<div class="row expanded results">
	<div class="fiches small-24 large-16 columns">
		<div class="row expanded">
			<span v-if="fichescount == 0 && isactive && getAddressDataError == false" class="heading semi-bold no-venues-message"><?= $translations[52] ?></span>
			<span v-if="fichescount == 0 && isactive && getAddressDataError == true" class="heading semi-bold no-venues-message"><?= $translations[63] ?></span>
			<fiche :key="index" v-for="(fiche, index) in <?= jsonToProp(json_encode($resultarray)) ?>" v-on:mouseover="fichehover(fiche)" :fichedataprop="fiche" :translations='<?= jsonToProp($translations_json) ?>' :favarray="favarray" :ipaddressprop="ipaddress" :langprop="lang"></fiche>
			<!-- <fiche v-for="(fiche, index) in fiches" v-on:mouseover="fichehover(fiche)" :fichedataprop="fiche" :translations='<?= jsonToProp($translations_json) ?>' :favarray="favarray" :ipaddressprop="ipaddress" :langprop="lang"></fiche> -->
		</div>
	</div>
	<div class="map-container noPadding selectedfiche-map noPadding small-8 columns" v-if="fiches">
		<div class="map">
		<gmap-map 
			style="width: 100%; height: 100%; position: absolute; left:0; top:0"
	        :center="{lat: mapcenter.lat, lng: mapcenter.lng}"
	        :zoom="mapcenter.zoom"
	        :options="mapoptions1"
	    >	
	    	<gmap-marker v-for="(f, index) in fiches"
				:key="index"
				:position="getposition(f.lat, f.lng)"
				:clickable="true"
				:icon="f.markerurl"
				:z-index="f.markerzindex"
				v-on:click="openmarker(f)"
			>
    	    	<gmap-info-window :opened="f.markeropen">
    	    		<a v-bind:href="f.linkurl" title="f.linkurl">
    		    		<img v-bind:src="f.markerimage" alt="f.markerimage">
    	    		</a>
    	    		<span>
    	    			{{ f.markertext }}
    	    		</span>
		    		<a v-bind:href="f.linkurl" title="f.linkurl" class="view-link light">
		    			Link
						<i class="fa fa-chevron-right" aria-hidden="true"></i>
		    		</a>
    	    	</gmap-info-window>
		    </gmap-marker>
	    </gmap-map>
		</div>
	</div>
</div>
<div class="row expanded" v-if="fiches">
	<div class="map-container map-container-mobile noPadding small-24 columns selectedfiche-map">
		<gmap-map 
			style="width: 100%; height: 100%; position: absolute; left:0; top:0"
	        :center="{lat: mapcenter.lat, lng: mapcenter.lng}"
	        :zoom="mapcenter.zoom"
	        :options="mapoptions2"
	    >	
	    	<gmap-marker v-for="(f, index) in fiches"
				:key="index"
				:position="getposition(f.lat, f.lng)"
				:clickable="true"
				:icon="f.markerurl"
				:z-index="f.markerzindex"
				v-on:click="openmarker(f)"
			>
		    	<gmap-info-window :opened="f.markeropen">
		    		<a v-bind:href="f.linkurl" title="f.linkurl">
			    		<img v-bind:src="f.markerimage" alt="f.markerimage">
		    		</a>
		    		<span>
		    			{{ f.markertext }}
		    		</span>
		    		<a v-bind:href="f.linkurl" title="f.linkurl" class="view-link light">
		    			Link
						<i class="fa fa-chevron-right" aria-hidden="true"></i>
		    		</a>
		    	</gmap-info-window>
		    </gmap-marker>
	    </gmap-map>
	</div>
</div>

<?php get_footer(); ?>
