<?php
require_once 'conn.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the XML data from the request body
    $xml = file_get_contents('php://input');
    $data = simplexml_load_string($xml);

    // Validate the required fields
    if (empty($data->email) || empty($data->password)) {
        $response['error'] = true;
        $response['message'] = 'Email and password are required.';
    } else {
        $email = $data->email;
        $password = $data->password;

        // Check the user credentials in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        try {
            if ($stmt->execute()) {
                // Check if the query returned any rows
                if ($stmt->rowCount() > 0) {
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    $response['error'] = false;
                    $response['message'] = 'Login successful.';
                    
                    // Create JWT token
                    $jwt_payload = array(
                        "sub" => 1234567890,
                        "id" => $res['UserID'],
                        "name" => $res['Username'],
                        "email" => $res['Email'],
                        "role" => $res['Rule'],
                        "iat" => time()
                    );
                    $jwt_token = jwt_encode($jwt_payload);
                    setcookie("jwt_token", $jwt_token, time() + (86400 * 30), '/');
                    
                    // Set the response content type to JSON
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit();
                } else {
                    $response['error'] = true;
                    $response['message'] = 'Invalid email or password.';
                }
            } else {
                $response['error'] = true;
                $response['message'] = 'Login failed.';
            }
        } catch (PDOException $e) {
            $response['error'] = true;
            $response['message'] = 'Database Error: ' . $e->getMessage();
        }
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request method. Only POST requests allowed.';
}

// Check if there is an error and format the response accordingly
if ($response['error']) {
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Successful login, redirect to the admin.php page
    header('Location: http://localhost/a7a/admin.php');
    exit();
}

$jwt_secret = "Koko_Is_a_good_hacke_yooo_2020@koko";

// Function to encode a JWT given a payload
function jwt_encode($payload)
{
    global $jwt_secret;
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode($payload);
    $base64_header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64_payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    $signature = hash_hmac('sha256', $base64_header . '.' . $base64_payload, $jwt_secret, true);
    $base64_signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    return $base64_header . '.' . $base64_payload . '.' . $base64_signature;
}

// Function to decode a JWT and return the payload
function jwt_decode($jwt)
{
    global $jwt_secret;
    $jwt_parts = explode('.', $jwt);
    $jwt_header = base64_decode(str_replace(['-', '_'], ['+', '/'], $jwt_parts[0]));
    $jwt_payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $jwt_parts[1]));
    $jwt_signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $jwt_parts[2]));
    $signature_verified = hash_hmac('sha256', $jwt_parts[0] . '.' . $jwt_parts[1], $jwt_secret, true) === $jwt_signature;
    return json_decode($jwt_payload, true);
}
?>
