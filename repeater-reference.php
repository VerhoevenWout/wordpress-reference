<?php get_header(); ?>

<?php if(is_user_logged_in()): ?>
  <!-- code only shown when logged in -->
<?php endif; ?>

<?php include(locate_template('tpl/parts/part-short-banner.php' )); ?>

  <?php if( have_rows('staff_repeater') ): ?>
    <?php while( have_rows('staff_repeater') ): the_row(); ?>
      <?php the_sub_field('staff_title'); ?>
      <?php the_sub_field('staff_details'); ?>
      <?php the_sub_field('staff_description'); ?>
    <?php endwhile ?>
  <?php endif ?>

<?php get_footer(); ?>
