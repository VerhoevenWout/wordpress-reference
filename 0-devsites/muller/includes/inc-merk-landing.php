<?php
global $muller;

//The template for displaying all pages

/*
	Variables to load {
		\muller\tax\merkreeks / get_level_1 / merken
		\muller\tax\merkreeks / get_merken / submerken / false
		\muller\tax\merkReeks / getBanner / banner
		\muller\tax\merkReeks / getAttachments / attachments
		\muller\menushelper / getBreadcrumb / breadcrumb 
	}
*/

	get_header(); 
?>
<div id='single-product' class="row">
	<aside class='columns xlarge-3 subcatmenu'>
		<div class='inner'>
			<h1><?php _e('Brands', 'muller');?></h1>
			<ul class='column small-12 subcat-menu row'>
				<?php foreach ($muller->merken as $merk):?>
					<li><a class='<?= $muller->merkReeks->taxVars->term_id == $merk->term_id ? 'active': ''?>' href='<?= get_term_link($merk->term_id, 'merk-reeks');?>'><?= $merk->name;?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
	</aside>
	<main class='columns small-12 xlarge-9 categorie'>
		<header class='row'>
			<div class='columns small-12 breadcrumb'>
				<?= $muller->breadcrumb;?>
			</div>
			<div class='columns small-12 banner'>
				<div class='row small-collapse picture'>
					<div class='columns small-12'>
						<?= $muller->banner['picture'];?>
					</div>
				</div>
				<?php if($muller->banner['intro']['titel'] != ''):?>
					<div class='row intro'>	
						<div class='columns small-12'>
							<h1><?= $muller->banner['intro']['titel'];?></h1>
							<p><?= $muller->banner['intro']['tekst'];?></p>
						</div>
					</div>
				<?php endif;?>
				<div class='row align-left extra'>
					<div class='columns small-12 catalogus'>
					
					<?php if( !empty($muller->attachments)):?>
						
							<?php if($muller->attachments['catalogus']):?>
							<input type="checkbox" name="catalogi" id='catalogi'/>
							<label for='catalogi'>
								<span><?php _e('catalogs', 'muller');?></span>
								<svg id="arrow-cross" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.96 6.25">
									<title>Naamloos-3</title>
									<rect class='line1' x="7.5" y="-0.5" width="1.04" height="7.76" transform="translate(4.57 -4.93) rotate(45)" />
									<rect class='line2' x="2.76" y="-0.5" width="1.04" height="7.76" transform="translate(-1.6 3.07) rotate(-45)" />
								</svg>
							</label>
							<ul class="row expanded">
								<?php foreach ($muller->attachments['catalogus'] as $link => $attachment):?>
									<li class="small-12 xsmall-4 medium-3 large-3"><a href="https://view.publitas.com/muller/<?= $link;?>" target="_blank"><img src='<?= $attachment['image'];?>'><span><?= $attachment['text'];?></span></a></li>
								<?php endforeach;?>
							</ul>
							<?php endif;?>
						
					<?php endif;?>
				 	<?php if($muller->attachments['website']):?>
						<a class="web-link" target='_blank' href='<?=$muller->attachments['website'];?>'><?= __('Visit website', 'muller');?><i class="fa fa-external-link"></i></a>
					<?php endif;?>
					<?php if($muller->attachments['videos']):?>
						<a class="web-link" target='_blank' href='https://vimeopro.com/<?=$muller->attachments['videos'];?>'><?= $muller->currentObject->name . __(' on Vimeo', 'muller');?><i class="fa fa-external-link"></i></a>
					<?php endif;?>
					</div>
				</div>
			</div>
		</header>
		<section class='row'>
			<div class='columns small-12 landing-home-blokken' id='blokken'>
				<h1><?php _e('Series', 'muller');?></h1>
				<div class='blokken'>
					<div class='slick-blokken row'>
						<?php 
							$index = 1;
						?>
						<?php $submerkArray = array(); ?>
						<?php foreach($muller->submerken as $key => $merk):?>
							<?php  
							$merk_reeks_count = count($merk['reeksen']);
							?>
							<?php if($merk['reeksen'] && $merk_reeks_count > 1): ?>
								<div sub-blok-data-id="<?php echo $key ?>" class='columns small-12 xsmall-6 large-3 open-dropdown-trigger slickthis'>
							<?php else: ?>
								<a href='<?= get_term_link($merk['term']->term_id,'merk-reeks' );?>' class='columns small-12 xsmall-6 large-3 slickthis'>
							<?php endif; ?> 
									<?php if($merk['thumb']['url']): ?>
										<img src="<?= $merk['thumb']['url']; ?>">
									<?php else: ?>
										<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
									<?php endif;?>
									<h3><?= $merk['term']->name;?></h3>
									<span class="sub-blok-arrow arrow-up sub-blok-arrow-<?php echo $key ?>"></span>
							<?php if($merk['reeksen'] && $merk_reeks_count > 1): ?>
								</div>
							<?php else: ?>
								</a>
							<?php endif; ?> 

							<!-- SUB BLOKKEN -->
							<?php $submerkArray[$key] = $merk; ?>
							<?php if($index % 4 == 0): ?>
								<?php foreach($submerkArray as $key => $submerk):?>
									<div class="sub-blok-container sub-blok-container-md-<?php echo $key ?>">
										<h3><?= $submerk['term']->name;?></h3>

										<?php foreach($submerk['reeksen'] as $key => $submerkreeks):?>
											<?php if($submerkreeks['term']->term_id): ?>
												<a href='<?= get_term_link($submerkreeks['term']->term_id) ?>' class='columns small-12 xsmall-6 medium-3 sub-blok'>
													<?php if($submerkreeks['thumb']['url']): ?>
														<img src="<?= $submerkreeks['thumb']['url'];?>">
													<?php else: ?>
														<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
													<?php endif;?>
													<h3><?= $submerkreeks['term']->name;?></h3>
												</a>
											<?php endif; ?>
										<?php endforeach;?>
										<a href='<?= get_term_link($submerk['term']->term_id,'merk-reeks' ) ?>' class='columns small-12 xsmall-6 medium-3 sub-blok sub-blok-all'>
											<?php if($submerk['thumb']['url']): ?>
												<img src="<?= $submerk['thumb']['url'];?>"> 
											<?php else: ?>
												<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
											<?php endif;?>
											<h3><?= __('View all products','muller');?></h3>
										</a>
										
										<img target=".sub-blok-container, .sub-blok-arrow" class="close" src="<?php echo get_bloginfo('template_url') ?>/dist/img/close.svg" alt="close">
									</div>

								<?php endforeach;?>
								<?php $submerkArray = []; ?>
							<?php endif; ?>

							<?php $index++ ?>
						<?php endforeach;?>

						<!-- Show remaining dropdown (last row) -->
						<div class="row expanded">
							<?php foreach($muller->submerken as $key => $merk):?>
								<?php if ($submerkArray): ?>
									<?php foreach($submerkArray as $key => $submerk):?>
										<div class="sub-blok-container sub-blok-container-md-<?php echo $key ?>">
											<h3><?= $submerk['term']->name;?></h3>

											<?php foreach($submerk['reeksen'] as $key => $submerkreeks):?>
												<?php if($submerkreeks['term']->term_id): ?>
													<a href='<?= get_term_link($submerkreeks['term']->term_id) ?>' class='columns small-12 xsmall-6 medium-3 sub-blok'>
														<?php if($submerkreeks['thumb']['url']): ?>
															<img src="<?= $submerkreeks['thumb']['url'];?>">
														<?php else: ?>
															<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
														<?php endif;?>
														<h3><?= $submerkreeks['term']->name;?></h3>
													</a>
												<?php endif; ?>
											<?php endforeach;?>
											<a href='<?= get_term_link($merk['term']->term_id,'merk-reeks' ) ?>' class='columns small-12 xsmall-6 medium-3 sub-blok sub-blok-all'>
												<?php if($submerk['thumb']['url']): ?>
													<img src="<?= $submerk['thumb']['url'];?>"> 
												<?php else: ?>
													<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
												<?php endif;?>
												<h3><?= __('View all products','muller');?></h3>
											</a>
											
											<img target=".sub-blok-container, .sub-blok-arrow" class="close" src="<?php echo get_bloginfo('template_url') ?>/dist/img/close.svg" alt="close">
										</div>

									<?php endforeach;?>
									<?php $submerkArray = []; ?>
								<?php endif ?>
							<?php endforeach;?>
						</div>
						<!-- <div class='loading'>
							<div class='spin'></div>
						</div> -->
					</div>
				</div>
			</div>
		</section>
	</main>
</div>


<?php 
get_footer(); 
?>