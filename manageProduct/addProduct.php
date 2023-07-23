<?php

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        require("../connection.php");

        $product    = $_POST["productname"];
        $summary    = $_POST["description"];
        $price      = $_POST["price"];
        $quantity   = $_POST["stockQuantity"];

        $query = $con->prepare("INSERT INTO `products`( `ProductName`, `Description`, `Price`, `StockQuantity`) VALUES (?,?,?,?)");
        $query->execute(array($product, $summary, $price, $quantity));
        $result = $query->rowCount();

        if(empty($product)){
            $message1 = "product name can not be empty"; 
        }else{
            if(empty($summary)){
                $message2 = "summary can not be empty ";
            }else{
                if(empty($price)){
                    $message3 = "price can not be empty ";
                }else{
                    if(empty($quantity)){
                        $message4 = "price can not be empty ";
                    }else{
                        if($result){
                            $message5 = "The Product Added Successfully ";
                        }else{
                            $message5 = "i think there is a problem in code ";
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
        <title>Add Product</title>
    </head>
    <body>
        
        <form style="text-align:center;" action="" method="POST">
        <h1>Add Product</h1>
        <input type="text" name="productname" placeholder="Enter product name">
        <br><?php echo @$message1 ; ?><br>
        <input type="text" name="description" placeholder="Enter description">
        <br><?php echo @$message2 ; ?><br>
        <input type="number" name="price" placeholder="Enter the price">
        <br><?php echo @$message3 ?><br>
        <input type="text" name="stockQuantity" placeholder="Enter product Stock Quantity">
        <br><?php echo @$message4 ; ?><br>
        <input type="submit" value="Add">
        <h4 style="color: green;"><?php echo @$message5 ; ?></h4>
        </form>
    </body>
</html>