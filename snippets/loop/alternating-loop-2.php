<style media="screen">
  .grid-3-box > div {
  transition: all .3s;
  opacity: 1;
  padding: 15px;
  }
  .grid-3-box > div:nth-child(1) {
  width: 66.66666666666%;
  padding-left: 30px;
  float: left;
  }
  .grid-3-box > div:nth-child(2), .grid-3-box > div:nth-child(3) {
  width: 33.3333333333%;
  padding-right: 30px;
  float: right;
  transition: all .3s;
  }
  .grid-3-box > div:nth-child(2) .box-height, .grid-3-box > div:nth-child(3) .box-height {
  padding-bottom: calc(72% + 1px);
  background-color: #ddd;
  }
  .grid-3-box > div:nth-child(3) {
  transition: all .3s;
  }
  .grid-3-box.off-screen > div {
  opacity: 0;
  }
  .grid-3-box.off-screen > div:nth-child(1) {
  transform: translateX(-200px);
  }
  .grid-3-box.off-screen > div:nth-child(2) {
  transform: translateY(100px);
  }
  .grid-3-box.off-screen > div:nth-child(3) {
  transform: translateY(100px);
  }

  .grid-2-box > div {
  transition: all .3s;
  padding: 15px;
  }
  .grid-2-box > div:nth-child(1) {
  width: 33.3333333333%;
  padding-left: 30px;
  float: left;
  }
  .grid-2-box > div:nth-child(1) .box-height {
  padding-bottom: calc(144% + 30px);
  background-color: #ddd;
  }
  .grid-2-box > div:nth-child(2) {
  width: 66.66666666666%;
  padding-right: 30px;
  float: right;
  transition: all .3s;
  }
  .grid-2-box.off-screen > div {
  opacity: 0;
  }
  .grid-2-box.off-screen > div:nth-child(1) {
  transform: translateY(100px);
  }
  .grid-2-box.off-screen > div:nth-child(2) {
  transform: translateY(200px);
  }
</style>

<?php
$args = array(
  'post_type' => 'case-studies', // enter your custom post type
  'post_status' => 'publish',
  'posts_per_page'=> '8',  // overrides posts per page in theme settings
  'paged' => $paged,
  'order' => 'asc',
  'orderby' => 'menu_order',
);

$loop = new WP_Query( $args );
if( $loop->have_posts() ):
?>
<?php $i = 1; while( $loop->have_posts() ): $loop->the_post(); global $post; ?>
  <?php if($i == 1 || $i == 6 || $i == 11): ?>
    <div class="row">
      <div class="grid-3-box off-screen">
  <?php endif; ?>

  <?php if($i == 4 || $i == 9): ?>
    <div class="row">
      <div class="grid-2-box off-screen">
  <?php endif; ?>

  <?php if($i == 4 || $i == 9 && get_field('featured_portrait')):
    $image = get_field('featured_portrait');
    elseif(get_field('featured_landscape')):
      $image = get_field('featured_landscape');
    else:
    $image = get_field('placeholder_image','options');
  endif;?>

  <div><a href="<?php the_permalink(); ?>"><div class="overflow-hidden"><div class="box-height" style="background-image: url('<?php echo $image['sizes']['large']; ?>');"></div><div class="case-study-title overlay-text"><?php the_title(); ?></div></div></a></div>

  <?php if($i == 3 || $i == 5 || $i == 8 || $i == 10): ?>
      </div>
    </div>
  <?php endif; ?>


  <?php wp_reset_postdata(); ?>
<?php $i++; endwhile; ?>

<script type="text/javascript">
  $( '.off-screen' ).each(function( index ) {
  if ($(this).isOnScreen()) {
  $(this).removeClass('off-screen');

  $.fn.isOnScreen = function(){
    var win = $(window);
    var viewport = {
      top : win.scrollTop(),
      left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height() - (win.height() / 3);

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

  };
</script>
