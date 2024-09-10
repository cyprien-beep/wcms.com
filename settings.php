<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include('db_connect.php'); // Make sure to create this file for database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $currentPassword = htmlspecialchars(trim($_POST['current_password']));
    $newPassword = htmlspecialchars(trim($_POST['password']));
    
    // Fetch the user's current hashed password from the database
    $userid = $_SESSION['userid'];
    $query = "SELECT password FROM users WHERE userid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the current password
    if (password_verify($currentPassword, $user['password'])) {
        // Update user information in the database
        $query = "UPDATE users SET username = ?, password = ? WHERE userid = ?";
        $stmt = $conn->prepare($query);
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // Hash the new password
        $stmt->bind_param("ssi", $username, $hashedPassword, $userid);
        
        if ($stmt->execute()) {
            $_SESSION['username'] = $username; // Update session variable
            $successMessage = "Settings updated successfully!";
            header("Location: login.html");
        } else {
            $errorMessage = "Failed to update settings. Please try again.";
        }
    } else {
        $errorMessage = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: skyblue;
        }
        .content {
            padding: 20px;
        }
        a {
            color: white;
            text-decoration: none;
        }
        h1 {
            text-align: center;
            color: blue;
        }
        form {
            align-content: center;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="content">
    <h1>User Settings</h1>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success"><?= $successMessage ?></div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>

    <!-- Settings Button Trigger Modal -->
    <a href="#"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#settingsModal">
        Open Settings Modal
    </button></a>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">User Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
