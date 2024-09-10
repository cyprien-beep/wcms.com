<?php
// Include database configuration
include 'db_connect.php'; // Ensure this contains MySQLi connection setup

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count waste collectors
$sql = "SELECT COUNT(*) AS total_collectors FROM users WHERE role = 'waste_collector'";
$result = $conn->query($sql);

// Fetch the result
$totalCollectors = 0;
if ($result) {
    $row = $result->fetch_assoc();
    $totalCollectors = $row['total_collectors'];
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Collectors Count</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2></h2>
        <div class="alert alert-info text-center">
            <h3><?php echo htmlspecialchars($totalCollectors); ?></h3>
        </div>
    </div>
</body>
</html>
