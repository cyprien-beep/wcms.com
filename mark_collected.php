<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html");
    exit();
}

// Include database connection
include('db_connect.php');

// Get request ID from the URL
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['mark_as_collected'])) {
        $request_id = $_POST['id'];

        // Begin a transaction
        $conn->begin_transaction();
        try {
            // Update the request status to 'collected'
            $query = "UPDATE collection_requests SET request_status = 'collected' WHERE id = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("i", $request_id);
            if (!$stmt->execute()) {
                throw new Exception("Error updating request status: " . $stmt->error);
            }

            // Check if admin ID exists in users table
            $admin_id = 1; // Assuming admin user ID is 1
            $check_admin_query = "SELECT * FROM users WHERE userid = ?";
            $check_stmt = $conn->prepare($check_admin_query);
            if (!$check_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $check_stmt->bind_param("i", $admin_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            if ($check_result->num_rows === 0) {
                throw new Exception("Admin user ID does not exist.");
            }

            // Notify the admin
            $notification_query = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
            $notification_stmt = $conn->prepare($notification_query);
            if (!$notification_stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $message = "Request ID $request_id has been marked as collected.";
            $notification_stmt->bind_param("is", $admin_id, $message);
            if (!$notification_stmt->execute()) {
                throw new Exception("Error inserting notification: " . $notification_stmt->error);
            }

            // Commit the transaction
            $conn->commit();

            // Set success message and redirect back to the collection requests page
            $_SESSION['success_message'] = "Collection request marked as collected.";
            header("Location: approved_requests.php");
            exit();

        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();
            $_SESSION['error_message'] = $e->getMessage(); // Store error message in session
            header("Location: collection_requests.php"); // Redirect back to the requests page
            exit();
        } finally {
            // Close statements
            if (isset($stmt)) $stmt->close();
            if (isset($check_stmt)) $check_stmt->close();
            if (isset($notification_stmt)) $notification_stmt->close();
        }
    }
}

// Close the database connection
$conn->close();
?>
