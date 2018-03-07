<?php
global $muller;

// Template name: Search

/*
	Variables to load {
		WP / page
	}
*/

get_header(); 
?>

<div id='vue-search' :lang="setlang('<?= ICL_LANGUAGE_CODE;?>')" class="row align-center">

	<main class='columns small-12 xlarge-9 categorie'>
		<header class='row'>
			<div class='columns small-12 breadcrumb'>
			<div class='search'>
				<div class="inner">
					<input :disabled='loading'  v-on:keyup.enter="search" v-model="searchquery" type="text" name="searchquery" />
					<button v-on:click='search' type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
			</div>
		</header>
		<section class='row '>
			<product :lang='"<?= ICL_LANGUAGE_CODE;?>"' :title='"Zoek"' :filterloader='loading' :currenturl='currenturl'></product>
		</section>
	</main>
</div>

<?php 
get_footer(); 
?>