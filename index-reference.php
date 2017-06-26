<?php get_header(); ?>

<?php if(is_user_logged_in()): ?>
  <!-- code only shown when logged in -->
<?php endif; ?>
<?php if(is_page('staff-testpage')): ?>
  <!-- code only shown on that page -->
<?php endif; ?>

<?php get_footer(); ?>
