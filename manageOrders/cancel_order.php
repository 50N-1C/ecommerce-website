<?php
// Include the connection file to establish a database connection
require_once '../connection.php';

if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

        // Check if the order status is "Shipping" before cancelling
        $status_sql = "SELECT OrderStatus FROM Orders WHERE OrderID = :orderID";
        $status_result = $con->prepare($status_sql);
        $status_result->bindParam(':orderID', $orderID, PDO::PARAM_INT);
        $status_result->execute();

        if ($status_result->rowCount() > 0) {
            $status_data = $status_result->fetch(PDO::FETCH_ASSOC);
            $orderStatus = $status_data['OrderStatus'];
            // Delete order items related to the order
            $delete_items_sql = "DELETE FROM OrderItems WHERE OrderID = :orderID";
            $delete_items_result = $con->prepare($delete_items_sql);
            $delete_items_result->bindParam(':orderID', $orderID, PDO::PARAM_INT);
            $delete_items_result->execute();

            // Update the order status to "Cancelled"
            $cancel_sql = "UPDATE Orders SET OrderStatus = 'Cancelled' WHERE OrderID = :orderID";
            $cancel_result = $con->prepare($cancel_sql);
            $cancel_result->bindParam(':orderID', $orderID, PDO::PARAM_INT);
            $cancel_result->execute();
            echo "Order with ID " . $orderID . " has been cancelled successfully.";
        } else {
            echo "Order not found.";
        }
   
} else {
    echo "Invalid request. Please provide an orderID.";
}

?>
