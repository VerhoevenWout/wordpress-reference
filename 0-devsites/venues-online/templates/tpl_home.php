<?php 
    /**
    * Template Name: Home
    */

	// GET search_parameters FROM 404 PAGE
	$search_values = isset($search_values) ? $search_values : null;
	$search_parameters = isset($search_parameters) ? $search_parameters : null;

	global $translations;
	global $translations_json;
	global $lang;
	
	$repeater = get_field( 'header_background_repeater' );
	$rand = rand(0, (count($repeater) - 1));
	$random_image = $repeater[$rand]['background'];

get_header(); ?>

	<div id='vue-search' v-bind:class="{ 'search-active': isactive }">
		<div class="row expanded">

			<img class="top-banner-background" src="<?php echo $random_image ?>" alt="background"/>
			<div class="top-banner-background top-banner-background-overlay"></div>

			<div class="top-banner columns">
				<img class="logo single-logo single-logo-out-view" src="<?php echo get_bloginfo('template_url') ?>/dist/img/single-logo.svg" alt="">
				<h1 class="heading text-center semi-bold">
					<?php echo the_field('home_header_heading')?>
				</h1>			
				<h2 class="heading text-center sub-heading thin">
					<?php echo the_field('home_header_subheading')?>
				</h2>
				<?php if($search_parameters): ?>
					<search :search-active='isactive' :translations='<?= jsonToProp($translations_json) ?>' :langprop="lang" :searchprop="<?= jsonToProp($search_parameters) ?>"></search>
				<?php else: ?>
					<search :search-active='isactive' :translations='<?= jsonToProp($translations_json) ?>' :langprop="lang"></search>
				<?php endif; ?>
			</div>
		</div>

		<div class="row expanded results">
			<div class="fiches small-24 large-16 columns">

				<?php include(locate_template('templates/partials/venuecounter-text.php')); ?>

				<?php if($search_parameters): ?>
					<!-- this way vars are available in the template -->
					<?php include(locate_template('templates/partials/seoblock-text.php')); ?>
				<?php endif; ?>

				<div class="row expanded">
					<span v-if="fichescount == 0 && isactive && getAddressDataError == false" class="heading semi-bold no-venues-message"><?= $translations[52] ?></span>
					<span v-if="fichescount == 0 && isactive && getAddressDataError == true" class="heading semi-bold no-venues-message"><?= $translations[63] ?></span>
					<fiche v-for="fiche in fiches" v-on:mouseover="fichehover(fiche)" :fichedataprop="fiche" :translations='<?= jsonToProp($translations_json) ?>' :favarray="favarray" :ipaddressprop="ipaddress" :langprop="lang"></fiche>
					<?php get_template_part('templates/partials/pagination') ?>
				</div>
			</div>

			<div v-show="isactive" class="map-container noPadding small-8 columns" v-if="fichescount != 0">
				<gmap-map 
					style="width: 100%; height: 100%; position: absolute; left:0; top:0"
			        :center="{lat: mapcenter.lat, lng: mapcenter.lng}"
			        :zoom="mapcenter.zoom"
			        :options="mapoptions"
			    >	
			    	<gmap-marker v-for="(f, index) in fiches"
						:key="index"
						:position="getposition(f.lat, f.lng)"
						:clickable="true"
						:icon="f.markerurl"
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

		<div class="row expanded" v-show="isactive">
			<div class="map-container map-container-mobile noPadding small-24 columns selectedfiche-map" v-if="fichescount != 0">
				<gmap-map 
					style="width: 100%; height: 100%; position: absolute; left:0; top:0"
			        :center="{lat: mapcenter.lat, lng: mapcenter.lng}"
			        :zoom="mapcenter.zoom"
			        :options="mapoptions"
			    >	
			    	<gmap-marker v-for="(f, index) in fiches"
						:key="index"
						:position="getposition(f.lat, f.lng)"
						:clickable="true"
						:icon="f.markerurl"
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

		<?php if(!$search_parameters): ?>
			<?php get_template_part('templates/partials/questionblock') ?>
			<?php get_template_part('templates/partials/socialblock') ?>
		<?php endif; ?>
		
		<?php get_template_part('templates/partials/newseoblock') ?>
		
	</div>
	<div class="row expanded">
		<div class="seo-block"></div>
	</div>

<?php get_footer(); ?>























