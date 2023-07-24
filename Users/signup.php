<?php
// Include the connection file to establish a database connection
require_once 'conn.php';

// Check if the form is submitted for user sign-up
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user'; // Set the user role as 'user'

    // Check if the username or email already exists in the database
    $checkUserExistenceSql = "SELECT UserID FROM Users WHERE Username = :username OR Email = :email";
    $checkUserExistenceStmt = $conn->prepare($checkUserExistenceSql);
    $checkUserExistenceStmt->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUserExistenceStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $checkUserExistenceStmt->execute();

    if ($checkUserExistenceStmt->rowCount() > 0) {
        echo "Username or email already exists. Please choose a different one.";
    } else {
        // Insert new user into the database
        $insertUserSql = "INSERT INTO Users (Rule, Username, Email, Password) VALUES (:role, :username, :email, :password)";
        $insertUserStmt = $conn->prepare($insertUserSql);
        $insertUserStmt->bindParam(':role', $role, PDO::PARAM_STR);
        $insertUserStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $insertUserStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertUserStmt->bindParam(':password', $password, PDO::PARAM_STR);

        if ($insertUserStmt->execute()) {
            echo "User registered successfully!";
            header('location:login.php');
            exit();
        } else {
            echo "Error occurred while registering user. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
</head>
<body>
    <h1>User Sign Up</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <!-- Hidden input field for setting user role -->
        <input type="hidden" name="role" value="user">

        <input type="submit" name="signup" value="Sign Up">
    </form>
</body>
</html>
