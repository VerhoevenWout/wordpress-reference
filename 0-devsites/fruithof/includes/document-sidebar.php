	<header>
		<h2 class="page-title"><?= get_the_title(8); ?></h2>
	</header>
	<form role="search" method="get" id="sidebar-search-form" action="<?php echo home_url( '/' ); ?>">
	     <label class="search-field-label">
	         <input type="search" class="search-field" placeholder="zoek in de documenten" value="<?php echo get_search_query() ?>" name="s" title="zoek" />
	     </label>
	     <div class="search-submit">
	         <input type="submit" value="" />
	         <i class="icon-search"></i>
	     </div>
	     
	 </form>
	<section class="block filter-block">
		<div class="btn show-filters">
			<i class="icon-arrow-down"></i> <strong>Toon filters</strong>
		</div>

		<?php

		function return_main_terms() {
			$categories = get_the_terms( get_the_ID(), 'document-groepen' );

			$taxonomies = array( 
				'document-groepen',
			);
			
			// Get main document groups
			$mainArgs = array( 'hide_empty' => false, 'fields' => 'all', 'parent' => 0 );

			$mainTerms = get_terms($taxonomies, $mainArgs);

			echo '<ul class="list-contact-groepen">';

			foreach ( $mainTerms as $mainTerm ) :

			   echo "<li><a href='?mainTerm=" . $mainTerm->slug . "&mainTermID=" . $mainTerm->term_id . "'>" . $mainTerm->name . "</a></li>";
			endforeach;

			echo '</ul>';
		}


		

		function return_terms() {
						
			$categories = get_the_terms( get_the_ID(), 'document-groepen' );

			$taxonomies = array( 
				'document-groepen',
			);

			if ($_GET["mainTermID"]) {
				$mainTermID = $_GET["mainTermID"];
			} else {
				$mainTermID = 0;
			}

			$currentMainTerm = get_term_by('id', $mainTermID, $taxonomies[0]);

			// Get sub document groups
											 
			$document_links = array();
		 
			foreach ( $categories as $category ) {
				$document_links[] = $category->name;
			}

			$args = array(
				'orderby'           => 'name', 
				'order'             => 'ASC',
				'hide_empty'        => false, 
				'fields'            => 'all',
				'parent'            => $mainTermID,
				'hierarchical'      => true,
				'child_of'          => $mainTermID,
				'pad_counts'        => true,
				'cache_domain'      => 'core'    
			);

			$terms = get_terms($taxonomies, $args);

			$return .= '<a href="'. get_the_permalink() . '"><i class="icon-arrow-left"></i> Terug naar de hoofdgroepen</a>'; 

			$return .= '<h3>' . $currentMainTerm->name . '</h3>'; 

			$return .= '<ul class="list-contact-groepen">'; 

			foreach ( $terms as $term ) {
				if ($term->slug == $_GET["mainTerm"] || $term->slug == $_GET["term"] || $term->slug == $_GET["subTerm"] || $term->slug == $_GET["subsubTerm"] || $term->slug == $_GET["parent"] || $term->slug == $document_links[0]) {
					$activeTerm = "active-term";
					$checked = "checked";
				} else {
					$activeTerm = "";
					$checked = "";
				}

			  // return terms
			  $return .= sprintf(
				'<li id="category-%1$s" class="toggle '.$activeTerm.'">
					<input type="checkbox" id="toggle-%1$s" '.$checked.'>
					<label for="toggle-%1$s">&nbsp;</label>
					<a href="/documentbeheer/?term=%2$s&mainTermID='.$mainTermID.'">
						%2$s <span class="cat-count">(%3$s) </span>
					</a>',
				$term->term_id,
				$term->slug,
				$term->count
			  );

				$subterms = get_terms($taxonomies, array(
				  'parent'   => $term->term_id,
				  'hide_empty' => false
				  ));

				$return .= '<ul>';

				foreach ( $subterms as $subterm ) {

					if ($subterm->slug == $_GET["subTerm"] || $subterm->name == $document_links[1]) {
						$activeTerm = "active-term";
					} else {
						$activeTerm = "";
					}

					$subTermID = get_term($subterm->term_id, 'document-groepen');
					$termParent = ($subTermID->parent == 0) ? $subTermID : get_term($subTermID->parent, 'document-groepen');

					//return sub terms 
					$return .= sprintf(
						'<li id="category-%1$s" class="toggle '.$activeTerm.'">
						<a href="/documentbeheer/?subTerm=%3$s&parent=%5$s&mainTermID='.$mainTermID.'">
							%2$s <span class="cat-count">(%4$s) </span>
						</a>',
						$subterm->term_id,
						$subterm->name,
						$subterm->slug,
						$subterm->count,
						$termParent->slug
					);

						$subSubterms = get_terms($taxonomies, array(
						  'parent'   => $subterm->term_id,
						  'hide_empty' => false
						  ));

						$return .= '<ul>';

						foreach ( $subSubterms as $subSubterm ) {

							if ($subSubterm->slug == $_GET["subsubTerm"] || $subSubterm->name == $document_links[1]) {
								$activeTerm = "active-term";
							} else {
								$activeTerm = "";
							}

							$subSubTermID = get_term($subSubterm->term_id, 'document-groepen');

							$subtermParent = ($subSubTermID->parent == 0) ? $subSubTermID : get_term($subSubTermID->parent, 'document-groepen');

							//return sub sub terms 
							$return .= sprintf(
								'<li id="category-%1$s" class="toggle '.$activeTerm.'">
								<a href="/documentbeheer/?subTerm=%3$s&parent=%5$s&mainTermID='.$mainTermID.'">
									%2$s <span class="cat-count">(%4$s) </span>
								</a>',
								$subSubterm->term_id,
								$subSubterm->name,
								$subSubterm->slug,
								$subSubterm->count,
								$subtermParent->slug
							);

						  $return .= '</li>'; //end subsubterms li
						}            

						$return .= '</ul>'; //end subsubterms ul

				  $return .= '</li>'; //end subterms li
				}            

				$return .= '</ul>'; //end subterms ul

			  $return .= '</li>'; //end terms li
			} //end foreach term

		  $return .= '</ul>';

		return $return;
		}

		if (empty($_GET) || empty($_GET["mainTermID"])) {
			echo return_main_terms();
		} else {
			echo return_terms();
		}
		
		?>
	</section>