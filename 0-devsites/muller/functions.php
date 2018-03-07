<?php 

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////////////////////////      ////////////      //////////
//////////////////////////     ///////////      ///////////
///////////////////////////     /////////      ////////////
////////////////////////////     ///////      /////////////
////////////////////////////      //////     //////////////
//////////////////////////////     ////     ///////////////
///////////////////////////////     //     ////////////////
////////////////////////////////          /////////////////
/////////////////////////////////        //////////////////
//////////////////////////////////      ///////////////////
///////////////////////////////////    ////////////////////
////////////////////////////////////  /////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

require get_template_directory().'/includes/autoload.php';

add_action('init', 'class_loader');
add_action('init', 'load_the_theme');

add_action('init','rewrite_test');


 function rewrite_test(){

    add_rewrite_rule(
        'products/(.+?)/?$',
        'index.php?product-categorie=$matches[1]',
        'top'
    );

     add_rewrite_rule(
        'produits/(.+?)/?$',
        'index.php?product-categorie=$matches[1]',
        'top'
    );

     add_rewrite_rule(
        'marques/(.+?)/?$',
        'index.php?merk-reeks=$matches[1]',
        'top'
    );

     add_rewrite_rule(
        'brands/(.+?)/?$',
        'index.php?merk-reeks=$matches[1]',
        'top'
    );

}

/**
 * Autoload the custom theme classes
 */
function class_loader()
{
    // Create a new instance of the autoloader
    $loader = new Psr4AutoloaderClass();
    
    // Register this instance
    $loader->register();
    
    // Add our namespace and the folder it maps to
    $loader->addNamespace('volta', get_template_directory() . '/volta');
    $loader->addNamespace('muller', get_template_directory() . '/muller');
}


function load_the_theme(){

    global $muller;
	$muller = new muller\init;

}


function textfield_counter(){
    if ('page' != get_post_type()) {
        $element    = '#acf-field_5a61b9a1c1041';
        $str_limit  = 200;
        $post_type  = 'nieuws';

        global $current_screen;
        if ($current_screen->post_type != $post_type) {
            return;
        }

        echo '
            <script>
            jQuery(document).ready(function(){
                jQuery("'.$element.'").after("<div style=\"position:absolute;top:-2em;right:0px;color:#666;\"><span>Excerpt length: </span><span id=\"textfield_counter\"></span><span style=\"padding-left:.5em;\">/ '.$str_limit.'</span><span><span style=\"padding-left:.5em;\">character(s).</span></span></div>");
                    jQuery("span#textfield_counter").text(jQuery("'.$element.'").val().length);
                    jQuery("'.$element.'").keyup( function() {
                        if(jQuery(this).val().length > '.$str_limit.'){
                            jQuery(this).val(jQuery(this).val().substr(0, '.$str_limit.'));
                        }
                    jQuery("span#textfield_counter").text(jQuery("'.$element.'").val().length);
                });
            });
            </script>
        ';
    }
}
add_action( 'admin_head-post.php', 'textfield_counter');
add_action( 'admin_head-post-new.php', 'textfield_counter');









