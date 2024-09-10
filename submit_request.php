<?php
// Include database connection
include 'db_connect.php';
session_start();
$userid = $_SESSION['userid'];
$_SESSION['username'] = $user['username'];
if (!isset($userid)) {
    die('User ID is not set in session. Please login again.');
}

$waste_type = $_POST['waste_type'];
$pickup_date = $_POST['pickup_date'];
$location=$_POST['location'];
$pickup_time = $_POST['pickup_time'];
$sel="SELECT * FROM users WHERE userid=?";
$sql = "INSERT INTO collection_requests (user_id, waste_type, pickup_date,location, pickup_time) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('issss', $userid, $waste_type, $pickup_date,$location, $pickup_time);

if ($stmt->execute()) {
    echo "<script>alert('Request submitted successfully'); window.location.href='owner_dash.php';</script>";
} else {
    echo "<script>alert('Failed to submit request'); window.location.href='request_collection.html';</script>";
}

$stmt->close();
$conn->close();
?>
