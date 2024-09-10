<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Include database connection
include('db_connect.php');

// Get the notification ID from the POST request
$notificationId = $_POST['id'];

// Update the notification status to 'read'
$query = "UPDATE notifications SET status = 'read' WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $notificationId, $_SESSION['userid']);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update notification.']);
}
?>
