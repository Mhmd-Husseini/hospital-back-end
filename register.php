<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');

include('connect.php');

// Rest of your PHP code
include('connect.php');

$response = array();

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['email'], $data['password'], $data['name'], $data['gender'], $data['user_types_id'])) {
    $email = $data['email'];
    $password = $data['password'];
    $name = $data['name'];
    $gender = $data['gender'];
    $user_types_id = $data['user_types_id'];

    $check = $mysqli->prepare('SELECT email FROM users WHERE email = ?');
    $check->bind_param('s', $email);
    if ($check->execute()) {
        $check->store_result();
        $num_rows = $check->num_rows();
        if ($num_rows > 0) {
            $response['status'] = 'Email already exists';
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = $mysqli->prepare('INSERT INTO users (user_name, email, user_password, gender, user_types_id) VALUES (?, ?, ?, ?, ?)');
            $query->bind_param('ssssi', $name, $email, $hashed_password, $gender, $user_types_id);
            if ($query->execute()) {
                $response['status'] = 'You are added';
            } else {
                $response['status'] = 'Error executing query';
            }
        }
    } else {
        $response['status'] = 'Error checking email';
    }
} else {
    $response['status'] = 'Missing input parameters';
}

echo json_encode($response);
?>
