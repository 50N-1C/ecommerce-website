<?php
    session_start();

    include("../connection.php"); 
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
            $CouponID = $_POST['CouponID'];
            $CouponCode = $_POST['CouponCode'];
            $DiscountPercentage = $_POST['DiscountPercentage'];
            $ExpiryDate = $_POST['ExpiryDate'];
            
            if ( !empty($CouponID) && !empty($CouponCode) && !empty($DiscountPercentage)&& !empty($ExpiryDate) && is_numeric($CouponID) && is_numeric($DiscountPercentage)) {
                
               try {
                $query = "update coupons set CouponCode='$CouponCode', DiscountPercentage='$DiscountPercentage', ExpiryDate='$ExpiryDate' where `coupons`.`CouponID` = '$CouponID' ";
                $stmt = $con->prepare($query);
                $stmt->execute();
                header("Location: view_coupons.php");
                die('updated successful!');
               } catch (Throwable $th) {
                echo "something went wrong, please retry";
                throw $th;
               }
        }else{
            echo "please fill out everything correctly";
        }} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
		table {
			border-collapse: collapse;
			width: 100%;
			margin-bottom: 20px;
		}

		th, td {
			border: 1px solid #ddd;
			padding: 8px;
			text-align: left;
		}

		th {
			background-color: #f2f2f2;
		}

		tr:nth-child(even) {
			background-color: #f9f9f9;
		}

		tr:hover {
			background-color: #f5f5f5;
		}
	</style>
</head>
<body>

    <h1>These are the Coupons</h1>
    <table>
		<thead>
			<tr>
                <th>Coupon ID</th>
				<th>Value</th>
                <th>Sale %</th>
				<th>Expiry date</th> 
			</tr>
		</thead>
		<tbody>
			<?php
                 $query = "select * from coupons";
                 $stmt = $con->prepare($query);
                 $stmt->execute();
                $result  = $stmt->fetchAll();
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['CouponID'] . "</td>";
                    echo "<td>" . $row['CouponCode'] . "</td>";
                    echo "<td>" . $row['DiscountPercentage'] . "%" ."</td>";
                    echo "<td>" . $row['ExpiryDate'] . "</td>";
                    echo "</tr>";
                }
            ?>
		</tbody>
	</table>
    <form method="post" action="#">
    
    <label for="CouponID">Coupon ID:</label>
    <input type="number" id="id" name="CouponID" required></br>
    
    </br><label for="CouponCode">New Coupon Code:</label>
    <input type="text" id="CouponCode" name="CouponCode" required></br></br>

    <label for="DiscountPercentage">NEW Discount %:</label>
    <input type="number" id="DiscountPercentage" name="DiscountPercentage" required></br></br>

    <label for="expiry">NEW Expiry Date:</label>
    <input type="date" placeholder="Format : 2023-07-25" name="ExpiryDate" required><br></br>
    
    <input type="submit" value="Update"></br></br>
    </form>
    <a href="#">PLACEHOLDER</a>&emsp;&emsp; <!-- PLEASE ENTER THE OTHER DESTINATIONS YOU WANT TO GO TO IN href -->
    <a href="view_coupons.php">BACK</a>&emsp;&emsp;
</body>
</html>