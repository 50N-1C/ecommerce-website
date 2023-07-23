<?php
    session_start();

    include("../connection.php"); 
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
		$value = $_POST['value'];
        $sale = $_POST['sale'];
        $expiry = $_POST['expiry'];
        if (!empty($value) && !empty($sale) && !empty($expiry)) {
      
              $query = "insert INTO `coupons` (`CouponID`, `CouponCode`, `DiscountPercentage`, `ExpiryDate`) VALUES (NULL, '$value', '$sale', '$expiry' )";
              $stmt = $con->prepare($query);
              $stmt->execute();
              header("Location: view_coupons.php");
              die('Added Sucessfully'); 
          }else{
              echo "Please enter some valid information";
          }
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Coupon</title>
    <style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
		}
		.container {
			margin: 50px auto;
			width: 400px;
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 0px 10px #aaa;
		}
		h1 {
			text-align: center;
			margin-bottom: 30px;
		}
		input {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
			font-size: 16px;
		}
		button {
			background-color: #6666ff;
			color: white;
			padding: 14px 20px;
			margin: 8px 0;
            margin-bottom: 30px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			width: 100%;
			font-size: 16px;
		}
		button:hover {
			background-color: #0000b3;
		}
        a {
			background-color: #4CAF50;
			color: white;
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			width: 100%;
			font-size: 16px;
		}
		.container label {
			font-size: 16px;
			font-weight: bold;
		}
		.container p {
			text-align: center;
			font-size: 14px;
			color: red;
			margin: 0;
		}
		@media screen and (max-width: 600px) {
			.container {
				width: 100%;
			}
		}
	</style>
</head>
<body>
<div class="container">
		<h1>Add Coupon</h1>
		<form action="#" method="post">
			<label for="value"><b>Coupon Code</b></label>
			<input type="text" placeholder="Enter Coupon Code" name="value" required>

			<label for="discountpercent"><b>Discount percentage</b></label>
			<input type="number" placeholder="Enter Sale %" name="sale" required>

            <label for="expiry">Expiry Date:</label>
            <input type="date" placeholder="Format : 2023-07-25" name="expiry" required><br>

			<button type="submit">ADD</button>
			<a href="../admin/index.html">Home</a> <!-- Add href to go back to home or index.php -->
			<a href="view_coupons.php">View all Coupons</a>
		</form>
	</div>
</body>
</html>