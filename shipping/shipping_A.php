<?php
// Include the conection file to establish a database conection
require_once("../connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Tracking For Admins</title>
</head>
<body>
    <h1>Order Tracking for Admins</h1>

    <?php
    // Retrieve orders, their status, and customer usernames
    $sql = "SELECT Orders.OrderID, Orders.OrderDate, Users.Username AS CustomerUsername, Orders.OrderStatus, 
            OrderItems.ProductID, OrderItems.Quantity, OrderItems.Subtotal, OrderItems.TotalPrice, OrderItems.Review, OrderItems.Rating
            FROM Orders 
            INNER JOIN Users ON Orders.UserID = Users.UserID
            INNER JOIN OrderItems ON Orders.OrderID = OrderItems.OrderID";
    $result = $con->query($sql);

    if ($result->rowCount() > 0) {
        echo "<h2>Orders</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Order ID</th><th>Order Date</th><th>Customer Username</th><th>Order Status</th><th>Product ID</th><th>Quantity</th><th>Price</th><th>Delivery Price</th><th>Total Price</th><th>Rating</th><th>Action</th></tr>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['OrderID'] . "</td>";
            echo "<td>" . $row['OrderDate'] . "</td>";
            echo "<td>" . $row['CustomerUsername'] . "</td>";
            echo "<td>" . $row['OrderStatus'] . "</td>";
            echo "<td>" . $row['ProductID'] . "</td>";
            echo "<td>" . $row['Quantity'] . "</td>";
            echo "<td>" . $row['TotalPrice'] . "</td>";
            echo "<td>" . ($row['Subtotal'] - $row['TotalPrice']) . "</td>";
            echo "<td>" . $row['Subtotal'] . "</td>";
            echo "<td>" . ($row['Rating'] ? $row['Rating'] : '-') . "</td>";
            echo "<td>";
            if ($row['OrderStatus'] === 'Shipping') {
                echo "<a href='cancel_order.php?orderID=" . $row['OrderID'] . "'>Cancel</a>";
            } elseif ($row['OrderStatus'] === 'Deliverd') {
                echo "<a href='check_order.php?orderID=" . $row['OrderID'] . "'>Check</a>";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No regular orders found.<br><br><br><br>";
    }        
        // Check for canceled orders and display them separately
        $canceled_orders_sql = "SELECT * FROM Orders WHERE OrderStatus = 'Cancelled'";
        $canceled_orders_result = $con->query($canceled_orders_sql);

        if ($canceled_orders_result->rowCount() > 0) {
            echo "<h2>Cancelled Orders</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Order ID</th><th>Order Date</th><th>Customer Username</th><th>Order Status</th></tr>";

            while ($row = $canceled_orders_result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['OrderID'] . "</td>";
                echo "<td>" . $row['OrderDate'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['OrderStatus'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No canceled orders found.";
        }
    
    ?>

</body>
</html>
