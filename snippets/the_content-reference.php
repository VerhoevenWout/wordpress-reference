<!-- Static page the_content -->
<!-- You need to call the posts first to set all the vars correctly (in order to call the_content) -->
<?php while ( have_posts() ) : the_post() ; ?>
  <p class="content-center-top">
    <?php the_content(); ?>
  </p>
<?php endwhile; ?>
