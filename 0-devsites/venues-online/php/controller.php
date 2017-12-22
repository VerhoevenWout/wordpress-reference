<?php

/**
 * get_fiches()
 * 
 * Will get all fiches by a certain post
 *
 * @param $meta_key                     the meta_key that connects both the given post and the fiche        
 * @param $meta_value                   the post ID
 *
 */
function get_fiches($meta_key, $meta_value) {
    global $wpdb;
 
    // FOR SEOPAGES WORKS
    $prepared_query = $wpdb->prepare('
        SELECT DISTINCT pm.post_id, p.*, t.language_code 
        FROM ' . $wpdb->prefix . 'posts AS p 
        JOIN ' . $wpdb->prefix . 'icl_translations AS t on p.ID=t.element_id 
        JOIN ' . $wpdb->prefix . 'postmeta AS pm ON p.ID=pm.post_id 
        WHERE t.element_type = "post_venues" 
        AND pm.meta_value = %d
        ORDER BY p.post_title ASC, t.language_code DESC', $meta_value);

    error_log($prepared_query);

    $result = $wpdb->get_results($prepared_query);
    return $result;
}

function get_seo_posts_by_webpartnerid($webpartnerid, $type) {
    global $wpdb;
 
    $prepared_query = $wpdb->prepare('
        SELECT DISTINCT p.ID as post_id, p.*, t.language_code 
        FROM ' . $wpdb->prefix . 'posts AS p 
        JOIN ' . $wpdb->prefix . 'icl_translations AS t on p.ID=t.element_id 
        WHERE t.element_type = "%s" AND p.webpartnerid = "%s"
        ORDER BY p.post_title ASC, t.language_code DESC', $type, $webpartnerid);

    // var_dump($prepared_query);

    $result = $wpdb->get_results($prepared_query);
 
    return $result;
}

function get_posts_by_webpartnerid($webpartnerid, $type) {
    global $wpdb;
 
    $prepared_query = $wpdb->prepare('
        SELECT DISTINCT p.ID as post_id, p.*, t.language_code 
        FROM ' . $wpdb->prefix . 'posts AS p 
        JOIN ' . $wpdb->prefix . 'icl_translations AS t on p.ID=t.element_id
        JOIN ' . $wpdb->prefix . 'postmeta AS pm on p.ID=pm.post_id
        WHERE p.post_type = "%s" AND pm.meta_key = "venue_id" AND pm.meta_value = "%s"
        ORDER BY p.post_title ASC, t.language_code DESC', $type, $webpartnerid);

    // var_dump($prepared_query);

    $result = $wpdb->get_results($prepared_query);
 
    return $result;
}

function get_fiches_by_termmeta($meta_key, $meta_value, $category_id, $lang, $quantity, $operator, $action) {
    // global $wpdb;

    // $prepared_query = $wpdb->prepare('
    //     SELECT DISTINCT p.*, coalesce((select meta_value from ' . $wpdb->prefix . 'postmeta where post_id = p.ID and meta_key = %s),0)*1 as list
    //     FROM ' . $wpdb->prefix . 'posts AS p 
    //     JOIN ' . $wpdb->prefix . 'icl_translations AS t on p.ID = t.element_id 
    //     JOIN ' . $wpdb->prefix . 'termmeta AS tm ON p.ID = tm.meta_value 
    //     JOIN ' . $wpdb->prefix . 'term_relationships tr ON tr.object_id = p.ID
    //     JOIN ' . $wpdb->prefix . 'term_taxonomy tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
    //     WHERE p.post_status = "publish" and tm.meta_key = %s AND tm.term_id = %d AND tt.taxonomy = "fiche_category" AND tt.term_id ' . $operator . ' %d
    //     ORDER BY list, rand() LIMIT %d', $action, $meta_key, $meta_value, $category_id, $quantity);

    // $result = $wpdb->get_results($prepared_query);

    // shuffle($result);
 
    // return $result;
}

/**
 * get_fiches_exclude()
 * 
 * Will get all fiches LIKE $data, not connected to a given post or user.
 *
 * @param $meta_key                         the key to check the connection between both the post/user and the fiche
 * @param $meta_value                       the ID of the given post or user
 * @param $data                             the search query, eg. "alm"
 * @param $lang                             the language, eg. "nl"
 *
 */
function get_fiches_exclude($meta_key, $meta_value, $data, $lang = NULL) {
	global $wpdb;
	$search = '%' . $wpdb->esc_like($data) . '%';

    if (isset($lang)) {
        $prepared_query = $wpdb->prepare('
            SELECT p.*, t.language_code
            FROM ' . $wpdb->prefix . 'posts AS p 
            JOIN ' . $wpdb->prefix . 'icl_translations AS t on p.ID=t.element_id 
            WHERE t.element_type = "post_venues" AND t.language_code = "%s" AND p.post_type = "venues" AND p.post_title LIKE %s AND p.ID NOT IN (
                SELECT post_id FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = "%s" AND meta_value = %d
            )
            ORDER BY p.post_title ASC, t.language_code DESC', $lang, $search, $meta_key, $meta_value);
    } else {
        $prepared_query = $wpdb->prepare('
            SELECT p.*, t.language_code
            FROM ' . $wpdb->prefix . 'posts AS p 
            JOIN ' . $wpdb->prefix . 'icl_translations AS t on p.ID=t.element_id 
            WHERE t.element_type = "post_venues" AND p.post_type = "venues" AND p.post_title LIKE %s AND p.ID NOT IN (
                SELECT post_id FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = "%s" AND meta_value = %d
            )
            ORDER BY p.post_title ASC, t.language_code DESC', $search, $meta_key, $meta_value);
    }

    $result = $wpdb->get_results($prepared_query);
 
    return $result;
}


/**
 * get_seopages_by_fiche()
 * 
 * Will get all SEO pages from a certain fiche
 *
 * @param $post_id                          the ID of the fiche
 *
 */
// function get_seopages_by_fiche($post_id) {
//     global $wpdb;

//     $order = "p.post_title ASC, t.language_code DESC";

//     $prepared_query = $wpdb->prepare('
//         SELECT DISTINCT pm.post_id, p.*, t.language_code 
//         FROM ' . $wpdb->prefix . 'posts AS p 
//         JOIN ' . $wpdb->prefix . 'icl_translations AS t on p.ID=t.element_id 
//         JOIN ' . $wpdb->prefix . 'postmeta AS pm ON p.ID=pm.meta_value 
//         WHERE pm.meta_key = "_fiche_seopage" AND pm.post_id = %d
//         ORDER BY ' . $order . ';', $post_id);

//     $result = $wpdb->get_results($prepared_query);
 
//     return $result;
// }


/**
 * get_fiches_exclude_user()
 * 
 * Will get all SEO pages LIKE $data, not connected to a certain fiche.
 *
 * @param $data                             the search query, eg. "alm"
 * @param $post_id                          the ID of the fiche
 * @param $lang                             the language, eg. "nl"
 *
 */
function get_seopages_exclude_fiche($data, $post_id, $lang = NULL) {
    // global $wpdb;
    // $search = '%' . $wpdb->esc_like($data) . '%';

    // if (isset($lang)) {
    //     $prepared_query = $wpdb->prepare('
    //         SELECT p.*, t.language_code 
    //         FROM ' . $wpdb->prefix . 'posts p
    //         JOIN ' . $wpdb->prefix . 'icl_translations t on p.ID=t.element_id
    //         WHERE t.element_type = "post_seopage" AND t.language_code = "%s" AND p.post_type = "seopage" AND p.post_title LIKE %s AND p.ID NOT IN (
    //             SELECT meta_value FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = "_fiche_seopage" AND post_id = %d
    //         )
    //         ORDER BY p.post_title ASC, t.language_code DESC', $lang, $search, $post_id);
    // } else {
    //     $prepared_query = $wpdb->prepare('
    //         SELECT p.*, t.language_code 
    //         FROM ' . $wpdb->prefix . 'posts p
    //         JOIN ' . $wpdb->prefix . 'icl_translations t on p.ID=t.element_id
    //         WHERE t.element_type = "post_seopage" AND p.post_type = "seopage" AND p.post_title LIKE %s AND p.ID NOT IN (
    //             SELECT meta_value FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = "_fiche_seopage" AND post_id = %d
    //         )
    //         ORDER BY p.post_title ASC, t.language_code DESC', $search, $post_id);
    // }

    // $result = $wpdb->get_results($prepared_query);
 
    // return $result;
}


function get_regions($post_id = null, $meta_key = null, $lang = NULL, $showEmpty = true, $hierarchical = true) {
    // global $wpdb;

    // $query = null;
    // $parents_included = false;

    // if ($post_id && $meta_key && $lang && $showEmpty) {
    //     $query = $wpdb->prepare('
    //         SELECT DISTINCT terms.*, tax.taxonomy, tax.parent AS parent_id, parents.name AS parent_name, (CASE WHEN checked.meta_value IS NOT null
    //            THEN
    //                true
    //            ELSE
    //                false
    //            END) AS checked
    //         FROM ' . $wpdb->prefix . 'terms as terms
    //         JOIN ' . $wpdb->prefix . 'term_taxonomy AS tax ON tax.term_id = terms.term_id
    //         JOIN ' . $wpdb->prefix . 'icl_translations t on tax.term_taxonomy_id = t.element_id AND t.language_code = %s AND t.element_type LIKE "tax_%%"
    //         LEFT JOIN ' . $wpdb->prefix . 'terms AS parents ON parents.term_id = tax.parent
    //         LEFT JOIN ' . $wpdb->prefix . 'termmeta AS checked ON checked.term_id = terms.term_id AND checked.meta_value = %d AND checked.meta_key = %s
    //         WHERE tax.taxonomy = "fiche_region"
    //         ORDER BY parent_id, term_id, parent_name, name;', $lang, $post_id, $meta_key);

    //     $parents_included = true;

    //     //wp_die($query);

    // } else if ($post_id && $meta_key && $showEmpty) {
    //     $query = $wpdb->prepare('
    //         SELECT terms.*, tax.taxonomy, tax.parent AS parent_id, parents.name AS parent_name, (CASE WHEN checked.meta_value IS NOT null
    //            THEN
    //                true
    //            ELSE
    //                false
    //            END) AS checked
    //         FROM ' . $wpdb->prefix . 'terms as terms
    //         JOIN ' . $wpdb->prefix . 'term_taxonomy AS tax ON tax.term_id = terms.term_id
    //         LEFT JOIN ' . $wpdb->prefix . 'terms AS parents ON parents.term_id = tax.parent
    //         LEFT join ' . $wpdb->prefix . 'termmeta AS checked on checked.term_id = terms.term_id AND checked.meta_value = %d AND checked.meta_key = %s
    //         WHERE tax.taxonomy = "fiche_region"
    //         ORDER BY parent_id, term_id, parent_name, name;', $post_id, $meta_key);

    //     $parents_included = true;

    // } else if ($post_id && $meta_key && !$showEmpty) {
    //     $query = $wpdb->prepare('
    //         SELECT terms.term_id
    //         FROM ' . $wpdb->prefix . 'terms as terms
    //         JOIN ' . $wpdb->prefix . 'term_taxonomy AS tax ON tax.term_id = terms.term_id
    //         LEFT JOIN ' . $wpdb->prefix . 'terms AS parents ON parents.term_id = tax.parent
    //         JOIN ' . $wpdb->prefix . 'termmeta as checked ON checked.term_id = terms.term_id AND checked.meta_value = %d AND checked.meta_key = %s
    //         WHERE tax.taxonomy = "fiche_region";', $post_id, $meta_key);

    //     $parents_included = true;

    // } else {
    //     $query = '
    //         SELECT terms.*, tax.taxonomy, tax.parent AS parent_id, parents.name AS parent_name, parents.slug AS parent_slug
    //         FROM ' . $wpdb->prefix . 'terms AS terms
    //         JOIN ' . $wpdb->prefix . 'term_taxonomy AS tax ON terms.term_id=tax.term_id
    //         JOIN ' . $wpdb->prefix . 'terms AS parents ON parents.term_id = tax.parent
    //         WHERE tax.taxonomy = "fiche_region" AND tax.parent > 0
    //         ORDER BY parent_name, name;';
    // }

    // $result = $wpdb->get_results($query);
    // $regions = $result;

    // if (isset($hierarchical) && $hierarchical == true && !$parents_included) {
    //     $regions = [];

    //     $prev = NULL;
    //     $i = $result[0]->parent_slug;
    //     // $i will always be the current parent term, eg. "belgie", take note this is the slug.

    //     $regions[$i] = new stdClass();
    //     $regions[$i]->term_id = $result[0]->parent_id;
    //     $regions[$i]->name = $result[0]->parent_name;
    //     $regions[$i]->slug = $result[0]->parent_slug;
    //     $regions[$i]->children = [];

    //     foreach ($result as $r) {

    //         if (isset($prev) && $prev->parent_slug != $r->parent_slug) {
    //             //nieuwe parent => nieuwe top level
    //             $i = $r->parent_slug;
                
    //             $regions[$i] = new stdClass();
    //             $regions[$i]->term_id = $r->parent_id;
    //             $regions[$i]->name = $r->parent_name;
    //             $regions[$i]->slug = $r->parent_slug;
    //             $regions[$i]->children = [];
    //         } 

    //         array_push($regions[$i]->children, $r);

    //         $prev = $r;
    //         $i = $r->parent_slug;
    //     }
    // } else if (isset($hierarchical) && $hierarchical == true && $parents_included) {
    //     $regions = [];

    //     foreach ($result as $r) {
    //         if ($r->parent_id == 0) {
    //             $r->children = [];
    //             $regions[$r->term_id] = $r;
    //         } else {
    //             $regions[$r->parent_id]->children[$r->term_id] = $r;
    //         }
    //     }
    // }
    
    // return $regions;
}

function get_terms_by_category($term_id, $taxonomy, $region_slug = null, $region_slug_operator = '=', $region_term_id = null) {
    // global $wpdb;
    // $query = null;

    // $initial_query = '
    //     SELECT terms.*, tax.taxonomy, tax.parent AS parent_id, parents.name AS parent_name, parents.slug AS parent_slug
    //     FROM ' . $wpdb->prefix . 'terms as terms
    //     JOIN ' . $wpdb->prefix . 'term_taxonomy AS tax ON tax.term_id = terms.term_id
    //     LEFT JOIN ' . $wpdb->prefix . 'terms AS parents ON parents.term_id = tax.parent
    //     WHERE ';

    // if($taxonomy=='fiche_region')
    // {
    //     $initial_query = $initial_query . 'tax.parent > 0 and ';
    // }

    // if($region_slug)
    // {
    //     $initial_query = $initial_query . 'parents.slug ' . $region_slug_operator .  ' "' . $region_slug . '" and ';
    // }

    // $initial_query = $initial_query . 'tax.taxonomy = %s and tax.term_taxonomy_id in (
    //         select term_taxonomy_id from ' . $wpdb->prefix . 'term_relationships where object_id in (
    //             select object_id from ' . $wpdb->prefix . 'term_taxonomy
    //             join ' . $wpdb->prefix . 'term_relationships on (' . $wpdb->prefix . 'term_relationships.term_taxonomy_id = ' . $wpdb->prefix . 'term_taxonomy.term_taxonomy_id)
    //             join ' . $wpdb->prefix . 'posts on ' . $wpdb->prefix . 'posts.id = ' . $wpdb->prefix . 'term_relationships.object_id

    //             join ' . $wpdb->prefix . 'postmeta on ' . $wpdb->prefix . 'postmeta.post_id = ' . $wpdb->prefix . 'posts.id and ' . $wpdb->prefix . 'postmeta.meta_key = "showinresults" and ' . $wpdb->prefix . 'postmeta.meta_value = 1

    //             where taxonomy = "fiche_category" and ' . $wpdb->prefix . 'term_taxonomy.term_id = %d and ' . $wpdb->prefix . 'posts.post_status = "publish"
    //         )';

    //         // addon for region selection
    //         if($region_term_id)
    //         {
    //             $initial_query = $initial_query . 'and object_id in (
    //         select object_id from ' . $wpdb->prefix . 'term_taxonomy
    //         join ' . $wpdb->prefix . 'term_relationships on (' . $wpdb->prefix . 'term_relationships.term_taxonomy_id = ' . $wpdb->prefix . 'term_taxonomy.term_taxonomy_id)
    //         join ' . $wpdb->prefix . 'posts on ' . $wpdb->prefix . 'posts.id = ' . $wpdb->prefix . 'term_relationships.object_id
    //         join ' . $wpdb->prefix . 'postmeta on ' . $wpdb->prefix . 'postmeta.post_id = ' . $wpdb->prefix . 'posts.id and ' . $wpdb->prefix . 'postmeta.meta_key = "showinresults" and ' . $wpdb->prefix . 'postmeta.meta_value = 1
    //         where
    //             taxonomy = "fiche_region" and
    //             ' . $wpdb->prefix . 'term_taxonomy.term_id = ' . $region_term_id . ' and
    //             ' . $wpdb->prefix . 'posts.post_status = "publish"
    //     )';
    //         }

    //     $initial_query = $initial_query . ')
    //     ORDER BY parent_name, name;';

    // $query = $wpdb->prepare($initial_query, $taxonomy, $term_id);

    // // var_dump($query);

    // $result = $wpdb->get_results($query);
    // $regions = $result;

    //  return $regions;
}

function get_search($s) {
    // $args = array(
    //     's' => $s,
    //     'sentence' => true,
    //     'post_type' => 'fiche',
    //     'meta_key' => 'showinresults', 
    //     'meta_value' => 1,
    //     'orderby' => 'title',
    //     'order' => 'ASC',
    //     'posts_per_page'   => 15,
    //     'suppress_filters' => false
    // );

    // $posts = get_posts($args);

    // foreach ($posts as $post) {
    //     // change guid to permalink for use in search results
    //     $post->guid = get_permalink($post);
    // }

    // return $posts;
}

function get_page_by_slug($page_slug, $lang, $output = OBJECT, $post_type = 'page' ) { 
    // global $wpdb; 
    // $page = $wpdb->get_var( $wpdb->prepare( '
    //     SELECT ID 
    //     FROM ' . $wpdb->prefix . 'posts p
    //     JOIN ' . $wpdb->prefix . 'icl_translations t on p.ID = t.element_id AND t.language_code = %s
    //     WHERE post_name = %s AND post_type= %s AND post_status = "publish"', $lang, $page_slug, $post_type ) ); 
    // if ( $page ) 
    //     return get_post($page, $output); 
    // return null; 
}