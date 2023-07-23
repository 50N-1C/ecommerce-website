<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        center {
            margin-top: 20px;
        }

        h1, h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        p {
            margin: 5px 0;
        }

        .order-info {
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #fff;
            max-width: 600px;
            margin: 0 auto;
        }

        .products-table {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php
// Include the connection file to establish a database connection
require_once '../connection.php';

// Retrieve the orderID from the URL
if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];
    // Query to retrieve detailed order information
    $order_sql = "SELECT Orders.OrderID, Orders.OrderDate, Users.Username AS CustomerUsername, Orders.OrderStatus, Orders.TotalAmount
                  FROM Orders 
                  INNER JOIN Users ON Orders.UserID = Users.UserID
                  WHERE Orders.OrderID = :orderID";

    $order_result = $con->prepare($order_sql);
    $order_result->bindParam(':orderID', $orderID, PDO::PARAM_INT);
    $order_result->execute();

    // Check if the order exists
    if ($order_result->rowCount() > 0) {
        $order_data = $order_result->fetch(PDO::FETCH_ASSOC);

        echo "<center><h1>Order Details</h1>";
        echo "<p>Order ID: " . $order_data['OrderID'] . "</p>";
        echo "<p>Order Date: " . $order_data['OrderDate'] . "</p>";
        echo "<p>Customer Username: " . $order_data['CustomerUsername'] . "</p>";
        echo "<p>Total Amount: $" . $order_data['TotalAmount'] . "</p>";
        echo "<p>Order Status: " . $order_data['OrderStatus'] . "</p></center>";

        // Query to retrieve products in the order and any available reviews
        $order_items_sql = "SELECT Products.ProductName, OrderItems.Quantity, OrderItems.Subtotal, OrderItems.Review, OrderItems.Rating
                            FROM OrderItems
                            INNER JOIN Products ON OrderItems.ProductID = Products.ProductID
                            WHERE OrderItems.OrderID = :orderID";
        $order_items_result = $con->prepare($order_items_sql);
        $order_items_result->bindParam(':orderID', $orderID, PDO::PARAM_INT);
        $order_items_result->execute();

        if ($order_items_result->rowCount() > 0) {
            echo "<center><h2>Products in the Order</h2></center>
            <center><table border='1'>
            <tr><th>Product Name</th><th>Quantity</th><th>Subtotal</th><th>Review</th><th>Rating</th></tr>";

            while ($row = $order_items_result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "<td>$" . $row['Subtotal'] . "</td>";
                echo "<td>" . ($row['Review'] ? $row['Review'] : 'No review yet') . "</td>";
                echo "<td>" . ($row['Rating'] ? $row['Rating'] : '-') . "</td>";
                echo "</tr>";
            }
            echo "</table></center>";
        } else {
            echo "<center><p><h2>No products found in the order.</h2></p></center>";
        }
    } else {
        echo "<center><p><h2>Order not found.</h2></p></center>";
    }
} else {
    echo "<center><p><h2>Invalid request. Please provide an order ID.</h2></p></center>";
}
?>

</body>
</html>