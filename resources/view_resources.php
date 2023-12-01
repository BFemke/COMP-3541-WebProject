   <!--
    Author: Barbara Emke
    Date:   July 6, 2023

   -->
<?php

session_start();

require_once('../utilities/database.php');

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

//grabs resources from database table resources in date order
try{
    $query = 'SELECT *
            FROM resources r
			JOIN users u ON u.userID = r.userID
			ORDER BY r.dateAdded DESC';
    $statement = $db->prepare($query);
    $statement->execute();
    $resources = $statement->fetchAll();
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
<script async src="resources.js"></script>
	
	<div id="resource_bar">
		<h1>Resources</h1>
		<button type="button" onclick="<?php if(isset($_SESSION['user'])) { echo 'openResourceForm()'; } else { echo 'openLoginForm()'; } ?>">Add New Resource</button>
	</div>

	<!-- Adds HTML login form -->
	<?php include '../utilities/login_form.php'; ?>
	
	<!-- Popup form to add new resource -->
	<div class="form_popup" id="resource_form">
		<form class="form-container" action="add_resource.php" method="post">
			<h3>Add Resource</h3>

			<div class="field">
				<label for="title"><p>*Title</p></label>
				<input type="text" placeholder="Enter Title" name="title" id="title" required />
			</div>

			<div class="field">
				<label for="descr"><p>*Description</p></label>
				<textarea type="are" placeholder="Describe resource or service" name="descr" id="descr" rows="6" required></textarea>
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
			echo "<script> document.getElementById(\"resource_form\").style.display = \"block\"; </script>";
			echo "<p class=\"error\">".$_SESSION['error']."</p>";
			unset($_SESSION['error']); 
			} ?>

			<div class="btns">
				<button type="submit" class="btn" id="add_resource">Submit</button>
				<button type="button" class="btn cancel" onclick="closeResourceForm()">Close</button>
			</div>
		</form>
	</div>
	
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
			</select>
		</div>
		<div class="search_bar">
			<input type="text" placeholder="Search by keyterm.." id="search-input"/>
			<Button type="button" class="search_btn" id="search_btn">Search</button>
		</div>
	</div>
	
	<div id="resources">
		<!-- Creates resource block for each resource in database -->
		<?php foreach ($resources as $resource) : ?>
		<div class="resource">
			<div class="user-info">
				<?php $imageBase64 = base64_encode($resource['image']);
						$imageSrc = 'data:image/jpeg;base64,' . $resource['image'];
						echo '<img class="user-image" src="' . $imageSrc . '" alt="profile image">'; ?>
				<p class="name"><?php echo $resource['firstName']." ".$resource['lastName']; ?></p>
			</div>
			<div class="content">
				<div class="heading">
					<h4 class="title"><?php echo $resource['title']; ?></h4>
					<p class="tags" id="tags"><?php echo $resource['tags']; ?></p>
				</div>
				<p class="date"><?php echo $resource['dateAdded']; ?></p>
				<?php if(isset($_SESSION['user']) && ($_SESSION['user']['userID'] == $resource['userID'] || $_SESSION['user']['isAdmin'] == TRUE)){ 
					echo "<p class=\"delete\"><a href=\"remove_resource.php?id={$resource['resourceID']}\">Delete</a></p>"; }?>
				<div class="group">
					<p class="description"><?php echo $resource['description']; ?></p>
					</div>
			</div>
			<div class="spacer"></div>
		</div>
		<?php endforeach; ?>

		<div id="no-results">
			<h3>No results match your criteria..</h3>
		</div>
	</div>
	
<?php include '../utilities/footer.php';