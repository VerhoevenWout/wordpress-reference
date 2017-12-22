<!-- Install plugin, add Access Token and User ID, add shortcode to page and function in script -->
<!-- Plugin js file didn't recognise jquery, that's why we need to activate sbi_init(); in the script  -->
<!-- If there are any errors in the console. the plugin won't work -->

<style media="screen">
  .sbi_item{
  display: inline-block!important;
  }
  .sb_instagram_header{
  padding: 0!important;
  }
</style>

<?php echo do_shortcode("[instagram-feed]"); ?>

<script type="text/javascript">
  // Instagram plugin init
  sbi_init();
</script>
