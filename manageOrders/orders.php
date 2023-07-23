<?php
// Include the connection file to establish a database connection
require_once '../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders</title>
        <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1, h2, h3 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: blue;
        }

        a:hover {
            text-decoration: underline;
        }

        center {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <center><h1>Order Tracking for Admins</h1></center>
<?php
$sql = "SELECT Orders.OrderID, Orders.OrderDate, Users.Username AS CustomerUsername, Orders.OrderStatus, OrderItems.ProductID, OrderItems.Quantity, OrderItems.Subtotal, OrderItems.TotalPrice, OrderItems.Review, OrderItems.Rating
            FROM Orders 
            INNER JOIN Users ON Orders.UserID = Users.UserID
            INNER JOIN OrderItems ON Orders.OrderID = OrderItems.OrderID";
    $result = $con->query($sql);
    if ($result->rowCount() > 0) {
        echo "<center><h2>Orders</h2>
        <table border='1'>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Customer Username</th>
                <th>Order Status</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Delivery Price</th>
                <th>Total Price</th>
                <th>Rating</th>
                <th>Edit</th>
            </tr>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['OrderID'] . "</td>";
            echo "<td>" . $row['OrderDate'] . "</td>";
            echo "<td>" . $row['CustomerUsername'] . "</td>";
            echo "<td>" . $row['OrderStatus'] . "</td>";
            echo "<td>" . $row['ProductID'] . "</td>";
            echo "<td>" . $row['Quantity'] . "</td>";
            echo "<td>" . $row['Subtotal'] . "</td>";
            echo "<td>" . ($row['TotalPrice'] - $row['Subtotal']) . "</td>";
            echo "<td>" . $row['TotalPrice'] . "</td>";
            echo "<td>" . ($row['Rating'] ? $row['Rating'] : '-') . "</td>";
            echo "<td>";
                echo "<a href='cancel_order.php?orderID=" . $row['OrderID'] . "'>Cancel</a><br>";
                echo "<a href='edit_order.php?orderID=" . $row['OrderID'] . "'>Edit</a><br>";
                echo "<a href='check_order.php?orderID=" . $row['OrderID'] . "'>Check</a><br>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table></center>";
    } else {
        echo "<center><h3>No orders found.</h3></center><br><br>";
    }

      /*  // Check for canceled orders and display them separately
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
            echo "<center><h3>No canceled orders found.</h3></center>";
        }
    } */
    ?>

</body>
</html>
