<!--    
    Author: Barbara Emke
    Date:   July 6, 2023 -->

<?php 
session_start();

require_once('../utilities/database.php');


//gets information from form for table
$userID = $_SESSION['user']['userID'];
$title = filter_input(INPUT_POST, 'title');
$descript= filter_input(INPUT_POST, 'descr');
$dateAdded = date('Y-m-d');  //gets current date

$tags = "";
//checks if auditory was selected
if (isset($_POST['type1'])) {
    $tags .= "(Auditory)";
}
//Checks if Cognitive, Learning, and Neurological was selected
if (isset($_POST['type2'])) {
    if(!empty($tags)){
        $tags .= ", ";
    }
    $tags .= "(Cognitive, Learning, and Neurological)";
}
//Checks if Physical was selected
if (isset($_POST['type3'])) {
    if(!empty($tags)){
        $tags .= ", ";
    }
    $tags .= "(Physical)";
}
//Checks if Visual was selected
if (isset($_POST['type4'])) {
    if(!empty($tags)){
        $tags .= ", ";
    }
    $tags .= "(Visual)";
}
//Checks if Speech was selected
if (isset($_POST['type5'])) {
    if(!empty($tags)){
        $tags .= ", ";
    }
    $tags .= "(Speech)";
}

try{
    //inserts new row into resources table
    $query = "INSERT INTO resources (userID, title, description, dateAdded, tags)
                VALUES (:userID, :title, :descript, :dateAdded, :tags)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':descript', $descript);
    $statement->bindValue(':dateAdded', $dateAdded);
    $statement->bindValue(':tags', $tags);
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