$(function() {
	'use strict';
	/*---ChartJS (#barChart)---*/
	var ctx = document.getElementById( "barChart" );
    ctx.height = 263;
	var barChart = new Chart(ctx, {
      type: 'bar',
	  data: {
          labels: ["Rose", "Harry", "Sophie", "James", "Jasmine"],
          datasets: [{
              label: 'Project Task',
              data: [19, 15, 17, 14, 12],
			  barGap:4,
			  barSizeRatio:1,
              backgroundColor: [
                  '#7673e6',
                  '#f47b25',
                  '#f6d30c',
                  '#22e840',
                  '#b03cd5',
                  '#f21887 '
              ],
              borderColor: [
                  '#7673e6',
                  '#f47b25',
                  '#f6d30c',
                  '#22e840',
                  '#b03cd5',
                  '#f21887 '
              ],
              borderWidth: 1
          }]
      },
      options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{
					barThickness : 30,
					ticks: {
						fontColor: "rgba(0,0,0,0.5)",
					 },
					gridLines: {
						display: false,
					}
				}],
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: "rgba(0,0,0,0.5)",
					},
					gridLines: {
						display: false
					},
				}]
			},
			legend: {
				labels: {
					fontColor: "rgba(0,0,0,0.5)"
				},
			},
		}
    });
	/*---ChartJS (#barChart) closed---*/

    /*---ChartJS (#team-chart)---*/
	var ctx = document.getElementById("team-chart");
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["2013", "2014", "2015", "2016", "2017", "2018", "2019"],
			type: 'line',
			datasets: [{
				data: [0, 7, 3, 5, 2, 10, 7],
				label: "Budget",
				backgroundColor: 'rgba(118, 115, 230, 0.7)',
				borderColor: 'rgba(118, 115, 230)',
				borderWidth: 3.5,
				pointStyle: 'circle',
				pointRadius: 5,
				pointBorderColor: 'transparent',
				pointBackgroundColor: 'rgba(118, 115, 230)',
			}, ]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#000',
				bodyFontColor: '#000',
				backgroundColor: '#fff',
				cornerRadius: 3,
				intersect: false,
			},
			legend: {
				display: false,
				position: 'top',
				labels: {
					usePointStyle: true,
				},
			},
			scales: {
				xAxes: [{
					ticks: {
						fontColor: "rgba(0,0,0,0.5)",
					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: true,
						color: 'rgba(0,0,0,0.1)'
					},
					scaleLabel: {
						display: true,
						labelString: 'Year',
						fontColor: 'rgba(0,0,0,0.61)'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "rgba(0,0,0,0.5)",
					 },
					display: true,
					gridLines: {
						display: false,
						drawBorder: false,
						color: 'rgba(0,0,0,0.061)'
					},
					scaleLabel: {
						display: true,
						labelString: 'Budget',
						fontColor: 'rgba(0,0,0,0.61)'
					}
				}]
			},
			title: {
				display: false,
			}
		}
	});
	/*---ChartJS (#team-chart) closed---*/

	/*---ChartJS (#lineChart)---*/
	var ctx = document.getElementById( "lineChart" );
	ctx.height = 270;
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
			datasets: [{
				label: "CPU",
				borderColor: "rgba(118, 115, 230, 0.9)",
				borderWidth: "1",
				backgroundColor: "rgba(118, 115, 230, 0.8)",
				data: [0, 30, 10, 120, 50, 63, 102]
			}, {
				label: "Memory",
				borderColor: "rgba(244, 123, 37 ,0.9)",
				borderWidth: "1",
				backgroundColor: "rgba(	244, 123, 37, 0.7)",
				pointHighlightStroke: "rgba(244, 123, 37 ,0.9)",
				data: [0, 50, 40, 80, 40, 79, 120]
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				intersect: false
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			scales: {
				xAxes: [{
					ticks: {
						fontColor: "rgba(0,0,0,0.5)",
					 },
					gridLines: {
						color: 'rgba(0,0,0,0.061)'
					}
				}],
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: "rgba(0,0,0,0.5)",
					},
					gridLines: {
						color: 'rgba(0,0,0,0.061)'
					},
				}]
			},
			legend: {
				labels: {
					fontColor: "rgba(0,0,0,0.5)"
				},
			},
		}
	});
	/*---ChartJS (#lineChart) closed---*/


});
