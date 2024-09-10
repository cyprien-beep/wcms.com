<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

<!-- Report Form -->
<form id="report-form" action="" method="POST">
    <h3>Submit a Report</h3>

    <label for="user-role">User Role:</label>
    <select id="user-role" name="user_role" required>
        <option value="waste_owner">Waste Owner</option>
        <option value="waste_collector">Waste Collector</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <label for="user-id">User ID:</label>
    <input type="number" id="user-id" name="user_id" required><br><br>

    <label for="report-type">Report Type:</label>
    <select id="report-type" name="report_type" required>
        <option value="issue">Issue</option>
        <option value="feedback">Feedback</option>
        <option value="status_update">Status Update</option>
    </select><br><br>

    <label for="report-details">Report Details:</label>
    <textarea id="report-details" name="report_details" required></textarea><br><br>

    <button type="submit" name="submit">Submit</button>
</form>
<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $user_role = $_POST['user_role'];
    $user_id = $_POST['user_id'];
    $report_type = $_POST['report_type'];
    $report_details = $_POST['report_details'];

    // Sanitize the input data
    $user_role = $conn->real_escape_string($user_role);
    $user_id = $conn->real_escape_string($user_id);
    $report_type = $conn->real_escape_string($report_type);
    $report_details = $conn->real_escape_string($report_details);

    $sql = "INSERT INTO reports (user_role, user_id, report_type, report_details)
            VALUES ('$user_role', '$user_id', '$report_type', '$report_details')";

    if ($conn->query($sql) === TRUE) {
        echo "Report submitted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

</body>
</html>