<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->

<head id="www-sitename-com">

	<meta charset="<?php bloginfo('charset'); ?>">

	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php if (is_search()):?>
		<meta name="robots" content="noindex, nofollow" />
	<?php endif; ?>

	<title>
		<?php
			if (is_home () ) { bloginfo('name'); }
			elseif ( is_category() ) { single_cat_title(); echo ' - ' ; bloginfo('name'); }
			elseif (is_single() ) { single_post_title(); echo ' - ' ; bloginfo('name');}
			elseif (is_page() ) { single_post_title(); echo ' - ' ; bloginfo('name');}
			else { wp_title('',true); }
		?>
	</title>

	<meta name="title" content="<?php
			if (is_home () ) { bloginfo('name'); }
			elseif ( is_category() ) { single_cat_title(); echo ' - ' ; bloginfo('name'); }
			elseif (is_single() ) { single_post_title(); echo ' - ' ; bloginfo('name');}
			elseif (is_page() ) { single_post_title(); echo ' - ' ; bloginfo('name');}
			else { wp_title('',true); }
		?>">

	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="keyword" content="">

	<meta name="google-site-verification" content="">
	<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->

	<meta name="author" content="Your Name Here">
	<meta name="Copyright" content="Copyright Your Name Here 2011. All Rights Reserved.">

	<!-- Dublin Core Metadata : http://dublincore.org/ -->
	<meta name="DC.title" content="Project Name">
	<meta name="DC.subject" content="What you're about.">
	<meta name="DC.creator" content="Who made this site.">

	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@twitter-handle">
	<meta name="twitter:url" property="og:url" content="https://my-site">
	<meta name="twitter:title" property="og:title" content="Metadata markup">
	<meta name="twitter:description" property="og:description" content="description of my site">
	<meta name="twitter:image" property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/img/share_image.png">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon-fd.png">
	<!-- This is the traditional favicon.
		 - size: 16x16 or 32x32
		 - transparency is OK
		 - see wikipedia for info on browser support: http://mky.be/favicon/ -->

	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon.png">
	<!-- The is the icon for iOS's Web Clip.
		 - size: 57x57 for older iPhones, 72x72 for iPads, 114x114 for iPhone4's retina display (IMHO, just go ahead and use the biggest one)
		 - To prevent iOS from applying its styles to the icon name it thusly: apple-touch-icon-precomposed.png
		 - Transparency is not recommended (iOS will put a black BG behind the icon) -->

	<!-- CSS: screen, mobile & print are all in the same file -->
	<!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/screen.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css"> -->

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- ADD GA CODE HERE -->

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="page-wrap"><!-- not needed? up to you: http://camendesign.com/code/developpeurs_sans_frontieres -->

		<header id="header">
			<div class="col-md-10 col-md-offset-1">
				<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
				<div class="description"><?php bloginfo('description'); ?></div>

				<button class="hamburger hamburger--spin" type="button">
				  <span class="hamburger-box">
				    <span class="hamburger-inner"></span>
				  </span>
				</button>

				<ul class="main-menu">
					<li><a href="#work-wrapper">Work</a></li>
					<li class="divider">/</li>
					<li><a href="#about-wrapper">About</a></li>
					<li class="divider">/</li>
					<li><a href="#sponsor-wrapper">Clients</a></li>
					<li class="divider">/</li>
					<li><a href="#contact-wrapper">Contact</a></li>
				</ul>
			</div>
		</header>

		<div id="content-wrap">

		<!-- OR -->

		<div class="container-fluid nav-bar fixed-top" id="top-nav-bar">
			<div class="container">
				<header id="header">
				  <nav class="navbar yamm">
		    		<a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"/></a>
						<?php wp_nav_menu( array('menu' => 'main-menu', 'menu_class' => 'nav navbar-nav navbar-right')); ?>
						<a class="log-in button shine-hover" href="<?php echo home_url().'/research/documents/'?> "><span>Research Library</span></a>
					</nav>
				</header>
		  </div>
	  </div><!-- /.container-fluid -->
