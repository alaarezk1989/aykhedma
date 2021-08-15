$(function() {
	/*---echart (#echart2)---*/
	var myChart2 = echarts.init(document.getElementById('echart2'));
	option2 = {
		title: {
			text: '',
			subtext: '',
			x: 'center'
		},
		tooltip: {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} ({d}%)"
		},
		legend: {
			x: 'center',
			y: 'bottom',
			data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
			textStyle: {
				color: 'rgba(0,0,0,0.3)'
			}
		},
		toolbox: {
			show: true,
			feature: {
				mark: {
					show: true
				}
			}
		},
		calculable: true,
		series: [{
			name: '',
			type: 'pie',
			radius: [20, 110],
			center: ['50%', '50%'],
			roseType: 'radius',
			label: {
				normal: {
					show: false
				},
				emphasis: {
					show: true
				}
			},
			lableLine: {
				normal: {
					show: false
				},
				emphasis: {
					show: true
				}
			},
			data: [{
				value: 10,
				name: 'Jan'
			}, {
				value: 5,
				name: 'Feb'
			}, {
				value: 15,
				name: 'Mar'
			}, {
				value: 25,
				name: 'Apr'
			}, {
				value: 20,
				name: 'May'
			}, {
				value: 25,
				name: 'Jun'
			}, {
				value: 30,
				name: 'Jul'
			}, {
				value: 40,
				name: 'Aug'
			}]
		}, ],
		color: ['#ff473d', '#004ced', '#01b8ff ', '#ffb209', '#b03cd5', ' #22e840', '#f47b25', '#7673e6']
	};
	myChart2.setOption(option2);
	/*---echart (#echart2) closed---*/

	/*---echart (#echart6)---*/
	var myChart6 = echarts.init(document.getElementById('echart6'));
	var base = +new Date(1968, 9, 3);
	var oneDay = 24 * 3600 * 1000;
	var date = [];

	var data = [Math.random() * 300];

	for (var i = 1; i < 20000; i++) {
		var now = new Date(base += oneDay);
		date.push([now.getFullYear(), now.getMonth() + 1, now.getDate()].join('/'));
		data.push(Math.round((Math.random() - 0.5) * 20 + data[i - 1]));
	}

	option1 = {
		tooltip: {
			trigger: 'axis',
			position: function(pt) {
				return [pt[0], '10%'];
			}
		},

		title: {
			left: 'center',
			text: '',
		},
		xAxis: {
			type: 'category',
			boundaryGap: false,
			data: date,
			axisLabel: {
				color: 'rgba(0,0,0,0.5)'
			},
		},
		yAxis: {
			type: 'value',
			boundaryGap: [0, '100%'],
			axisLine: {
				onZero: false,
				lineStyle: {
				  color: 'rgba(0,0,0,0.1)'
				}
			},
			axisLabel: {
				color: 'rgba(0,0,0,0.5)'
			},
			splitLine: {
				show: true,
				lineStyle: {
				  color: 'rgba(0,0,0,0.1)'
				}
			},
		},
		grid: {
			x: 40,
			y: 20,
			x2: 40,
			y2: 20
		},
		dataZoom: [{
			type: 'inside',
			start: 0,
			end: 10
		}, {
			start: 0,
			end: 10,
			handleSize: '100%',
			handleStyle: {
				color: '#fff',
				shadowBlur: 10,
				shadowColor: 'rgba(0, 0, 0, 0.6)',
				shadowOffsetX: 2,
				shadowOffsetY: 2
			}
		}],
		series: [{
			name: '',
			type: 'line',
			smooth: true,
			symbol: 'none',
			sampling: 'average',
			itemStyle: {
				color: '#23dbcf'
			},
			areaStyle: {
				color: new echarts.graphic.LinearGradient([{
					offset: 0,
					color: '#7673e6'
				}, {
					offset: 1,
					color: '#3edbe8'
				}])
			},
			data: data
		}],
		color: ['#7673e6']
	};
	myChart6.setOption(option1);
    /*---echart (#echart6) closed---*/

	/*---echart (#echart)---*/
	var myChart = echarts.init(document.getElementById('echart'));
	var category = [];
	var dottedBase = +new Date();
	var lineData = [];
	var barData = [];
	for (var i = 0; i < 10; i++) {
		var date = new Date(dottedBase += 3600 * 24 * 1000);
		category.push([
			date.getFullYear(),
			date.getMonth() + 1,
			date.getDate()
		].join('-'));
		var b = Math.random() * 200;
		var d = Math.random() * 200;
		barData.push(b)
		lineData.push(d + b);
	}
	option8 = {
		tooltip: {
			trigger: 'axis',
			axisPointer: {
				type: 'shadow'
			}
		},
		legend: {
			data: ['line', 'bar'],
			textStyle: {
				color: 'rgba(0,0,0,0.4)'
			}
		},
		xAxis: {
			data: category,
			axisLine: {
				lineStyle: {
					color: 'rgba(0,0,0,0.4)'
				}
			}
		},
		yAxis: {
			splitLine: {
				show: false
			},
			axisLine: {
				lineStyle: {
					color: 'rgba(0,0,0,0.4)'
				}
			}
		},
		grid: {
			x: 30,
			y: 20,
			x2: 0,
			y2: 20
		},
		series: [{
			name: 'Page Views',
			type: 'line',
			smooth: true,
			showAllSymbol: true,
			symbol: 'emptyCircle',
			symbolSize: 10,
			data: lineData,
			itemStyle: {
				normal: {
					barBorderRadius: 5,
					color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
						offset: 0,
						color: '#f47b25'
					}, {
						offset: 1,
						color: '#f47b25'
					}])
				}
			},
		}, {
			name: 'Shares',
			type: 'bar',
			barWidth: 20,
			itemStyle: {
				normal: {
					barBorderRadius: 5,
					color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
						offset: 0,
						color: '#7673e6'
					}, {
						offset: 1,
						color: '#7673e6'
					}])
				}
			},
			data: barData
		}, {
			name: 'Users',
			type: 'bar',
			barGap: '-100%',
			barWidth: 20,
			itemStyle: {
				normal: {
					color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
						offset: 0,
						color: '#01b8ff'
					}, {
						offset: 0.2,
						color: '#01b8ff'
					}, {
						offset: 1,
						color: '#01b8ff'
					}])
				}
			},
			z: -12,
			data: lineData
		}, ]
	};
	myChart.setOption(option8);
	/*---echart (#echart) closed---*/

	/*---Morris (#graph5)---*/
	Morris.Bar({
		barGap:4,
		barSizeRatio:0.33,
		element: 'graph5',
		data: [{
			x: '2011 Q1',
			y: 3407,
			z: 2660
		}, {
			x: '2011 Q2',
			y: 3351,
			z: 3629
		}, {
			x: '2011 Q3',
			y: 3269,
			z: 2618
		}, {
			x: '2011 Q4',
			y: 3246,
			z: 1661
		}, {
			x: '2011 Q5',
			y: 3517,
			z: 2660
		}, {
			x: '2011 Q6',
			y: 3051,
			z: 2620

		}, {
			x: '2011 Q8',
			y: 3276,
			z: 2661
		}],
		barThickness : 10,
		xkey: 'x',
		ykeys: ['y', 'z'],
		labels: ['Likes', 'Shares'],
		barColors: ['#7673e6', '#f47b25']
	});
	/*---Morris (#graph5) closed---*/

	/*---DonutChart (#morrisBar8)---*/
	new Morris.Donut({
		element: 'morrisBar8',
		    data: [
				{value: 50, label: 'FaceBook'},
				{value: 25, label: 'Twitter'},
				{value: 15, label: 'Pinterest'}
			],
			labelColor:"#555858",
			  colors: [
			'#7673e6', '#f47b25', '#fdb901'
	    ],
		  formatter: function (x) { return x + "%"}
		}).on('click', function(i, row){
		  console.log(i, row);
	});

	var chartdata = [
		{
		  name: 'FaceBook',
		  type: 'bar',
		  data: [10, 15, 9, 18, 10, 15]
		},
		{
		  name: 'Twitter',
		  type: 'line',
		  smooth:true,
		  data: [8, 5, 25, 10, 10]
		},
		{
		  name: 'Pinterest',
		  type: 'bar',
		  data: [10, 14, 10, 15, 9, 25]
		}
	];
	/*---DonutChart (#morrisBar8) closed---*/

});
