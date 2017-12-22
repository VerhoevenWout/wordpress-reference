<style>
  .block-drop-menu{
  display: block!important;
  }
  .reveal-drop-menu{
  opacity: 1!important;
  }
</style>

<header id="header" <?php echo $show_submenu?"class='inner-page'":false; ?>>
 		<nav id="nav" class="navbar navbar-default navbar-fixed-top <?php if ( is_single() || is_category() ) { ?>catid<?php echo $category_id; } ?> ">
		<div class="container" style="height:60px;">
			<div class="navbar-brand">
					<div class="logo-wrap">
						<a href="<?php echo get_option('home'); ?>/">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="hawley place">
						</a>
					</div>
				</div>
			<div class="navbar-header text-center">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
      <?php get_template_part('tpl/flag-menu') ?>
			<div class="collapse navbar-collapse" id="main-navbar">
				<?php wp_nav_menu( array('menu' => 'main menu','container' => false,'menu_class' => 'nav navbar-nav navbar-right', 'depth' => 2, 'walker' => new Child_Wrap() , )); ?>
        <?php if(is_single()): ?>
          <!-- code -->
				<?php endif; ?>
			</div>
		</div>
	</nav>
</header>

<script type="text/javascript">
  var mq = window.matchMedia( "(max-width: 500px)" );
  if (mq.matches) {
    $('.menu-item-has-children > a').click( function(e) {
      e.preventDefault();
      $(this).parent().find('.drop-menu').addClass('block-drop-menu');
      $(this).parent().find('.drop-menu').addClass('reveal-drop-menu');
      $(this).parent().find('.drop-menu ul').append('<li class="back-drop-menu"><a>BACK</a></li>');

      $('.back-drop-menu').click(function(){
        $(this).remove();
        $('.drop-menu').removeClass('reveal-drop-menu');
        setTimeout(function(){
          $('.drop-menu').removeClass('block-drop-menu');
        },300);
      });
    });
  } else{
    $('li.menu-item-has-children').mouseenter( function() {
      $('.drop-menu').removeClass('reveal-drop-menu');
      $(this).find('.drop-menu').addClass('block-drop-menu');
      $(this).find('.drop-menu').addClass('reveal-drop-menu');
    });
    $('.drop-menu').mouseleave( function() {  // mouse enter
      $('.drop-menu').removeClass('reveal-drop-menu');
      setTimeout(function(){
        $('.drop-menu').removeClass('block-drop-menu');
      },300);
    });
  }
</script>
