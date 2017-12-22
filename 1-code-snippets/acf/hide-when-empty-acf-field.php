if (!empty($instagram)) : ?>
  <a class="link instagram" href="<?php esc_html(the_field('instagram_url', 'options')); ?>" target="_blank">
    <i class="fa fa-instagram" aria-hidden="true"></i>
  </a>
<?php endif; ?>
