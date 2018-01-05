<style media="screen">
  /*the body tag will get class .logged-in when logged in*/
  body.logged-in{
    /*Code only shown when logged in*/
  }
</style>

<?php if(is_user_logged_in()): ?>
  <!-- code only shown when logged in -->
<?php endif; ?>
