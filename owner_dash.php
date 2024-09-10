<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Database connection
include 'db_connect.php'; // Make sure this file establishes a connection to your database

// Function to fetch notification count
function fetchNotificationCount($conn, $userId) {
    $query = "SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND status = 'unread'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['count'];
}

// Fetch notification count for the logged-in user
$notificationCount = fetchNotificationCount($conn, $_SESSION['userid']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Owner Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding: 15px;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
            text-align: center;
            color: blue;
            font-family: italic;
        }
        .navbar {
            margin-left: 250px;
            background-color: #343a40;
            padding: 100px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 5px;
            position: relative;
        .notification-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 class="text-white">Owner Dashboard</h2>
    <a href="#"><i class="bi bi-house-door"></i> Home</a>
    <a href="request_collection.html"><i class="bi bi-pencil-square"></i> Request Collection</a>
    <a href="#"><i class="bi bi-clock-history"></i> Collection History</a>
    <a href="#"><i class="bi bi-map"></i> Track Collector</a>
    <a href="payment.php"><i class="bi bi-wallet2"></i> Payments</a>
     <li class="nav-item">
                <!-- Settings Button Trigger Modal -->
                <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#settingsModal">
                    <i class="bi bi-gear-fill"></i> Settings
                </a>
            </li>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="navbar">
    <a href="notifications.php">
         <i class="bi bi-bell"></i> Notifications
        <?php if ($notificationCount > 0): ?>
            <span class="notification-count"><?php echo $notificationCount; ?></span>
        <?php endif; ?>
    </a>

    <a href="#" data-togle ="modal" data-target="profileModal"> <?php
include 'view_profile.php';
?></a>

</div>
<div style="margin-left:1400px "><?php include'timm.php';?></div>
<div class="content">
    <div class="welcome-message">
        <h1>
        <?php
        // Output the username in a safe way
        echo "Welcome dear, " . htmlspecialchars($_SESSION['username']) . "!";

        ?>

        </h1>
        
    </div>
</div>
<!-- Bootstrap Modal for Settings -->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">User Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to update username and password -->
                    <form method="POST" action="settings.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($_SESSION['username']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
