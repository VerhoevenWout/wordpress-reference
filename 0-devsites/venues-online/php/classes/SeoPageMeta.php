<?php

class SeoPageMeta {
	const LANG = 'venuesonline';
  const POST_TYPE = 'seopage';

	public function __construct() {
        add_action( 'add_meta_boxes', array( &$this, 'add_some_meta_box' ) );
    }

  public function add_some_meta_box() {
      add_meta_box( 
           'fiche_meta_box',
           __( 'Connections', self::LANG ),
          array( &$this, 'render_meta_box_content' ),
          self::POST_TYPE,
          'advanced',
          'high'
      );
  }

  public function render_meta_box_content() {
    enqueue_custom_assets();

    $post_id = $_GET['post'];
    $fiches = get_fiches('_fiche_seopage', $post_id);

    ?>
    <table class="form-table meta-table" id="fiches">
      <tbody>
        <tr>
          <th>Gekoppelde fiches</th>
          <td>
            <div id="owned-fiches" class="owned-meta">
              <ul>
              <?php foreach($fiches as $fiche): ?>
                <li data-id="<?= $fiche->ID ?>"><?= $fiche->post_title ?><span class="lang">(<?= $fiche->language_code ?>)</span><button class="delete"><i class="fa fa-times"></i></button></li>
              <?php endforeach; ?>
              </ul>
            </div>
          </td>
        </tr>
        <tr>
          <!-- SEO PAGE -->
          <th>Fiche toevoegen</th>
          <td>
            <input type="text" class="regular-text search-fiches search-meta" placeholder="Gelieve 3 of meer karakters in te typen..." />
            <i id="loading" class="fa fa-spinner fa-pulse"></i>
            <div class="results-container">
              <div id="result-fiches" class="result-meta"></div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <?php
  }
}