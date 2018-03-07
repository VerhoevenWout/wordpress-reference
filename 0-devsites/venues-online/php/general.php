<?php

include 'controller.php';
include 'stats-controller.php';
include 'cms.php';
include 'ajax.php';
include 'stats.php';
include 'seopages.php';

// include 'populate-seo.php';
// include 'populate-seo-fr.php';

function enqueue_custom_assets() {
	wp_enqueue_style( 'prefix-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.0.3' );
	// wp_enqueue_style( 'edit-user', get_template_directory_uri() . '/dist/css/cms.css', '20160203', true );
	wp_enqueue_script( 'jquery' );
	wp_localize_script( 'includes', 'site', array(
                'theme_path' => get_template_directory_uri(),
                'ajaxurl'    => admin_url('admin-ajax.php')
            )
    );
	wp_enqueue_script( 'edit-user', get_template_directory_uri() . '/dist/js/cms.bundle.js', array(), '20160203', true );
	wp_enqueue_style( 'seopages', get_template_directory_uri() . '/dist/css/seopages.css', '20160218', true );
	// wp_enqueue_script( 'stats', get_template_directory_uri() . '/dist/js/stats.bundle.js', array(), '20160215', true );
	$lang = explode("-", ICL_LANGUAGE_CODE)[0];
	wp_localize_script('edit-user', 'globals', array(
			'lang' => $lang,
		)
	);
}

function enqueue_required_assets() {
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	if (is_page_template('templates/tpl_favourites.php')) {
		wp_enqueue_script( 'favourites', get_template_directory_uri() . '/dist/js/favourites.bundle.js', array (  ), 1.0, true);
	} elseif (is_single() && get_post_type()=='seopage') {
		wp_enqueue_script( 'seopage', get_template_directory_uri() . '/dist/js/seopage.bundle.js', array (  ), 1.0, true);
	} else{
		wp_enqueue_script( 'search', get_template_directory_uri() . '/dist/js/search.bundle.js', array (  ), 1.0, true);
	}
	wp_enqueue_script( 'main', get_template_directory_uri() . '/dist/js/main.bundle.js', array (  ), 1.0, true);
	wp_enqueue_script( 'animations', get_template_directory_uri() . '/dist/js/animations.bundle.js', array (  ), 1.0, true);

	// Import global php vars in main.js
	$lang = explode("-", ICL_LANGUAGE_CODE)[0];
	global $post;
	wp_localize_script('main', 'globals', array(
			'post' => $post,
			'post_meta' => get_post_meta($post->ID),
			'site_url' => get_site_url(),
			'template_dir' => get_template_directory_uri(),
			'lang' => $lang,
			'site_id' => get_current_blog_id()
		)
	);
}
add_action( 'wp_enqueue_scripts', 'enqueue_required_assets' );