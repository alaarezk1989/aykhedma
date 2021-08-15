(function($) {
	"use strict";
	
	
	$(".dragdrop").sortable({
		connectWith: '.dragdrop',
		items: '.draggable',
		revert: true,
		placeholder: 'draggable-placeholder',
		forcePlaceholderSize: true,
		opacity: 0.77,
		cursor: 'move'
	});
	
})(jQuery);