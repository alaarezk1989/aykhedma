$(function() {
	'use strict';
	/*---ChartJS (#widgetChart1)---*/
    var ctx = document.getElementById( "widgetChart1" );
    ctx.height = 70;
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            type: 'line',
            datasets: [ {
                data: [1, 18, 9, 17, 34, 22, 11],
                label: 'Marketcap',
                backgroundColor: 'transparent',
                borderColor: '#7673e6',
            }, ]
        },
        options: {

            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [ {
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: 'transparent'
                    }
                } ],
                yAxes: [ {
                    display:false,
                    ticks: {
                        display: false,
                    }
                } ]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                    borderWidth: 3
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    } );
	/*---ChartJS (#widgetChart1) closed---*/

	/*---ChartJS (#widgetChart2)---*/
	var ctx = document.getElementById( "widgetChart2" );
    ctx.height = 70;
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            type: 'line',
            datasets: [ {
                data: [2, 4, 3, 4, 7, 5, 4, 3, 5, 6, 2],
                label: 'Marketcap',
                backgroundColor: 'transparent',
                borderColor: '#f47b25',
            }, ]
        },
        options: {

            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
               cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [ {
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: 'transparent'
                    }
                } ],
                yAxes: [ {
                    display:false,
                    ticks: {
                        display: false,
                    }
                } ]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                    borderWidth: 3
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    });
	/*---ChartJS (#widgetChart2) closed---*/

	/*---HightChart Barchart (#Highchart)---*/
	Highcharts.chart('Highchart', {
		chart: {
			backgroundColor: 'transparent',
			zoomType: 'xy'
		},
		title: {
			text: ''
		},
		subtitle: {
			text: ''
		},
		exporting: {
			enabled: false
		},
		credits: {
			enabled: false
		},
		xAxis: [{
			gridLineColor: 'rgba(0,0,0,0.1)',
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			crosshair: true,
			labels: {
				style: {
					color: '#000',
				}
			}
		}],
		yAxis: [{ // Primary yAxis
			gridLineColor: 'rgba(0,0,0,0.1)',
			labels: {
				format: '{value}',
				style: {
					color: '#000',
				}
			},
			title: {
				text: 'Last Price',
				style: {
					color: '#000',
				}
			}
		}, { // Secondary yAxis
			gridLineColor: 'rgba(0,0,0,0.1)',
			title: {
				text: 'Daily change',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			labels: {
				format: '{value} ',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			opposite: true
		}],
		tooltip: {
			shared: true
		},
		legend: {
			layout: 'vertical',
			align: 'left',
			x: 120,
			verticalAlign: 'top',
			y: 100,
			floating: true,
			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255,255,255)'
		},
		series: [{
			name: 'Last Price',
			type: 'column',
			yAxis: 1,
			data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
			color: '#7673e6',
			tooltip: {
				valueSuffix: ' BTC'
			}
		}, {
			name: 'Daily Change',
			type: 'spline',
			data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
			color: '#f47b25',
			tooltip: {
				valueSuffix: 'BTC'
			}
		}]
	});
	/*---HightChart Barchart (#Highchart) closed---*/

    /*---HightChart AreaChart (#hightchart1)---*/
	Highcharts.chart('hightchart1', {

		chart: {
			type: 'area'
		},
		title: {
			text: ''
		},
		exporting: { enabled: false },
		 credits: {
			  enabled: false
		  },
		xAxis: {
			allowDecimals: false,
			labels: {
				formatter: function () {
					return this.value; // clean, unformatted number for year
				}
			}
		},
		yAxis: {
			title: {
				text: 'values'
			},
			labels: {
				formatter: function () {
					return this.value / 100 ;
				}
			}
		},
		tooltip: {
			pointFormat: '{series.name} had stockpiled <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
		},
		plotOptions: {
			area: {
				pointStart: 1977,
				marker: {
					enabled: false,
					symbol: 'circle',
					radius: 2,
					color:'#000',
					states: {
						hover: {
							enabled: false
						}
					}
				}
			}
		},
		series: [{
			name: 'Hourly Position Values',
			data: [
				24304, 23464, 23708, 24099, 24357, 24237, 24401,
				26662, 26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605,
				20434, 24126, 27387, 29459, 31056, 31982, 32040, 31233, 29224, 27342,
				26662, 26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605,
				24304, 23464, 23708, 24099, 24357, 24237, 24401,,
			],
			color:'rgb(118, 115, 230,0.7)'
		}]
	});
	 /*---HightChart AreaChart (#hightchart1) closed---*/

});