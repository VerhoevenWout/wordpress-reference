<?php  

	if (get_blog_details( $blogId )->blog_id == 2) {
		if (!is_user_logged_in()) { auth_redirect(); }
	}
?>
<?php
global $voltatheme;

/*
	Variables to load {
		WP / the_title
		WP / the_content
	}
*/
?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>

<meta charset="UTF-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<title><?= $voltatheme->WP['the_title'];?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_url'); ?>/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="<?php bloginfo('template_url'); ?>/favicons/manifest.json">
<link rel="mask-icon" href="<?php bloginfo('template_url'); ?>/favicons/safari-pinned-tab.svg" color="#000000">
<meta name="theme-color" content="#ffffff">

<!-- Analytics -->




<!-- build:css dist/css/vendor.css -->
<!-- bower:css -->

<!-- endbower -->
<!-- endbuild -->


<!-- Webfont -->
<link rel="stylesheet" type="text/css" href="https://fast.fonts.net/cssapi/04ddfc5c-8438-4165-8a67-d0a203e598be.css">
<script src="https://use.fontawesome.com/79149b2df3.js"></script>

<!-- 'mobile-open' -->

<!-- WP head -->
<?php wp_head(); ?>

<?php
	if (get_blog_details( $blogId )->blog_id == 2) {
		$site = "intranet";
		$collapse = "";
	} else {
		$site = "hoofdsite";
		$collapse = "xmedium-collapse";
	}
?>
<body <?php body_class($site); ?>>
	<div class="page-wrap">
		<header id="site-header">
			<div class='row small-collapse medium-uncollapse xmedium-collapse align-justify'>
				<div id="site-logo" class='column large-2'>
					<a href='/' alt="<?php bloginfo( 'name' ); ?> | <?php bloginfo('description'); ?>" title="<?php bloginfo( 'name' ); ?> | <?php bloginfo('description'); ?>"><?= $voltatheme->logo; ?></a>
				</div>
				<div class="mobile-nav column small-2">
					<i class="icon-menu"></i>
				</div>

				<?php if (get_blog_details( $blogId )->blog_id == 1) : ?>
					
					<div class="mobile-buttons column small-12 medium-7">
						<a href="tel:003234401925" class="btn btn-secretariaat" title="Secretariaat">
							secretariaat <strong>03/440.19.25</strong> <small>07:30u - 19:00u</small>
						</a>
						<a href="http://groepspraktijkfruithof.digitalewachtkamer.be/" class="btn btn-boekonline" title="Boek online" target="_blank">
							<i class="icon-chairs"></i>
							<span>
								<small>afspraak?</small><strong>Boek online</strong>
							</span>
						</a>
					</div>

				<?php endif; ?>
				<nav id="site-nav" class='column small-12 large-9'>
					<?php 
						wp_nav_menu( 
							array( 
								'theme_location' => 'hoofd-menu',
								'menu_class'     => 'hoofd-menu'
							) 
						);
					?>

					<?php if (get_blog_details( $blogId )->blog_id == 2) : ?>
						<form role="search" method="get" id="top-search-form" action="<?php echo home_url( '/' ); ?>">
						    <label class="search-field-label">
						        <input type="search" class="search-field" placeholder="zoek het intranet" value="<?php echo get_search_query() ?>" name="s" title="zoek" />
						    </label>
						    <ul class="search-filter">
						    	<li class="filter-toggle">
						    		<strong>filter</strong> <i class="icon-arrow-down"></i>
						    	</li>
						    	<li>
						    		<input type="checkbox" name="type1" value="contact"> Contactbeheer
						    	</li>
						    	<li>
						    		<input type="checkbox" name="type2" value="document"> Documentbeheer
						    	</li>
						    	<li>
						    		<input type="checkbox" name="type3" value="post"> Prikbord
						    	</li>
						    </ul>
						    <div class="search-submit">
						        <input type="submit" value="" />
						        <i class="icon-search"></i>
						    </div>
						    
						</form>
					<?php endif; ?>
				</nav>
			</div>
		</header>

		<main id="site-main">
			<div class='row <?php echo $collapse; ?>'>