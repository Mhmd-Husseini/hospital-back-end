<?php
header('Content-Type: application/json');
include('connect.php');
include('jwt.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['email'], $data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    $query = $mysqli->prepare('SELECT id, email, user_password, user_types_id FROM users WHERE email = ?');
    $query->bind_param('s', $email);
    if ($query->execute()) {
        $query->store_result();
        $num_rows = $query->num_rows();
        if ($num_rows == 1) {
            $query->bind_result($id, $email, $hashed_password, $user_types_id);
            $query->fetch();
            if (password_verify($password, $hashed_password)) {
                $token = array();
                $token['id'] = $id;
                $token['email'] = $email;
                $token['user_types_id'] = $user_types_id;
                $jwt = JWT::encode($token, 'secret_key');
                $response['status'] = 'success';
                $response['token'] = $jwt;
                $response['user_type'] = $user_types_id;
            } else {
                $response['status'] = 'Invalid email or password';
            }
        } else {
            $response['status'] = 'Invalid email or password';
        }
    } else {
        $response['status'] = 'Error executing query';
    }
} else {
    $response['status'] = 'Missing input parameters';
}

echo json_encode($response);
?>
