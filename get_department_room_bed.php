<?php
include('connect.php');


$response = json_decode($auth_response, true);
    $token = $response['token'];
    header("Location: login.php?token=$token");
    $decoded_token = JWT::decode($token, 'secret_key', array('HS256'));
    $userid = $decoded_token->id;


$result = $mysqli->query("SELECT departments.id As depid, departments.name AS depname,
rooms.number, rooms.number_beds, beds.id AS bedid 
FROM departments 
join hospital_users on departments.hospital_id=hospitals.id
join rooms on rooms.department_id=departments.id
join users on users.id=hospital_users.user_id
join beds on beds.room_id=rooms.id
where users.id=?");
$result->bind_param("i", userid);
$result->execute();

$results =[];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $results[] = $row;
    }
  }

  echo json_encode($results);
?>