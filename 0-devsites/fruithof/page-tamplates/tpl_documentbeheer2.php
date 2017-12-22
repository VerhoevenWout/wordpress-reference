<?php
global $voltatheme;

// Template name: Documentbeheer2

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
	
	if ($_GET["mainTerm"]):
		$getMainTerm = $_GET["mainTerm"];

		$mainTermArray = get_term_by('slug', $_GET["mainTerm"], 'document-groepen');
	endif;

	if ($_GET["term"] && $_GET["mainTermID"]):
		$getMainTerm = $_GET["mainTermID"];
		$getTerm = $_GET["term"];

		$mainTermArray = get_term_by('id', $_GET["mainTermID"], 'document-groepen');
		$termArray = get_term_by('slug', $_GET["term"], 'document-groepen');
	endif;

	if ($_GET["subTerm"] && $_GET["parent"] && $_GET["mainTermID"]):
		$getMainTerm = $_GET["mainTermID"];
		$getTerm = $_GET["parent"];
		$getSubTerm = $_GET["subTerm"];

		$mainTermArray = get_term_by('id', $_GET["mainTermID"], 'document-groepen');
		$termArray = get_term_by('slug', $_GET["parent"], 'document-groepen');
		$subTermArray = get_term_by('slug', $_GET["subTerm"], 'document-groepen');
	endif;

	if ($_GET["subsubTerm"] && $_GET["subTerm"] && $_GET["parent"] && $_GET["mainTermID"]):
		$getMainTerm = $_GET["mainTermID"];
		$getTerm = $_GET["parent"];
		$getSubTerm = $_GET["subTerm"];
		$getSubSubTerm = $_GET["subsubTerm"];

		$mainTermArray = get_term_by('id', $_GET["mainTermID"], 'document-groepen');
		$termArray = get_term_by('slug', $_GET["parent"], 'document-groepen');
		$subTermArray = get_term_by('slug', $_GET["subTerm"], 'document-groepen');
		$subSubTermArray = get_term_by('slug', $_GET["subsubTerm"], 'document-groepen');
	endif;

?>
<section class="breadcrumbs column small-12" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php 
    	if(function_exists('bcn_display')):
        	bcn_display();
		endif;
	?>
	<?php if ($mainTermArray) : ?> 
		<i class="icon-arrow-right"></i> 
		<span>
			<a href="<?php the_permalink(); ?>?mainTerm=<?php echo $mainTermArray->slug; ?>&mainTermID=<?php echo $mainTermArray->term_id; ?>">
				<?php echo $mainTermArray->name; ?>
			</a>
		</span>
	<?php endif; ?>

	<?php if ($termArray) : ?> 
		<i class="icon-arrow-right"></i> 
		<span>
			<a href="<?php the_permalink(); ?>?term=<?php echo $termArray->slug; ?>&mainTermID=<?php echo $mainTermArray->term_id; ?>">
				<?php echo $termArray->name; ?>
			</a>
		</span>
	<?php endif; ?>

	<?php if ($subTermArray) : ?> 
		<i class="icon-arrow-right"></i> 
		<span>
			<a href="<?php the_permalink(); ?>?subTerm=<?php echo $subTermArray->slug; ?>&parent=<?php echo $termArray->slug; ?>&mainTermID=<?php echo $mainTermArray->term_id; ?>">
				<?php echo $subTermArray->name; ?>
			</a>
		</span>
	<?php endif; ?>

	<?php if ($subSubTermArray) : ?> 
		<i class="icon-arrow-right"></i> 
		<span>
			<a href="<?php the_permalink(); ?>?subsubTerm=<?php echo $subSubTermArray->slug; ?>&subTerm=<?php echo $subTermArray->slug; ?>&parent=<?php echo $termArray->slug; ?>&mainTermID=<?php echo $mainTermArray->term_id; ?>">
				<?php echo $subSubTermArray->name; ?>
			</a>
		</span>
	<?php endif; ?>

	
</section>
<aside class="sidebar sidebar-contactbeheer column small-12 xmedium-4">
	<?php get_template_part("includes/document-sidebar"); ?>
</aside>
<section class="block column small-12 xmedium-8">
	<section class="block documentbeheer-block column small-12">

		<?php

		function return_files() {

			if ($_GET["term"]):
				$postTerm = $_GET["term"];
			elseif ($_GET["mainTerm"]): 
				$postTerm = $_GET["mainTerm"];
			elseif ($_GET["subsubTerm"]):
				$postTerm = $_GET["subsubTerm"];
			elseif ($_GET["subTerm"]):
				$postTerm = $_GET["subTerm"];
			else:
				$postTerm = "";
			endif;


			$currentTerm = get_term_by('slug', $postTerm, 'document-groepen');


			$termchildren = get_term_children( $currentTerm->term_id, 'document-groepen' );

			$fileArgs = array( 
				'posts_per_page' => -1,
				'post_type' => array('document', 'privatedocument'),
				'tax_query' => array(
			        array(
			            'taxonomy' 			=> 'document-groepen',
			            'field'   			=> 'ID',
			            'terms'    			=> $termchildren,
			            'operator' 			=> 'NOT IN'

			        ),
		            array(
		                'taxonomy' 			=> 'document-groepen',
		                'field'   			=> 'ID',
		                'terms'    			=> $currentTerm->term_id,
		                'operator' 			=> 'IN'

		            )
		        )
			);

			echo "<ul class='document-grid row'>";

			$files = get_posts( $fileArgs );
			foreach ( $files as $file ) : //print_r($file); ?>

				<?php if (get_field("docs_type", $file->ID ) == "file"): ?>

					<?php 

					$docFile = get_field("docs_file", $file->ID);

					if( $docFile ): ?>
						<li class="document">
							<?php $download_url = $docFile['url']; ?>
							<?php if (get_field("acf_password", $file->ID )): ?>
								<a href="<?php echo the_permalink($file->ID) ?>"><i class="icon-doc-download"></i> <span><?php echo $file->post_title; ?></span></a> 
							<?php else: ?>
								<a href="<?php echo the_permalink($file->ID) ?>"><i class="icon-doc-download"></i> <span><?php echo $file->post_title; ?></span></a>
							<?php endif; ?>
						</li>
					<?php else: ?>
						<li class="document">
							<a href="#">
								Geen bestand gevonden voor: <small><?php echo $file->post_title; ?></small>
							</a>							
						</li>

					<?php endif; ?>

				<?php elseif (get_field("docs_type", $file->ID ) == "url"): ?>

					<li class="document">
						<a href="<?php echo get_field("docs_url", $file->ID ); ?>"><i class="icon-doc-link"></i> <span><?php echo $file->post_title; ?></span></a>
					</li>

				<?php elseif (get_field("docs_type", $file->ID ) == "txt"): ?>
					<li class="document">
						<a href="<?php echo $file->guid; ?>"><i class="icon-doc-text"></i> <span><?php echo $file->post_title; ?></span></a>
					</li>
				<?php else: ?>
					<li class="document">
						Geen document gevonden voor <?php echo $file->post_title; ?>
					</li>
				<?php endif; ?>
				
				
			<?php endforeach; 
			echo "</ul>";
		}



		function return_main_docterms() {

			$taxonomies = array( 
				'document-groepen',
			);
			
			// Get main document groups
			$mainArgs = array( 'hide_empty' => false, 'fields' => 'all', 'parent' => 0 );

			$mainTerms = get_terms($taxonomies, $mainArgs);

			echo '<ul class="folder-grid row">';

			foreach ( $mainTerms as $mainTerm ) :
			    echo "<li class='folder'>";
					echo "<div>";
						if ($mainTerm->count == 0) :
							
							echo "<img src='/wp-content/themes/fruithof/includes/svg/folder-empty.svg' />";
							echo "<span>" . $mainTerm->name . " <small>" . $mainTerm->count . " documenten</small></span>";
							
						else:
							echo "<a href='?mainTerm=" . $mainTerm->slug . "&mainTermID=" . $mainTerm->term_id . "'>";
								echo "<img src='/wp-content/themes/fruithof/includes/svg/folder-full.svg' />";
								echo "<span>" . $mainTerm->name . " <small>" . $mainTerm->count . " documenten</small></span>";
							echo "</a>";
						endif;
					echo "</div>";
						
				echo "</li>";
			endforeach;

			echo return_files();

			echo '</ul>';
		}

		function return_docterms() {

			$taxonomies = array( 
				'document-groepen',
			);
			
			$mainTermID = $_GET["mainTermID"];

			$args = array(
				'orderby'           => 'name', 
				'order'             => 'ASC',
				'hide_empty'        => false, 
				'fields'            => 'all',
				'parent'            => $mainTermID,
				'hierarchical'      => true,
				'child_of'          => $mainTermID  
			);

			$terms = get_terms($taxonomies, $args);

			echo '<ul class="folder-grid row">'; 

			foreach ( $terms as $term ) {

			    echo "<li class='folder'>";

					echo "<div>";
						if ($term->count == 0) :
							
							echo "<img src='/wp-content/themes/fruithof/includes/svg/folder-empty.svg' />";
							echo "<span>" . $term->name . " <small>" . $term->count . " documenten</small></span>";
							
						else:
							echo "<a href='?term=" . $term->slug . "&mainTermID=" . $_GET["mainTermID"] . "'>";
								echo "<img src='/wp-content/themes/fruithof/includes/svg/folder-full.svg' />";
								echo "<span>" . $term->name . " <small>" . $term->count . " documenten</small></span>";
							echo "</a>";
						endif;
					echo "</div>";
				echo "</li>";

			} //end foreach term

			echo '</ul>';

			echo return_files();

		}

		function return_sub_docterms() {


			$taxonomies = array( 
				'document-groepen',
			);
			
			if ($_GET["term"]):
				$parentTerm = $_GET["term"];
			elseif ($_GET["subTerm"]): 
				$parentTerm = $_GET["subTerm"];
			endif;
			

			$currentTerm = get_term_by('slug', $parentTerm, $taxonomies[0]);

			$args = array(
				'orderby'           => 'name', 
				'order'             => 'ASC',
				'hide_empty'        => false, 
				'fields'            => 'all',
				'parent'            => $currentTerm->term_id,
				'hierarchical'      => true,
				'child_of'          => $currentTerm->term_id  
			);

			$terms = get_terms($taxonomies, $args);

			echo '<ul class="folder-grid row">'; 

			foreach ( $terms as $term ) {

			    echo "<li class='folder'>";

					echo "<div>";
						if ($term->count == 0) :
							
							echo "<img src='/wp-content/themes/fruithof/includes/svg/folder-empty.svg' />";
							echo "<span>" . $term->name . " <small>" . $term->count . " documenten </small></span>";

						elseif ($_GET["subTerm"]):
							echo "<a href='?subsubTerm=" . $term->slug . "&subTerm=" . $_GET["subTerm"] . "&parent=" . $_GET["parent"] . "&mainTermID=" . $_GET["mainTermID"] . "'>";
								echo "<img src='/wp-content/themes/fruithof/includes/svg/folder-full.svg' />";
								echo "<span>" . $term->name . " <small>" . $term->count . " documenten </small></span>";
							echo "</a>";
						else:
							echo "<a href='?subTerm=" . $term->slug . "&parent=" . $_GET["term"] . "&mainTermID=" . $_GET["mainTermID"] . "'>";
								echo "<img src='/wp-content/themes/fruithof/includes/svg/folder-full.svg' />";
								echo "<span>" . $term->name . " <small>" . $term->count . " documenten </small></span>";
							echo "</a>";
						endif;
					echo "</div>";
				echo "</li>";

			} //end foreach term

			echo '</ul>';

			echo return_files();

		}


		if ($_GET["term"]):
			echo return_sub_docterms();
		elseif ($_GET["mainTerm"]): 
			echo return_docterms();
		elseif ($_GET["subsubTerm"]):
			echo return_files();
		elseif ($_GET["subTerm"]):
			echo return_sub_docterms();
		else:
			echo return_main_docterms();
		endif;


		?>
	</section>
</section>


<?php 
endwhile;
get_footer(); 
?>