<?php get_header(); ?>

<?php if ( is_front_page() || is_home()): ?>
  <!-- code only shown on frontpage -->
<?php endif; ?>

<?php if(is_page('staff-testpage')): ?>
  <!-- code only shown on that page -->
<?php endif; ?>

<?php get_template_part( 'tpl/instagram' );  ?>

<?php get_footer(); ?>
