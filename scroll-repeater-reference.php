<style>
  .staff-links-container a{
    display: block;
  }
  .big-hr-margin{
    margin: 50px 0;
  }
  /*.container .big-hr-margin:last-of-type{
    display: none;
  }*/
</style>

<div class="col-md-8 entry main-content">
  <div class="staff-links-container">
    <?php if( have_rows('staff_repeater') ): ?>
      <?php while( have_rows('staff_repeater') ): the_row(); ?>
        <a href="#<?php echo str_replace(' ', '', get_sub_field('staff_title')); ?>"><?php the_sub_field('staff_title'); ?></a>
      <?php endwhile ?>
    <?php endif ?>
  </div>
  <div class="reqruitment-container">
    <?php if( have_rows('staff_repeater') ): ?>
      <?php while( have_rows('staff_repeater') ): the_row(); ?>
        <div id="<?php echo str_replace(' ', '', get_sub_field('staff_title')); ?>" class="reqruitment">
          <h3><strong><?php the_sub_field('staff_title'); ?></strong></h3>
          <?php the_sub_field('staff_details'); ?>
          <hr />
          <?php the_sub_field('staff_description'); ?>
          <hr class="big-hr-margin" />
        </div>
      <?php endwhile ?>
    <?php endif ?>
  </div>
</div>

<script type="text/javascript">
  var $body = $('html, body');
  $('.staff-links-container a').click(function(){
  var topOfObject = $( $.attr(this, 'href') ).offset().top;
  // change headerheight
  $body.animate({
  scrollTop: topOfObject - headerheight
  }, 500);
  return false;
  });

  $('.container .big-hr-margin:last').remove();
</script>
