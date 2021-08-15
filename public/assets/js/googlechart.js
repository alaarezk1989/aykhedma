$(function() {
	'use strict';


	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	google.charts.setOnLoadCallback(drawChart1);
	google.charts.setOnLoadCallback(drawChart2);
	google.charts.setOnLoadCallback(drawVisualization);

	//areachart
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		  ['Year', 'Sales', 'Expenses'],
		  ['2013',  1000,      400],
		  ['2014',  1170,      460],
		  ['2015',  660,       1120],
		  ['2016',  1030,      540]
		]);

		var options = {
			hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
			vAxis: {minValue: 0},
			chartArea:{width:"80%",height:"80%"},
			'legend': {'position': 'top'}
		};

		var chart = new google.visualization.AreaChart(document.getElementById('chart_area'));
		chart.draw(data, options);
	}

	//pie chart
	function drawChart1() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
		  'legend': {'position': 'bottom'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }

	//pie chart
	function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
		  'legend': {'position': 'bottom'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }

	//combo charts
	function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
          ['2014/05',  165,      938,         522,             998,           450,      614.6],
          ['2015/06',  135,      1120,        599,             1268,          288,      682],
          ['2016/07',  157,      1167,        587,             807,           397,      623],
          ['2017/08',  139,      1110,        615,             968,           215,      609.4],
          ['2018/09',  136,      691,         629,             1026,          366,      569.6]
        ]);

        var options = {
          title : 'Monthly Coffee Production by Country',
          vAxis: {title: 'Cups'},
          hAxis: {title: 'Month'},
          seriesType: 'bars',
          series: {5: {type: 'line'}},
		  'legend': {'position': 'bottom'}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('combo-chart'));
        chart.draw(data, options);
    }

	//barchart
	google.charts.load('current', {'packages':['bar']});
	google.charts.setOnLoadCallback(drawbarChart);
	function drawbarChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses', 'Profit'],
          ['2014', 1000, 400, 200],
          ['2015', 1170, 460, 250],
          ['2016', 660, 1120, 300],
          ['2017', 1030, 540, 350]
        ]);

        var options = {
		  bars: 'vertical',
          vAxis: {format: 'decimal'},
          colors: ['#7673e6', '#f47b25', '#b03cd5'],

        };

        var chart = new google.charts.Bar(document.getElementById('chart_bar'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

        var btns = document.getElementById('btn-group');
	}

	//linechart
	google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawlineChart);

    function drawlineChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Daily');
      data.addColumn('number', 'Slaes');
      data.addColumn('number', 'Profit');
      data.addColumn('number', 'Gain');

      data.addRows([
        [1,  37.8, 80.8, 41.8],
        [2,  30.9, 69.5, 32.4],
        [3,  25.4,   57, 25.7],
        [4,  11.7, 18.8, 10.5],
        [5,  11.9, 17.6, 10.4],
        [6,   8.8, 13.6,  7.7],
        [7,   7.6, 12.3,  9.6],
        [8,  12.3, 29.2, 10.6],
        [9,  16.9, 42.9, 14.8],
        [10, 12.8, 30.9, 11.6],
        [11,  5.3,  7.9,  4.7],
        [12,  6.6,  8.4,  5.2],
        [13,  4.8,  6.3,  3.6],
        [14,  4.2,  6.2,  3.4]
      ]);

      var options = {
        chart: {
        },
        axes: {
          x: {
            0: {side: 'bottom'}
          }
        }

      };

      var chart = new google.charts.Line(document.getElementById('line'));

      chart.draw(data, google.charts.Line.convertOptions(options));
	}
});