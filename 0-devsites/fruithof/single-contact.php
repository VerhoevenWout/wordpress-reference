<?php

get_header(); 
while ( have_posts() ) : the_post();
?>

<?php

	$categories = get_the_terms( get_the_ID(), 'contact-groepen' );
                      				 
    $contact_links = array();
 
    foreach ( $categories as $category ) {
        $contact_links[] = $category->name;
    }
                         
    $contacts = join( " / ", $contact_links );


    // if ($_GET["term"] == "allochtonen") {
    // 	$loadTerm = "allochtonen";
    // } else if ($_GET["term"] == "") {
    // 	$activeTerm = $contact_links[0];
    // } else {
    // 	$loadTerm = $_GET["term"];
    // }

    // echo $activeTerm;
?>


<?php 
	
	// Form handling

	if ($_SERVER["REQUEST_METHOD"] == "POST") :

		if ( $_POST["contact_adres"] ) {
			$contact_adres_key = "field_5804be95897fa";
			$contact_adres_value = $_POST["contact_adres"];
			update_field( $contact_adres_key, $contact_adres_value, $post_id );
		}

		if ( $_POST["contact_gemeente"] ) {
			$contact_gemeente_key = "field_5804bea2897fb";
			$contact_gemeente_value = $_POST["contact_gemeente"];
			update_field( $contact_gemeente_key, $contact_gemeente_value, $post_id );
		}
		
		if ( $_POST["contact_organisatie"] ) {
			$contact_organisatie_key = "field_5804bf3f89800";
			$contact_organisatie_value = $_POST["contact_organisatie"];
			update_field( $contact_organisatie_key, $contact_organisatie_value, $post_id );
		}
		
		if ( $_POST["contact_tel_dienst"] ) {
			$contact_tel_dienst_key = "field_5804bf5389801";
			$contact_tel_dienst_value = $_POST["contact_tel_dienst"];
			update_field( $contact_tel_dienst_key, $contact_tel_dienst_value, $post_id );
		}
		
		if ( $_POST["contact_tel_werk"] ) {
			$contact_tel_werk_key = "field_5804bedb897fd";
			$contact_tel_werk_value = $_POST["contact_tel_werk"];
			update_field( $contact_tel_werk_key, $contact_tel_werk_value, $post_id );
		}
		
		if ( $_POST["contact_tel_prive"] ) {
			$contact_tel_prive_key = "field_5804bf1f897ff";
			$contact_tel_prive_value = $_POST["contact_tel_prive"];
			update_field( $contact_tel_prive_key, $contact_tel_prive_value, $post_id );
		}
		
		if ( $_POST["contact_gsm"] ) {
			$contact_gsm_key = "field_5804d6650510f";
			$contact_gsm_value = $_POST["contact_gsm"];
			update_field( $contact_gsm_key, $contact_gsm_value, $post_id );
		}
		
		if ( $_POST["contact_fax"] ) {
			$contact_fax_key = "field_5804bf12897fe";
			$contact_fax_value = $_POST["contact_fax"];
			update_field( $contact_fax_key, $contact_fax_value, $post_id );
		}
		
		if ( $_POST["contact_email"] ) {
			$contact_email_key = "field_5804beb7897fc";
			$contact_email_value = $_POST["contact_email"];
			update_field( $contact_email_key, $contact_email_value, $post_id );
		}
		
		if ( $_POST["contact_web"] ) {
			$contact_web_key = "field_5804bf6a89802";
			$contact_web_value = $_POST["contact_web"];
			update_field( $contact_web_key, $contact_web_value, $post_id );
		}
		
		if ( $_POST["contact_rang"] ) {
			$contact_rang_key = "field_5806097ccdd3a";
			$contact_rang_value = $_POST["contact_rang"];
			update_field( $contact_rang_key, $contact_rang_value, $post_id );
		}
		
		if ( $_POST["contact_opmerkingen"] ) {
			$contact_opmerkingen_key = "field_5804bf7e89803";
			$contact_opmerkingen_value = $_POST["contact_opmerkingen"];
			update_field( $contact_opmerkingen_key, $contact_opmerkingen_value, $post_id );
		}
	endif;
?>


<aside class="sidebar sidebar-contactbeheer column small-12 xmedium-3">
	<?php get_template_part("includes/contact-sidebar"); ?>
</aside>
<section class="block column small-12 xmedium-9">
	<?php if ($_GET['edit-contact'] != "true"): ?>
	<article class="block single-contact-block column small-12 row">
		<main class="column small-12 medium-6">
			<header>
				<h1>
					<?php the_title(); ?>
					<small><?php echo $contacts; ?></small>			
				</h1>
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
			</ul>
		</main>
		<aside class="column small-12 medium-6 large-4">
			<section class="contact-rang">
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
			</section>
			<section class="contact-opmerking">
				<strong>Opmerkingen</strong>
				<?php the_field("contact_opmerkingen"); ?>
			</section>
		</aside>
		<footer class="column small-12">
			<a href="?edit-contact=true" class="btn">Aanpassen</a>
			<a href="#" class="btn">Print contact</a>
		</footer>
	</article>
	<?php else: ?>
		<form class="block single-contact-block edit-single-contact-block column small-12 row" method="post" action="<?php the_permalink(); ?>">
			<main class="column small-12 medium-6">
				<header>
					<h1>
						<?php the_title(); ?>
						<small><?php echo $contacts; ?></small>			
					</h1>
				</header>
				<ul>
					<li>
						<strong>Adres</strong>
						<span><input type="text" name="contact_adres" placeholder="straat + nr" value="<?php the_field("contact_adres"); ?>"></span>
						<span><input type="text" name="contact_gemeente" placeholder="Postcode + Gemeente" value="<?php the_field("contact_gemeente"); ?>"></span>
					</li>
					
					<li>
						<strong>Organisatie</strong>
						<span><input type="text" name="contact_organisatie" placeholder="Naam organisatie" value="<?php the_field("contact_organisatie"); ?>"></span>
					</li>

					<li>
						<strong>Telefoon</strong>
						<table>
							<tr>
								<td>Dienst</td>
								<td><input type="text" name="contact_tel_dienst" placeholder="Tel dienst" value="<?php the_field("contact_tel_dienst"); ?>"></td>
							</tr>
							<tr>
								<td>Werk</td>
								<td><input type="text" name="contact_tel_werk" placeholder="Tel werk" value="<?php the_field("contact_tel_werk"); ?>"></td>
							</tr>
							<tr>
								<td>Privé</td>
								<td><input type="text" name="contact_tel_prive" placeholder="Tel privé" value="<?php the_field("contact_tel_prive"); ?>"></td>
							</tr>
							<tr>
								<td>GSM</td>
								<td><input type="text" name="contact_gsm" placeholder="Gsm nr" value="<?php the_field("contact_gsm"); ?>"></td>
							</tr>
						</table>
					</li>

					<li>
						<strong>Fax</strong>
						<span><input type="text" name="contact_fax" placeholder="Fax nr" value="<?php the_field("contact_fax"); ?>"></span>
					</li>

					<li>
						<strong>Email</strong>
						<span><input type="text" name="contact_email" placeholder="Email adres" value="<?php the_field("contact_email"); ?>"></span>
					</li>

					<li>
						<strong>Web</strong>
						<input type="text" name="contact_web" placeholder="Website" value="<?php the_field("contact_web"); ?>">
					</li>
				</ul>
			</main>
			<aside class="column small-12 medium-6 large-4">
				<section class="contact-rang">
					<i class="icon-star"></i> <input type="number" name="contact_rang" min="0" max="5" value="<?php the_field("contact_rang"); ?>">
				</section>
				<section class="contact-opmerking">
					<strong>Opmerkingen</strong>
					<textarea name="contact_opmerkingen" placeholder="Opmerkingen"><?php echo strip_tags(get_field("contact_opmerkingen")); ?></textarea>
				</section>
			</aside>
			<footer class="column small-12">
				<input type="submit" value="Werk bij" class="btn btn-green">
				<a href="<?php the_permalink(); ?>" class="btn">Annuleer</a>
			</footer>
		</form>
	<?php endif; ?>
</section>
<?php 
endwhile;
get_footer(); 
?>