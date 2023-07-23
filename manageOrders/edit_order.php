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

        h2 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
require_once '../connection.php';
if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

    if (isset($_POST['updateOrder'])) {
        $newStatus = $_POST['orderStatus']; 
        $update_sql = "UPDATE Orders SET OrderStatus = :newStatus WHERE OrderID = :orderID";
        $update_result = $con->prepare($update_sql);
        $update_result->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
        $update_result->bindParam(':orderID', $orderID, PDO::PARAM_INT);

        try {
            $update_result->execute();
            header("Location: check_order.php?orderID=$orderID");
            exit;
        } catch (PDOException $e) {
            echo "<center><p><h2>Failed to update the order. Please try again later.</h2></p></center>";
        }
    }

}
?>

<?php if (isset($orderID)) { ?>
    <center>
        <h2>Update Order</h2>
        <form method="post">
            <label for="orderStatus">Order Status:</label>
            <select name="orderStatus" id="orderStatus" required>
                <option value="shipping">shipping</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            <br>
            <input type="submit" name="updateOrder" value="Update">
        </form>
    </center>
<?php } ?>
</body>
</html>
