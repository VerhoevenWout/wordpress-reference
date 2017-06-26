<!-- Make sure to use the lates version of ACF-pro (v5.+) -->

<?php if (is_page('8968')): ?>
	<p><?php the_field('pre_accordion_content') ?></p>

	<?php if( have_rows('accordion_repeater') ):?>
    <style>
      #accordion{
        margin-top: 50px;
        margin-bottom: 50px;
      }
      .ui-accordion-header:hover{
        cursor: pointer;
      }
      .ui-state-focus { outline: none; }
      .ui-icon.iconOpen{
        position: absolute;
        left: -15px;
        margin-top: -1px;
      }
      .ui-icon.iconOpen:before{
        content: '-';
      }
      .ui-icon.iconClosed{
        position: absolute;
        left: -15px;
        margin-top: -1px;
      }
      .ui-icon.iconClosed:before{
        content: '+';
      }
    </style>
		<script>
			$(function(){
        // open and go to correct accordion-header when adding /#link-1 in url
				var hashLink = window.location.hash;
				if (hashLink){
					// var hashLinkId = hashLink.split('-')[1];
					setTimeout(function(){
						$(hashLink).click();
					}, 500);
				}
				$counter = 1;
				$("#accordion h3").each(function(){
					$(this).attr("id", "link-" + $counter);
					$counter = $counter +1;
				});
				var icons = {
					header: "iconClosed",    // custom icon class
					activeHeader: "iconOpen" // custom icon class
				};
				$("#accordion").accordion({
					icons: icons,
					heightStyle: "content",
					collapsible: true,
					active: false,
					activate: function( event, ui ){
						if(!$.isEmptyObject(ui.newHeader.offset())) {
						  $('html:not(:animated), body:not(:animated)').animate({ scrollTop: ui.newHeader.offset().top - 30 }, 'slow');
						}
					}
				});
			});
		</script>
		<div id="accordion">
			<?php while (have_rows('accordion_repeater')): the_row()?>
				<h3><?php the_sub_field('accordion_title'); ?></h3>
			  <div>
			    <p><?php the_sub_field('accordion_content'); ?></p>
			  </div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
	<p><?php the_field('post_accordion_content') ?></p>
<?php endif; ?>

<?php edit_post_link(); ?>
