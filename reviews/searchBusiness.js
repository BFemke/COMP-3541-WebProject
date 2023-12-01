/*
   Author: Barbara Emke
   Date:   July 5, 2023

   Filename: searchBusiness.js


*/

function initialize() {
	var input = document.getElementById('google_search');
	var options = {
		types: ['establishment'],
		componentRestrictions: {country: ['ca']}
	};
	var autocomplete = new google.maps.places.Autocomplete(input, options);
	autocomplete.setFields(['place_id']);
	
	autocomplete.addListener('place_changed', function() {
		var place = autocomplete.getPlace();
		var nextPage = "./view_business_reviews.php?placeID="+place.place_id;
		location.replace(nextPage);
	
	});
}

google.maps.event.addDomListener(window, 'load', initialize);