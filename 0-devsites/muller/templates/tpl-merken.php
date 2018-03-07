<?php
global $muller;

// Template name: Merken

/*
	Variables to load {
		WP / page
		WP / the_content
		\muller\tax\merkreeks / get_merken / merken / true	
	}
*/

get_header(); 
?>

<div class="row align-center ">
	<main class='columns small-12 large-10'>
		<header class='row'>
			<div class='columns small-12 breadcrumb'>
				<?= $muller->breadcrumb;?>
			</div>
			<div class='columns small-12 banner'>
				<div class='row intro transparent'>
					<div class='columns small-12'>
						<h1><?= $muller->WP['page']->post_title; ?></h1>
						<p><?= apply_filters("the_content", $muller->WP['page']->post_content); ?></p>
					</div>
				</div>
			</div>
		</header>
		<section class='row'>
			<div class='columns small-12 landing-home-blokken merken' id='blokken'>
				<div class='blokken'>
					<div class='slick-blokken row'>
						
						<?php foreach($muller->merken as $merk):?>
							<div class='columns small-12 xsmall-6 xlarge-3 xxlarge-2 slickthis'>
								<a href='<?= get_term_link($merk['term']->term_id,'merk-reeks' );?>'>
									<?php if($merk['thumb']['url']): ?>
										<img src="<?= $merk['thumb']['url'];?>">
									<?php else: ?>
										<img src="/wp-content/themes/muller/dist/img/muller-categorie-460.jpg">
									<?php endif;?>
									<h3><?= $merk['term']->name;?></h3>
								</a>
							</div>
						<?php endforeach;?>
						<!-- <div class='loading'>
							<span class='spin'></span>
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