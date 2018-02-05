
// SET PARAMETER
$("#selectedVenue").change(function(){
	var value = $(this).find("option:selected").attr('value');
	location.href = location.origin + location.pathname + '?value='+value;
});

// SET PARAMETER AND APPEND
var url = window.location.href;    
if (url.indexOf('?') > -1){
   url += '&param=1'
}else{
   url += '?param=1'
}
window.location.href = url;