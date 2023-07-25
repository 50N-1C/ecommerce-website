<?php
require_once 'conn.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the XML data from the request body
        $xml = file_get_contents('php://input');
        $data = simplexml_load_string($xml);

        // Validate the required fields
        if (empty($data->username) || empty($data->email) || empty($data->password)) {
            $response['error'] = true;
            $response['message'] = 'Username, email, and password are required.';
        } else {
            // Sanitize the input data to prevent SQL injection
            $username = htmlspecialchars($data->username);
            $email = htmlspecialchars($data->email);
            $password = password_hash($data->password, PASSWORD_DEFAULT);

            // Insert the user data into the database
            $stmt = $conn->prepare("INSERT INTO Users (Username, Email, Password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                $response['error'] = false;
                $response['message'] = 'User registration successful.';
            } else {
                $response['error'] = true;
                $response['message'] = 'User registration failed.';
            }
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'Invalid request method. Only POST requests allowed.';
    }
} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = 'Database Error: ' . $e->getMessage();
}

// Set the response content type to XML
header('Content-Type: application/xml');

// Output the XML response
$xml_response = new SimpleXMLElement('<response/>');
array_walk_recursive($response, array($xml_response, 'addChild'));
print $xml_response->asXML();
?>