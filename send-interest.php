<?php
session_start();
include('Database/db-connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to send interest']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$receiver_id = $input['receiver_id'] ?? null;
$sender_id = $_SESSION['user_id'];

if (!$receiver_id) {
    echo json_encode(['success' => false, 'message' => 'Receiver ID is required']);
    exit;
}

if ($sender_id == $receiver_id) {
    echo json_encode(['success' => false, 'message' => 'You cannot send interest to yourself']);
    exit;
}

// Check if interest already exists
$check_query = "SELECT id FROM user_interests WHERE sender_id = ? AND receiver_id = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $sender_id, $receiver_id);
$check_stmt->execute();
$existing = $check_stmt->get_result()->fetch_assoc();

if ($existing) {
    echo json_encode(['success' => false, 'message' => 'Interest already sent to this profile']);
    exit;
}

// Insert new interest
$insert_query = "INSERT INTO user_interests (sender_id, receiver_id, status) VALUES (?, ?, 'pending')";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("ii", $sender_id, $receiver_id);

if ($insert_stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Interest sent successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send interest']);
}
?>