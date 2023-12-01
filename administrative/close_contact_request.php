<!--
    Author: Barbara Emke
    Date:   July 6, 2023

-->

<?php
session_start();
require_once('../utilities/database.php');

// Get IDs
$requestID = filter_input(INPUT_POST, 'requestID');
$dateAddressed = date('Y-m-d');  //gets current date
$adminID = $_SESSION['user']['userID'];

try{
    // Delete the product from the database
    if ($requestID != FALSE) {
        $query = 'UPDATE contact_requests
                SET adminClosedID = :adminID, dateAddressed = :dateAddressed
                WHERE requestID = :requestID';
        $statement = $db->prepare($query);
        $statement->bindValue(':adminID', $adminID);
        $statement->bindValue(':dateAddressed', $dateAddressed);
        $statement->bindValue(':requestID', $requestID);
        $success = $statement->execute();
        $statement->closeCursor();    
    }
} catch (PDOException $e) {
    // Handle database error
    $error_message = $e->getMessage();
    include('../utilities/database_error.php');
    exit();
}

// Display the Product List page
header('Location: manage_open_contact_requests.php');