<!--    
    Author: Barbara Emke
    Date:   July 6, 2023 -->

<?php 
session_start();

require_once('../utilities/database.php');


//gets information from form for table
$locationID = $_GET['locationID'];
$userID = $_SESSION['user']['userID'];
$_SESSION['title'] = filter_input(INPUT_POST, 'title');
$title = filter_input(INPUT_POST, 'title');
$_SESSION['comment'] = filter_input(INPUT_POST, 'descr');
$comment = filter_input(INPUT_POST, 'descr');
$dateAdded = date('Y-m-d');  //gets current date


if (isset($_POST['review-type'])) {
    $rating = $_POST['review-type'];
    //sets image based on rating selection.
    if($rating == "positive"){
        $imageData = file_get_contents('../images/thmUp.png');
        $ratingImg = base64_encode($imageData);
    }
    else{
        $imageData = file_get_contents('../images/thmDown.png');
        $ratingImg = base64_encode($imageData);
    }
}
else{
    $_SESSION['error'] = "You must indicate whether positive or negative review.";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

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
if(empty($tags)){
    $_SESSION['error'] = "You must select at least one disability type.";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

unset($_SESSION['title']);
unset($_SESSION['comment']);

try{
    //inserts new row into reviews table
    $query = "INSERT INTO reviews (userID, title, comment, dateAdded, tags, ratingImg, locationID)
                VALUES (:userID, :title, :comment, :dateAdded, :tags, :ratingImg, :locationID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':comment', $comment);
    $statement->bindValue(':dateAdded', $dateAdded);
    $statement->bindValue(':tags', $tags);
    $statement->bindValue(':ratingImg', $ratingImg);
    $statement->bindValue(':locationID', $locationID);
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