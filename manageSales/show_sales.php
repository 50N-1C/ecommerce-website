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

$sql = "SELECT ProductID, ProductName, Description, Price, StockQuantity, Sales FROM products";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    if ($row["Sales"] != NULL && $row["Sales"] > 0) {
        echo "id: " . $row["ProductID"]. " - Name: " . $row["ProductName"]. " - Description: " . $row["Description"]. " - Price: " . $row["Price"]. " - StockQuantity: " . $row["StockQuantity"]. " - Sales: " . $row["Sales"]. "<br>";
    }
  }
} else {
  echo "0 results";
}
$con->close();
?>
