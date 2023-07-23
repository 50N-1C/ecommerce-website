<?php
    session_start();

    include("../connection.php"); 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Coupons</title>
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
                    echo "<td>" . $row['ExpiryDate'] . "</td>"; //Format : 2023-07-25
                    echo "</tr>";
                }
            ?>
		</tbody>
	</table>
     <!-- PLEASE ENTER THE OTHER DESTINATIONS YOU WANT TO GO TO IN href -->
    <a href="create_coupons.php">Create Coupon</a>&emsp;&emsp;
    <a href="delete_coupons.php">Delete Coupon</a>&emsp;&emsp;
    <a href="edit_coupons.php">Edit Coupon</a>&emsp;&emsp;
</body>
</html>