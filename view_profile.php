<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
            <i class="bi bi-person-circle"></i> Profile
        </a>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Your Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                include 'db_connect.php';

                // Check if the user is logged in
                if (!isset($_SESSION['userid'])) {
                    header("Location: login.html");
                    exit();
                }

                // Fetch the user's profile information from the database
                $userid = $_SESSION['userid'];
                $sql = "SELECT * FROM users WHERE userid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $userid);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                ?>

                <form action="update_profile.php" method="post">
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" disabled value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" disabled value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" disabled value="<?php echo htmlspecialchars($user['phone']); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" id="role" name="role" disabled value="<?php echo htmlspecialchars($user['role']); ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
