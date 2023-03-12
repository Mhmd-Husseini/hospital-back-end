<?php
include('connect.php');

$patientId = $_POST['patient_id'];
$hospitalId = $_POST['hospital_id'];

$stmt = $mysqli->prepare("INSERT INTO hospital_users (hospital_id, user_id)
VALUES (?, ?)");
$stmt->bind_param("ii", $hospitalId, $patientId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['message' => 'Patient assigned successfully.']);
} else {
    echo json_encode(['error' => 'Error assigning patient.']);
}
