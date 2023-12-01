/*
   Author: Barbara Emke
   Date:   July 5, 2023

   Filename: business.js


*/

var google;

function init() {
	initPage();
}

function initPage(){
	
	var searchButton = document.getElementById("search_btn");
	searchButton.addEventListener("click", searchReviews, true);
	
	var searchBar = document.getElementById("search-input");
	searchBar.addEventListener("keydown", function(event) {
		if (event.keyCode === 13) {
			  // Search when enter key pressed
			  searchReviews();
			  return;
		}
		if (event.key === 'Enter') {
			// Search when enter key pressed
			  searchReviews();
		}
	});
	
	var selectFilter = document.getElementById('filter');
	selectFilter.addEventListener("change", (event) => {
		filterReviews();
	});
	
	document.addEventListener('DOMContentLoaded', function () {
		let footerheight = document.querySelector("footer").offsetHeight;
		document.querySelector("body").style.paddingBottom = footerheight;
	});
	
	// Get the URL of the current page
	var url = window.location.href;

	// Get the value of the "placeID" parameter
	var id = getUrlParameter("placeID");
	
	function getUrlParameter(name) {
	  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		  results = regex.exec(url);
	  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	
	google.maps.event.addDomListener(window, 'load', function() {
	  var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 37.7749, lng: -122.4194},
		zoom: 12
	  });
	});


	var service = new google.maps.places.PlacesService(map);
	
	var request = {
	  placeId: id,
	  fields: ['name', 'formatted_address', 'formatted_phone_number', 'website']
	};
	
	service.getDetails(request, function(place, status) {
	  if (status === google.maps.places.PlacesServiceStatus.OK) {
		// Do something with the extracted details, such as display them on the page
		document.getElementById('b_name').textContent = place.name;
		document.getElementById('address').textContent = "Address: "+place.formatted_address;
		document.getElementById('web').textContent = "Web: "+place.website;
		document.getElementById('phn').textContent = "Phone #: "+place.formatted_phone_number;
		
		//sets static map
		var img = document.getElementById('mapImage');
		var encodedAddress = encodeURIComponent(place.formatted_address);

		img.src = 'https://maps.googleapis.com/maps/api/staticmap?center=' + encodedAddress + '&zoom=14&size=400x400&maptype=roadmap&markers=' + place.formatted_address + '&key=AIzaSyBZUlxtqrpZc8kvsWc0gl5W0LD4--d3y78';

	  }
	});

}

function openReviewForm() {
  document.getElementById("review_form").style.display = "block";
}

function openLoginForm() {
	document.getElementById("login_form").style.display = "block";
}

function closeReviewForm() {
  document.getElementById("review_form").style.display = "none";
}

function closeLoginForm() {
	document.getElementById("login_form").style.display = "none";
}

//searches each review for input and displays only those that apply
function searchReviews() {
	var found = 0;
	const reviews = document.querySelectorAll('.review, review[hidden]');
	
	//loops through each review searching for term
	reviews.forEach(review => {
		if (search(review)) {
			document.getElementById("no-results").style.display = 'none';
			review.style.display = 'block';
			found = 1;
		} else {
			review.style.display = 'none';
		}
	});
	
	if(found === 0){
		document.getElementById("no-results").style.display = 'block';
	}
	
	//checks review description and title for search input returns true or false
	function search(review){
		const term = document.getElementById('search-input').value.toLowerCase();
		const texts = review.textContent.toLowerCase();
		return texts.includes(term);
	}
}

//searches each review for filter tag and displays only those that match
function filterReviews(){
	var found = 0;
	const reviews = document.querySelectorAll('.review, .review[hidden]');
	
	//loops through each review searching for tag
	reviews.forEach(review => {
		const selectedOption = document.getElementById('filter').value;
		var tags = review.querySelector('.tags, .tags[hidden]').textContent.toLowerCase();
		var type = review.querySelector('.type, .type[hidden]').alt;
		console.log(type);
		if (selectedOption === 'placeholder' || tags.includes(selectedOption) || type.includes(selectedOption)){
			document.getElementById("no-results").style.display = 'none';
			review.style.display = 'block';
			found = 1;
		} else {
			review.style.display = 'none';
		}
	});
	
	
	if(found === 0){
		document.getElementById("no-results").style.display = 'block';
	}
}

google.maps.event.addDomListener(window, 'load', initPage);