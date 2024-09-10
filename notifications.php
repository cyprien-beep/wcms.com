<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include('db_connect.php');

// Fetch notifications for the logged-in user
$userId = $_SESSION['userid'];
$query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-4">
    <h1>Notifications</h1>
    <?php if (empty($notifications)): ?>
        <p>No notifications.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($notifications as $notification): ?>
                <li class="list-group-item <?= $notification['status'] == 'unread' ? 'font-weight-bold' : '' ?>">
                    <?= htmlspecialchars($notification['message']) ?>
                    <small class="text-muted float-end"><?= $notification['created_at'] ?></small>
                    <?php if ($notification['status'] == 'unread'): ?>
                        <button class="btn btn-sm btn-primary float-end ms-2 mark-read" data-id="<?= $notification['id'] ?>">Mark as Read</button>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<script>
$(document).on('click', '.mark-read', function() {
    var notificationId = $(this).data('id');
    var $this = $(this);

    $.ajax({
        url: 'mark_read.php', // URL to the PHP script that handles marking as read
        method: 'POST',
        data: { id: notificationId },
        success: function(response) {
            // Remove the notification from the list or update the UI
            if (response.success) {
                $this.closest('li').remove(); // Remove the notification from the list
            } else {
                alert('Failed to mark notification as read.');
            }
        },
        error: function() {
            alert('An error occurred while processing your request.');
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
