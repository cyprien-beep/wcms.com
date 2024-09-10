<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>


<?php
// Connect to the database
$conn = new mysqli('localhost', 'username', 'password', 'waste_collection');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$binId = $_POST['binId'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$collectorId = 1; // Replace with the logged-in collector's ID

// Insert collection record with GPS coordinates
$sql = "INSERT INTO collection_records (bin_id, collector_id, status, latitude, longitude) 
        VALUES ('$binId', '$collectorId', 'collected', '$latitude', '$longitude')";

if ($conn->query($sql) === TRUE) {
    // Fetch owner's email address
    $ownerSql = "SELECT email FROM users 
                 JOIN bins ON users.id = bins.owner_id
                 WHERE bins.bin_id = '$binId'";
    $result = $conn->query($ownerSql);
    $owner = $result->fetch_assoc();
    
    if ($owner) {
        $to = $owner['email'];
        $subject = "Your Bin has been Collected!";
        $message = "Your bin with ID: $binId has been collected.\n\n" .
                    "Collection Location:\nLatitude: $latitude\nLongitude: $longitude";
        $headers = "From: no-reply@wastemanagement.com";

        // Send the email
        mail($to, $subject, $message, $headers);
    }

    echo "Collection record updated and email sent successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
</body>
</html>