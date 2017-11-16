<?php
/**
* Enable the option page in ACF
*
**/
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
	// Optional
	acf_set_options_page_title('Opties');
	acf_set_options_page_title(__('Opties'));
	// or
	acf_add_options_page();
	acf_add_options_sub_page('Footer');
	acf_add_options_sub_page('Contact');
	acf_add_options_sub_page('Vertalingen');
}
?>

<?php echo the_field('footer_copyright', 'option') ?>
<?php if ( !empty(get_field('footer_repeater_links', 'option')) ) :
while(have_rows('footer_repeater_links', 'option')): the_row();?>
	<a href="<?php echo the_sub_field('link_repeater_links_url', 'option'); ?>" title=""><?php echo the_sub_field('link_repeater_links_text', 'option'); ?></a>
<?php endwhile;
endif; ?>
