(function() {
  "use strict";
   
  
	//vertical form validation
	window.addEventListener("load", function() {
		var form = document.getElementById("vertical-validation");
		form.addEventListener("submit", function(event) {
			if (form.checkValidity() == false) {
			event.preventDefault();
			event.stopPropagation();
			}
			form.classList.add("was-validated");
		}, false);
	}, false);
	
	
	//Horizontal form validation
	window.addEventListener("load", function() {
		var form = document.getElementById("horizontal-validation");
		form.addEventListener("submit", function(event) {
			if (form.checkValidity() == false) {
			event.preventDefault();
			event.stopPropagation();
			}
			form.classList.add("was-validated");
		}, false);
	}, false);
	
	
	//General form validation
	window.addEventListener("load", function() {
		var form = document.getElementById("form-validation");
		form.addEventListener("submit", function(event) {
			if (form.checkValidity() == false) {
			event.preventDefault();
			event.stopPropagation();
			}
			form.classList.add("was-validated");
		}, false);
	}, false);


})(jQuery);