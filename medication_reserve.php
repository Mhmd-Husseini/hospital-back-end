<?php
include('connect.php');

$userId = $_POST['user_id'];
$medicationId = $_POST['medication_id'];
$quantity = $_POST['quantity'];

$stmt = $mysqli->prepare("INSERT INTO users_medication (user_id, medication_id, quantity)
VALUES (?, ?, ?)");
$stmt->bind_param("iii", $userId, $medicationId, $quantity);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['message' => 'Patient reserved successfully.']);
} else {
    echo json_encode(['error' => 'Error.']);
}
