<?php
// Include the database connection file
include 'db_connect.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the request ID from the URL
    $id = $_GET['id'];

    // Escape the ID to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);

    // Prepare the SQL query to update the request status to 'Approved'
    $sql = "UPDATE collection_requests SET request_status = 'Approved' WHERE id = '$id'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // If the update was successful, redirect back to the collection requests page or display a success message
        echo "<script>alert('Request has been approved successfully.')</script>";
        // Optionally, you can redirect to the previous page:
        header("Location: view_request.php");
        // exit();
    } else {
        // If there was an error, display an error message
        echo "Error updating record: " . $conn->error;
    }
} else {
    // If no 'id' parameter is provided, display an error message
    echo "No request ID provided.";
}

// Close the database connection
$conn->close();
?>
