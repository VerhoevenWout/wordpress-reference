<?php 

	wp_localize_script( 'includes', 'site', array(
                'theme_path' => get_template_directory_uri(),
                'ajaxurl'    => admin_url('admin-ajax.php')
            )
    );

	function ajax_update_favourite($id){

		$data = $_POST['id'];

		$sql = '
			UPDATE wp_searchtable
			SET favourite = favourite + 1
			WHERE id = '.$data.id;

		error_log($sql);
		global $wpdb;
		$result = $wpdb->query($sql);

		wp_send_json($result);

	    die();

	}
	add_action( 'wp_ajax_update_favourite', 'ajax_update_favourite' );
	add_action( 'wp_ajax_nopriv_update_favourite', 'ajax_update_favourite' );

?>

<script>
	function makefavourite(){
		// update_favourite
        var formData = new FormData();
		formData.append('action', 'update_favourite');
		formData.append('id',  JSON.stringify(this.fichedata.post_id));
		
		var vm = this;
		this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
			console.log(response);
        });
    },
</script>

<!-- OR -->

<script type="text/javascript">
    jQuery('#passwordChecker').submit(ajaxSubmit);

    function ajaxSubmit(){
        var passwordChecker = jQuery(this).serialize();
        jQuery.ajax({
            action : 'update_favourite',
            type   : "POST",
            url    : "/wp-admin/admin-ajax.php",
            data   : passwordChecker,
            success: function(data){
                jQuery("#feedback").html(data);
            }
        });
        return false;
    }
</script>
