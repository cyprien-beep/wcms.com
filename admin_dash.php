<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit()
    ;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding: 15px;
            position: fixed;
            width: 250px;
        }

        .sidebar .nav-link {
            color: #fff;
            margin-bottom: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            text-align: center;
            color: blue;
            font-family: italic;
        }

        .navbar {
            margin-left: 250px;
            background-color: #ffffff;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar .navbar-brand {
            font-weight: bold;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white">Admin Dashboard</h4>
        <hr class="text-white">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-people-fill"></i> Manage Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-truck"></i> Manage Waste Collectors</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_request.php"><i class="bi bi-geo-alt-fill"></i> View Requests</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-bar-chart-fill"></i> Reports</a>
            </li>
            <li class="nav-item">
                <!-- Settings Button Trigger Modal -->
                <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#settingsModal">
                    <i class="bi bi-gear-fill"></i> Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <nav class="navbar navbar-light">
            <a class="navbar-brand" href="#">Admin Panel</a>
        </nav>
        <div class="welcome-message">
            <h1>
            <?php
            echo "Welcome dear, " . htmlspecialchars($_SESSION['username']) . "!";
            ?>
            </h1>
            
        </div>
        <div style="margin-left:1000px "><?php include'timm.php';?></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-people-fill"></i> Total Users</h5>
                            <?php
                             include'total_users.php';
                            ?>
                            <p class="card-text">Manage and view users.</p>
                            <a href="users.php" class="btn btn-primary">Go to Users</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-truck"></i> Waste Collectors</h5>
                            <?php
                             include'total_collectors.php';
                            ?>
                            <p class="card-text">View and manage waste collectors.</p>
                            <a href="display_collectors.php" class="btn btn-primary">Go to Waste Collectors</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-geo-alt-fill"></i> Collection Requests</h5>
                            <?php
                            include'total_requests.php';
                            ?>
                            <p class="card-text">Monitor and manage collection requests.</p>
                            <a href="view_request.php" class="btn btn-primary">View Requests</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-bar-chart-fill"></i> Reports</h5>
                            <p class="card-text">Generate and view reports.</p>

                        
                            <a href="raporo.php" class="btn btn-primary">Go to Reports</a>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
