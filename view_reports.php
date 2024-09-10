
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>


<?php
include 'db_connect.php';

// Fetch all reports from the reports table
$sql = "SELECT * FROM reports ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Report Type</th>
            <th>Report Details</th>
            <th>User ID</th>
            <th>User Role</th>
            <th>Created At</th>
          </tr>";
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["report_type"] . "</td>
                <td>" . $row["report_details"] . "</td>
                <td>" . $row["user_id"] . "</td>
                <td>" . $row["user_role"] . "</td>
                <td>" . $row["created_at"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No reports found";
}

$conn->close();
?>

</body>
</html>