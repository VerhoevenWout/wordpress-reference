<?php

class FicheMeta {
  const LANG = 'venuesonline';
  const POST_TYPE = 'venues';

  public function __construct() {
    add_action( 'add_meta_boxes', array( $this, 'add_seo_page_meta_box' ) );
    add_action( 'save_post', array( $this, 'save_fiche_meta_data'), 10, 2 ); 
  }

  public function add_seo_page_meta_box() {
    add_meta_box( 
      'custom_meta_box' ,
      __( 'Connections', self::LANG ),
      array( &$this, 'render_meta_box_content' ),
      self::POST_TYPE, 
      'advanced',
      'high'
      );
  }

  public function save_fiche_meta_data( $post_id, $post_object ) {

    add_term_meta(3, "_featured_post", "save_init");
    // wp_die( 'Succes! <br><pre>'. print_r( $post_object, true) . '</pre>' );


    if ( ! isset( $_POST['custom_meta_box_nonce'] ) ) {
        return $post_id;
    }

    $nonce = $_POST['custom_meta_box_nonce'];

    if ( ! wp_verify_nonce( $nonce, 'custom_meta_box' ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( $_POST['post_type'] == 'page' ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
    }

    $featured = $_POST['featured'];
    $recommended = $_POST['recommended'];

    if (isset($featured) || isset($recommended)) {
      if (isset($featured)) {
        self::handle_term_meta($featured, "_featured_post", $post_id);
      }

      if (isset($recommended)) {
        self::handle_term_meta($recommended, "_recommended_post", $post_id);
      }
    } else {
      self::handle_term_meta(null, "_featured_post", $post_id);
      self::handle_term_meta(null, "_recommended_post", $post_id);
    }

    $fiches = $_POST['fiche_fiche'];

    if (isset($fiches))
    {
      self::handle_post_meta($fiches, "_fiche_fiche", $post_id);
    }
    else
    {
      self::handle_post_meta(null, "_fiche_fiche", $post_id);
    }
  }

  public function handle_post_meta($fiches, $meta_key, $post_id) {
    $current_fiches = get_post_meta($post_id, '_fiche_fiche');

    $add_fiches = [];
    $remove_fiches = [];

    if ($fiches == null)
    {
      $remove_fiches = $current_fiches;
    }
    else
    {
      $add_fiches = array_diff($fiches, $current_fiches);
      $remove_fiches = array_diff($current_fiches, $fiches);
    }

    foreach ($add_fiches as $f) {
      add_post_meta($post_id, $meta_key, $f);
    }

    foreach ($remove_fiches as $f) {
      delete_post_meta($post_id, $meta_key, $f);
    }
  }

  public function handle_term_meta($regions, $meta_key, $post_id) {
    $current_regions_objects = get_regions($post_id, $meta_key, ICL_LANGUAGE_CODE, false, false);

    $current_regions = [];
    foreach ($current_regions_objects as $cr) {
      array_push($current_regions, $cr->term_id);
    }

    $add_region = [];
    $remove_region = [];

    if ($regions == null) {
      $remove_region = $current_regions;
    } else {
      $add_region = array_diff($regions, $current_regions);
      $remove_region = array_diff($current_regions, $regions);
    }

    foreach ($add_region as $r) {
      add_term_meta($r, $meta_key, $post_id);
    }

    foreach ($remove_region as $r) {
      delete_term_meta($r, $meta_key, $post_id);
    }
  }

  public function render_meta_box_content( $post ) {
    enqueue_custom_assets();
    add_action( 'save_post', 'save_fiche_meta_data' ); 

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'custom_meta_box', 'custom_meta_box_nonce' );

    $post_id = $_GET['post'];
    $seopages = get_seopages_by_fiche($post_id);
    $regions = get_regions();

    $regions_featured = get_regions($post_id, "_featured_post", ICL_LANGUAGE_CODE);
    $regions_recommended = get_regions($post_id, "_recommended_post", ICL_LANGUAGE_CODE);
    ?>

    <table class="form-table meta-table" id="seopages">
      <tbody>
        <tr>
          <th>Gekoppelde SEO pagina's</th>
          <td>
            <div id="owned-seopages" class="owned-meta">
              <ul>
              <?php foreach($seopages as $seopage): ?>
                <li data-id="<?= $seopage->ID ?>"><?= $seopage->post_title ?><span class="lang">(<?= $seopage->language_code ?>)</span><button class="delete"><i class="fa fa-times"></i></button></li>
              <?php endforeach; ?>
              </ul>
            </div>
          </td>
        </tr>
        <tr>
          <th>SEO pagina toevoegen</th>
          <td>
            <input type="text" class="regular-text search-seopages search-meta" placeholder="Gelieve 3 of meer karakters in te typen..." />
            <i id="loading" class="fa fa-spinner fa-pulse"></i>
            <div class="results-container">
              <div id="result-seopages" class="result-meta"></div>
            </div>
          </td>
        </tr>
        <tr>
          <!-- <th>Uitgelicht op</th>
          <td>
            <div class="featured-container regions-container">
              <ul class="categorychecklist">
              <?php foreach($regions_featured as $region): ?>
                <li>
                  <label for="featured-<?= $region->slug ?>"><input type="checkbox" data-id="<?= $region->term_id ?>" name="featured[]" <?php if ($region->checked) { echo 'checked="checked"'; } ?> id="featured-<?= $region->slug ?>" value="<?= $region->term_id ?>"/> <?= $region->name ?></label>
                  <ul class="children">
                    <?php foreach($region->children as $subregion): ?>
                      <li>
                        <label for="featured-<?= $subregion->slug ?>"><input type="checkbox" data-id="<?= $subregion->term_id ?>" name="featured[]" <?php if ($subregion->checked) { echo 'checked="checked"'; } ?> id="featured-<?= $subregion->slug ?>" value="<?= $subregion->term_id ?>"/> <?= $subregion->name ?></label>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </li>
              <?php endforeach; ?>
              </ul>
            </div>
          </td> -->
        </tr>
        <?php
          $fiche_user = get_post_meta($post_id, '_fiche_user', 1);
          $fiche_fiches = get_post_meta($post_id, '_fiche_fiche');

          if($fiche_user)
          {
            $user_fiches = get_fiches('_fiche_user', $fiche_user);
            if(count($user_fiches)>1)
            {
              echo "<tr>";
              echo "<th>Gekoppelde fiches</th>";
              echo "<td><div><ul>";
              
              foreach($user_fiches as $user_fiche)
              {
                if($user_fiche->post_id!=$post_id)
                {
                  echo "<li><label><input type='checkbox' name='fiche_fiche[]' value='" . $user_fiche->post_id . "'";

                  // als fiche gekoppelde heeft mag deze niet kunnen worden aangevinkt
                  if(count(get_post_meta($user_fiche->post_id, '_fiche_fiche'))>0)
                  {
                    echo " disabled";
                  }

                  // aanvinken als de fiche gekoppeld is met de huidige fiche
                  foreach($fiche_fiches as $fiche_fiche)
                  {
                    if($fiche_fiche==$user_fiche->post_id) { echo ' checked="checked"'; }
                  }
                  echo "> " . $user_fiche->post_title . " (" . strtoupper($user_fiche->language_code) . ")</label></li>";
                }
              }

              echo "</ul></div></td>";
              echo "</tr>";
            }
          }
        ?>
        <?php /* <tr>
          <th>Aanbevolen op</th>
          <td>
            <div class="recommended-container regions-container">
              <ul class="categorychecklist">
              <?php foreach($regions_recommended as $region): ?>
                <li>
                  <label for="recommended-<?= $region->slug ?>"><input type="checkbox" data-id="<?= $region->term_id ?>" name="recommended[]" <?php if ($region->checked) { echo 'checked="checked"'; } ?> id="recommended-<?= $region->slug ?>" value="<?= $region->term_id ?>"/> <?= $region->name ?></label>
                  <ul class="children">
                    <?php foreach($region->children as $subregion): ?>
                      <li>
                        <label for="recommended-<?= $subregion->slug ?>"><input type="checkbox" data-id="<?= $subregion->term_id ?>" name="recommended[]" <?php if ($subregion->checked) { echo 'checked="checked"'; } ?> id="recommended-<?= $subregion->slug ?>" value="<?= $subregion->term_id ?>"/> <?= $subregion->name ?></label>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </li>
              <?php endforeach; ?>
              </ul>
            </div>
          </td>
        </tr> */ ?>
      </tbody>
    </table>
    <?php
  }
}