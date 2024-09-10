<?php
header('Content-Type: application/json');
include 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT latitude, longitude FROM gps_locations ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(array("latitude" => 0, "longitude" => 0));
}

$conn->close();
?>
s