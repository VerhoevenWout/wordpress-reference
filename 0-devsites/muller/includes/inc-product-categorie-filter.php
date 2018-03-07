<?php
global $muller;

//The template for displaying all pages
/*
	Variables to load {
		\muller\menushelper / getBreadcrumb / breadcrumb 
	}
*/

get_header(); 
?>

<div id='vue-product-filter' class="row" :lang="setlang('<?= ICL_LANGUAGE_CODE;?>')" :termid="setTermid(<?= $muller->currentTax->term_id;?>, <?= $muller->currentTax->parent;?>)">
	<aside class='columns xlarge-3 subcatmenu filters' v-bind:class="{ active: isactive }" >
		<div class='inner'>
			<div class='breadcrumb'>
				<?= $muller->breadcrumb;?>
			</div>
			<h1><?= $muller->active['productcat'][0]->name;?></h1>
			<a v-if='Object.keys(filters).length > 1 ' class='filterbtn' v-on:click="togglefilter" ><span><i class="fa fa-list-ul" aria-hidden="true"></i><?= __('Filter', 'muller');?> <small>({{ countproducts }})</small></span></a>
			<a v-else class='filterbtn'  ><span><i></i>{{ countproducts }} <?= __('Producten', 'muller');?></span></a>
			<div class='filterbtns' v-bind:class="{'disabled': filterloader == true}">
				<a v-on:click='togglefilter'>OK</a>
				<!-- <a v-on:click='togglefilter'>Annuleer</a> -->
			</div>
			<productfilter v-for="(filter, index) in filters" :filterkey='index' :filterdata='filter' :countloader='countloader'  :subfilter='false' :termparent="termparent" :key="filter.name" :filtersactive='isactive' :filterloader='filterloader' :termid='termid'></productfilter>
		</div>
	</aside>
	<main class='columns small-12 xlarge-9 categorie'>
		<header class='row'>
			<div class='columns small-12 breadcrumb'>
				<?= $muller->breadcrumb;?>
			</div>
		</header>
		<section class='row filterrow'>
				<product :lang='"<?= ICL_LANGUAGE_CODE;?>"' :termid='termid' :currenturl='currenturl' :filterloader='filterloader' :activefilters='activefilters' :isactive='isactive' ></product>
		</section>
	</main>
</div>


<?php 
get_footer(); 
?>