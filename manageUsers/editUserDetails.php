<?php 
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        //connection with database 
        require("../connection.php");   //`UserID`, `Role`, `Username`, `Email`, `Password`, `Address`
        $username = $_POST["username"];
        $userid   = $_POST["userid"];
        $role     = $_POST["role"];
        $name     = $_POST["name"];
        $email    = $_POST["Email"];
        $password = $_POST["password"];
        $address  = $_POST["adress"];


        if(!empty($username)){

            $query = $con->prepare("SELECT * FROM `users` WHERE `Username` = ?");
            $query->execute(array($username));
            $result = $query->rowCount();
             if($result > 0){

                if(!empty($userid)){
                    $query = $con->prepare("UPDATE `users` SET `UserID`= ? WHERE `Username` = ?");
                    $query->execute(array($userid, $username));
                    $result = $query->rowCount();
                }
        
                if(!empty($role)){
                    $query = $con->prepare("UPDATE `users` SET `Role`= ? WHERE `Username` = ?");
                    $query->execute(array($role, $username));
                    $result = $query->rowCount();
                }
        // `UserID`, `Role`, `Username`, `Email`, `Password`, `Address` 
                if(!empty($email)){
                    $query = $con->prepare("UPDATE `users` SET `Email`= ? WHERE `Username` = ?");
                    $query->execute(array($email, $username));
                    $result = $query->rowCount();
                    if($result > 0){

                    }
                }
        
                if(!empty($password)){
                    $query = $con->prepare("UPDATE `users` SET `Password`= ? WHERE `Username` = ?");
                    $query->execute(array($password, $username));
                    $result = $query->rowCount();
                }
        
                if(!empty($address)){
                    $query = $con->prepare("UPDATE `users` SET `Address`= ? WHERE `Username` = ?");
                    $query->execute(array($address, $username));
                    $result = $query->rowCount();
                }

                if(!empty($name)){
                    $query = $con->prepare("UPDATE `users` SET `Username`= ? WHERE `Username` = ?");
                    $query->execute(array($name, $username));
                    $result = $query->rowCount();
                }

                $message1 = "updated successfully . ";

             }else{
                $message2 = "user not found";
             }

        }else{
            $message3 = "can not be empty";
        }
        
        $query2 = $con->prepare("SELECT * FROM `users` WHERE `Username` = ?");
        $query2->execute(array($name));
        $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result2) > 0){

        }else{
            $notFound = "user not found";
        }
        
    }


?>



<!DOCTYPE html>
<html>
    <head>
    <style>
        table, th, td {
        border:1px solid black;
        text-align: center;
        }
    </style>
    <title>Edit users</title>
    </head>
    <body>
        
        <article style="padding: 30px; background-color: #f6f8ff;">

            <?php //include("viewUserDetails.php")?>


            <br><br><br>
            <form style="text-align:center;" action="" method="POST">
                <h1>Edit User</h1>
                enter username will be edit:<br><input type="text" name="username" placeholder="Enter username">
                <br><h4 style="color: green;"><?php echo @$message3 ; ?></h4><br>
                <input type="number" name="userid" placeholder="Edit user id">
                <br><br>
                <input type="text" name="role" placeholder="Edit role user/admin">
                <br><br>
                <input type="text" name="name" placeholder="Edit username">
                <br><br>
                <input type="email" name="Email" placeholder="Edit email">
                <br><br>
                <input type="password" name="password" placeholder="Edit Password">
                <br><br>
                <input type="text" name="adress" placeholder="Edit address">
                <br><br>
                <input type="submit" value="Update">
                <h4 style="color: green;"><?php echo @$message1 ; ?></h4>
                <h4 style="color: red;"><?php echo @$message2 ; ?></h4>
            </form>
            <hr style="height: 5px;
           background: teal;
           margin: 20px 0;
           box-shadow: 0px 0px 4px 2px rgba(204,204,204,1);">
           <br><br>
           <table style="width:100%">
                <tr>
                    <th>UserID</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Address</th>
                </tr>
                <tr>
                    <td><?php echo @$result["UserID"] ; ?></td>
                    <td><?php echo @$result["Role"] ; ?></td>
                    <td><?php echo @$result["Username"] ; ?></td>
                    <td><?php echo @$result["Email"] ; ?></td>
                    <td><?php echo @$result["Password"] ; ?></td>
                    <td><?php echo @$result["Address"] ; ?></td>

                </tr>
                <h4 style="color: red;"><?php echo @$notFound ; ?></h4>
            </table> 
        </article>
    </body>
</html>