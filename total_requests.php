<?php
include 'db_connect.php';
//session_start();

// Ensure user is logged in
if (!isset($_SESSION['userid'])) {
    die('User ID is not set in session. Please login again.');
}

$userid = $_SESSION['userid'];

// Fetch the username from the database
$query = "SELECT username FROM users WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$_SESSION['username'] = $user['username'] ?? '';

// SQL query to count requests
$countQuery = "SELECT COUNT(*) AS total_requests FROM collection_requests";
$countResult = $conn->query($countQuery);
$totalRequests = 0;

if ($countResult) {
    $row = $countResult->fetch_assoc();
    $totalRequests = $row['total_requests'];
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Total Collection Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    
    <div class="alert alert-info text-center">
        <h3><?php echo htmlspecialchars($totalRequests); ?></h3>
    </div>
</div>
</body>
</html>
