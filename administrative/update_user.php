<!--
    Author: Barbara Emke
    Date:   July 6, 2023

-->
<?php

session_start();

require_once('../utilities/database.php');

//gets information for table
$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');
$username = filter_input(INPUT_POST, 'username');
$email = filter_input(INPUT_POST, 'email');
$pass = filter_input(INPUT_POST, 'pass');

$userID = $_SESSION['userID'];
unset($_SESSION['userID']);

$path = $_SESSION['path'];
unset($_SESSION['path']);

if($userID != 0){
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
    } catch (PDOException $e) {
        // Handle database error
        $error_message = $e->getMessage();
        include('../utilities/database_error.php');
        exit();
    }
}
else {
    try{
        //adds new admin
        $query = 'INSERT INTO users (firstName, lastName, username, email, password, isAdmin) 
                    Values (:firstName, :lastName, :username, :email, :password, TRUE)';
        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $pass);
        $result = $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        // Handle database error
        $error_message = $e->getMessage();
        include('../utilities/database_error.php');
        exit();
    } 
}

header("Location: $path");

?>