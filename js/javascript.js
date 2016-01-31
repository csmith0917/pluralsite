(function($){
	// $(document).ready(function(){
	// 	$('#search input:text').autofill({
	// 		value: "Search..."
	// 	});
	// });
// Drupal behavior runs on ready and whenever the DOM changes
	Drupal.behaviors.pluralsite = {
		attach: function (context) {
			$('#search input:text', context).autofill({
				value: "Search..."
			});
		}
	};
})(jQuery)

