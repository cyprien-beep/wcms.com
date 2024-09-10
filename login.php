<?php
// login.php

session_start();
include 'db_connect.php';

// Check if the username and password are set
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Debugging output (remove in production)
        echo "Stored hash: " . $user['password'] . "<br>";
        echo "Entered password: " . $password . "<br>";

        // Verify password (assuming passwords are hashed)
        if (password_verify($password, $user['password'])) {
            // Regenerate session ID for security
            session_regenerate_id();

            // Store user info in session
            $_SESSION['userid'] = $user['userid'];  // Make sure the correct field name is used here
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] == 'admin') {
                header("Location: admin_dash.php");
                exit();
            } elseif ($user['role'] == 'waste_collector') {
                header("Location: collector_dash.php");
                exit();
            } elseif ($user['role'] == 'waste_owner') {
                header("Location: owner_dash.php");
                exit();
            } else {
                // Unknown role
                echo "Invalid role!";
            }
        } else {
            // Invalid password
            echo "<script>alert('Invalid username or password');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('Invalid username or password');</script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle missing fields
    echo "<script>alert('Please enter both username and password');</script>";
}
?>
