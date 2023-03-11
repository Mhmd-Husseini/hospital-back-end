<?php
include('connect.php');

$response = array();

if (isset($_POST['email'], $_POST['password'], $_POST['name'], $_POST['gender'], $_POST['user_types_id'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $user_types_id = $_POST['user_types_id'];

    $check = $mysqli->prepare('SELECT email FROM users WHERE email = ?');
    $check->bind_param('s', $email);
    if ($check->execute()) {
        $check->store_result();
        $num_rows = $check->num_rows();
        if ($num_rows > 0) {
            $response['status'] = 'Email already exists';
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = $mysqli->prepare('INSERT INTO users (name, email, password, gender, user_types_id) VALUES (?, ?, ?, ?, ?)');
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
