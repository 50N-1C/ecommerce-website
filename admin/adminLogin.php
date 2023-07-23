<?php 

// $username = "name$"; // assuming the username is submitted via a form

// if (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
//     echo "Invalid username";
// } else {
//     echo "Valid username: " . $username;
// }


if($_SERVER["REQUEST_METHOD"]==="POST"){
    //connect with database
    require("../connection.php");
    $filter   = "/^[a-zA-Z0-9_-]+$/";
    $username = htmlspecialchars($_POST["Username"]);
    $password = htmlspecialchars($_POST["Password"]);
    

    $query = $con->prepare("SELECT UserName, Password FROM admins WHERE UserName = ? AND Password = ? ");
    $query->execute(array($username, $password));
    $check = $query->rowCount();

    // echo $check ;
    if ( $check > 0 ) {
        echo "welcom";
        closeConnection();
        header("Location:index.html");
        exit();

    }else {

        $message = "Invalid username or password";
    
    }

}
?>



<!DOCTYPE html>
<html>
    <head>
        <title>login page</title>
    </head>
    <body>
        
        <form style="text-align:center;" action="" method="POST">
        <h1>Admin Login</h1>
        <input type="text" name="Username" placeholder="Username">
        <br><br>
        <input type="password" name="Password" placeholder="Password">
        <br><?php echo @$message ?><br>
        <input type="submit" value="Login">
        </form>
    </body>
</html>