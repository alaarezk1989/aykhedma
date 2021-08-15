$(function() {
	/*---ChartJS (#barChart)---*/
	var ctx = document.getElementById("barChart");
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
			datasets: [{
				label: "online",
				data: [65, 59, 80, 81, 56, 55, 40],
				borderColor: "#7673e6",
				borderWidth: "0",
				barWidth: "1",
				backgroundColor: "#7673e6"
			}, {
				label: "offline",
				data: [28, 48, 40, 19, 86, 27, 90],
				borderColor: "#f47b25",
				borderWidth: "0",
				barWidth: "1",
				backgroundColor: "#f47b25"
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{
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

	/*---Morris (#bar-chart2)---*/
	var bar = new Morris.Bar({
 		element: 'bar-chart2',
 		resize: true,
 		data: [{
 			y: '2008',
 			a: 50,
 			b: 90,
			c: 30
 		}, {
 			y: '2010',
 			a: 95,
 			b: 65,
			c: 25
 		}, {
 			y: '2012',
 			a: 50,
 			b: 40,
			c: 40
 		}, {
 			y: '2015',
 			a: 75,
 			b: 65,
			c: 36
 		}, {

 			y: '2019',
 			a: 100,
 			b: 90,
			c: 50
 		}],
 		barColors: ['#f47b25', '#7673e6','#ffb209'],
 		xkey: 'y',
 		ykeys: ['a', 'b', 'c'],
 		labels: ['Success', 'Pending','Failed'],
 		hideHover: 'auto'
 	});
	/*---Morris (#bar-chart2) closed---*/

    /*---ChartJS (#sales-chart)---*/
	var ctx = document.getElementById("sales-chart");
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],
			type: 'line',
			datasets: [{
				label: "New",
				data: [0, 30, 10, 120, 50, 63, 10],
				backgroundColor: 'transparent',
				borderColor: '#7673e6',
				borderWidth: 3,
				pointStyle: 'circle',
				pointRadius: 5,
				pointBorderColor: 'transparent',
				pointBackgroundColor: '#7673e6',
			}, {
				label: "Existing",
				data: [0, 50, 40, 80, 40, 79, 120],
				backgroundColor: 'transparent',
				borderColor: '#f47b25',
				borderWidth: 3,
				pointStyle: 'circle',
				pointRadius: 5,
				pointBorderColor: 'transparent',
				pointBackgroundColor: '#f47b25',
			}]
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
				labels: {
					usePointStyle: true,
					fontFamily: 'Montserrat',
				},
			},
			scales: {
				xAxes: [{
					ticks: {
						fontColor: "rgba(0,0,0,0.5)",
					 },
					display: true,
					gridLines: {
						display: true,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: 'rgba(0,0,0,0.61)'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "rgba(0,0,0,0.5)",
					 },
					display: true,
					gridLines: {
						display: true,
						drawBorder: false
					},
					scaleLabel: {
						display: true,
						labelString: 'Value',
						fontColor: 'rgba(0,0,0,0.61)'
					}
				}]
			},
			title: {
				display: false,
				text: 'Normal Legend'
			}
		}
	});
	/*---ChartJS (#sales-chart) closed---*/

	/*---ChartJS (#pieChart)---*/
	var ctx = document.getElementById("pieChart");
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			datasets: [{
				data: [40, 25, 20],
				backgroundColor: ['#7673e6', ' #f47b25', '#ffb209' ],
				hoverBackgroundColor: ['#7673e6','#f47b25','#ffb209'],
				borderColor:'transparent',
			}],
			labels: ["sales", "profit", "growth"]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				labels: {
					fontColor: "rgba(0,0,0,0.5)"
				},
			},
		}
	});
	/*---ChartJS (#pieChart) closed---*/

});
