<!--
    Author: Barbara Emke
    Date:   July 6, 2023
   -->
   <?php 
session_start();

require_once('../utilities/database.php');

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$username = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['pass'];

//gets locationID if logging in from reviews page
if(isset($_SESSION['locationID'])){ $locationID = $_SESSION['locationID']; }

try{
    $query = "SELECT COUNT(*) as count FROM users WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
	$statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
	$statement->closeCursor();
} catch (PDOException $e) {
	// Handle database error
	$error_message = $e->getMessage();
	include('../utilities/database_error.php');
	exit();
}

if($result['count'] == 0){
    try{
        //checks if email and password combo exists in database
        $query = "INSERT INTO users (firstName, lastName, username, email, password, isAdmin)
                    VALUES (:firstName, :lastName, :username, :email, :pass, FALSE)";
        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':pass', $pass);
        $result = $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        // Handle database error
        $error_message = $e->getMessage();
        include('../utilities/database_error.php');
        exit();
    }

    //checks if successful if not creates error message
    if ($result) {
        try{
            //checks if email and password combo exists in database
            $query = "SELECT * FROM users WHERE username = :username AND password = :pass";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':pass', $pass);
            $statement->execute();
            $user = $statement->fetch();
            $statement->closeCursor();

            $_SESSION['user'] = $user;
        } catch (PDOException $e) {
            // Handle database error
            $error_message = $e->getMessage();
            include('../utilities/database_error.php');
            exit();
        }
    } else {
        $_SESSION['register_error'] = 'Something went wrong.';
    }
}
else{
    $_SESSION['register_error'] = 'Username already taken.'; 
}

//brings user back to page they were on
if(isset($locationID)){ //if request came from reviews page
    header("Location: ".$_SERVER['HTTP_REFERER']."?placeID=".$locationID);
}
else{
    header("Location: ".$_SERVER['HTTP_REFERER']);
}

?>