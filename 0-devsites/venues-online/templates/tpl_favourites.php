<?php 
    /**
    * Template Name: Favourites
    */

    global $translations;
	global $translations_json;

	$home = get_page_by_path( 'home' );

get_header(); ?>
<div class="row expanded results">
	<div class="fiches small-24 large-16 columns">

		<?php include(locate_template('templates/partials/share-section.php')); ?>

		<div class="row expanded">
			<div v-if="fiches == null">
				<slick ref="slick" :options="slickOptions">
	 				<?php if(have_rows('founders_repeater')): ?>
						<?php while(have_rows('founders_repeater')): the_row(); ?>
							<div>
								<img class="slide" src="<?php echo the_sub_field('founder'); ?>">
							</div>
						<?php endwhile ;?>
		 			<?php else: ?>
						<?php while(have_rows('header_background_repeater', $home->ID)): the_row(); ?>
							<div>
								<img class="slide" src="<?php echo the_sub_field('background'); ?>">
							</div>
						<?php endwhile ;?>
	 				<?php endif; ?>
				</slick>
				<h1 class="heading semi-bold no-venues-message">
					<?= $translations[44]; ?>
				</h1>
			</div>

			<fiche v-if="fiches" v-for="(fiche, index) in fiches" :fichedataprop="fiche" :translations='<?= jsonToProp($translations_json) ?>' :favarray="favarray" :langprop="lang"></fiche>
			<?php get_template_part('templates/partials/pagination') ?>
			
		</div>
	</div>

	<div class="map-container selectedfiche-map noPadding small-8 columns">
		<gmap-map 
			style="width: 100%; height: 100%; position: absolute; left:0; top:0"
	        :center="{lat: mapcenter.lat, lng: mapcenter.lng}"
	        :zoom="mapcenter.zoom"
	        :options="{styles: mapsstyle, gestureHandling: 'greedy'}"
	    >	
	    	<gmap-marker v-for="(f, index) in fiches"
				:key="index"
				:position="getposition(f.lat, f.lng)"
				:clickable="true"
				:icon="f.markerurl"
				v-on:click="openmarker(f)">
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
<div class="row expanded" v-if="fiches">
	<div class="map-container map-container-mobile noPadding small-24 columns selectedfiche-map">
		<gmap-map 
			style="width: 100%; height: 100%; position: absolute; left:0; top:0"
	        :center="{lat: mapcenter.lat, lng: mapcenter.lng}"
	        :zoom="mapcenter.zoom"
	        :options="{styles: mapsstyle}"
	    >	
	    	<gmap-marker v-for="(f, index) in fiches"
				:key="index"
				:position="getposition(f.lat, f.lng)"
				:clickable="true"
				:icon="f.markerurl"
				v-on:click="openmarker(f)">
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
