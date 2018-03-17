
<?php $args = array(
  'post_type' => 'photos',
  'post_status' => 'publish',
  'posts_per_page'=> '5',
  'paged' => $paged,
  'order' => 'asc',
  'orderby' => 'menu_order',
);
$loop = new WP_Query( $args );
if( $loop->have_posts() ): ?>
    <?php $i = 1; while( $loop->have_posts() ): $loop->the_post(); global $post; ?>
	<!-- CODE -->
    <?php $i++; endwhile; ?>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>