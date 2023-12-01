<!--    
    Author: Barbara Emke
    Date:   July 6, 2023 -->

    <?php 
session_start();

require_once('../utilities/database.php');


$resourceID = $_GET['id'];


try{
    //removes specified row from resources table
    $query = "DELETE FROM resources WHERE resourceID = :resourceID;";
    $statement = $db->prepare($query);
    $statement->bindValue(':resourceID', $resourceID);
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