<?php

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        require("../connection.php");

        $product = $_POST["Product"];

        $query = $con->prepare("DELETE FROM `products` WHERE `ProductName` = ?");
        $query->execute(array($product));
        $result = $query->rowCount();

        if(empty($product)){
            $message1 = "can not be empty"; 
        }else{
            if($result){
                $message2 = "The Product Deleted Successfully ";
            }else{
                $message2 = "i think there is a problem in your input data ";
                }
            }
            
        
}



?>


<!DOCTYPE html>
<html>
    <head>
        <title>Delete Product</title>
    </head>
    <body>
        
        <form style="text-align:center;" action="" method="POST">
        <h1>Delete Product</h1>
        <p>Name of Product to Delete it :</p>
        <input type="text" name="Product" placeholder="Enter Product name">
        <br><?php echo @$message1 ; ?><br>
        <input type="submit" value="Delete">
        <h4 style="color: green;"><?php echo @$message2 ; ?></h4>
        </form>
    </body>
</html>