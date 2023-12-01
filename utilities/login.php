<!--
    Author: Barbara Emke
    Date:   July 6, 2023
   -->
<?php 
session_start();

require_once('../utilities/database.php');

$username = $_POST['username'];
$pass = $_POST['pass'];

//gets locationID if logging in from reviews page
if(isset($_SESSION['locationID'])){ $locationID = $_SESSION['locationID']; }

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

//checks if successful if not creates error message
if ($user) {
	$_SESSION['user'] = $user;
} else {
    // Authentication failed, display an error message
    $_SESSION['login_error'] = 'Invalid username or password';
}

//brings user back to page they were on
if(isset($locationID)){ //if request came from reviews page
    header("Location: ".$_SERVER['HTTP_REFERER']."?placeID=".$locationID);
}
else{
    header("Location: ".$_SERVER['HTTP_REFERER']);
}

?>