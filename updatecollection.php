
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
    echo "Collection record updated successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
