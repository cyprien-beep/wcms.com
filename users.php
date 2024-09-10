<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include('db_connect.php');

// Fetch users from the database
$query = "SELECT userid, username, email, role, phone FROM users"; // Adjust fields as necessary
$result = $conn->query($query);

if (!$result) {
    die("Database query failed: " . $conn->error);
}

$users = $result->fetch_all(MYSQLI_ASSOC);

// Handle delete request
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $deleteQuery = "DELETE FROM users WHERE userid = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $deleteId);
    $deleteStmt->execute();
    header("Location: users.php"); // Redirect to refresh the page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1>Users</h1>
    <?php if (empty($users)): ?>
        <p>No users found.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['userid']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td>
                            <a href="update_user.php?userid=<?= $user['userid'] ?>" class="btn btn-sm btn-warning">Update</a>
                            <a href="?delete_id=<?= $user['userid'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<a href="admin_dash.php">Back</a>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
