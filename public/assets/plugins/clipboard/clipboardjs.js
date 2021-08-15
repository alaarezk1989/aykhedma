(function($) {
	"use strict";	

	var clipboard = new ClipboardJS('.btn', {
		text: function() {
			return 'to be or not to be';
		},
		target: function() {
			return document.querySelector('div');
		}
	});
	var clipboard = new ClipboardJS('.btn');

	clipboard.on('success', function(e) {
		console.log(e);
	});

	clipboard.on('error', function(e) {
		console.log(e);
	});
})(jQuery);