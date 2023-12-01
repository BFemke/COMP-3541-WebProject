<!--Barbara Emke (T00721475) -->

<?php
    $dsn = 'mysql:host=localhost;dbname=accessibility_now';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
    
?>