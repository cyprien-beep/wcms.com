<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include('db_connect.php');

// Fetch all approved collection requests from the database
$query = "SELECT cr.id, cr.pickup_date, u.username, cr.location
          FROM collection_requests cr
          JOIN users u ON cr.user_id = u.userid
          WHERE cr.request_status = 'approved'
          ORDER BY cr.pickup_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$approved_requests = [];
while ($row = $result->fetch_assoc()) {
    $approved_requests[] = $row;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Collection Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1>Approved Collection Requests</h1>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Date</th>
                <th>Username</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($approved_requests)): ?>
                <tr>
                    <td colspan="5">No approved collection requests found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($approved_requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['id']) ?></td>
                        <td><?= htmlspecialchars($request['pickup_date']) ?></td>
                        <td><?= htmlspecialchars($request['username']) ?></td>
                        <td><?= htmlspecialchars($request['location']) ?></td>
                        <td><a href="mark_collected.php?id=<?= htmlspecialchars($request['id']) ?>" class="btn btn-success" name="mark_as_collected">Mark as Collected</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body></html>
