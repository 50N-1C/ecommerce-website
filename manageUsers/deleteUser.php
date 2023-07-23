<?php

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        require("../connection.php");

        $username = $_POST["username"];

        $query = $con->prepare("DELETE FROM `users` WHERE `Username` = ?");
        $query->execute(array($username));
        $result = $query->rowCount();

        if(empty($username)){
            $message1 = "can not be empty"; 
        }else{
            if($result > 0){
                $message2 = "The User Deleted Successfully ";
            }else{
                $message2 = "i think there is a problem in your input data ";
                }
            }
            
        
}



?>


<!DOCTYPE html>
<html>
    <head>
        <title>Delete username</title>
    </head>
    <body>
        
        <form style="text-align:center;" action="" method="POST">
        <h1>Delete user</h1>
        Name of user to Delete :<br><br>
        <input type="text" name="username" placeholder="Enter name of user">
        <br><?php echo @$message1 ; ?><br>
        <input type="submit" value="Delete">
        <h4 style="color: green;"><?php echo @$message2 ; ?></h4>
        </form>
    </body>
</html>