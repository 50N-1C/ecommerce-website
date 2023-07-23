<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product Information</title>
</head>
<body>
    <h1>Product Information</h1>

    <?php
    // Include the connection file to establish a database connection
    include("../connection.php");



        // Retrieve product information
        $product_sql = "SELECT * FROM Products";
        $product_result = $con->query($product_sql);

        if ($product_result->rowCount() > 0) {
            while ($product_data = $product_result->fetch(PDO::FETCH_ASSOC)) {
                echo "<h2>" . $product_data['ProductName'] . "</h2>";
                echo "<p>ProductID: " . $product_data['ProductID'] . "</p>";
                echo "<p>Description: " . $product_data['Description'] . "</p>";
                echo "<p>Price: $" . $product_data['Price'] . "</p>";
                echo "<p>Stock Quantity: " . $product_data['StockQuantity'] . "</p>";

                // Retrieve the product category name
                $categoryID = $product_data['CategoryID'];
                $category_sql = "SELECT CategoryName FROM Category WHERE CategoryID = :categoryID";
                $category_result = $con->prepare($category_sql);
                $category_result->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
                $category_result->execute();

                if ($category_result->rowCount() > 0) {
                    $category_data = $category_result->fetch(PDO::FETCH_ASSOC);
                    echo "<p>Category: " . $category_data['CategoryName'] . "</p>";
                } else {
                    echo "<p>Category: Not specified</p>";
                }
            }
        } else {
            echo "Product not found.";
        }
    ?>

</body>
</html>
