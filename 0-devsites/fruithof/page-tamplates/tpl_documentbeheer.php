<?php
global $voltatheme;

// Template name: Documentbeheer

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
		$loadTerm = "document-groepen";
	} else {
		$loadTerm = $_GET["term"];
	}

	$mainTerm = get_term_by('term_id', $_GET["mainTermID"], 'document-groepen');

	$currentTerm = get_term_by('slug', $loadTerm, 'document-groepen');

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
		<i class="icon-arrow-right"></i> 
		<span>
			<a href="<?php the_permalink(); ?>?term=<?php echo $mainTerm->slug; ?>&mainTermID=<?php echo $mainTerm->term_id; ?>">
				<?php echo $mainTerm->name; ?>
			</a>
		</span>

		<i class="icon-arrow-right"></i> <span><?php echo $currentTerm->name; ?></span>

	<?php else: ?>
		<!-- <i class="icon-arrow-right"></i> 
		<span>
			<a href="<?php the_permalink(); ?>?term=Allochtonen">
				Allochtonen
			</a>
		</span> -->

	<?php endif; ?>
</section>
<aside class="sidebar sidebar-contactbeheer column small-12 xmedium-3">
	<?php get_template_part("includes/document-sidebar"); ?>
</aside>
<section class="block column small-12 xmedium-9">
	<section class="block contactbeheer-block column small-12">

		<?php
				
				$args = array(
					'post_type' => 'document',
					'posts_per_page' => -1,
					'tax_query' => array(
					    array(
					    'taxonomy' => 'document-groepen',
					    'field' => 'slug',
					    'terms' => $loadTerm
					    )
					  )
				);
				$query = new WP_Query( $args ); 


				if ( $query->have_posts() ) :
			?>
				<header>
					<h1 class="page-title"><?php echo $currentTerm->name; ?></h1>
				</header>
				<section class="contact-table">
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
							
							<?php the_title(); ?><br>
						<?php
							endwhile;
						endif;
						/* Restore original Post Data */
						wp_reset_postdata();
					?>
				</section>
				
	</section>
</section>


<?php 
endwhile;
get_footer(); 
?>