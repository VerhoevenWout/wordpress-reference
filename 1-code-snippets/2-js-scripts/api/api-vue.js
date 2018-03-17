this.$http.get('//freegeoip.net/json/?').then(response => {
	var ipaddress = response.body.ip;
	console.log(ipaddress);
	this.ipaddress = ipaddress;
	localStorage.setItem("ipaddress", ipaddress);
}, response => {
	console.log(response);
});

// --------------------
// OR WITH PARAMS
// --------------------

var vm = this;
var url = window.location.href;
url = url.replace('.loc/', '.com/');

var data = {
	fields: 'id,share,og_object{engagement{reaction_count},likes.summary(true).limit(0),comments.limit(0).summary(true)}',
	id: url
}
this.$http.get('https://graph.facebook.com/', {params: data})
.then(function (response){
    var shareCount = response.body.share.share_count;
    console.log(shareCount);

}, function(error){
    console.log(error);

});