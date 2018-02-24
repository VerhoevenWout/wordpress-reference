
// REDIRECT URL (with params)
window.location.href = '/' + lang + '/external-link/?id='+parent_post_id+'&url='+url+'&title='+short_title+'';

// SIMPLE
var param = window.location.search;
param = param.replace('?','');
console.log('%c' + param, 'color: white; font-size: 18px;');

// OTHER EXAMPLE
getExternalLinkData(){
	var url = location.href;
	console.log(this.getUrlParameter('url'));
	this.externalLinkUrl = this.getUrlParameter('url');
	this.externalLinkPostId = this.getUrlParameter('id');
	this.externalLinkShortTitle = this.getUrlParameter('title');
},

getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));

    // REMOVE TRAILING SLASH
    // results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    // results = results[1].replace(/\/$/, "");
    // return results;
},

getUrlParameter: function(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));

    // REMOVE TRAILING SLASH
    // results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    // results = results[1].replace(/\/$/, "");
    // return results;
},