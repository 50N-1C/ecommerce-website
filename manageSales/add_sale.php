<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT ProductID, ProductName FROM products";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "Product ID: " . $row["ProductID"]. " - Name: " . $row["ProductName"] . 
    " - <form action='add_sale_to_product.php' method='post'><input type='hidden' name='id' value='" . $row["ProductID"] . "'><input type='number' name='sale_amount' min='0' step='.01' required><input type='submit' value='Add Sale'></form><br>";
  }
} else {
  echo "0 results";
}
$con->close();
?>
