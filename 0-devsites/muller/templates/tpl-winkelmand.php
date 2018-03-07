<?php
global $muller;

// Template name: Winkelmandje

/*
	Variables to load {
		WP / page
		menus / account-menu
		userhelper / loginbar / loginbar
		userhelper / checkpost / checkpost
	}
*/

get_header(); 

?>
<div class="row">
	<main class='columns small-12'>
		<header class='row'>
			<div class='columns small-12 breadcrumb'>
				<?= $muller->breadcrumb;?>
			</div>
			<div class='columns small-12 banner'>
				<div class='row intro transparent'>
					<div class='columns small-12 large-9'>
						<?= $muller->loginbar;?>
						<?= $muller->menus['account-menu'];?>
					</div>
				</div>
			</div>
		</header>
		<section class='row'>
			<div class='cart columns small-12 large-9'>
				<div id='cart'>
					<div class="loading" v-show='loading'><div class='spin'></div></div>
					<span v-if='Object.keys(products).length > 0'><?= _e('Offers are automatically assigned an ID number, optionally followed by a name you enter below.') ?></span>
					<span class='noproducts' v-if='Object.keys(products).length == 0 && !offertesend'><?= __('No products in your quote.', 'muller');?></span>
					<span class='sendmessage' v-show='offertesend'>
						<?= __('Thank you for your quote request. We will contact you as soon as possible.', 'muller');?>
						<a v-on:click='closeoffertesend' class='hamburger open'> <span></span><span></span><span></span></a>
					</span>
					<ul class="cart-list">
						<li v-for="product in products" class="cart-item">
							<div class='rect'>
								<?php if (ICL_LANGUAGE_CODE == 'nl'): ?>
									<a v-bind:href="'/nl/'+product.post_name">						 		
						 		<?php elseif(ICL_LANGUAGE_CODE == 'fr'): ?>
									<a v-bind:href="'/fr/'+product.post_name">						 		
						 		<?php elseif(ICL_LANGUAGE_CODE == 'en'): ?>
									<a v-bind:href="'/en/'+product.post_name">						 		
					 			<?php elseif(ICL_LANGUAGE_CODE == 'de'): ?>
									<a v-bind:href="'/de/'+product.post_name">					 			
								<?php endif ?>
									<div class='container'><img :src="'//s3-eu-west-1.amazonaws.com/muller-kitchenandtableware-webimages/'+product.images.thumb"></div>
								</a>
							</div>
							<div class='content'>
								
								<?php if (ICL_LANGUAGE_CODE == 'nl'): ?>
									<a v-bind:href="'/nl/'+product.post_name">						 		
						 		<?php elseif(ICL_LANGUAGE_CODE == 'fr'): ?>
									<a v-bind:href="'/fr/'+product.post_name">						 		
						 		<?php elseif(ICL_LANGUAGE_CODE == 'en'): ?>
									<a v-bind:href="'/en/'+product.post_name">						 		
					 			<?php elseif(ICL_LANGUAGE_CODE == 'de'): ?>
									<a v-bind:href="'/de/'+product.post_name">					 			
								<?php endif ?>

									<?php if (ICL_LANGUAGE_CODE == 'nl'): ?>
							 			<h3>{{ product.post_title }}</h3>
							 		<?php elseif(ICL_LANGUAGE_CODE == 'fr'): ?>
							 			<h3>{{ product.artikelnaam_FR }}</h3>
							 		<?php elseif(ICL_LANGUAGE_CODE == 'en'): ?>
							 			<h3>{{ product.artikelnaam_EN }}</h3>
						 			<?php elseif(ICL_LANGUAGE_CODE == 'de'): ?>
						 				<h3>{{ product.artikelnaam_DE }}</h3>
									<?php endif ?>

							 		<span><?= __('Article number', 'muller');?>: {{ product.intern_artikelnr }}</span>
							 	</a>
							 	<div class='quantity'>
							 		<span>{{ product.count }}</span>
							 		<div class="quantity-nav">
										<div  v-on:click='quantityup(product.ID, product.nlID)' class="quantity-button quantity-up">
											<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#85878a;stroke-miterlimit:10"></polyline></svg>
										</div>
										<div v-on:click='quantitydown(product.ID, product.nlID)' class="quantity-button quantity-down">
											<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill:none;stroke:#85878a;stroke-miterlimit:10"></polyline></svg>
										</div>
									</div>
									<div v-on:click='deleteproduct(product.ID, product.nlID)' class='delete'>
										<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9.17 9.17"><title>Naamloos-2</title><polyline points="8.66 0.51 4.58 4.58 0.51 0.51" style="fill:none;stroke:#7d7b7c;stroke-miterlimit:10;stroke-width:1.44792048473394px"/><polyline points="0.51 8.66 4.58 4.58 8.66 8.66" style="fill:none;stroke:#7d7b7c;stroke-miterlimit:10;stroke-width:1.44792048473394px"/></svg>
									</div>
							 	</div>
							 </div>
						
						</li>
					</ul>
					<?php if(is_user_logged_in()):?>
						<div class='form' v-if='Object.keys(products).length != 0'>
							<label for='name'><?= __('Give this quote a name (this is shown in your quote request history):', 'muller');?></label>
							<input @change='savefields()' type="text" v-model='naam' name="">
							<label for='opmerking'><?= __('Comments for this quote request', 'muller');?></label>
							<textarea @change='savefields()' v-model='opmerking'></textarea>
							<a v-on:click='zendofferte'><?= __('Request a quote', 'muller');?></a>
						</div>
					<?php endif;?>

				</div>
				<?php if(!is_user_logged_in()): 
						echo '<h4>'.__('Log in to request a quote', 'muller').'</h4>';
						//wp_login_form(['remember' => false]);
						echo do_shortcode('[ultimatemember form_id=59983]');
						echo '<p>'.__('Log in to request a quote', 'muller').'.<br>'.__('No account yet?','muller').' <a href="'.get_page_link(59990).'" > '.__('Register here', 'muller').'.</a></p>';
				    endif;
				?>
			</div>
		</section>
	</main>
</div>

<?php 
get_footer(); 
?>