<?php
include('connection.php');

$result = $mysqli->query("SELECT * FROM hospitals");
$results =[];
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
      $results[] = $row;
    }
  }

  echo json_encode($results);
?>