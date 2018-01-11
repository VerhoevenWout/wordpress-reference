<!-- Put this on the first line of header.php -->

<?php
	if ( ! is_user_logged_in() ) {
		$currentUrl = $_SERVER['REQUEST_URI'];
		wp_redirect( wp_login_url($currentUrl) );
		exit;
	}
?>