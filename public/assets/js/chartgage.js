$(function(e){
  'use strict';

	var g1, g2, g3, g4, g5, g6;

    window.onload = function(){

		var g1 = new JustGage({
			id: "g1",
			value: getRandomInt(0, 100),
			min: 0,
			max: 100,
			title: "Custom Width",
			label: "",
			gaugeColor: "#f7f7fa",
			levelColors: ["#3ebaef"],
			gaugeWidthScale: 0.2
		});

		var g2 = new JustGage({
			id: "g2",
			value: getRandomInt(0, 100),
			min: 0,
			max: 100,
			title: "Custom Shadow",
			label: "",
			gaugeColor: "#f7f7fa",
			levelColors: ["#7673e6"],
			shadowOpacity: 0.3,
			shadowSize: 0,
			shadowVerticalOffset: 0

		});

		var g3 = new JustGage({
			id: "g3",
			value: getRandomInt(0, 100),
			min: 0,
			max: 100,
			title: "Custom Colors",
			label: "",
			gaugeColor: "#f7f7fa",
			levelColors: [
				"#31c92e",
				"#7673e6",
				"#f47b25"
			]

		});

		var g4 = new JustGage({
			id: "g4",
			value: getRandomInt(0, 100),
			min: 0,
			max: 100,
			title: "Hide Labels",
			gaugeColor: "#f7f7fa",
			levelColors: ["#00e682"],
			showMinMax: false

		});

		var g5 = new JustGage({
			id: "g5",
			value: getRandomInt(0, 100),
			min: 0,
			max: 100,
			title: "Animation Type",
			label: "",
			startAnimationTime: 2000,
			startAnimationType: ">",
			refreshAnimationTime: 1000,
			gaugeColor: "#f7f7fa",
			levelColors: ["#ffa22b"],
			refreshAnimationType: "bounce"

		});

		var g6 = new JustGage({

			id: "g6",
			value: getRandomInt(0, 100),
			min: 0,
			max: 100,
			title: "Minimal",
			label: "",
			showMinMax: false,
			gaugeColor: "#f7f7fa",
			levelColors: ["#21cb95"],
			showInnerShadow: false,
			startAnimationTime: 1,
			startAnimationType: "linear",
			refreshAnimationTime: 1,
			refreshAnimationType: "linear"
		});

		setInterval(function() {

          g1.refresh(getRandomInt(0, 100));
		  g2.refresh(getRandomInt(0, 100));
		  g3.refresh(getRandomInt(0, 100));
		  g4.refresh(getRandomInt(0, 100));
		  g5.refresh(getRandomInt(0, 100));
		  g6.refresh(getRandomInt(0, 100));

        }, 2500);

    };


	//gauge chart
	var chart_gauge_settings = {
	  lines: 12,
	  angle: 0,
	  lineWidth: 0.4,
	  pointer: {
		  length: 0.75,
		  strokeWidth: 0.042,
		  color: '#ececff'
	  },
	  limitMax: 'false',
	  colorStart: '#7673e6',
	  colorStop: '#7673e6',
	  strokeColor: '#f7f7fa',
	  generateGradient: true
	};


	if ($('#chart_gauge_01').length){

		var chart_gauge_01_elem = document.getElementById('chart_gauge_01');
		var chart_gauge_01 = new Gauge(chart_gauge_01_elem).setOptions(chart_gauge_settings);

	}


	if ($('#gauge-text').length){

		chart_gauge_01.maxValue = 6000;
		chart_gauge_01.animationSpeed = 32;
		chart_gauge_01.set(3200);
		chart_gauge_01.setTextField(document.getElementById("gauge-text"));

	}

	if ($('#chart_gauge_02').length){

		var chart_gauge_02_elem = document.getElementById('chart_gauge_02');
		var chart_gauge_02 = new Gauge(chart_gauge_02_elem).setOptions(chart_gauge_settings);

	}
		if ($('#gauge-text2').length){

			chart_gauge_02.maxValue = 9000;
			chart_gauge_02.animationSpeed = 32;
			chart_gauge_02.set(2400);
			chart_gauge_02.setTextField(document.getElementById("gauge-text2"));

		}

		if ($('#chart_gauge_03').length){

			var chart_gauge_03_elem = document.getElementById('chart_gauge_03');
			var chart_gauge_03 = new Gauge(chart_gauge_03_elem).setOptions(chart_gauge_settings);

		}
		if ($('#gauge-text3').length){

			chart_gauge_03.maxValue = 6000;
			chart_gauge_03.animationSpeed = 53;
			chart_gauge_03.set(5400);
			chart_gauge_03.setTextField(document.getElementById("gauge-text3"));

		}
});