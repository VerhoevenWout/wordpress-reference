<?php if (is_user_logged_in()):
	global $current_user;
	get_currentuserinfo();
?>
<a class="log-in button shine-hover" href="<?php echo home_url().'/intelligence'?> "><span>Hi <?php echo $current_user->user_firstname;?></span></a>
<?php else: ?>
  <!-- Some other code -->
<?php endif; ?>
