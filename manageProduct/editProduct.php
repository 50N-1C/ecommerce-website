<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {
    require("../connection.php");

    $oldProduct = $_POST["oldProduct"];
    $newProduct = $_POST["newProduct"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stockQuantity = $_POST["stockQuantity"];

    $query = $con->prepare("UPDATE `products` SET `ProductName`= ? ,`Description`= ? ,`Price`= ? ,`StockQuantity`= ? WHERE `ProductName`= ? ");
    $query->execute(array($newProduct, $description, $price, $stockQuantity, $oldProduct));
    $result = $query->rowCount();

    if(empty($oldProduct)) {
        $message1 = "Product name cannot be empty"; 
    } else {
        if(empty($newProduct)) {
            $message2 = "New product name cannot be empty";
        } else {
            if(empty($description)) {
                $message3 = "Description cannot be empty";
            } else {
                if(empty($price)) {
                    $message4 = "Price cannot be empty";
                } else {
                    if(empty($stockQuantity)) {
                        $message5 = "Stock quantity cannot be empty";
                    } else {
                        if($result) {
                            $message6 = "The product has been updated successfully";
                        } else {
                            $message6 = "There was an error updating the product";
                        }
                    }
                }
            }
        }
    }
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Edit Product</title>
    </head>
    <body>
        <form style="text-align:center;" action="" method="POST">
            <h1>Edit Product</h1>
            <input type="text" name="oldProduct" placeholder="Enter product name">
            <br><?php echo @$message1 ; ?><br>
            <input type="text" name="newProduct" placeholder="Enter a new name">
            <br><?php echo @$message2 ?><br>
            <input type="text" name="description" placeholder="Enter a description">
            <br><?php echo @$message3 ?><br>
            <input type="number" name="price" placeholder="Enter the price">
            <br><?php echo @$message4 ?><br>
            <input type="number" name="stockQuantity" placeholder="Enter the stock quantity">
            <br><?php echo @$message5 ?><br>
            <input type="submit" value="Update">
            <h4 style="color: green;"><?php echo @$message6 ; ?></h4>
        </form>
    </body>
</html>