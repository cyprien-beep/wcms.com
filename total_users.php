<?php
// Include database connection
include('db_connect.php');

// Query to count total users
$query = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $totalUsers = $row['total_users'];
} else {
    $totalUsers = 0; // Default to 0 if there's an error
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Count</title>
    <style>
        .user-count {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
            color: ;
        }
        
    </style>
</head>
<body>
    <div class="alert alert-info text-center">
        <h1> <?php echo $totalUsers; ?></h>
    </div>
</body>
</html>
