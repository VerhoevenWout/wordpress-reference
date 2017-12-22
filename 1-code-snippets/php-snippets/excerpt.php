<!-- EXCERPT only show first 86 characters -->
<?php if(get_field('excerpt')): ?>
  <p>
    <?php $excerpt = get_field('excerpt'); if($i == -1 || strlen($excerpt) < 86): echo $excerpt; else: echo substr($excerpt, 0, 86) . '...'; endif; ?>
  </p>
<?php endif; ?>
