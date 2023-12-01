<!--
    Author: Barbara Emke
    Date:   July 6, 2023
-->
<?php session_start(); 

require_once('../utilities/database.php');

if(isset($_GET['placeID'])){
	$_SESSION['locationID'] = $_GET['placeID'];
}
$locationID = $_SESSION['locationID'];

//Handles login validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform the authentication process
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    try{
		//checks if email and password combo exists in database
		$query = "SELECT * FROM users WHERE username = :username AND password = :pass";
		$statement = $db->prepare($query);
		$statement->bindValue(':username', $username);
		$statement->bindValue(':pass', $pass);
		$statement->execute();
	
		$user = $statement->fetch();
		$statement->closeCursor();
	} catch (PDOException $e) {
		// Handle database error
		$error_message = $e->getMessage();
		include('../utilities/database_error.php');
		exit();
	}
	
    // If authentication is successful, redirect to a secure page
    if ($user) {
		$_SESSION['user'] = $user;
    } else {
        // Authentication failed, display an error message
        $error = 'Invalid username or password';
    }
}


//grabs revuews from database table reviews in date order
try{
    $query = 'SELECT *
            FROM reviews r
			JOIN users u ON u.userID = r.userID
			WHERE r.locationID = :locationID
			ORDER BY r.dateAdded DESC';
    $statement = $db->prepare($query);
	$statement->bindValue(':locationID', $locationID);
    $statement->execute();
    $reviews = $statement->fetchAll();
    $statement->closeCursor();
} catch (PDOException $e) {
    // Handle database error
    $error_message = $e->getMessage();
    include('../utilities/database_error.php');
    exit();
}
?>

   <?php include '../utilities/header.php'; ?>
   
   <link href="../utilities/styles.css" rel="stylesheet" />
   
   <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZUlxtqrpZc8kvsWc0gl5W0LD4--d3y78&libraries=places&callback=initPage" ></script>
   <script async src="business.js"></script>
	
	<div class="column1-3">
		<div id="business_info">
			<h3 id="b_name">Name</h3>
			<div id="map"></div>
			<img id="mapImage" src="../images/defaultMap.png" alt="map of location"/>
			<p id="address"></p>
			<p id="web"></p>
			<p id="phn"></p>
		</div>
		<button type="button" onclick="<?php if(isset($_SESSION['user'])) { echo 'openReviewForm()'; } else { echo 'openLoginForm()'; } ?>">Add Review</button>
	</div>

	<!-- Adds HTML login form -->
	<?php include '../utilities/login_form.php'; ?>
	
	<!-- Popup form to add new review -->
	<div class="form_popup" id="review_form">
		<form action="add_review.php?locationID=<?php echo $locationID; ?>" method="post"class="form-container">
			<div class="column1-2">
				<h3>Add Review</h3>

				<div class="field">
					<label for="title"><p>*Title</p></label>
					<input type="text" placeholder="Enter Title" name="title" id="title" value="<?php if(isset($_SESSION['title'])){ echo $_SESSION['title']; } ?>" required />
				</div>

			</div>
			<div class="column1-2" id="radio">
				<p>*Would you recommend this place?</p>
				<input type="radio" id="good" name="review-type" value="positive">
				<label for="good">Yes&nbsp;&nbsp;&nbsp;<img class="icon" src="../images/thmUp.png" alt="thumbs up"/></label><br>
				<input type="radio" id="bad" name="review-type" value="negative">
				<label for="bad">No&nbsp;&nbsp;&nbsp;<img class="icon" src="../images/thmDown.png" alt="thumbs down"/></label>

			</div>

			<div class="field" >
				<label for="descr"><p>*Description</p></label>
				<textarea type="are" placeholder="Describe resource or service" name="descr" id="descr" rows="6" required><?php if(isset($_SESSION['comment'])){ echo $_SESSION['comment']; }?></textarea>
			</div>
			<div class="mult_group">
				<p>*Select the disabilities that apply to this resource:</p>
				<div class="mult_select">
					<input type="checkbox" id="type1" name="type1" value="Auditory">
					<label for="type1" class="check">Auditory</label><br>
					
					<input type="checkbox" id="type2" name="type2" value="Cognitive, Learning, and Neurological">
					<label for="type2" class="check">Cognitive, Learning, and Neurological</label><br>
					
					<input type="checkbox" id="type3" name="type3" value="Physical">
					<label for="type3" class="check">Physical</label><br>
					
					<input type="checkbox" id="type4" name="type4" value="Visual">
					<label for="type4" class="check">Visual</label><br>
					
					<input type="checkbox" id="type5" name="type5" value="Speech">
					<label for="type5" class="check">Speech</label><br>
				</div>
			</div>
			<?php if(isset($_SESSION['error'])){ 
			echo "<script> document.getElementById(\"review_form\").style.display = \"block\"; </script>";
			echo "<p class=\"error\">".$_SESSION['error']."</p>";
			unset($_SESSION['error']); 
			} ?>

			<div class="btns">
				<button type="submit" class="btn" id="add_review">Submit</button>
				<button type="button" class="btn cancel" onclick="closeReviewForm()">Close</button>
			</div>
		</form>
	</div>
	
	<div class="column2-3">
		<div id="filter_options">
			<div id="selection">
				<label for="disability">Filter by: </label>
				<select title="Filter Selection" name="disability" id="filter">
					<option value="placeholder" selected="selected">Select filter..</option>
					<option value="auditory">Auditory</option>
					<option value="cognitive, learning, and neurological">Cognitive, Learning, and Neurological</option>
					<option value="physical">Physical</option>
					<option value="visual">Visual</option>
					<option value="speech">Speech</option>
					<option value="positive">Positive</option>
					<option value="negative">Negative</option>
				</select>
			</div>
			<div class="search_bar">
				<input type="text" placeholder="Search.." id="search-input"/>
				<Button type="button" class="search_btn" id="search_btn">Search</button>
			</div>
		</div>
		<div id="reviews">

		<!--default display if no reviews exist -->
		
		<?php 
			if(!isset($reviews)){
			echo "<div>";
			echo "<h3>No reviews have been added for this location..</h3>";
			echo "</div>";
			}
		?>

		<!-- Prints each review block from the reviews database -->
		<?php foreach($reviews as $review) : ?>
		<div class="review">
			<div class="user-info">
			<?php $imageBase64 = base64_encode($review['image']);
						$imageSrc = 'data:image/jpeg;base64,' . $review['image'];
						echo '<img class="user-image" src="' . $imageSrc . '" alt="profile image">'; ?>
				<p class="name"><?php echo $review['firstName']." ".$review['lastName']; ?></p>
			</div>
			<div class="content">
				<div class="heading">
					<h4 class="title"><?php echo $review['title']; ?></h4>
					<p class="tags" id="tags"><?php echo $review['tags']; ?></p>
				</div>
				<p class="date"><?php echo $review['dateAdded']; ?></p>
				<?php if(isset($_SESSION['user']) && ($_SESSION['user']['userID'] == $review['userID'] || $_SESSION['user']['isAdmin'] == TRUE)){ 
					echo "<p class=\"delete\"><a href=\"remove_review.php?id={$review['reviewID']}\">Delete</a></p>"; }?>
				<div class="group">
				<?php $imageBase64 = base64_encode($review['image']);
						$imageSrc = 'data:image/jpeg;base64,' . $review['ratingImg'];
						echo '<img class="type" id="type" src="' . $imageSrc . '" alt="rating icon">'; ?>
					<p class="description"><?php echo $review['comment']; ?></p>
				</div>
			</div>
			<div class="spacer"></div>
		</div>
		<?php endforeach; ?>

		<div id="no-results">
			<h3>No results match your criteria..</h3>
		</div>
	</div>
	</div>
	
	<?php include '../utilities/footer.php'; ?>