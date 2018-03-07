<?php
	// if ( ! is_user_logged_in() ) {
	// 	$currentUrl = $_SERVER['REQUEST_URI'];
	// 	wp_redirect( wp_login_url($currentUrl) );
	// 	exit;
	// }
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

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="description" content="Venues Online, een overzicht van de beste locaties">
<meta name="keywords" content="Venues Online overzicht van de beste locaties">
<!-- <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" /> -->
<meta content="width=device-width, user-scalable=1" name="viewport" />
<!-- expiration date -->
<meta http-equiv="Expires" content="30" /> 

<title>

	<?php global $page_title; ?>
	<?php if ($page_title){echo $page_title;}else{wp_title('');}?>  | <?php bloginfo( 'description' ); ?>

</title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<!-- Favicon -->
<!-- <link rel="Shortcut Icon" type="image/x-icon" href="<?php bloginfo('template_url'); ?>/dist/img/single-logo-marker.png" /> -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_url'); ?>/dist/img/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_url'); ?>/dist/img/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_url'); ?>/dist/img/favicons/favicon-16x16.png">
<link rel="manifest" href="<?php bloginfo('template_url'); ?>/dist/img/favicons/manifest.json">
<link rel="mask-icon" href="<?php bloginfo('template_url'); ?>/dist/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">

<!-- Analytics -->
<!-- If staging or webhosting, don't index -->
<?php if(stristr( $_SERVER['SERVER_NAME'], "webhosting" ) || stristr($_SERVER['SERVER_NAME'], "staging") || stristr($_SERVER['SERVER_NAME'], "lancering" )): ?>
	<meta name="robots" content="noindex, nofollow">
<?php endif; ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KX7P2KB');</script>
<!-- End Google Tag Manager -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-54697759-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-54697759-1');
</script>

<!-- Theme styles -->
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,300,400,600,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/dist/css/style-site.css" />

<?php  

	function jsonToProp($data){
	    return htmlentities($data);
	}

	global $translations;
	global $translations_json;
	global $lang;

	$lang = ICL_LANGUAGE_CODE;
	if ($lang == 'fr'){
		$translation_group = acf_get_fields(1653161);
	} elseif($lang == 'en'){
		$translation_group = acf_get_fields(1653125);
	} else{
		$translation_group = acf_get_fields(1653089);
	}

	$translations = [];
	foreach ( $translation_group as $field ) {
		$field_value = get_field( $field['name'], 'option' );
		if ( $field_value && !empty( $field_value ) ) {
			array_push($translations, $field_value);
		}
	}
	$translations_json = json_encode($translations);
	$translations_json = str_replace("'","`",$translations_json);

	// echo "<pre>";
	// var_dump( $translations_json );
	// echo "</pre>";
?>
<?php gravity_form_enqueue_scripts(1,true) ?>
<?php wp_head();?>

</head>

<body <?php if (!is_front_page()) body_class('not-frontpage'); ?> <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KX7P2KB"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div class="page-wrap" v-on:click="clickDocument()">
		<div class="loading-overlay" v-bind:class="{ 'loading-overlay-hide': loading == false }">
			<i class="loading"></i>
			<img class="logo" src="<?php echo get_bloginfo('template_url') ?>/dist/img/main-logo-invert.svg" alt="">
		</div>
		<nav v-bind:class="{ 'search-active': isactive }">
			<a href="<?php echo icl_get_home_url() ?>" title="">
				<img class="logo main-logo main-logo-normal" src="<?php echo get_bloginfo('template_url') ?>/dist/img/main-logo.svg" alt="">
				<img class="logo main-logo main-logo-invert" src="<?php echo get_bloginfo('template_url') ?>/dist/img/main-logo-invert.svg" alt="">
			</a>

			<button class="hamburger hamburger--squeeze" type="button">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
			<div class="full-main-menu-container">
				<div class="venue-search">
					<form v-on:submit.prevent="submitSearchName()">
						<input v-model="search" v-bind:value="search" type="text" name="search" autocomplete="off" >
						<span class="icon-magnify" v-on:click="submitSearchName()"></span>
					</form>
				</div>

				<div class="menu-main-menu-container">
					<?php 
						wp_nav_menu( array(
							'menu_class'	=> 'light',
							'menu'       	=> 'MenuNl'
						) ); 
					?>
				</div>
				
				<div class="language-menu">
					<?php if ( function_exists( 'icl_get_languages' ) ) : $languages = icl_get_languages('skip_missing=0'); ?>
						<?php if ($languages): ?>
							<ul id="lang-select">
								<?php foreach ($languages as $key => $l): if($l['active']): ?>
									<span class="lang-text short-code"><?= $l['code']; ?></span>
									<?php unset($languages[$key]); ?>
								<?php continue; endif; endforeach; ?>
								<?php $index = 0 ?>
								<?php foreach ($languages as $l): ?>
									<li class="language-item language-item<?= $index ?>">
										<a href="<?= $l['url']; ?>">
											<span class="short-code"><?= $l['code']; ?></span>
										</a>
									</li>
									<?php $index++ ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<a v-if="this.$root.isfavouritespage == false" href="<?php echo icl_get_home_url() ?>/mijn-favorieten/" title="" class="btn myFavourites">
					<?= $translations[1] ?><span class="icon-favourite"></span>
				</a>
				<a v-if="this.$root.isfavouritespage == true" v-on:click="sharefavourites(<?= jsonToProp($translations_json) ?>)" title="" class="btn myFavourites">
					<?= $translations[2] ?><span class="icon-favourite"></span>
				</a>

			</div>
		</nav>