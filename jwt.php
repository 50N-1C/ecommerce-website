<?php 

		$jwt_secret = "123456789";
        function jwt_encode($payload) {
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
        function jwt_decode($jwt) {
            global $jwt_secret;
            $jwt_parts = explode('.', $jwt);
            $jwt_header = base64_decode(str_replace(['-', '_'], ['+', '/'], $jwt_parts[0]));
            $jwt_payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $jwt_parts[1]));
            $jwt_signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $jwt_parts[2]));
            $signature_verified = hash_hmac('sha256', $jwt_parts[0] . '.' . $jwt_parts[1], $jwt_secret, true) === $jwt_signature;
            return json_decode($jwt_payload, true);
        }


?>