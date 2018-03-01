<style>
	/* FULL WIDTH GRAVITY FORM */
	.gform_wrapper {
		form .gform_body .ginput_complex input[type=text] {
			width: 100%!important;
		}
		input[type=text], select, textarea {
			width: 100%!important;
			padding: .5em 1em!important;
		}
		ul.gform_fields li.gfield{
			padding: 0!important;
		}
		.top_label .gfield_label{
			display: none;
		}
		input[type=submit]{
			background: blue;
			padding: .5em 1em;
		}
		.gform_footer{
			padding-bottom: 0!important;
		}
	}
</style>

<?php echo do_shortcode('[gravityform id="1" title="false" description="false"]'); ?>