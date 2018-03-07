<?php
global $muller;

if(!is_user_logged_in()){ 
	//auth_redirect(); 
}

/*
	Variables to load {
		WP / the_title
		\muller\tax\productCategory / get_level_1 / parents
		\muller\menushelper / getHoofdCatMenu / hoofdcatmenu
		menus / hoofd-menu
		menus / lang-menu
		\muller\init / get_svg / arrowsmall / arrow-small
		\muller\init / getbytemplate / tplsearch / tpl-search
		\muller\init / getbytemplate / tplwinkelmand / tpl-winkelmand
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
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NBN6PPH');</script>
<!-- End Google Tag Manager -->

<meta charset="UTF-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<title><?php wp_title(); ?></title>

<link rel="profile" href="//gmpg.org/xfn/11" />

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php bloginfo('template_url'); ?>/dist/img/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/favicon-16x16.png">
<link rel="manifest" href="<?php bloginfo('template_url'); ?>/dist/img/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php bloginfo('template_url'); ?>/dist/img/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<!-- Analytics -->



<!-- If staging or webhosting, don't index -->
<?php if(stristr( $_SERVER['SERVER_NAME'], "webhosting" ) || stristr($_SERVER['SERVER_NAME'], "staging" )): ?>
	<meta name="robots" content="noindex, nofollow">
<?php endif; ?>

<!-- Make IE recognise HTML5 elements for styling -->
<!--[if lte IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/assets/libraries/css3-mediaqueries.js"></script>
<![endif]-->



<!-- WP head -->
<?php wp_head();?>

<body <?php body_class(); ?>> 

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NBN6PPH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php if(!isset($_COOKIE['visited'])) : ?>
  <div id="cookie-banner">
    <div class="container">
      <span>
        <?php _e('This website uses cookies. By continuing to browse this website, you are agreeing to the use of cookies. Read our <a href="/cookie" target="_blank">general conditions</a> for more information on cookies.', 'Cookie'); ?>
      </span>
        <div id="cookie-close">
          <span class="cross"></span>
        </div>
    </div>
  </div>
<?php endif; ?> 

<div class='main-inner'>
<input type="radio" name="menu-radio" id='menu-radio'  >
<header class='main'>
	<div class='row '>
		<div class='column small-12 '>
			<label  for='menu-radio' class='hamburger'>
			 <svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 675 522.5"><title>Naamloos-5</title><rect width="675" height="104.5" style="fill:#e2231a"/><rect y="209" width="675" height="104.5" style="fill:#e2231a"/><rect y="418" width="675" height="104.5" style="fill:#e2231a"/></svg>
			</label>
			<a class='logo' href="<?= icl_get_home_url() ?>" alt='<?= __('Muller kitchen and tableware for retail, catering and B2B', 'muller');?>'><?= $muller->logo; ?></a>
			<form class='search' method="get" action="<?= get_permalink($muller->tplsearch->ID);?>">
				<div class="inner">
					<input type="text" name="query" placeholder="<?= _e('What are you looking for?', 'muller') ?>" />
					<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</form>
			<ul class='share'>

				<li><a target='_blank' href='https://pinterest.com/pin/create/bookmarklet/?media=https://muller-nv.be/wp-content/uploads/2018/02/Social-media-standard-brand.jpg&url=<?= get_site_url();?>/en&description=<?= urlencode("Expert quality for kitchen and table. Are you a retailer or professional with an interest in kitchen and tableware? Be sure to browse
our website, we’ll be happy to assist you further. Simply a cooking addict? You're very welcome to
have a look and ask for our resellers.");?>'><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
				<li><a target='_blank' href='https://www.facebook.com/sharer.php?u=<?= get_site_url();?>/en'><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
			</ul>
			<a href='<?= get_permalink($muller->tplwinkelmand);?>'><i class="fa fa-shopping-cart" aria-hidden="true"><span><?= __('My quote', 'muller');?></span></i></a>
			<?php if(is_user_logged_in()): ?>
				<a href='<?= get_permalink(apply_filters( 'wpml_object_id', 29582, 'page', TRUE  ));?>'><i class="fa fa-user" aria-hidden="true"><span><?= __('My account', 'muller');?></span></i></a>
			<?php else: ?>
				<a href='<?= get_permalink($muller->tplwinkelmand);?>'><i class="fa fa-user" aria-hidden="true"><span><?= __('Login', 'muller');?></span></i></a>
			<?php endif;?>
		</div>
	</div>
</header>
<nav id='nav' class='row'>
	<header>
		<div class='logo'>
		<?= $muller->logo; ?>
		</div>
		<label  for='menu-radio' class='hamburger open' v-on:click.prevent='closemenu()'>
			  <span></span><span></span><span></span>
		</label>
	</header>
	<form class='search' method="get" action="<?= get_permalink($muller->tplsearch->ID);?>">
		<div class="inner">
			<input type="text" name="query" placeholder="<?= _e('What are you looking for?', 'muller') ?>" />
			<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
	</form>
	<?= $muller->menus['hoofd-menu'];?>
	<?= $muller->menus['lang-menu'];?>

	<div class="hoofdcat-menu-mobile">
		<?= $muller->hoofdcatmenu;?>
	</div>

	
	<!-- <div class='subcatmenu'  v-bind:class="{ active: isActive }">
		<div class='inner'>
			<header class='header'>
				<i v-on:click='isActive = false'><?= $muller->arrowsmall;?></i>
				<label  for='menu-radio' class='hamburger open' v-on:click.prevent='closemenu()'>
				  <span></span><span></span><span></span>
				</label>
				<h3>{{ decodeHtml(currentterm.name) }}</h3>
			</header>
			<ul class='small-12 column'>
				<li v-for='item in subcatmenu' >
					<span  v-on:click='activesubmenu = item.term.term_id' v-if="item.childeren.length > 0">{{ decodeHtml(item.term.name) }}</span>
					<a v-if="item.childeren.length == 0" v-bind:href='"/product-categorie/"+item.term.slug '>{{ decodeHtml(item.term.name) }}</a>
					<ul v-if="item.childeren.length > 0"  v-bind:class="{ active: activesubmenu == item.term.term_id }">
						<li class='header'>
							<header>
								<i v-on:click='activesubmenu = false'><?= $muller->arrowsmall;?></i>
								<label  for='menu-radio' class='hamburger open' v-on:click.prevent='closemenu()'>
								  <span></span><span></span><span></span>
								</label>
								<h3>{{ decodeHtml(item.term.name) }}</h3>
							</header>
						</li>
						<li v-for='subitem in item.childeren'><a v-bind:href='"/product-categorie/"+subitem.slug'>{{ decodeHtml(subitem.name) }}</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div> -->

</nav>
<nav id='nav' class='row expanded hoofdcat-menu-desktop'>
	<?= $muller->hoofdcatmenu;?>
</nav>
<main id='main'>
	