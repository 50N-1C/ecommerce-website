<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping";
$productID = intval($_POST['id']);
$saleAmount = floatval($_POST['sale_amount']);

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

$sql = "UPDATE products SET Sales = $saleAmount WHERE ProductID = $productID";

if ($con->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $con->error;
}

$con->close();
?>
