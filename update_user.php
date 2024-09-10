<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include('db_connect.php');

// Initialize user variable
$user = null;
$errors = []; // Array to collect errors

// Validate and fetch user data for the given ID
if (isset($_GET['userid'])) {
    $userId = intval($_GET['userid']); // Ensure userId is an integer
    $query = "SELECT * FROM users WHERE userid = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $userId); // Use "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
    } else {
        $errors[] = "Failed to prepare statement for fetching user.";
    }
}

// Check if user exists
if (!$user) {
    // Redirect to users page with an error message
    $_SESSION['error_message'] = "User not found.";
    header("Location: users.php");
    exit();
}

// Update user information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Validate inputs
    if (empty($username)) {
        $errors[] = "Username cannot be empty.";
    }
    if (empty($email)) {
        $errors[] = "Email cannot be empty.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // If there are no errors, proceed to update
    if (empty($errors)) {
        $updateQuery = "UPDATE users SET username = ?, email = ?, phone = ? WHERE userid = ?";
        $updateStmt = $conn->prepare($updateQuery);
        if ($updateStmt) {
            $updateStmt->bind_param("sssi", $username, $email,$phone,$userId);
            if ($updateStmt->execute()) {
                $_SESSION['success_message'] = "User updated successfully.";
                header("Location: users.php");
                exit();
            } else {
                $errors[] = "Failed to update user: " . $updateStmt->error;
            }
            $updateStmt->close();
        } else {
            $errors[] = "Failed to prepare statement for updating user.";
        }
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1>Update User</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
         <div class="mb-3">
            <label for="phone" class="form-label">Email</label>
            <input type="phone" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        </div>
        <button type="submit" name="Update" class="btn btn-primary">Update User</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
