<!--    
    Author: Barbara Emke
    Date:   July 6, 2023 -->

    <?php 
session_start();

require_once('../utilities/database.php');

//gets information from form for table
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$msg = filter_input(INPUT_POST, 'msg');
$dateSubmitted = date('Y-m-d');  //gets current date

if(empty($name || empty($email) || empty($msg))){
    $_SESSION['error'] = "All fields must be filled in.";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

$pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

if (!preg_match($pattern, $email)){
    $_SESSION['error'] = "Must enter a valid email.";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

try{
    //inserts new row into resources table
    $query = "INSERT INTO contact_requests (name, email, message, dateSubmitted)
                VALUES (:name, :email, :msg, :dateSubmitted)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':msg', $msg);
    $statement->bindValue(':dateSubmitted', $dateSubmitted);
    $result = $statement->execute();
    $statement->closeCursor();
    $_SESSION['confirmed'] = TRUE;
    header("Location: {$_SERVER['HTTP_REFERER']}");
} catch (PDOException $e) {
    // Handle database error
    $error_message = $e->getMessage();
    include('../utilities/database_error.php');
    exit();
}

?>