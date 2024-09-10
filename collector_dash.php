<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Collector Dashboard</title>
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
            text-shadow: black;
        }
        .navbar {
            margin-left: 250px;
            background-color: #343a40;
            padding: 10px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }
        .navbar a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
          footer {
            background-color:black;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2 class="text-white">Collector Dashboard</h2>
    <a href="#"><i class="bi bi-house-door"></i> Home</a>
    <a href="approved_request.php"><i class="bi bi-truck"></i> Collection Requests</a>
    <a href="#"><i class="bi bi-map"></i> GPS Tracking</a>
    <a href="#"><i class="bi bi-wallet2"></i> Payments</a>
    <a href="#"><i class="bi bi-bar-chart"></i> Reports</a>
 <li class="nav-item">
                <!-- Settings Button Trigger Modal -->
                <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#settingsModal">
                    <i class="bi bi-gear-fill"></i> Settings
                </a>
            </li>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="navbar">
 
    
    <a href=""><i class="bi bi-bell"></i> Notifications</a>
        </a>
    <a href="#" data-togle ="modal" data-target="profileModal"> <?php
include 'view_profile.php';
?></a>


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

<div class="content">
    <div class="welcome-message">
        <h1>
        <?php
        // Output the username in a safe way
        echo "Welcome dear, " . htmlspecialchars($_SESSION['username']) . "!";
        ?>
        </h1>
       
           </div>
           <div style="margin-left:1000px "><?php include'timm.php';?></div>
          <footer style="color:white ;">
          <p>FYP&copy;2024 CYPRIEN AND THEOPHILE KEEP CITY CLEAN <a href=""><i class="bi bi-basket"></i></a></p>
<p>follow us on:<a href=""><i class="bi bi-facebook"></i></a>
    <a href="https//:www.whatsapp.com"><i class="bi bi-whatsapp"></i></a>
    <a href=""><i class="bi bi-instagram"></i></a>
    <a href=""><i class="bi bi-envelope"></i></a>
          </p>
            </footer>
 
    
    <!-- Additional content and cards can be added here -->
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
