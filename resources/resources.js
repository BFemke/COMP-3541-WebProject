/*
   Author: Barbara Emke
   Date:   July 8, 2023
*/

window.onload = init();

function init() {
	
	var searchButton = document.getElementById("search_btn");
	searchButton.addEventListener("click", searchResources, true);
	
	var searchBar = document.getElementById("search-input");
	searchBar.addEventListener("keydown", function(event) {
		if (event.keyCode === 13) {
			  // Search when enter key pressed
			  searchResources();
			  return;
		}
		if (event.key === 'Enter') {
			// Search when enter key pressed
			  searchResources();
		}
	});
	
	var selectFilter = document.getElementById('filter');
	selectFilter.addEventListener("change", (event) => {
		filterResources();
	});
}

function openResourceForm() {
  document.getElementById("resource_form").style.display = "block";
}

function closeResourceForm() {
  document.getElementById("resource_form").style.display = "none";
}

function openLoginForm() {
	document.getElementById("login_form").style.display = "block";
  }
  
  function closeLoginForm() {
	document.getElementById("login_form").style.display = "none";
  }

//searches each resource for input and displays only those that apply
function searchResources() {
	var found = 0;
	const resources = document.querySelectorAll('.resource');
	
	//loops through each resource searching for term
	resources.forEach(resource => {
		if (search(resource)) {
			document.getElementById("no-results").style.display = 'none';
			resource.style.display = 'block';
			found = 1;
		} else {
			resource.style.display = 'none';
		}
	});
	
	console.log(found);
	
	if(found == 0){
		document.getElementById("no-results").style.display = 'block';
	}
	
	//checks resource description and title for search input returns true or false
	function search(resource){
		const term = document.getElementById('search-input').value.toLowerCase();
		const texts = resource.textContent.toLowerCase();
		return texts.includes(term);
	}
}

//searches each resource for filter tag and displays only those that match
function filterResources(){
	var found = 0;
	const resources = document.querySelectorAll('.resource, .resource[hidden]');
	console.log("filtering");
	
	//loops through each resource searching for tag
	resources.forEach(resource => {
		const selectedOption = document.getElementById('filter').value;
		var tags = resource.querySelector('.tags, .tags[hidden]').textContent.toLowerCase();
		console.log(tags);
		if (selectedOption === 'placeholder' || tags.includes(selectedOption)) {
			document.getElementById("no-results").style.display = 'none';
			resource.style.display = 'block';
			found = 1;
		} else {
			resource.style.display = 'none';
		}
	});
	
	console.log(found);
	
	if(found == 0){
		document.getElementById("no-results").style.display = 'block';
	}
}

