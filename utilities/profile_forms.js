/*
   Author: Barbara Emke
   Date:   July 8, 2023
*/

window.onload = init();

function init() {
	
	//listener to open login form
    document.getElementById("sign-in").addEventListener("click", function(event) {
        event.preventDefault();
        openLoginForm();
        
     });

     //listener to open register form
     document.getElementById("register").addEventListener("click", function(event) {
        event.preventDefault();
        openRegisterForm();
        
     });
}

function openLoginForm() {
	document.getElementById("login_form").style.display = "block";
}

function closeLoginForm() {
	document.getElementById("login_form").style.display = "none";
}

function openRegisterForm() {
	document.getElementById("register_form").style.display = "block";
}

function closeRegisterForm() {
	document.getElementById("register_form").style.display = "none";
}