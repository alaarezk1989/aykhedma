$(function(e){
  'use strict'

	//Sparkline charts
	$(".sparkline_one").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
		type: 'bar',
		height: '125',
		barWidth: 13,
		colorMap: {

		},
		barSpacing: 2,
		barColor: '#00bcd4'
	});


	$(".sparkline_two").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
		type: 'bar',
		height: '40',
		barWidth: 9,
		colorMap: {
		},
		barSpacing: 2,
		barColor: '#00e682'
	});


	$(".sparkline_three").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
		type: 'line',
		width: '260',
		height: '90',
		lineColor: '#22e840',
		fillColor: '#c2efc9',
		lineWidth: 2,
		spotColor: '#00e682',
		minSpotColor: '#00e682'
	});


	$(".sparkline11").sparkline([3, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
		type: 'bar',
		height: '43',
		barWidth: 12,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 1,
		barColor: '#00e682'
	});
	$(".sparkline12").sparkline([3, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
		type: 'bar',
		height: '43',
		barWidth: 12,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 1,
		barColor: '#ffa22b'
	});
	$(".sparkline11a").sparkline([9, 6, 4, 9, 3, 5, 2, 4, 8, 5, 9, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
		type: 'bar',
		height: '180',
		barWidth: 10,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 1,
		barColor: '#7673e6'
	});
	$(".sparkline11b").sparkline([3, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
		type: 'bar',
		height: '43',
		barWidth: 12,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 1,
		barColor: '#ffa22b'
	});
	$(".sparkline11c").sparkline([3, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
		type: 'bar',
		width: '200',
		height: '43',
		barWidth: 12,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 1,
		barColor: '#ffa22b'
	});
	$(".sparkline14").sparkline([3, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
		type: 'bar',
		width: '270',
		height: '93',
		barWidth: 12,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 1,
		barColor: '#ffa22b'
	});
	$(".sparkline15").sparkline([3, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
		type: 'bar',
		width: '270',
		height: '93',
		barWidth: 12,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 1,
		barColor: '#7673e6'
	});

	$(".sparkline16").sparkline([ 5, 4, 3, 5, 6, 2, 4, 3, 4,4, 6, 2, 4], {
		type: 'bar',
		width: '270',
		height: '93',
		barWidth: 8,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 6,
		barColor: '#ffb209'
	});

	$(".sparkline17").sparkline([ 5, 4, 3, 4, 8, 5, 4, 3, 5, 6, 2, 4, 3, 4, 5, 4, 5, 4], {
		type: 'bar',
		width: '200',
		height: '130',
		barWidth: 9,
		colorMap: {
			'7': '#a1a1a1'
		},
		barSpacing: 7,
		barColor: '#ffb209'
	});

	$(".sparkline22").sparkline([2, 4, 3, 4, 7, 5, 4, 3, 5, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6], {
		type: 'line',
		height: '40',
		width: '200',
		lineColor: '#00e682',
		fillColor: '#ffffff',
		lineWidth: 3,
		spotColor: '#ffa22b',
		minSpotColor: '#ffa22b'
	});

	$(".sparkline23").sparkline([2, 4, 3, 4, 7, 5, 4, 3, 5, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6], {
		type: 'line',
		height: '90',
		width: '260',
		lineColor: '#01b8ff',
		fillColor: '#ffffff',
		lineWidth: 3,
		spotColor: '#ffb209',
		minSpotColor: '#ffa22b'
	});


	$(".sparkline_bar").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5], {
		type: 'bar',
		height: 50,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#f47b25',
		barSpacing: 4
	});
	$(".sparkline_bar-1").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
		type: 'bar',
		height: 50,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#7673e6',
		barSpacing: 4
	});

	$(".sparkline_bar28").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
		type: 'bar',
		height: 80,
		width:250,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#7673e6'
	});

	$(".sparkline_bar1").sparkline([5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 2], {
		type: 'bar',
		height: 40,
		width:120,
		barSpacing: 4,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#f47b25 '
	});

	$(".sparkline_bar2").sparkline([2, 1, 3, 4, 3, 4, 3, 4, 3, 4, 3, 2, 1], {
		type: 'bar',
		height: 40,
		width:120,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#01b8ff'
	});

	$(".sparkline_bar3").sparkline([5, 2, 4, 5, 8, 3, 4, 6, 8, 3, 3, 2, 3], {
		type: 'bar',
		height: 40,
		width:120,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#f47b25'
	});

	$(".sparkline_bar4").sparkline([5, 2, 4, 5, 8, 3, 4, 6, 8, 3, 3, 2, 3], {
		type: 'bar',
		height: 40,
		width:120,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#ff473d'
	});

	$(".sparkline_area").sparkline([5, 2, 4, 5, 8, 3, 4, 6, 8, 3, 3, 2], {
		type: 'line',
		width: 50,
		height: 50,
		lineColor: '#ffa22b',
		fillColor: '#ffa22b',
		spotColor: '#f44336',
		minSpotColor: '#f44336',
		maxSpotColor: '#f44336',
		highlightSpotColor: '#f44336',
		highlightLineColor: '#f44336',
		spotRadius: 2.5,
		width: 85
	});

	$(".sparkline_area2").sparkline([5, 2, 4, 5, 8, 3, 4, 6, 8, 3, 3, 2], {
		type: 'line',
		width: 50,
		height: 90,
		lineColor: '#b03cd5',
		fillColor: '#e8baf7',
		spotColor: '#f44336',
		minSpotColor: '#f44336',
		maxSpotColor: '#f44336',
		highlightSpotColor: '#f44336',
		highlightLineColor: '#f44336',
		spotRadius: 2.5,
		width: 260
	});


	$(".sparkline_area3").sparkline([5, 2, 4, 5, 8, 3, 4, 6, 8, 3, 3, 2,2, 4, 3, 4, 5, 4, 5, 4, 3, 4,], {
		type: 'line',
		lineThickness: 5,
		height: 50,
		lineColor: '#ffa22b',
		fillColor: 'transparent',
		spotColor: '#f44336',
		minSpotColor: '#f44336',
		maxSpotColor: '#f44336',
		highlightSpotColor: '#f44336',
		highlightLineColor: '#f44336',
		spotRadius: 1.5,
		width: 85
	});


	$(".sparkline_area1").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
		type: 'line',
		width: 50,
		height: 50,
		lineColor: '#ffa22b',
		fillColor: '#ffa22b',
		spotColor: '#f44336',
		minSpotColor: '#f44336',
		maxSpotColor: '#f44336',
		highlightSpotColor: '#f44336',
		highlightLineColor: '#f44336',
		spotRadius: 2.5,
		width: 280,
		height:165
	});


	$(".sparkline_line").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
		type: 'line',
		lineColor: '#7673e6',
		fillColor: '#7673e6',
		width: 80,
		height: 50,
		spotColor: '#f44336',
		minSpotColor: '#f44336'
	});

    $(".sparkline_line1").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5], {
		type: 'line',
		lineColor: '#ffb209 ',
		fillColor: '#ffb209 ',
		width: 80,
		height: 50,
		spotColor: '#f44336',
		minSpotColor: '#f44336'
	});

	$(".sparkline_pie").sparkline([1, 1, 2, 1], {
		type: 'pie',
		width: 50,
		height: 50,
		sliceColors: ['#01b8ff','#f47b25','#7673e6','#ffb209']
	});

	$(".sparkline_pie2").sparkline([1, 1, 2, 1], {
		type: 'pie',
		width: 140,
		height: 140,
		sliceColors: ['#01b8ff','#f47b25','#7673e6','#ffb209']
	});


	$(".sparkline_discreet").sparkline([4, 6, 7, 7, 4, 3, 2, 1, 4, 4, 2, 4, 3, 7, 8, 9, 7, 6, 4, 3,2, 4, 3, 4, 5, 4, 5, 4, 3], {
		type: 'discrete',
		barWidth: 100,
		lineColor: '#f47b25 ',
		width: 150,
		height: 50,
	});

});