<?php
// Connect to the database using PDO
require("../connection.php");

// Retrieve user data from the database
$sql = "SELECT `UserID`, `Username` FROM `users` WHERE 1";
$stmt = $con->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($users) > 0) {
  foreach ($users as $user) {
    $userID = $user['UserID'];
    $username = $user['Username'];

    $result = "
    <tr>
        <td>{$userID}</td>
        <td>{$username}</td>
     
    </tr>";


  }
} else {
  $noUser = "No users found";
}


// Close the database connection
closeConnection();
?>


<html>
    <head>
        <style>
            table, th, td {
                text-align:center;
                border:1px solid black;
            }
    </style>
        <title>View Users List</title>
    </head>
    <body>
        <h1 style = " text-align: center;">Users List</h1>
        <table style="width:100%">
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
            <?php echo @$result ?>
        </table>
        <h3 style="text-align:center"><?php echo @$noUser?></h3>
    </body>
</html>