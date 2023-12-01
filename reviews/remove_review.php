<!--    
    Author: Barbara Emke
    Date:   July 6, 2023 -->

<?php 
session_start();

require_once('../utilities/database.php');


$reviewID = $_GET['id'];


try{
    //removes specified row from reviews table
    $query = "DELETE FROM reviews WHERE reviewID = :reviewID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':reviewID', $reviewID);
    $statement->execute();
    $statement->closeCursor();
    header("Location: {$_SERVER['HTTP_REFERER']}");
} catch (PDOException $e) {
    // Handle database error
    $error_message = $e->getMessage();
    include('../utilities/database_error.php');
    exit();
}

?>