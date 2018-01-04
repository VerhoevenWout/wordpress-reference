<?php
$current_cat = get_the_category();
wp_dropdown_categories( array(
  'hide_empty'       => 0,
  'name'             => 'category_parent',
  'orderby'          => 'name',
  'selected'         => $current_cat[0]->slug ,
  'hierarchical'     => true,
  'show_option_none' => __('Categories'),
  'option_none_value' => 'all',
//	  'child_of' => 37,
  'id' => 'news-archive-dropdown',
  'value_field' => 'slug'
) ); ?>


<!-- GET CATEGORY ITEMS IN ARCHIVE -->
<?php
  $single_cat_id = get_cat_id( single_cat_title("",false));
  $args = array(
    'post_type' => 'post',
    'category' => $single_cat_id,
  );
  $postslist = get_posts($args);
  foreach ($postslist as $post) :  setup_postdata($post); ?>
?>
  <div class="col-md-4 col-sm-6">
    <a href="<?php the_permalink(); ?>">
      <div class="teaser teaser--date teaser--grey">
        <div class="teaser__date">
          <?php the_time('j F Y'); ?>
        </div>
        <div class="teaser__title">
          <?php the_title(); ?>
        </div>
        <p>
          <?php the_field('excerpt'); ?>
        </p>
        <div class="bg-squares"></div>
      </div>
    </a>
  </div>
  <?php 	wp_reset_postdata();
endforeach; ?>


<!-- SINGLE PAGE GET CATEGORY NAME -->
<?php $category = get_the_category();
$firstCategory = $category[0]->cat_name;
?>

<script>
  $newsDropdown = $('#news-archive-dropdown');
  $newsDropdown.on('change', function(){
  var cat = $(this).val();
  if(cat == 'all'){
    window.location.href = '/news';
  }else{
    window.location.href = '/category/' + cat;
  }
  });
</script>
