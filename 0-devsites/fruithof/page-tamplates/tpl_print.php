<?php
global $voltatheme;

// Template name: Print page

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

<section class="print-block block column small-12 row">
	
	<article class="block single-contact-block column small-12 row">
		<div class="column small-12">
			<button onclick="myFunction()" class="btn">Deze pagina afdrukken?</button>
		</div>	
	</article>

	<script>
	function myFunction() {
	    window.print();
	}
	</script>

	<?php
		$myposts = array();
		$myposts_expanded = array();
		$checks = array();

		if(!empty($_POST['select-contact'])) :
		    foreach($_POST['select-contact'] as $check) :
		    	array_push($checks, $check);
		    endforeach;

	    	$args = array( 
	    		'post_type' 		=> 'contact', 
	    		'posts_per_page' 	=> -1, 
	    		'include' 			=> $checks,
	    	);
	    	$myposts = get_posts( $args );

    	 	foreach ($myposts as $post):
    			$post->contact_rang = get_field("contact_rang");
	    	endforeach;
		
	    	usort($myposts, "sort_alphabetical");
	    	usort($myposts, "sort_rang");

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

		<article class="block single-contact-block column small-12 row">
			<div class="column small-12">
				<button onclick="myFunction()" class="btn">Deze pagina afdrukken?</button>
			</div>	
		</article>
</section>


<?php 
endwhile;
get_footer(); 
?>

