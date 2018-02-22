<script>
	var formData = new FormData();
	formData.append('action', 'ajax_get_level_2_content');
	// $http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
	//     console.log(response);
	// });

	$.ajax({
	    url: '/wp-admin/admin-ajax.php',
	    type: 'POST',
	    data: formData,
	    contentType: false,
	    processData: false,
	    // success: success,
	    // error: error
	    success: function(response){
	        console.log(response);    
	    },
	    error: function(response){
	        console.log(response);                    
	    }
	});
</script>
<!-- php/ajax.php -->
<?php  
function ajax_get_level_2_content() {
	$data = $_POST['data'];

	wp_send_json( 'test' );
    die();
}
add_action( 'wp_ajax_ajax_get_level_2_content', 'ajax_get_level_2_content' );
add_action( 'wp_ajax_nopriv_ajax_get_level_2_content', 'ajax_get_level_2_content' );
?>