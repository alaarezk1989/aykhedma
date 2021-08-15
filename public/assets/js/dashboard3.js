$(function() {
	'use strict';

	/*---Morris (#line-chart)---*/
	var line = new Morris.Line({
		element: 'line-chart',
		resize: true,
		data: [{
 			y: '2015 Q1',
 			item1: 2666
 		}, {
 			y: '2016 Q2',
 			item1: 2778
 		}, {
 			y: '2016 Q3',
 			item1: 4912
 		}, {
 			y: '2017 Q4',
 			item1: 3767
 		}, {
 			y: '2017 Q1',
 			item1: 6810
 		}, {
 			y: '2018 Q2',
 			item1: 15670
 		}, {
 			y: '2018 Q3',
 			item1: 4820
 		}, {
 			y: '2018 Q4',
 			item1: 15073
 		}, {
 			y: '2019 Q1',
 			item1: 10687
 		}, {
 			y: '2019 Q2',
 			item1: 8432
 		}],
		xkey: 'y',
 		ykeys: ['item1'],
 		labels: ['Users'],
 		lineColors: ['#7673e6'],
		pointRadius: 0,
 		hideHover: 'auto',
		parseTime: false
	});
	/*---Morris (#line-chart) closed---*/

	/*----Morris (#donutchart)----*/
	var donut = new Morris.Donut({
		element: 'donutchart',
		resize: true,
		colors: ['#f47b25', '#7673e6', '#ffb209','#01b8ff'],
		data: [{
			label: "Google+",
			value: 30
		}, {
			label: "Face Book",
			value: 40
		}, {
			label: "Twitter",
			value: 10
		},  {
			label: "You Tube",
			value: 20
		}],
		labelColor:"#555858",
		hideHover: 'auto'
	});
	/*----Morris (#donutchart) closed----*/

	/*----Apex (#barchart)----*/
	var options = {
		chart: {
			height: 330,
			type: 'bar',
		},
		plotOptions: {
			bar: {
				horizontal: false,
				endingShape: 'rounded',
				columnWidth: '55%',
			},
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		colors: ['#7673e6','#f47b25'],
		series: [{
			name: 'Users',
			data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
		}, {
			name: 'Page Views',
			data: [44, 55, 57, 56, 61, 58, 63, 60, 66]

		}],
		xaxis: {
			categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		},
		yaxis: {
			title: {
				text: 'Users'
			}
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			y: {
				formatter: function(val) {
					return "$ " + val + " thousands"
				}
			}
		}
	}
	var chart = new ApexCharts(document.querySelector("#barchart"), options);
	chart.render();

	if ($("#Area-chart").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug","Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
        datasets: [{
            data: [130, 120, 140, 135, 170, 145, 160, 115, 190,135,240, 270, 240,270, 260, 200, 300,290, 220, 200, 240, 200, 230, 220,  190,185, 220, 120, 250],
           backgroundColor: 'rgb(215, 215, 247,0.4)',
            borderColor: [
              '#c8c7e6'
            ],
            borderWidth: 3,
            fill: 'origin',
            label: "Bounce Rate"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          filler: {
            propagate: false
          }
        },
        scales: {
          xAxes: [{
            display: false,
            ticks: {
              display: true
            },
            gridLines: {
              display: false,
              drawBorder: false,
              color: 'transparent',
              zeroLineColor: '#eeeeee'
            }
          }],
          yAxes: [{
            display: false,
            ticks: {
              display: true,
              autoSkip: false,
              maxRotation: 0,
              stepSize: 100,
              min: 0,
              max: 300
            },
            gridLines: {
              drawBorder: false
            }
          }]
        },
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        elements: {
          line: {
            tension: .09
          },
          point: {
            radius: 0
          }
        }
      }
      var salesChartCanvas = $("#Area-chart").get(0).getContext("2d");
      var salesChart = new Chart(salesChartCanvas, {
        type: 'line',
        data: areaData,
        options: areaOptions
      });
    }
    /*----Apex (#barchart) closed----*/

	/*----Morris Linechart (#graph2)----*/
	var day_data = [{
		"sales": "Jan",
		"value": 34
	}, {
		"sales": "feb",
		"value": 24
	}, {
		"sales": "Mar",
		"value": 3
	}, {
		"sales": "Apr",
		"value": 12
	}, {
		"sales": "May",
		"value": 13
	}, {
		"sales": "Jun",
		"value": 22
	}, {
		"sales": "Jul",
		"value": 5
	}, {
		"sales": "Aug",
		"value": 26
	}, {
		"sales": "Sep",
		"value": 12
	}, {
		"sales": "Oct",
		"value": 19
	}];
	Morris.Line({
		element: 'graph2',
		data: day_data,
		xkey: 'sales',
		ykeys: ['value'],
		labels: ['value'],
		parseTime: false,
		lineColors: ['#7673e6', '#00d9bf']
	});
	/*----Morris Linechart (#graph2) closed----*/

});