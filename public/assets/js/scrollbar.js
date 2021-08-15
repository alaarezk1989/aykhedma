(function($) {
	"use strict";
	
	$(window).on("load",function(){
		$(".content").mCustomScrollbar();
	});
	$("#content-4").mCustomScrollbar({
		theme:"rounded-dots",
		scrollInertia:400
	});
	$("#content-5").mCustomScrollbar({
		axis:"x",
		theme:"dark-thin",
		autoExpandScrollbar:true,
		advanced:{autoExpandHorizontalScroll:true}
	});
	
})(jQuery);