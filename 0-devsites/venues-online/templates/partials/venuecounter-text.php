<?php 
	global $translations
?>

<div class="row expanded" v-if="isactive">
	<div class="small-24 columns">
		<p class="venuecount">
			{{ this.fichescount }} <?=  $translations[26] ?>
		</p>
	</div>
</div>