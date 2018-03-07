var $ = jQuery.noConflict();

var post_id;
var chartsLoaded = false;
var post;
var site_url = globals.site_url;

$('.btn.initStats').click(initStats);
$('.btn.clearStats').click(clearStats);
$("#selectedVenue").change(function(){
	var value = $(this).find("option:selected").attr('value');
	location.href = location.origin + location.pathname + '?venue_key='+value;
});


function initStats() {
	console.log('%c' + 'initStats', 'color: white; font-size: 18px;');
	
	if (!chartsLoaded) {
		google.charts.load('44', {'packages':['corechart']});
		chartsLoaded = true;
	}

	$(".fiches .row").each(function() {
		var post_id = $(this).data('post_id');
		var today = new Date();
		var month = today.getMonth()+1;
		var year = today.getFullYear();

		month = month - 1;
		if(month==0) {
			month = 12;
			year = year - 1;
		}

		// SCROLL TO FICHES
		stats_graph($(this).find(".graph"), post_id, month, year);
		// var offset = $('#fichesanchor').offset().top;
		// $('body,html').animate({scrollTop: offset}, 500);
	});
}

function clearStats()
{
	$('#dayfrom').val('');
	$('#monthfrom').val('');
	$('#yearfrom').val('');
	$('#dayto').val('');
	$('#monthto').val('');
	$('#yearto').val('');

	initStats();
}


var datefrom;
var dateto;

function periodStats()
{
	var dayfrom = $('#dayfrom').val();
	var monthfrom = $('#monthfrom').val();
	var yearfrom = $('#yearfrom').val();
	var dayto = $('#dayto').val();
	var monthto = $('#monthto').val();
	var yearto = $('#yearto').val();

	var periodDates = new Array();

	if(dayfrom&&monthfrom&&yearfrom&&dayto&&monthto&&yearto)
	{
		try {
			datefrom = new Date(yearfrom, monthfrom-1, dayfrom);
			periodDates.push(datefrom);
		} catch(err) {}

		try {
			dateto = new Date(yearto, monthto-1, dayto);
			periodDates.push(dateto);
		} catch(err) {}
	}

	console.log(periodDates);

	return periodDates;
}

function stats_graph(element, post_id, month, year) {
	var types = $('.fiches').data('types').split(',');
	element.addClass("stats-loading");
	stats_companies(element.parent().find(".companies"), post_id, month, year);

	var html = '';

	if(periodStats().length<2)
	{
		html += '<h3>' + month + '/' + year + '</h3>';
		html += '<a href="/ajax/api.php?action=ajax_get_csv&post_id=' + post_id + '&year=' + year + '&month=' + month + '" class="download no-smooth"><i class="fa fa-arrow-circle-o-down"></i></a>';
		html += '<a href="#" class="previous"><i class="s s-arrow-circle-left" aria-hidden="true"></i></a>';
		html += '<a href="#" class="next"><i class="s s-arrow-circle-right" aria-hidden="true"></i></a>';

		$('.btn-clearstats').hide();
	}
	else
	{
		$('.btn-clearstats').show();

		datefrom = periodStats()[0];
		dateto = periodStats()[1];
		html += '<h3>' + datefrom.getDate() + '/' + (datefrom.getMonth()+1) + '/' + datefrom.getFullYear() + ' - ' + dateto.getDate() + '/' + (dateto.getMonth()+1) + '/' + dateto.getFullYear() + '</h3>';
		html += '<a href="/ajax/api.php?action=ajax_get_csv&post_id=' + post_id + '&year=0&month=0&dayfrom=' + datefrom.getDate() + '&monthfrom=' + (datefrom.getMonth()+1) + '&yearfrom=' + datefrom.getFullYear() + '&dayto=' + dateto.getDate() + '&monthto=' + (dateto.getMonth()+1) + '&yearto=' + dateto.getFullYear() + '" class="download no-smooth"><i class="fa fa-arrow-circle-o-down"></i></a>';
	}
	html += '<div id="chart' + post_id + '"></div>';
	element.html(html);

	element.find('a.previous').click(function() {
		month = month - 1;
		if(month==0) {
			month = 12;
			year = year - 1;
		}

		stats_graph(element, post_id, month, year);
		return false;
	});

	element.find('a.next').click(function() {
		month = month + 1;
		if(month==13) {
			month = 1;
			year = year + 1;
		}

		stats_graph(element, post_id, month, year);
		return false;
	});

	var chart_width = element.width();
	var chart_height = 300;

	google.charts.setOnLoadCallback(drawChart(post_id, year, month, chart_width, chart_height, element, types));
}

function drawChart(post_id, year, month, chart_width, chart_height, element, types) {
	// console.log(post_id);

	var dayto;
	var monthto;
	var yearto;
	var dayfrom;
	var monthfrom;
	var yearfrom;

	if(periodStats().length==2)
	{
		datefrom = periodStats()[0];
		dateto = periodStats()[1];

		dayfrom = datefrom.getDate();
		monthfrom = (datefrom.getMonth()+1);
		yearfrom = datefrom.getFullYear();
		dayto = dateto.getDate();
		monthto = (dateto.getMonth()+1);
		yearto = dateto.getFullYear();

		year = 0;
		month = 0;
	}
	
	$.ajax({
		type: 'POST',
		url: '/wp-admin/admin-ajax.php',
		data: {
			action: 'ajax_get_stats_by_day',
			post_id: post_id,
			year: year,
			month: month,

			dayfrom: dayfrom,
			monthfrom: monthfrom,
			yearfrom: yearfrom,
			dayto: dayto,
			monthto: monthto,
			yearto: yearto
		},
		success: function(response) {
			var data = new google.visualization.DataTable();

			var options = {
				animation:{
					duration: 1000,
					easing: 'out',
					"startup": true,
				},
				legend: { position: 'bottom' },
				'width': chart_width,
				'height':chart_height,
				'chartArea': {'top': 45, 'width': '90%'},
				isStacked: true,
				vAxis:{
					baselineColor: '#fff',
					gridlineColor: '#fff',
					textPosition: 'none'
				},
				hAxis:{
					baselineColor: '#fff',
					gridlineColor: '#fff',
					textPosition: 'none'
				},
				backgroundColor: { fill:'transparent' }
			};

			data.addColumn('string', 'Dag');
			for (var j = 0; j < types.length; j++) {
				data.addColumn('number', types[j]);
			}

			for (var i = 0, r; r = response[i]; i++) {
				if(periodStats().length<2)
				{
					element.find('h3').html(r.monthDisplay + ' ' + r.year);
				}

				var row = r.dayDisplay + ' ' + r.day + ' ' + r.monthDisplay.toLowerCase() + ' ' + r.year;
				for (var j = 0; j < types.length; j++) {
					row += ',' + r[types[j]];
				}

				row = row.split(',');
				for (var j = 0; j < row.length; j++) {
					if(j==0) {
						row[j] = String(row[j]);
					} else {
						row[j] = parseInt(row[j]);
					}
				}

				data.addRows([row]);
			}

			var chart = new google.visualization.ColumnChart(document.getElementById('chart' + post_id));
			element.removeClass("stats-loading");
			chart.draw(data, options);
		}
	});
}


function stats_companies(element, post_id, month, year) {
	var types = $('.fiches').data('types').split(',');
	var title = $('.fiches').data('companies_title');

	element.addClass("stats-loading");
	element.html('');

	var dayto;
	var monthto;
	var yearto;
	var dayfrom;
	var monthfrom;
	var yearfrom;

	if(periodStats().length==2)
	{
		datefrom = periodStats()[0];
		dateto = periodStats()[1];

		dayfrom = datefrom.getDate();
		monthfrom = (datefrom.getMonth()+1);
		yearfrom = datefrom.getFullYear();
		dayto = dateto.getDate();
		monthto = (dateto.getMonth()+1);
		yearto = dateto.getFullYear();

		year = 0;
		month = 0;
	}

	$.ajax({
		type: 'POST',
		url: '/wp-admin/admin-ajax.php',
		data: {
			action: 'ajax_get_company_stats',
			post_id: post_id,
			year: year,
			month: month,
			day: 0,

			dayfrom: dayfrom,
			monthfrom: monthfrom,
			yearfrom: yearfrom,
			dayto: dayto,
			monthto: monthto,
			yearto: yearto
		},
		success: function(response) {
			// GET SHOWN IN LOOP
			var html = '';
			html += '<h3>' + title + '</h3>';

			if(periodStats().length<2){
				html += '<a href="/ajax/api.php?action=ajax_get_csv&mode=companies&post_id=' + post_id + '&year=' + year + '&month=' + month + '&day=0" class="download no-smooth"><i class="fa fa-arrow-circle-o-down"></i></a>';
			}
			else{
				html += '<a href="/ajax/api.php?action=ajax_get_csv&mode=companies&post_id=' + post_id + '&year=0&month=0&day=0&dayfrom=' + datefrom.getDate() + '&monthfrom=' + (datefrom.getMonth()+1) + '&yearfrom=' + datefrom.getFullYear() + '&dayto=' + dateto.getDate() + '&monthto=' + (dateto.getMonth()+1) + '&yearto=' + dateto.getFullYear() + '" class="download no-smooth"><i class="fa fa-arrow-circle-o-down"></i></a>';
			}
			html += '<div class="table">';

			var previousname = '';
			for (var i = 0, r; r = response[i]; i++) {
				if(r.name!=previousname)
				{
					html += '<div class="table-row">';
					html += '<div class="table-cell">' + r.name + '</div>';
					html += '</div>';
				}

				previousname = r.name;
			}

			html += '</div>';

			element.html(html);
			element.removeClass("stats-loading");

			return false;
		}
	});
}
