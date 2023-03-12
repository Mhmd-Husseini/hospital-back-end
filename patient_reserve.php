<?php
include('connect.php');

$patientId = $_POST['patient_id'];
$departmentId = $_POST['department_id'];
$roomId = $_POST['room_id'];
$bedId = $_POST['bed_id'];


$stmt = $mysqli->prepare("INSERT INTO user_departments (user_id, department_id)
VALUES (?, ?) 
Insert Into user_rooms (user_id, room_id, bed_id) Values (?, ?, ?, ?, ?)");
$stmt->bind_param("iiiii", $patientId, $departmentId, $roomId, $bedId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['message' => 'Patient reserved successfully.']);
} else {
    echo json_encode(['error' => 'Error.']);
}
