<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<small>Zoekresultaten voor</small> <span><?php echo esc_html( get_search_query() ); ?></span></h1>
			</header><!-- .page-header -->
			<ul class="search-results">
			<?php
				$searchPostType = array($_GET["type1"], $_GET["type2"], $_GET["type3"]);

				if ($_GET["type1"] || $_GET["type2"] || $_GET["type3"]) :
					$searchArgs = array( 
						'paged' => $paged, 
						's' => get_search_query(),
						'post_type' => $searchPostType,
						'posts_per_page' => 10
					);
				else :
					$searchArgs = array( 
						'paged' => $paged, 
						's' => get_search_query(),
						'posts_per_page' => 10
					);
				endif;

				//'post_type' => array( 'post', 'page', 'movie', 'book' )
				$searchQuery = get_search_query();

				// print_r($searchPostType[0]); echo "<br>";
				// 	print_r($searchPostType[1]); echo "<br>";
				// 		print_r($searchPostType[2]); echo "<br>";

				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			
				
			
				$wpSearchQuery = new WP_Query($searchArgs);

				// print_r($wpSearchQuery);

				if ( $wpSearchQuery->have_posts() ) :

					while ( $wpSearchQuery->have_posts() ) : $wpSearchQuery->the_post(); 

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						//get_template_part("includes/content-search");
			?>
					<li>
						<small><?php echo get_post_type( get_the_ID() ); ?></small>
						<a href="<?php the_permalink(); ?>" class="read-more"><?php echo get_the_title(); ?><i class="icon-arrow-right"></i> </a>
					</li>
						
			<?php endwhile; ?>
			
			</ul>
			<section class="pagination">
				<?php

					$big = 999999999; // need an unlikely integer
					 
					echo paginate_links( array(
					    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					    'format' => '?paged=%#%',
					    'current' => max( 1, get_query_var('paged') ),
					    'total' => $wpSearchQuery->max_num_pages
					) );
				?>
			</section>
				

			<?php
				else :
				    echo "<p>Geen resultaten gevonden voor <strong>'" . esc_html( get_search_query() ) . "'</strong>.</p>";

				endif;

			

			/* Restore original Post Data */
			wp_reset_postdata();

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		
		</main><!-- .site-main -->
	</section><!-- .content-area -->
<?php get_footer(); ?>
