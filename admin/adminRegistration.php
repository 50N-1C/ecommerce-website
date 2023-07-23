<?php 
if($_SERVER["REQUEST_METHOD"]==="POST"){
    //connect with database
    require("../connection.php");

    $username = htmlspecialchars($_POST["Username"]);
    $password = htmlspecialchars($_POST["Password"]);
    $filter   = "/^[a-zA-Z0-9_-]+$/";

    //check data exist or not
    $query = $con->prepare("SELECT UserName, Password FROM admins WHERE UserName = ? AND Password = ?");
    $query->execute(array($username, $password));
    $check = $query->rowCount();

    if($check > 0){

        $message ="<br> <h3 style = 'color: red;'>UserName already Exist.</h3> ";  //message for user if user exist
    
    }elseif( empty($username) ){
    
        $message = "<br><h3 style='color: red;'>enter ur username please</h3>";
    
    }elseif(!preg_match($filter, $username)) {

        $message = " <h3 style='color: red;'>The UserName must be letters and numbers only <h3>"; // messsage for user if username input is number

    }else{
    

            if(empty($password)){
                
                // message for user if do not creat password
                $messagePass = "<h3 style = 'color: red;'>please creat new password . </h3> "; 

            }else{

                //Finally Add Data To DataBase
                            
                // $query = $con->prepare("INSERT INTO `admins`( `UserName`, `Password`) VALUES (?,?)");
                // $query->bindParam(1, $username);
                // $query->bindParam(2, $password);
                // $check = $query->execute() ;

                $query = $con->prepare("INSERT INTO `admins`(`UserName`, `Password`) VALUES (?, ?)");
                $check = $query->execute(array($username, $password));


                if($check){
                    closeConnection();
                    
                    die("
                        <h2 style='text-align: center; color: green;'>SignUp successfully</h2>    
                        <br><br>
                        <h3 style='text-align: center;'>
                        <a href='\big task\website_A\admin\adminLogin.php' >Go To Login</a>
                        </h3>");  

                    
                }

            }

            }
        }
    






?>



<!DOCTYPE html>
<html>
    <head>
        <title>Registration Admin page</title>
    </head>
    <body>
        <h1 style="text-align:center;">Admin Registration </h1>
        <form style="text-align:center;" action="" method="POST">
        <input type="text" name="Username" placeholder="Username" autocomplete="off">
        <br>
        <?php echo @$message?>
        <br>
        <input type="password" name="Password" placeholder="New Password" autocomplete="new-password">
        <br>
        <?php echo @$messagePass?>
        <br>
        <input type="submit" value="SignUp">
        </form>
    </body>
</html>






