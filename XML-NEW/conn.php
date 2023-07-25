<?php

// Database configuration
$db_host = 'localhost';
$db_name = 'shopping';
$db_user = 'root';
$db_pass = '';


try {
    // Connect to the database using PDO
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = 'Database Error: ' . $e->getMessage();
}

?>