<!--
    Author: Barbara Emke
    Date:   July 6, 2023
-->
<?php

session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();


// Redirect to the given page 
header("Location: ../home/index.php");
exit();

?>