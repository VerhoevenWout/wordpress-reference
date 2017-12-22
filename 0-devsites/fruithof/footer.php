<?php
global $voltatheme;
?>

			</div>
		</main>	
		
	</div> <!-- End .page-wrap -->
	<!-- <section class="footer-subscribe">
		<div class='row xmedium-collapse'>
			<div class="column">
				<?php // gravity_form(1, true, false, false, '', true, 12); ?>
			</div>					
		</div>
	</section> -->
	<footer id='site-footer'>

		<div class='row align-center large-collapse'>
			<section class="footer-logo column small-12 medium-2 large-2">
				<img src="<?php bloginfo('template_url'); ?>/dist/img/logo-small.svg">
			</section>
			<section class="footer-details column small-12 medium-10 large-10">
				<ul class="row large-collapse">
					<li class="column small-12 medium-6 xmedium-4 large-2">
						<strong>adres</strong> <br>
						Sint Theresiastraat 5 <br>
						2600 Berchem <br>
						<a href="mailto:info@groepspraktijkfruithof.be">info@groepspraktijkfruithof.be</a>
					</li>

					<li class="column small-12 medium-6 xmedium-4 large-2 large-offset-1">
						<strong>openingsuren</strong> <br>
						maandag - vrijdag<br>
						07:30u - 19:00u <br>
					</li>
					<li class="column small-12 medium-6 xmedium-4 xmedium-order-1 large-2">
						<a href="tel:003234401925" class="btn btn-secretariaat" title="Secretariaat">
							secretariaat <strong>03/440.19.25</strong> <small>07:30u - 19:00u</small>
						</a>
					</li>
					<li class="column small-12 medium-6 xmedium-4 xmedium-order-1 large-2">
						<a href="tel:090010512" class="btn btn-vanwacht" title="Huisarts van wacht">
							huisarts van wacht <strong>0900/10.512</strong> <small>avond / nacht / weekend</small>
						</a>
					</li>
					<li class="column small-12 medium-6 xmedium-4 xmedium-order-0 large-order-2 large-3">
						<a href="http://groepspraktijkfruithof.digitalewachtkamer.be/" class="btn btn-boekonline btn-revert" title="Boek online" target="_blank">
							<i class="icon-chairs"></i>
							<span>
								<small>afspraak?</small><strong>Boek online</strong>
							</span>
						</a>
					</li>
				</ul>
			</section>
			<nav id="footer-nav" class="column small-12">
				<strong>© <?php bloginfo( 'name' ); ?> <?= date("Y"); ?> </strong>
				<?php 
					wp_nav_menu( 
						array( 
							'theme_location' => 'footer-menu',
							'menu_class'     => 'footer-menu'
						) 
					); 
				?>
			</nav>
		</div>
	</footer>
<!-- WP footer -->
<?php wp_footer(); ?>

</body>
</html>