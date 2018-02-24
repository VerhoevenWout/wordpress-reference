
// SET PARAMETER
$("#selectedVenue").change(function(){
	var value = $(this).find("option:selected").attr('value');
	location.href = location.origin + location.pathname + '?value='+value;
});

var url = window.location.href;
url = url.replace(/\?.*/,'');
history.replaceState(null, null, url+'?'+value);

// SET PARAMETER AND APPEND (NOT WORKING)
// var url = window.location.href;    
// if (url.indexOf('?') > -1){
//    url += '&param=1'
// }else{
//    url += '?param=1'
// }
// window.location.href = url;