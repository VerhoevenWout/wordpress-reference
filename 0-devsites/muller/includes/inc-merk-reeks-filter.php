<?php
global $muller;

//The template for displaying all pages
/*
	Variables to load {
		\muller\menushelper / getBreadcrumb / breadcrumb 
		\muller\merkReeks / getsidebar / sidebar 
	}
*/

get_header(); 
?>


<div id='vue-merk-filter'  class="row" :termid="setTermid(<?= $muller->currentTax->term_id;?>)">
	<aside class='columns xlarge-3 subcatmenu filters'  v-bind:class="{ active: isActive }" >
		<div class='inner'>
		<div class='breadcrumb'>
			<?= $muller->breadcrumb;?>
		</div>
		<h1><a href='<?= get_term_link($muller->sidebar['parent']);?>'><?= $muller->sidebar['parent']->name; ?></a></h1>
		<a v-on:click="togglefilter" class='filterbtn'  ><span><i class="fa fa-list-ul" aria-hidden="true"></i><?= __('Filter', 'muller');?></span></a>
		<div class='filterbtns' >
			<a v-on:click='togglefilter'><?= __('Ok', 'muller');?></a>
			<!-- <a v-on:click='togglefilter'>Annuleer</a> -->
		</div>
		<ul class='active merk'>
		<?php foreach ($muller->sidebar['childeren'] as $key => $term):?>
			<li class='<?= $term['term']->term_id == $muller->merkReeks->taxVars->term_id || $term['term']->term_id == $muller->merkReeks->taxVars->parent ? 'active' : '' ;?>'>
				<a href='<?= get_term_link($term['term']);?>'><?= $term['term']->name ;?></a>
				<?php if($term['childeren'] && ($term['term']->term_id == $muller->merkReeks->taxVars->term_id || $term['term']->term_id == $muller->merkReeks->taxVars->parent)):?>
					<ul>
						<?php foreach ($term['childeren'] as $key => $child):?>
							<li class='<?= $child->term_id == $muller->merkReeks->taxVars->term_id ? 'active' : '' ;?>' ><a href='<?= get_term_link($child);?>'><?= $child->name ;?></a></li>
						<?php endforeach;?>
					</ul>
				<?php endif;?>
			</li>
		<?php endforeach;?>
		</ul>
		</div>
	</aside>
	<main class='columns small-12 xlarge-9 categorie'>
		<header class='row'>
			<div class='columns small-12 breadcrumb'>
				<?= $muller->breadcrumb;?>
			</div>
		</header>
		<section class='row'>
				<product :lang='"<?= ICL_LANGUAGE_CODE;?>"' :action='"get_merk_products"' :currenturl='currenturl' :termid='termid' :title='"<?= $muller->active['merkReeks'][0]->name;?>"'></product>
		</section>
	</main>
</div>

<?php 
get_footer(); 
?>