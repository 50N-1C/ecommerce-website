<?php 
if($_SERVER["REQUEST_METHOD"]==="POST"){
    
    //connection with database
    require("../../connection.php");
    
    $username = $_POST["username"];

    $query = $con->prepare("SELECT * FROM `users` WHERE `Username` = ?");
    $query->execute(array($username));
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) > 0){
        foreach($result as $users){
            //`UserID`, `Role`, `Username`, `Email`, `Password`, `Address`

            $userID    = $users["UserID"];
            $role      = $users["Role"];
            $username  = $users["Username"];
            $email     = $users["Email"];
            $password  = $users["Password"];
            $address   = $users["Address"]; 
        }
    }else{
        $notFound = "User Not Found . ";
    }
}


?>



<!DOCTYPE html>
<html>
    <head>
        <title>View User Details</title>
    <style>
        table, th, td {
        border:1px solid black;
        text-align: center;
        }
    </style>
    </head>
    <body>
        
        <form style="text-align:center;" action="" method="POST">
        <h1>Enter Name of User</h1>
        <input type="text" name="username" placeholder="Enter name">
        <br><br>
        <input type="submit" value="View">
        
        </form>
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
                <td><?php echo @$userID ; ?></td>
                <td><?php echo @$role ; ?></td>
                <td><?php echo @$username ; ?></td>
                <td><?php echo @$email ; ?></td>
                <td><?php echo @$password ; ?></td>
                <td><?php echo @$address ; ?></td>

            </tr>
            <h4 style="color: red;"><?php echo @$notFound ; ?></h4>
        </table>        
    </body>
</html>