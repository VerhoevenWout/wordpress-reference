<?php

$first_menu_item = '<ul id="%1$s" class="%2$s"><li class="menu-item"><a href="/"><img src='.$vrb->ACF["logo_png"]["url"].' alt="'.$vrb->ACF["logo_svg"]["alt"].'"></a></li>%3$s</ul>';
?>
<?php wp_nav_menu( array( 
	'container_class' => 'menu', 
	'theme_location' => 'main_nav',
	'items_wrap' => $first_menu_item
) ); ?>