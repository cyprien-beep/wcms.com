<?php
include 'db_connect.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['userid'])) {
    die('User ID is not set in session. Please login again.');
}

$userid = $_SESSION['userid'];

// Fetch the username from the database
$query = "SELECT username FROM users WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$_SESSION['username'] = $user['username'] ?? '';

// SQL query to fetch requests
$sel = "SELECT id, waste_type, pickup_date, pickup_time,location, request_status, users.username, users.userid 
        FROM users 
        JOIN collection_requests ON users.userid = collection_requests.user_id";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle approval or rejection
    $requestId = $_POST['request_id'];
    $userId = $_POST['user_id'];
    $status = $_POST['status'];

    // Update the request status in the database
    $updateQuery = "UPDATE collection_requests SET request_status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    if ($stmt) {
        $stmt->bind_param("si", $status, $requestId);
        $stmt->execute();

        // Prepare the notification message
        $message = "Your request has been $status.";

        // Insert notification into the database
        $notificationQuery = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notificationStmt = $conn->prepare($notificationQuery);
        if ($notificationStmt) {
            $notificationStmt->bind_param("is", $userId, $message);
            $notificationStmt->execute();
            $notificationStmt->close();
        } else {
            echo "Error preparing notification statement: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing update statement: " . $conn->error;
    }

    // Redirect back to the same page to refresh the request list
    header("Location: view_request.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Collection Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Waste Type</th>
                <th>Pickup Date</th>
                <th>Pickup Time</th>
                <th>Location</th>
                <th>Status</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $row = $conn->query($sel);
        while ($dd = mysqli_fetch_array($row)) {
            ?>
            <tr>
                <td><?php echo $dd['id']; ?></td>
                <td><?php echo htmlspecialchars($dd['username']); ?></td>
                <td><?php echo htmlspecialchars($dd['waste_type']); ?></td>
                <td><?php echo htmlspecialchars($dd['pickup_date']); ?></td>
                <td><?php echo htmlspecialchars($dd['pickup_time']); ?></td>
                <td><?php echo htmlspecialchars($dd['location']); ?></td>
                <td><?php echo htmlspecialchars($dd['request_status']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="request_id" value="<?php echo $dd['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $dd['userid']; ?>">
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-success btn-sm <?php echo ($dd['request_status'] == 'Rejected') ? 'disabled' : ''; ?>">
                            <i class="bi bi-check-circle"></i> Approve
                        </button>
                    </form>
                </td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="request_id" value="<?php echo $dd['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $dd['userid']; ?>">
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-x-circle"></i> Reject
                        </button>

                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

                    <a href="admin_dash.php" ><button class="btn btn-success" style="align: center;">Back</button></a>
</body>
</html>
