// /*jshint esversion: 6 */

// var $ = jQuery.noConflict();

// $(document).ready(function() {
// 	if ($("body").hasClass("toplevel_page_stats")) {
// 		var types = $('#params').data('types').split(',');

// 		init_stats(types);
// 	}
// });

// function init_stats(types)
// {
// 	$("a.fiche").click(function() {
// 		var post_id = $(this).data('post_id');
// 		var post_title = $(this).data('title');
// 		var post_container = $(this).parent().parent();

// 		var yearfrom = document.params.yearfrom.options[document.params.yearfrom.selectedIndex].value;
// 		var yearto = document.params.yearto.options[document.params.yearto.selectedIndex].value;

// 		if($('#stats_by_month_' + post_id).length==0)
// 		{
// 			post_container.after('<div class="ajax-wrapper" id="stats_by_month_' + post_id + '"></div>');

// 			$('#stats_by_month_' + post_id).addClass("loading");

// 			$.ajax({
// 				type: 'POST',
// 				url: AJAX_URL,
// 				data: {
// 					action: 'ajax_get_stats_by_month',
// 					post_id: post_id,
// 					yearfrom: yearfrom,
// 					yearto: yearto
// 				},
// 				success: function(response) {
// 					var html = '';

// 					for (var i = 0, r; r = response[i]; i++) {
// 						html += '<div class="table-row">';
// 						html += '<div class="table-cell"><a href="#" class="month" data-post_id="' + post_id + '" data-title="' + post_title + '" data-month="' + r.month + '" data-year="' + r.year + '">' + r.monthDisplay + ' ' + r.year + '</a><a href="admin-ajax.php?action=ajax_get_csv&post_id=' + post_id + '&year=' + r.year + '&month=' + r.month + '" class="download"><i class="fa fa-arrow-circle-o-down"></i></a></div>';

// 						for (var j = 0; j < types.length; j++) {
// 							html += '<div class="table-cell">' + r[types[j]] + '</div>';
// 						}

// 						html += '<div class="table-cell"><a href="#" class="fiche-company" data-post_id="' + post_id + '" data-title="' + post_title + ' - ' + r.monthDisplay + ' ' + r.year + '" data-year="' + r.year + '" data-month="' + r.month + '" data-day="0">' + r.companies + '</a></div>';
// 						html += '</div>';
// 					}

// 					$('#stats_by_month_' + post_id).html(html);
// 					$('#stats_by_month_' + post_id).removeClass("loading");

// 					init_stats_by_month(types, '#stats_by_month_' + post_id);
// 					init_stats_companies(types);

// 					return false;
// 				}
// 			});
// 		}
// 		else
// 		{
// 			$('#stats_by_month_' + post_id).toggle();
// 		}

// 		return false;
// 	});

// 	init_stats_companies(types);
// }

// function init_stats_by_month(types, single)
// {
// 	$(single + " a.month").click(function() {
// 		var post_id = $(this).data('post_id');
// 		var post_title = $(this).data('title');
// 		var year = $(this).data('year');
// 		var month = $(this).data('month');
// 		var month_container = $(this).parent().parent();

// 		if($('#stats_by_day_' + post_id + '_' + month).length==0)
// 		{
// 			month_container.after('<div class="ajax-wrapper" id="stats_by_day_' + post_id + '_' + month + '"></div>');

// 			$('#stats_by_day_' + post_id + '_' + month).addClass("loading");

// 			$.ajax({
// 				type: 'POST',
// 				url: AJAX_URL,
// 				data: {
// 					action: 'ajax_get_stats_by_day',
// 					post_id: post_id,
// 					year: year,
// 					month: month
// 				},
// 				success: function(response) {
// 					var html = '';

// 					for (var i = 0, r; r = response[i]; i++) {
// 						html += '<div class="table-row">';
// 						html += '<div class="table-cell">' + r.dayDisplay + ' ' + r.day + ' ' + r.monthDisplay.toLowerCase() + ' ' + year + '</div>';

// 						for (var j = 0; j < types.length; j++) {
// 							html += '<div class="table-cell">' + r[types[j]] + '</div>';
// 						}

// 						html += '<div class="table-cell"><a href="#" class="fiche-company" data-post_id="' + post_id + '" data-title="' + post_title + ' - ' + r.dayDisplay + ' ' + r.day + ' ' + r.monthDisplay.toLowerCase() + ' ' + year + '" data-year="' + year + '" data-month="' + r.month + '" data-day="' + r.day + '">' + r.companies + '</a></div>';
// 						html += '</div>';
// 					}

// 					$('#stats_by_day_' + post_id + '_' + month).html(html);
// 					$('#stats_by_day_' + post_id + '_' + month).removeClass("loading");

// 					init_stats_companies(types);

// 					return false;
// 				}
// 			});
// 		}
// 		else
// 		{
// 			$('#stats_by_day_' + post_id + '_' + month).toggle();
// 		}

// 		return false;
// 	});
// }

// function init_stats_companies(types)
// {
// 	$("a.fiche-company").click(function() {
// 		var post_id = $(this).data('post_id');
// 		var post_title = $(this).data('title');
// 		var year = $(this).data('year');
// 		var month = $(this).data('month');
// 		var day = $(this).data('day');

// 		stats_companies(types, post_id, post_title, year, month, day);

// 		return false;
// 	});
// }

// function stats_companies(types, post_id, title, year, month, day)
// {
// 	if($('#stats_popup').length==0)
// 	{
// 		$('body').prepend('<div id="stats_overlay"><div id="stats_popup"></div></div>');

// 		$("#stats_overlay").click(function() {
// 			$("#stats_overlay").remove();
// 		});
// 	}

// 	var dayto;
// 	var monthto;
// 	var yearto;
// 	var dayfrom;
// 	var monthfrom;
// 	var yearfrom;

// 	if(year==0)
// 	{
// 		dayto = document.params.dayto.options[document.params.dayto.selectedIndex].value;
// 		monthto = document.params.monthto.options[document.params.monthto.selectedIndex].value;
// 		yearto = document.params.yearto.options[document.params.yearto.selectedIndex].value;
// 		dayfrom = document.params.dayfrom.options[document.params.dayfrom.selectedIndex].value;
// 		monthfrom = document.params.monthfrom.options[document.params.monthfrom.selectedIndex].value;
// 		yearfrom = document.params.yearfrom.options[document.params.yearfrom.selectedIndex].value;
// 	}

// 	// console.log(dayfrom + '-' + monthfrom + '-' + yearfrom + ' - ' + dayto + '-' + monthto + '-' + yearto);

// 	$('#stats_popup').addClass("loading");

// 	$.ajax({
// 		type: 'POST',
// 		url: AJAX_URL,
// 		data: {
// 			action: 'ajax_get_company_stats',
// 			post_id: post_id,
// 			year: year,
// 			month: month,
// 			day: day,

// 			dayfrom: dayfrom,
// 			monthfrom: monthfrom,
// 			yearfrom: yearfrom,
// 			dayto: dayto,
// 			monthto: monthto,
// 			yearto: yearto
// 		},
// 		success: function(response) {
// 			var html = '';
// 			html += '<div><h2>' + title + '</h2><a href="admin-ajax.php?action=ajax_get_csv&mode=companies&post_id=' + post_id + '&year=' + year + '&month=' + month + '&day=' + day;

// 			if(year==0)
// 			{
// 				html += '&dayfrom=' + dayfrom + '&monthfrom=' + monthfrom + '&yearfrom=' + yearfrom + '&dayto=' + dayto + '&monthto=' + monthto + '&yearto=' + yearto;
// 			}

// 			html += '" class="download"><i class="fa fa-arrow-circle-o-down"></i></a></div>';
// 			html += '<div class="table-row table-header">';
// 			html += '<div class="table-cell">Bedrijf</div>';
// 			for (var j = 0; j < types.length; j++) {
// 				html += '<div class="table-cell">' + types[j] + '</div>';
// 			}
// 			html += '</div>';

// 			for (var i = 0, r; r = response[i]; i++) {
// 				html += '<div class="table-row">';
// 				html += '<div class="table-cell">' + r.name + ' (' + r.ipaddress + ')</div>';

// 				for (var j = 0; j < types.length; j++) {
// 					html += '<div class="table-cell">' + r[types[j]] + '</div>';
// 				}

// 				html += '</div>';
// 			}

// 			$('#stats_popup').html(html);
// 			$('#stats_popup').removeClass("loading");

// 			return false;
// 		}
// 	});
// }