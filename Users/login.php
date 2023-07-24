<?php
// Include the connection file to establish a database connection
require_once 'conn.php';

// Check if the form is submitted for user login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Unsafe query (NOT RECOMMENDED - PRONE TO SQL INJECTION)
    $loginSql = "SELECT * FROM Users WHERE Username = '$username' And Password='$password'";
    $loginResult = $conn->query($loginSql);

    if ($loginResult->rowCount() > 0) {
        $userData = $loginResult->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['user_id'] = $userData['UserID'];
            $_SESSION['username'] = $userData['Username'];
            header("Location: dashboard.php"); // Replace with the dashboard page URL
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
    <h1>User Login</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required ><br>

        <input type="submit" name="login" value="Login">
    </form>
    <a href="signup.php">signup</a>
</body>
</html>
