    <header>
        <h2 class="page-title"><?= get_the_title(6); ?></h2>
    </header>
   <form role="search" method="get" id="sidebar-search-form" action="<?php echo home_url( '/' ); ?>">
        <label class="search-field-label">
            <input type="search" class="search-field" placeholder="zoek in de contacten" value="<?php echo get_search_query() ?>" name="s" title="zoek" />
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

        function return_terms_index() {
          $categories = get_the_terms( get_the_ID(), 'contact-groepen' );
                                             
          $contact_links = array();
         
          foreach ( $categories as $category ) {
            $contact_links[] = $category->name;
          }

          $taxonomies = array( 
            'contact-groepen',
          );

          $args = array(
            'orderby'           => 'name', 
            'order'             => 'ASC',
            'hide_empty'        => true, 
            'fields'            => 'all',
            'parent'            => 0,
            'hierarchical'      => true,
            'child_of'          => 0,
            'pad_counts'        => true,
            'cache_domain'      => 'core'    
          );

          $terms = get_terms($taxonomies, $args);

          $return .= '<ul class="list-contact-groepen">'; 

            foreach ( $terms as $term ) {
                if ($term->name == $_GET["term"] || $term->name == $_GET["parent"] || $term->name == $contact_links[0]) {
                    $activeTerm = "active-term";
                    $checked = "checked";
                } else {
                    $activeTerm = "";
                    $checked = "";
                }

              // return terms (working)
              $return .= sprintf(
                '<li id="category-%1$s" class="toggle '.$activeTerm.'">
                    <input type="checkbox" id="toggle-%1$s" '.$checked.'>
                    <label for="toggle-%1$s">&nbsp;</label>
                    <a href="/contactbeheer/?term=%2$s">
                        %2$s <span class="cat-count">(%3$s) </span>
                    </a>',       
                $term->term_id,
                $term->name,
                $term->count
              );

                $subterms = get_terms($taxonomies, array(
                  'parent'   => $term->term_id,
                  'hide_empty' => true
                  ));

                $return .= '<ul>';

                foreach ( $subterms as $subterm ) {

                    if ($subterm->name == $_GET["term"] || $subterm->name == $contact_links[1]) {
                        $activeTerm = "active-term";
                    } else {
                        $activeTerm = "";
                    }

                    $subTermID = get_term($subterm->term_id, 'contact-groepen');
                    $termParent = ($subTermID->parent == 0) ? $subTermID : get_term($subTermID->parent, 'contact-groepen');

                    //return sub terms (not working :( )
                    $return .= sprintf(
                        '<li id="category-%1$s" class="toggle '.$activeTerm.'">
                        <a href="/contactbeheer/?term=%2$s&parent=%4$s">
                            %2$s <span class="cat-count">(%3$s) </span>
                        </a>',
                    $subterm->term_id,
                    $subterm->name,
                    $subterm->count,
                    $termParent->name
                    );

                  $return .= '</li>'; //end subterms li
                }            

                $return .= '</ul>'; //end subterms ul

              $return .= '</li>'; //end terms li
            } //end foreach term

          $return .= '</ul>';

        return $return;
        }

        echo return_terms_index();
        ?>
    </section>