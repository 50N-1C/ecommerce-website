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

// Initialize the cart array in the session if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the form is submitted for adding to the cart
if (isset($_POST['add_to_cart'])) {
    if (isset($_POST['selected_products']) && is_array($_POST['selected_products'])) {
        $selectedProducts = $_POST['selected_products'];

        // Fetch selected products from the database and add them to the cart
        $productIDs = implode(",", $selectedProducts);
        $product_sql = "SELECT * FROM Products WHERE ProductID IN ($productIDs)";
        $product_result = $conn->query($product_sql);

        if ($product_result->rowCount() > 0) {
            while ($product_data = $product_result->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['cart'][] = [
                    'ProductID' => $product_data['ProductID'],
                    'ProductName' => $product_data['ProductName'],
                    'Price' => $product_data['Price'],
                ];
            }
        }
    }
}

// Check if the form is submitted for clearing the cart
if (isset($_POST['clear_cart'])) {
    // Clear the cart by unsetting the 'cart' session variable
    unset($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            text-align: center;
        }

        table {
            margin: 0 auto;
        }

        th, td {
            padding: 8px;
        }

        
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <p><a href="logout.php">Logout</a></p>
    <h2>All Products</h2>
    <form action="" method="post">
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
                    echo "<input type='checkbox' name='selected_products[]' value='" . $product_data['ProductID'] . "'>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No products found.</td></tr>";
            }
            ?>
        </table>
        <input type="submit" name="add_to_cart" value="Add to Cart">
    </form>

    <form action="" method="post">
        <input type="submit" name="clear_cart" value="Clear Cart">
    </form>

    <h2>Shopping Cart</h2>
    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
        </tr>

        <?php
        // Display the cart items from the session
        if(isset($_SESSION['cart'])){
        $totalPrice = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            echo "<tr>";
            echo "<td>" . $cartItem['ProductName'] . "</td>";
            echo "<td>$" . $cartItem['Price'] . "</td>";
            echo "</tr>";
            $totalPrice += $cartItem['Price'];
        }
        echo "<tr><td colspan='2'>Total: $" . $totalPrice . "</td></tr>";
    }
    $name="subtotal";
    $value=$totalPrice;
    $cookie_expiry = time() + (86400 );
    setcookie($name,$value, $cookie_expiry,"/");
        ?>
    </table>
    <p><a href="#">Proceed to Checkout</a></p> <!-- add name ya reda el 5awl -->
</body>
</html>
