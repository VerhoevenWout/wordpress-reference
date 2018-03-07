<?php
global $muller;

// Template name: Historiek

/*
	Variables to load {
		WP / page
		menus / account-menu
		userhelper / loginbar / loginbar
		userhelper / orderhistory / orderhistory
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
					<div class='columns small-12 medium-9'>
						<?= $muller->loginbar;?>
						<?= $muller->menus['account-menu'];?>
					</div>
				</div>
			</div>
		</header>
		<section class='row'>
			<div  class='columns small-12 medium-9 history'>
				
				<?php if(is_user_logged_in()):?>
					<ul>
						<?php foreach ($muller->orderhistory['orders'] as $key => $order):?>
							<li>
								<form action="<?= get_page_link(icl_object_id(29577, 'page', true));?>" method="GET">
									<?php if ($order->order_title): ?>
										<p><?= $order->order_title;?>-<?= $order->id;?><span class='date'><?= $order->date;?></span></p>
									<?php else: ?>
										<p><?= $order->id;?></p>
									<?php endif ?>
									<!-- <?php if ($order->order_note): ?>
										<span><?= $order->order_note;?></span>
									<?php endif; ?> -->

									<ul>
										<?php $cart = []; ?>
										<?php foreach (json_decode($order->cart) as $keyprod => $prod):?>
											<li>
												<?php if($prod->count): ?>
													<?php $transid = apply_filters( 'wpml_object_id',  $prod->ID,  'product',  true );?>
													<?= $prod->count;?> x <?= $muller->product->formatnr($transid, true);?> - <?= get_the_title($transid);?>
												<?php endif; ?>
											</li>
										<?php endforeach;?>
									</ul>
									<input type='hidden' name='cartvalue' value='<?= $order->id ?>'>
									<input type="submit" name="" value='<?= __("Add to quotation request", "mulller");?>'>
								</form>
							</li>
						<?php endforeach;?>
					</ul>
					<?php if($muller->orderhistory['pages'] > 1):?>
					<div class="pagination">
						<ul>
							<?php if($_GET['pg'] && $_GET['pg'] != 0):?>
								<a href='?pg=<?= $_GET['pg']-1;?>' class="slider-arrow left">
									<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill: none; stroke: rgb(35, 31, 32); stroke-miterlimit: 10;"></polyline></svg>
								</a> 
							<?php endif;?>
							<?php for ($i=0; $i < $muller->orderhistory['pages']; $i++) { ?>
								<li class="<?= $_GET['pg'] == $i ? 'active' : '';?> nopseudo"><a href='?pg=<?= $i;?>'><?= $i+1;?></a></li>
							<?php };?>
							<?php if($_GET['pg'] != $muller->orderhistory['pages']-1):?>
							  	<a href='?pg=<?= $_GET['pg']+1;?>' class="slider-arrow right">
							  		<svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3.87 6.33"><title>arrow-small</title><polyline points="0.35 0.35 3.17 3.17 0.35 5.98" style="fill: none; stroke: rgb(35, 31, 32); stroke-miterlimit: 10;"></polyline></svg>
							  	</a>
						 	 <?php endif;?>
						 </ul>
					</div>
					<?php endif;?>
				<?php else: 
					echo '<h4>'.__('Log in om een offerte aan te vragen', 'muller').'</h4>';
					wp_login_form(['remember' => false]);
				endif; ?>
			</div>
		</section>
	</main>
</div>

<?php 
get_footer(); 
?>