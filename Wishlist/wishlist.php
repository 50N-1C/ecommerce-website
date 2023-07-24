<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY Wishlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 8px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
// Include the connection file to establish a database connection
require_once 'conn.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Retrieve the user's ID from the session data
$userID = $_SESSION['user_id'];

// Fetch wishlist items for the user from the database
$sql = "SELECT * FROM wishlist natural join Products  WHERE UserID = :userID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$wishlistItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>My Wishlist</h1>
<table>
    <tr>
        <th>WishlistID</th>
        <th>ProductID</th>
        <th>ProductName</th>
        <th>Action</th>
    </tr>

    <?php
    // Display wishlist items in the table
    if (count($wishlistItems) > 0) {
        foreach ($wishlistItems as $item) {
            echo "<tr>";
            echo "<td>" . $item['WishlistID'] . "</td>";
            echo "<td>" . $item['ProductID'] . "</td>";
            echo "<td>" . $item['ProductName'] . "</td>";
            echo "<td>";
            echo "<form action='#' method='post' name='s'>";
            echo "<input type='hidden' name='productID' value='" . $item['ProductID'] . "'>";
            echo "<input type='submit' value='Delete from Wishlist'>";
            echo "</form>";
            echo "</td>";  
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No items in the wishlist.</td></tr>";
    }
    if(isset($_POST['productID']))
    {
        $uid=$_SESSION['user_id'];
        $id=$_POST['productID'];
        $sql="DELETE FROM wishlist WHERE UserID=$uid AND ProductID=$id limit 1";
        $esql=$conn->query($sql);
        header('location:wishlist.php');
        exit();
    }
    ?>
    
</table>

<a href="dashboard.php" class="button">Dashboard</a>

</body>
</html>
