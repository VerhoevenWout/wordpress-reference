var $ = require('jquery');
var Dropzone = require('dropzone');

module.exports = function(){

	Dropzone.options.importDropzone = {
		
		success: function(file, response){
			refreshTable();
		}

	}


	function refreshTable(){
		$.post(
		    '/wp-admin/admin-ajax.php', 
		    {
		        'action': 'get_csvs_table'
		    }, 
		    function(response){
		     	$('#csvTable').html(response);
		    }
		);

	}

}