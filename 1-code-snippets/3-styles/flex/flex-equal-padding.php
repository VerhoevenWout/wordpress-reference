<style>
.landing-home-blokken{
	&.merken{
		@include xl{
			.row{
				margin: -0.5em;
			}
			.blokken .row .column{
				padding: 0 1rem;
			}
		}
	}
}
</style>

<section class='row'>
	<div class='columns small-12 landing-home-blokken merken' id='blokken'>
		<div class='blokken'>
			<div class='slick-blokken row'>
				<?php foreach($muller->merken as $merk):?>
					<div class='columns small-12 xsmall-6  xlarge-2'>
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
			</div>
		</div>
	</div>
</section>