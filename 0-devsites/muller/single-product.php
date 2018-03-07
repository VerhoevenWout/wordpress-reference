<?php
global $muller;

//The template for displaying all pages

/*
	Variables to load {
		WP / post
		\muller\menushelper / getBreadcrumb / breadcrumb 
		\muller\product / getImagesGrid / images 
		\muller\product / getMerk / productmerk 
		\muller\product / getTechnicalInfo / technicalinfo
		\muller\product / getrelatedProducts / relatedproducts
		\muller\product / getManual / manual
		\muller\product / getPostMeta / postMeta
		\muller\product / getVideo / video
		\muller\product / getLink / link
		\muller\product / getshareurls / sharelinks
		\muller\init / get_svg / arrowright / arrowright
		\muller\awshelper / getImgProductsSingle / aws
	}
*/
get_header(); 
while ( have_posts() ) : the_post();
?>


<div class="row ">
	<main id='single-product' class='columns small-12 single-product'>
		<header class='row '>
			<div class='columns small-12 breadcrumb '>
				<?= $muller->breadcrumb;?>
			</div>
		</header>
		<section class='row'>
			<div class='columns small-12 medium-7 large-8 xxlarge-6 left-side'>
				<h1 class=' title'><?= $muller->WP['post']->post_title; ?></h1>
				<div v-if="$mq.resize && $mq.above('46em')" class='productimage'>
					<?= $muller->images['imagegrid']['HB']; ?>
					<?php if(isset($muller->images['sliders']['XL'])): ?>
						<i v-on:click='openslider' class="fa fa-search" aria-hidden="true"></i>
					<?php endif;?>
				</div>
				<div  class='sliderwrapper' v-bind:class="{ fullscreen: sliderOpen }">
					<svg  v-on:click="closeslider" id="arrow-cross" id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.68 24.68">
						<title>Close</title><polyline points="0.35 0.35 12.34 12.34 0.35 24.33" style="fill:none;stroke:#2e2a25;stroke-miterlimit:10"/><polyline points="24.33 24.33 12.34 12.34 24.33 0.35" style="fill:none;stroke:#2e2a25;stroke-miterlimit:10"/>
					</svg>
					<div class='logo'>
						<?= $muller->logo;?>
					</div>
					<?php if(isset($muller->images['sliders']['XL'])):?>
						<ul class='product-slider' v-if="$mq.resize && $mq.above('46em')">
							<?= $muller->images['sliders']['XL'];?>
						</ul>
					<?php endif;?>
					<ul class='product-slider' v-if="$mq.resize && $mq.below('46em')">
						<?= $muller->images['sliders']['EB'];?>
					</ul>
					<?php if(isset($muller->images['sliders']['XL'])): ?>
						<i v-on:click='openslider' class="fa fa-search" aria-hidden="true"></i>
					<?php endif;?>
				</div>
				<?php if($muller->productmerk->logo):?>
					<div class='merklogo'>
						<?= $muller->productmerk->logo;?>
					</div>
				<?php endif;?>
				<?php
					if(isset($muller->images['imagegrid']['html'])):
						echo $muller->images['imagegrid']['html']; 
					endif
				?>
			</div>
			<div class='columns small-12 medium-5 large-4 xxlarge-6 right-side'>
				<div class='inner small-12 xxlarge-6'>
					<ul class='share-products'>
						<div class="share-products-top">
							<?php  
								$nl_ID = apply_filters( 'wpml_object_id',  $muller->product->postVars->ID,  'product',  true,  'nl' );
								
							?>
							<counter :id="<?= $nl_ID;?>" :count="<?= $muller->product->postMeta['EV'][0];?>"  add='<?= __("Add to quote", "muller");?>' added='<?= __("in quote", "muller");?>'></counter>
							<div class="share-button-container">
								<li><a target="_blank" href='<?= $muller->sharelinks['pinterest'];?>'><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
								<li><a target="_blank" href='<?= $muller->sharelinks['facebook'];?>'><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							</div>
						</div>
						<li class='xtrinfo'><?= __('Sold per', 'muller');?> <?= $muller->product->postMeta['EV'][0];?> - art nr: <?= $muller->product->formatnr($muller->product->postMeta['intern artikelnr'][0]);?></li>
						<?php if(is_user_logged_in() && current_user_can('manage_options') ):?>
							<li class='xtrinfo'>
								<form action="" method="post"><input type="hidden" name="getaws" value="true"><input type="submit" value="Refresh afbeeldingen"></form>
							</li>
						<?php endif?>
					</ul>
					<div class='wysiwyg discription'>
						<?= apply_filters("the_content", $muller->WP['post']->post_content); ?>
					</div>
					<?php if($muller->product->postMeta['toelichting '.strtoupper(ICL_LANGUAGE_CODE)][0]):?>
					<div class="toelichting">
						<p><?= $muller->product->postMeta['toelichting '.strtoupper(ICL_LANGUAGE_CODE)][0];?></p>
					</div>
					<?php endif;?>	
				
					<?php if($muller->video):?>
						<div class='video'>
							<a v-on:click="openpopup"><i class="fa fa-vimeo-square" aria-hidden="true"></i>
								<?= __('Watch the video', 'muller');?> </a>
							
							<div class='popup'>
								<span class='overlay' v-on:click="closepopup"></span>
								<div class='popup-inner'>
									<svg  v-on:click="closepopup" id="arrow-cross" id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.68 24.68">
										<title>Close</title><polyline points="0.35 0.35 12.34 12.34 0.35 24.33" style="fill:none;stroke:#2e2a25;stroke-miterlimit:10"/><polyline points="24.33 24.33 12.34 12.34 24.33 0.35" style="fill:none;stroke:#2e2a25;stroke-miterlimit:10"/>
									</svg>
									<div class='logo muller'>
										<?php //$muller->logo;?>
									</div>
									<div class='embed-container'><iframe src='https://player.vimeo.com/video/<?= $muller->video;?>' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>
									<div class="logo">
										<?= $muller->productmerk->logo;?>
									</div>
								</div>
							</div>
						</div>
					<?php endif;?>
						<?php if($muller->link['url']):?>
							<div class='link'>
							<a href='<?= $muller->link['url'];?>' target='_blank'>
								<?= $muller->link['text'];?> </a>
							</div>
					<?php endif;?>
					<div class='technical-info '>
						<input type="checkbox" name="technicalradio" id='technicalradio'/>
						<header class='<?= $muller->technicalinfo && $muller->manual ? 'two' : 'one' ;?>'>
							<?php if($muller->technicalinfo):?>
								<label for='technicalradio'>
									<span><?php _e('Technical data', 'muller');?></span>
									<svg id="arrow-cross" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.96 6.25">
										<title>Naamloos-3</title>
										<rect class='line1' x="7.5" y="-0.5" width="1.04" height="7.76" transform="translate(4.57 -4.93) rotate(45)" />
										<rect class='line2' x="2.76" y="-0.5" width="1.04" height="7.76" transform="translate(-1.6 3.07) rotate(-45)" />
									</svg>
								</label>
							<?php endif;?>
							<?php if($muller->manual):?>	
								<a href="<?= $muller->manual;?>" target='_blank' ><?php _e('Download de handleiding', 'muller');?></a>
							<?php endif;?>
						</header>
						<div class='tab'>
							<?= $muller->technicalinfo;?>
							<?php if(isset($muller->images['imagegrid']['pack'])):?>
								<div class="img-container">
									<?= $muller->images['imagegrid']['pack'];?>
									<?php if(strpos($muller->images['imagegrid']['pack'], 'reppack')):?>
										<span><?php _e('A representative packaging image is shown', 'muller');?></span>
									<?php endif;?>
								</div>
							<?php endif;?>
						</div>
						<a href="<?= get_page_link(61133) ?>"><?= $muller->arrowright;?><span><?= _e('Questions? Contact our customer service', 'muller');?></span></a>
					</div>
				</div>
				<div class="xxlarge-6">
					<?= $muller->relatedproducts ? $muller->relatedproducts : '' ;?>
				</div>
			</div>


		</section>
		<!-- <footer class='row'>
			
		</footer> -->
	</main>
</div>

<?php 
endwhile;
get_footer(); 
?>