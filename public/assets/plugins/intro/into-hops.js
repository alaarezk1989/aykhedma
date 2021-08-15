(function($) {
	"use strict";
	
	var placementRight = 'right';
	var placementLeft = 'left';

	// Define the tour!
	var tour = {
		id: "my-intro",
		steps: [
			{
				target: "logo-tour",
				title: "Template Logo",
				content: "You can create logo in our own styles.",
				placement: placementRight,
				yOffset: 10
			},
			{
				target: 'sidebar-toggle',
				title: "Sider-button",
				content: "Siderbar Collapase Button.",
				placement: 'right',
				zindex: 9999
			},
			{
				target: 'headerbar',
				title: "Header bar",
				content: "You Create or own styles in header section.",
				placement: 'bottom',
				zindex: 9999
			},
			{
				target: 'dash-tour',
				title: "Dashboard menu",
				content: "You can include No.of Dashboards.",
				placement: 'bottom',
				zindex: 9999
			},
			{
				target: 'sidebar',
				title: "Sidebar section",
				content: "You can create our own styles Siderbar menu section.",
				placement: 'right',
				zindex: 99999
			},
			{
				target: 'body',
				title: "Body Section",
				content: "You can create our own styles Widgets,elements.",
				placement: 'top',
				 zindex: 999999
			},

		],
		showPrevButton: true
	};

	// Start the tour!
	hopscotch.startTour(tour);

})(jQuery);