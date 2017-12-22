<?php
global $voltatheme;

// Template name: Contactbeheer

/*
	Variables to load {
		WP / page
		ACF / home_link_text
		ACF / home_link_url
	}
*/

get_header(); 
while ( have_posts() ) : the_post();
?>

<?php
	if ($_GET["term"] == "") {
		$loadTerm = "allochtonen";
	} else {
		$loadTerm = $_GET["term"];
	}
?>
<section class="breadcrumbs column small-12" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php 
    	if(function_exists('bcn_display')):
        	bcn_display();
		endif;
	?>
	<?php if ($_GET["parent"] != "") : ?> 
		<i class="icon-arrow-right"></i> 
		<span>
			<a href="<?php the_permalink(); ?>?term=<?php echo $_GET["parent"]; ?>">
				<?php echo $_GET["parent"]; ?>
			</a>
		</span>
	<?php endif; ?>

	<?php if ($_GET["term"] != "") : ?> 
		<i class="icon-arrow-right"></i> <span><?php echo $_GET["term"]; ?></span>

	<?php else: ?>
		<i class="icon-arrow-right"></i> 
		<span>
			<a href="<?php the_permalink(); ?>?term=Allochtonen">
				Allochtonen
			</a>
		</span>

	<?php endif; ?>
</section>
<aside class="sidebar sidebar-contactbeheer column small-12 xmedium-3">
	<?php get_template_part("includes/contact-sidebar"); ?>
</aside>
<section class="block column small-12 xmedium-9">
	<section class="block contactbeheer-block column small-12 row">

		<?php
			$args = array(
				'post_type' => 'contact',
				'posts_per_page' => -1,
				'tax_query' => array(
				    array(
				    'taxonomy' => 'contact-groepen',
				    'field' => 'slug',
				    'terms' => $loadTerm
				    )
				  )
			);
			$query = new WP_Query( $args ); 


			if ( $query->have_posts() ) :
		?>
			<header class="column small-8">
				<h1 class="page-title"><?= $loadTerm; ?></h1>
			</header>
				

			<form action="/print/" method="post">
				<div class="print-btns print-btns-top" >
					<div>
						<input type="submit" value="Print selectie" class="btn selection-print" disabled="disabled">
						<small>Print de geselecteerde contacten</small>
					</div>
					<div>
						<input type="submit" value="Snelle selectie" class="btn fast-print">
						<small>Print snel de eerste 10 contacten</small>
					</div>				
				</div>
				
				<table class="contact-table">
					<thead> 
						<tr>
							<th scope="col">Naam</th>
							<th scope="col">Adres</th>
							<th scope="col">Tel. werk</th>
							<th scope="col">Rang</th>
							<th scope="col">Selecteer/bekijk</th>
						</tr>
					</thead>
					<tbody>
						<tr class="section-title">
							<!-- <th colspan="5"> -->
								<?php 
									// $thisTerm =  get_term_by('slug', $loadTerm, 'contact-groepen');
									// $termID = $thisTerm->term_id;

									// print_r(get_term_children( $termID, 'contact-groepen' ) );
								?>
							<!-- </th> -->
						</tr>
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
							<tr>
								<th scope="row">
									<strong><?php the_title(); ?></strong>
								</th>
								<td data-title="Adres">
									<span><?php the_field("contact_gemeente"); ?></span>
									<span><?php the_field("contact_adres"); ?></span>
								</td>
								<td data-title="Tel. Werk">
									<span>T. <?php the_field("contact_tel_werk"); ?></span>
									<span>F. <?php the_field("contact_fax"); ?></span>
								</td>
								<td data-title="Rang">
									<?php
										$stars = get_field("contact_rang");

										$emptyStars = -intval($stars)+5;

										for ($x = 1; $x <= $stars; $x++) {
										    echo '<i class="icon-star"></i>';
										} 

										for ($y = 1; $y <= $emptyStars; $y++) {
										    echo '<i class="icon-star icon-blank"></i>';
										} 
									?>
								</td>
								<td data-title="Selecteer/Bekijk">
									<span>
										<input type="checkbox" id="select-contact-<?php the_ID(); ?>" name="select-contact[]" value="<?php the_ID(); ?>">
										<label for="select-contact-<?php the_ID(); ?>"></label>
										<a href="<?php the_permalink(); ?>">
											<i class="fa fa-eye"></i>
										</a>
									</span>	

								</td>
							</tr>
							
						<?php
							endwhile;
						endif;
						/* Restore original Post Data */
						wp_reset_postdata();
					?>
				</tbody>
			</table>`
			
			<div class="print-btns" >
				<div>
					<input type="submit" value="Print selectie" class="btn selection-print" disabled="disabled">
					<small>Print de geselecteerde contacten</small>
				</div>
				<div>
					<input type="submit" value="Snelle selectie" class="btn fast-print">
					<small>Print snel de eerste 10 contacten</small>
				</div>				
			</div>
		</form>
	</section>
</section>


<?php 
endwhile;
get_footer(); 
?>