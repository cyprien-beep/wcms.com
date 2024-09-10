<?php
// Include database configuration
include 'db_connect.php'; // Ensure this contains MySQLi connection setup

// Create a MySQLi connection
//$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get waste collectors
$sql = "SELECT userid, username, email, phone FROM users WHERE role = 'waste_collector'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Collectors</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Waste Collectors</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($collector = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($collector['userid']); ?></td>
                            <td><?php echo htmlspecialchars($collector['username']); ?></td>
                            <td><?php echo htmlspecialchars($collector['email']); ?></td>
                            <td><?php echo htmlspecialchars($collector['phone']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No waste collectors found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
