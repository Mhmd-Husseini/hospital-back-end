<?php
include('connect.php');

$result = $mysqli->query("SELECT * FROM users 
join user_types on user_types.id=users.user_types_id 
where user_types='employee'");

$results =[];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $results[] = $row;
    }
  }

  echo json_encode($results);
?>