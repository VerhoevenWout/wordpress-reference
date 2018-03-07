var $ = require('jquery');

module.exports = function(){

	$( document ).ready(function() {

		$('#import-categories').click(function(){

			$.post(
			    '/wp-admin/admin-ajax.php', 
			    {
			        'action': 'start_import'
			    }, 
			    function(response){
			    }
			);

		});
		
	});

	
	
}