<?php
    session_start();

    include("../connection.php"); 
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") { 

        $CouponID = $_POST['CouponID'];
        
        if (!empty($CouponID) && is_numeric($CouponID)) {
            try {
                $query = "delete from coupons where CouponID = '$CouponID' limit 1";
                $stmt = $con->prepare($query);
                $stmt->execute();
            
                header("Location: view_coupons.php");
                die('deleted successful!');
            } catch (\Throwable $th) {
                throw $th;
                echo "something went wrong";
            }
        }else{
            echo "Please enter a valid ID";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Coupon</title>
</head>
<body>
    <form action="#" method="post">
			<label for="CouponID"><b>ID of Coupon you want to delete</b></label></br></br>
			<input type="number" placeholder="Enter Coupon ID" name="CouponID" required></br></br>

			<button type="submit">Delete</button></br></br>
		</form>
        <a href="view_coupons.php">Back</a>
</body>
</html>