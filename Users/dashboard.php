<?php
// Include the connection file to establish a database connection and handle the session
require_once 'conn.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Retrieve the user's name from the session data
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Add some basic styling to the cart section */
        .cart-section {
            float: right;
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            margin-left: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <p><a href="logout.php">Logout</a></p>
    <p><a href="wishlist.php">wishlist</a></p>
    <h2>All Products</h2>
    <table border="1">
        <tr>
            <th>ProductID</th>
            <th>ProductName</th>
            <th>Description</th>
            <th>Price</th>
            <th>StockQuantity</th>
            <th>CategoryID</th>
            <th>Action</th>
        </tr>

        <?php
        // Fetch all products from the database
        $product_sql = "SELECT * FROM Products";
        $product_result = $conn->query($product_sql);

        if ($product_result->rowCount() > 0) {
            while ($product_data = $product_result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $product_data['ProductID'] . "</td>";
                echo "<td>" . $product_data['ProductName'] . "</td>";
                echo "<td>" . $product_data['Description'] . "</td>";
                echo "<td>$" . $product_data['Price'] . "</td>";
                echo "<td>" . $product_data['StockQuantity'] . "</td>";
                echo "<td>" . $product_data['CategoryID'] . "</td>";
                echo "<td>";
                echo "<a href='cart.php'>Add to Cart</a> ";
                echo "<td>";
                echo "<form action='#' method='post' name='s'>";
                echo "<input type='hidden' name='productID' value='" . $product_data['ProductID'] . "'>";
                echo "<input type='submit' value='Add to Wishlist'>";
                echo "</form>";
                echo "</td>";  
                echo "<td>";  
             echo "<a href='#?productID=" . $product_data['ProductID'] . "'>Proceed to Checkout</a>";// put page nammmmmmmmmme!!
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No products found.</td></tr>";
        }
        ?>
    </table>

        <?php
        if(isset($_POST['productID']))
        {
            $uid=$_SESSION['user_id'];
            $id=$_POST['productID'];
            $sql="INSERT INTO wishlist (UserID, ProductID) VALUES('$uid','$id')";
            $esql=$conn->query($sql);
        }
        ?>


</body>
</html>
