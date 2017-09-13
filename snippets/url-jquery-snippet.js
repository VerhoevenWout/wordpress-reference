// 1. Get The Current Page URL
// A very simple snippet, which stores the current page URL in a variable:
// Retrieve current URL
var url = document.URL;

// 2. Get The Current Root URL
// A very simple snippet, which stores the root URL in a variable:
// Retrieve root URL
var root = location.protocol + '//' + location.host;

// 3. Get A URL Hash Parameter
// Retrive a hash parameter and store in a variable:
// Get # parameter
var param = document.URL.split('#')[1];

// 4. Change Browser Address Bar Hash Parameter
// In the example below we replace the hash parameter, which we get from the clicked link. Useful for adding bookmarking capabilities when using AJAX:
// update browser address bar URL
$('a.demo-link').click(function(){
    var hash = $(this).attr('href');
    location.hash = hash;
});

// 5. Redirect Using Javascript
// If you need to redirect a page using jQuery:
// Redirect - insert required URL
window.location.href = "http://designchemical.com/";

// 6. Get Querystring Parameters
// If the URL contains a querystring with multiple parameters the following snippet will parse each parameter and store the array as a variable:
var vars = [], hash;
    var q = document.URL.split('?')[1];
    if(q != undefined){
        q = q.split('&');
        for(var i = 0; i < q.length; i++){
            hash = q[i].split('=');
            vars.push(hash[1]);
            vars[hash[0]] = hash[1];
        }
}
// To use any of the parameters you can access the value using the parameter name. E.g. if the URL contains the querystring “?a=3&b=2&c=1″ you can access the value for “a” using:
// Will alert the value of parameter a
alert(vars['a']);

// 7. Highlight Current Menu Item
// Rather than manually modify navigation menus to add an “active” class to the current page we can use jQuery to identify which link contains the current URL:
var url = document.URL;
$('#menu a[href="'+url+'"]').addClass('active');

// 8. Check If Link Contains External URL
// The following snippet will check if a clicked link contains a URL to an external web page and if so, open in a new browser window:
var root = location.protocol + '//' + location.host;
$('a').not(':contains(root)').click(function(){
    this.target = "_blank";
});