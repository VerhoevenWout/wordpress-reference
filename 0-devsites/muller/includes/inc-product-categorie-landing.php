<?php
global $muller;

//The template for displaying all pages

/*
	Variables to load {
		\muller\tax\productCategory / get_tax_childeren / childeren / false
		\muller\tax\productCategory / get_merken / merken / false
		\muller\menushelper / getSubCatMenu / subcatmenu / false
		\muller\tax\productCategory / getBanner / banner
		\muller\menushelper / getBreadcrumb / breadcrumb 
		\muller\tax\productCategory / refresh / refresh
	}
*/

	get_header(); 
	?>
<div class="row ">
	<aside class='columns xlarge-3 subcatmenu'>
		<div class='inner'>
			<h1><?= $muller->active['productcat'][0]->name;?></h1>
			<?= $muller->subcatmenu;?>
			<h1><?= __('Brands', 'muller');?></h1>
			<ul class='column small-12 subcat-menu row'>

				<?php foreach ($muller->merken['merken'] as $key => $merk):	?>
					<li><a href='?merken=<?= $merk['term']->term_id;?>'><?= $merk['term']->name; ?></a>
						<ul>
							<?php if(isset($merk['reeksen'])): ?>
								<?php foreach ($merk['reeksen'] as $key => $merk):?>
									<li><a href='?merken=<?= $merk['term']->term_id;?>'><?= $merk['term']->name; ?></a></li>
								<?php endforeach;?>
							<?php endif;?>
						</ul>
					</li>
				<?php endforeach;?>
				<?php if(is_user_logged_in() && current_user_can('manage_options') ):?>
					<li class='xtrinfo'>
						<form action="" method="post"><input type="hidden" name="getmerken" value="true"><input type="submit" value="Refresh afbeeldingen"></form>
					</li>
				<?php endif?>
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
			</div>
		</header>
		<section class='row'>

				<div class='columns small-12 landing-home-blokken' id='blokken'>
					<h1><?= $muller->active['productcat'][0]->name;?></h1>
					<div class='blokken'>
						<div class='slick-blokken row'>
							
							<?php 
								$index = 1;
							?>
							<?php $submerkArray = array(); ?>
							<?php foreach($muller->merken['merken'] as $key => $merk):?>
								<?php $merk_reeks_count = count($merk['reeksen']); ?>
								<?php if($merk['reeksen'] && $merk_reeks_count > 1): ?>
									<div sub-blok-data-id="<?php echo $merk['term']->term_id ?>" class='column slickthis small-12 xsmall-6 medium-3 open-dropdown-trigger'>
								<?php else: ?>
									<a href='?merken=<?= $merk['term']->term_id;?>' class='column slickthis small-12 xsmall-6 medium-3'>
								<?php endif; ?> 
										<?php if($merk['thumb']['url']): ?>
											<img src="<?= $merk['thumb']['url']; ?>">
										<?php else: ?>
											<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
										<?php endif;?>
										<h3><?= $merk['term']->name;?></h3>
										<span class="sub-blok-arrow arrow-up sub-blok-arrow-<?php echo $merk['term']->term_id ?>"></span>
								<?php if($merk['reeksen'] && $merk_reeks_count > 1): ?>
									</div>
								<?php else: ?>
									</a>
								<?php endif; ?> 
								
								<!-- SUB BLOKKEN -->
								<?php $submerkArray[$merk['term']->term_id] = $merk; ?>
								<?php if($index % 4 == 0): ?>
									<?php foreach($submerkArray as $keysubmerkArray => $submerk):?>
										<div class="sub-blok-container sub-blok-container-md-<?php echo $keysubmerkArray ?>">
											<h3><?= $submerk['term']->name;?></h3>

											<?php foreach($submerk['reeksen'] as $key => $submerkreeks):?>
												<?php if($submerkreeks['term']->term_id): ?>
													<a href='?merken=<?= $submerkreeks['term']->term_id;?>' class='columns small-12 xsmall-6 medium-3 sub-blok'>
														<?php if($submerkreeks['thumb']['url']): ?>
															<img src="<?= $submerkreeks['thumb']['url'];?>">
														<?php else: ?>
															<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
														<?php endif;?>
														<h3><?= $submerkreeks['term']->name;?></h3>
													</a>
												<?php endif; ?>
											<?php endforeach;?>
											<a href='?merken=<?= $keysubmerkArray;?>' class='columns small-12 xsmall-6 medium-3 sub-blok sub-blok-all'>
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

							<div class="row expanded">
							<?php foreach($muller->merken['merken'] as $key => $merk):?>
								<?php if ($submerkArray): ?>
									<?php foreach($submerkArray as $keysubmerkArray => $submerk):?>
										<div class="sub-blok-container sub-blok-container-md-<?php echo $keysubmerkArray ?>">
											<h3><?= $submerk['term']->name;?></h3>

											<?php foreach($submerk['reeksen'] as $key => $submerkreeks):?>
												<?php if($submerkreeks['term']->term_id): ?>
													<a href='?merken=<?= $submerkreeks['term']->term_id;?>' class='columns small-12 xsmall-6 medium-3 sub-blok'>
														<?php if($submerkreeks['thumb']['url']): ?>
															<img src="<?= $submerkreeks['thumb']['url'];?>">
														<?php else: ?>
															<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
														<?php endif;?>
														<h3><?= $submerkreeks['term']->name;?></h3>
													</a>
												<?php endif; ?>
											<?php endforeach;?>
											<a href='?merken=<?= $keysubmerkArray;?>' class='columns small-12 xsmall-6 medium-3 sub-blok sub-blok-all'>
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
							<!-- <div class='loading'>
								<div class='spin'></div>
							</div> -->
							</div>



						</div>
					</div>
				</div>
		
		</section>
	</main>
</div>

<?php 
get_footer(); 
?>










































