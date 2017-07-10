<?php if (is_user_logged_in()  && (is_home() || is_front_page())):
  // wp_redirect('http://www.google.com');
  $url = 'portal.investit.com/intelligence';
  wp_redirect($url);
?>
