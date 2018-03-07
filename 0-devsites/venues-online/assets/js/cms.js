/*jshint esversion: 6 */

var $ = jQuery.noConflict();
const AJAX_URL = ajaxurl || site.ajaxurl;

var config = {
	id: 			undefined,
	meta_key: 		undefined,
	ajax_action: 	undefined,
	lang: 			undefined,
	reverse: 		false
};

$(document).ready(function() {
	$("body").prepend('<div class="overlay-loading"><i class="fa fa-cog fa-spin"></i></div>');

	$("input#adduser-noconfirmation, input#noconfirmation").attr("checked", "checked");
	$("input#adduser-noconfirmation, input#noconfirmation").parents('tr').css("display", "none");

	config.lang = globals.lang;

	if ($("body").hasClass("user-edit-php") || $("body").hasClass("profile-php")) {
		init_user_edit();
	}

	if ($("body").hasClass("post-type-venues")) {
		init_fiche_edit();
	}

	if ($("body").hasClass("post-type-seopage")) {
		init_seopage_edit();
	}

	if ($("body").hasClass("seopage_page_bulk_seopages")) {
		init_bulk_seopages();
	}

	init_search_posts(config.id);
	init_remove_owned_post(config.id);
});

function init_seopage_edit() {
	config = {
		id: QueryString.post,
		meta_key: "_fiche_seopage",
		ajax_action: "ajax_get_fiches_exclude",
		lang: config.lang
	};
}

function init_bulk_seopages() {
	config = {
		id: QueryString.post,
		meta_key: "_fiche_seopage",
		ajax_action: "ajax_get_fiches_exclude",
		lang: config.lang,
		isbulk: true
	};
}

function init_fiche_edit() {
	config = {
		id: QueryString.post,
		meta_key: "_fiche_seopage",
		ajax_action: "ajax_get_seopages_exclude_fiche",
		lang: config.lang,
		reverse: true // fiche will be the post_id, where seopage will be the meta_value, so we have to reverse the insert in the DB
	};
}

function init_user_edit() {
	config = {
		id: QueryString.user_id,
		meta_key: "_fiche_user",
		ajax_action: "ajax_get_fiches_exclude",
		lang: undefined
	};

	//disable form submit on enter
	$('#your-profile').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) { 
			e.preventDefault();
			return false;
		}
	});
}

function init_search_posts(id) {
	$(".search-meta").on('keyup', function(e) {
		e.preventDefault();
		var $this = $(this);
		var query = $this.val();

		if (query.length > 2) {
			if (e.which === 13) {
				delay(function() {
					get_posts_exclude(query, id);
				}, 0);
			} else {
				delay(function() {
					get_posts_exclude(query, id);
				}, 300);
			}
		} else {
			$(".result-meta").html('<ul><li class="message">Gelieve 3 of meer karakters in te typen...</li></ul>');
		}
	});
}

// Get posts
function get_posts_exclude(query, id) {
	$("table.meta-table").addClass("loading");
	console.log('config.ajax_action');
	console.log(config.ajax_action);
	console.log('config.meta_key');
	console.log(config.meta_key);
	console.log('query');
	console.log(query);
	console.log('id');
	console.log(id);
	$.ajax({
		type: 'POST',
		url: AJAX_URL,
		data: {
			action: config.ajax_action, 
			meta_key: config.meta_key,
			data: query,
			id: id,
			lang: config.lang
		},
		success: function(response){
			var html = "";
			html += '<ul>';

			for (var i = 0, r; r = response[i]; i++) {
				html += '<li data-id="'+r.ID+'">' + r.post_title  + '<span class="lang">(' + r.language_code + ')</span></li>';
			}

			html += '</ul>';
			$(".result-meta").html(html);
			$("table.meta-table").removeClass("loading");

			init_add_owned_post(id);

			return false;
		},
		error: function(response){
			console.log('error');
			console.log(response);
		}
	});
}

function bulk_fiches(post_id, action)
{
	var fiches = [];

	if($('#data-fiches').val())
	{
		fiches = $('#data-fiches').val().split(',');
	}
	var index = fiches.indexOf(post_id.toString());

	if(action=='add')
	{
		if (index = -1) {
			fiches.push(post_id);
		}
	}

	if(action=='delete')
	{
		if (index > -1) {
    		fiches.splice(index, 1);
		}
	}

	$('#data-fiches').val(fiches.join());
}

function init_add_owned_post(meta_value) {
	$(".result-meta ul li").click(function() {
		var $this = $(this);
		var $clone = $this.clone();
		$clone.append('<button class="delete"><i class="fa fa-times"></i></button>');
		$(".owned-meta ul").append($clone);

		var post_id = $this.data("id");

		if(!config.isbulk) {
			if (config.reverse) {
				handle_post_meta("create", meta_value, post_id);
			} else {
				handle_post_meta("create", post_id, meta_value);
			}
		}
		else {
			bulk_fiches(post_id, 'add');
		}

		init_remove_owned_post(meta_value);
		$this.remove();
	});
}

function init_remove_owned_post(meta_value) {
	$(".owned-meta ul li button.delete").click(function() {
		var $this = $(this);
		var $li = $this.parent("li");
		var post_id = $li.data("id");

		if(!config.isbulk) {
			if (config.reverse) {
				handle_post_meta("delete", meta_value, post_id);
			} else {
				handle_post_meta("delete", post_id, meta_value);
			}
		}
		else {
			bulk_fiches(post_id, 'delete');
		}

		$li.remove();
		$(".search-meta").val("");
		$(".result-meta").html("");
	});
}

function handle_post_meta(crud, post_id, meta_value) {
	$("body").addClass("loading");
	$.ajax({
		type: 'POST',
		url: AJAX_URL,
		data: {
			action: "ajax_handle_post_meta", 
			crud: crud,
			post_id: post_id,	
			meta_key: config.meta_key,
			meta_value: meta_value
		},
		success: function(response) {
			$("body").removeClass("loading");

			return false;
		}
	});
}

var lang = function() {
	var locale = $("html").attr("lang");
	var lang = locale.split("-")[0].toLowerCase();

	return lang;
};

var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout(timer);
		timer = setTimeout(callback, ms);
	};
})();

var QueryString = function () {
	var query_string = {};
	var query = window.location.search.substring(1);
	var vars = query.split("&");

	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		// If first entry with this name
		if (typeof query_string[pair[0]] === "undefined") {
			query_string[pair[0]] = decodeURIComponent(pair[1]);
		// If second entry with this name
	} else if (typeof query_string[pair[0]] === "string") {
		var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
		query_string[pair[0]] = arr;
		// If third or later entry with this name
	} else {
		query_string[pair[0]].push(decodeURIComponent(pair[1]));
	}	
} 

return query_string;
}();