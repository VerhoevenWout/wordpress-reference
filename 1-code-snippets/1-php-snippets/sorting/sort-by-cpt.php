<!-- ITEMS PAGE (select items here to print) -->

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
	</table>
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

<!-- PRINT PAGE -->

<?php
$myposts = array();
$myposts_expanded = array();
$checks = array();

if(!empty($_POST['select-contact'])) :
	// Collect checked items
    foreach($_POST['select-contact'] as $check) :
    	array_push($checks, $check);
    endforeach;

    // Get posts with that post_ID (of checks)
	$args = array( 
		'post_type' 		=> 'contact', 
		'posts_per_page' 	=> -1, 
		'include' 			=> $checks,
	);
	$myposts = get_posts( $args );

	// Add CPT value 'rang' to each post
 	foreach ($myposts as $post):
		$post->contact_rang = get_field("contact_rang");
	endforeach;

	// Sort alphabetically and then by rang (posts show hig->low rang, in alphabetical order)
	usort($myposts, "sort_alphabetical");
	usort($myposts, "sort_rang");

	// Output posts
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<article class="block single-contact-block column small-12 row">
			<main class="column small-12">
				<header>
					<h3>
						<?php the_title(); ?>		
					</h3>
				</header>
				<ul>
					<?php if (get_field("contact_adres") || get_field("contact_gemeente")) : ?>
						<li>
							<strong>Adres</strong>
							<span><?php the_field("contact_adres"); ?></span>
							<span><?php the_field("contact_gemeente"); ?></span>
						</li>
					<?php endif; ?>

					<?php if (get_field("contact_organisatie")) : ?>
						<li>
							<strong>Organisatie</strong>
							<span><?php the_field("contact_organisatie"); ?></span>
						</li>
					<?php endif; ?>

					<?php if (get_field("contact_tel_dienst") || get_field("contact_tel_werk") || get_field("contact_tel_prive") || get_field("contact_gsm")) : ?>
					<li>
						<strong>Telefoon</strong>
						<table>
							<?php if (get_field("contact_tel_dienst")) : ?>
								<tr>
									<td>Dienst</td>
									<td><?php the_field("contact_tel_dienst"); ?></td>
								</tr>
							<?php endif; ?>
							<?php if (get_field("contact_tel_werk")) : ?>
								<tr>
									<td>Werk</td>
									<td><?php the_field("contact_tel_werk"); ?></td>
								</tr>
							<?php endif; ?>
							<?php if (get_field("contact_tel_prive")) : ?>
								<tr>
									<td>Privé</td>
									<td><?php the_field("contact_tel_prive"); ?></td>
								</tr>
							<?php endif; ?>
							<?php if (get_field("contact_gsm")) : ?>
								<tr>
									<td>GSM</td>
									<td><?php the_field("contact_gsm"); ?></td>
								</tr>
						<?php endif; ?>
						</table>
					</li>
					<?php endif; ?>

					<?php if (get_field("contact_fax")) : ?>
						<li>
							<strong>Fax</strong>
							<span><?php the_field("contact_fax"); ?></span>
						</li>
					<?php endif; ?>

					<?php if (get_field("contact_email")) : ?>
						<li>
							<strong>Email</strong>
							<a href="mailto:<?php the_field("contact_email"); ?>" alt="<?php the_title(); ?>"><?php the_field("contact_email"); ?></a>
						</li>
					<?php endif; ?>

					<?php if (get_field("contact_web")) : ?>
						<li>
							<strong>Web</strong>
							<a href="<?php the_field("contact_web"); ?>" alt="<?php the_title(); ?>" target="_blank"><?php the_field("contact_web"); ?></a>
						</li>
					<?php endif; ?>

					<li>
						<strong>Rang</strong>
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
					</li>

				</ul>
			</main>
			<hr>
		</article>
	<?php endforeach; 
	wp_reset_postdata();?>
<?php
else:
?>

<p>Maak een selectie op de vorige pagina</p>

<?php endif; ?>

<!-- Functions.php -->
	<?php
	function sort_alphabetical($a, $b) {
	    return strcmp($a->post_title, $b->post_title);
	}
	function sort_rang($a, $b) {
	    $c = strcmp($b->contact_rang, $a->contact_rang);
	    return $c;
	}
?>



