<!--
    Author: Barbara Emke
    Date:   July 6, 2023
-->
<?php session_start(); ?>

   <?php include '../utilities/header.php'; ?>

   <link href="../utilities/styles.css" rel="stylesheet" />

   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUlxtqrpZc8kvsWc0gl5W0LD4--d3y78&libraries=places"></script>
   <script src="searchBusiness.js"></script>
	
	<h1>Reviews</h1>
	<div id="business_search">
		<h3>Find a Business</h3>
		<div class="search_bar">
			<input id="google_search" class="controls" type="text" placeholder="Enter Business Name"/>
			<Button type="button" class="search_btn">Search</button>
		</div>
	</div>
	
   <?php include '../utilities/footer.php'; ?>