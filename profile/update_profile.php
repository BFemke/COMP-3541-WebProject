<!--
    Author: Barbara Emke
    Date:   July 6, 2023
   -->
<?php
session_start();

require_once('../utilities/database.php');

$userID = $_SESSION['user']['userID'];

$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');
$username = filter_input(INPUT_POST, 'username');
$email = filter_input(INPUT_POST, 'email');
$pass = filter_input(INPUT_POST, 'pass');

//gets path tp redirect to later
$path = $_SESSION['path'];
unset($_SESSION['path']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Check if the file was uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES["image"]["tmp_name"]; //gets temp file path

        //converts image to BLOB compatible form
        $imageData = file_get_contents($tmpFilePath);
        $userImg = base64_encode($imageData);

        try{
         //Updates user info
            $query = 'UPDATE users 
                    SET firstName = :firstName, lastName = :lastName, username = :username, email = :email, password = :password, image = :image 
                    WHERE userID = :userID';
            $statement = $db->prepare($query);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $pass);
            $statement->bindValue(':image', $userImg);
            $statement->bindValue(':userID', $userID);
            $result = $statement->execute();
            $statement->closeCursor();

            if($result){
                $query = 'SELECT * FROM users 
                        WHERE userID = :userID';
                $statement = $db->prepare($query);
                $statement->bindValue(':userID', $userID);
                $statement->execute();
                $user = $statement->fetch();
                $statement->closeCursor();  

                $_SESSION['user'] = $user;
            }
            header("Location: {$path}");
        } catch (PDOException $e) {
            // Handle database error
            $error_message = $e->getMessage();
            include('../utilities/database_error.php');
            exit();
        }
    }
    else{

        try{
            //Updates user info
            $query = 'UPDATE users 
                        SET firstName = :firstName, lastName = :lastName, username = :username, email = :email, password = :password 
                        WHERE userID = :userID';
            $statement = $db->prepare($query);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $pass);
            $statement->bindValue(':userID', $userID);
            $result = $statement->execute();
            $statement->closeCursor();

            if($result){
                $query = 'SELECT * FROM users 
                        WHERE userID = :userID';
                $statement = $db->prepare($query);
                $statement->bindValue(':userID', $userID);
                $statement->execute();
                $user = $statement->fetch();
                $statement->closeCursor();  

                $_SESSION['user'] = $user;
            }
            header("Location: {$path}");
        } catch (PDOException $e) {
            // Handle database error
            $error_message = $e->getMessage();
            include('../utilities/database_error.php');
            exit();
        }
    }

}
?>