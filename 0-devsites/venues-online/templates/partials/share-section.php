<?php 
	global $translations;
	global $translations_json;
?>

<div class="row expanded" v-if="favarray.length > 0">
	<div class="share-block small-24 columns">
		<div class="share-content">
			<a v-if="this.$root.isfavouritespage == true" v-on:click="sharefavourites(<?= jsonToProp($translations_json) ?>)" title="" class="btn myFavourites">
				<?= $translations[35] ?><span class="icon-favourite"></span>
			</a>
		</div>
	</div>
</div>