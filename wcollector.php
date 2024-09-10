<!-- Waste Collector Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>

<form  method="POST" action="">
    <h3>Waste Collector Form</h3>
    <label for="collector-name">Name:</label>
    <input type="text" id="collector-name" name="collector_name" required><br><br>

    <label for="collector-email">Email:</label>
    <input type="email" id="collector-email" name="collector_email" required><br><br>

    <label for="collector-phone">Phone:</label>
    <input type="tel" id="collector-phone" name="collector_phone" required><br><br>

    <label for="collector-area">Assigned Area:</label>
    <input type="text" id="collector-area" name="collector_area" required><br><br>

    <label for="route-start">Route Start Time:</label>
    <input type="time" id="route-start" name="route_start" required><br><br>

    <button type="submit" name="submit">Submit</button>
</form>
<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['collector_name'];
    $email = $_POST['collector_email'];
    $phone = $_POST['collector_phone'];
    $assigned_area = $_POST['collector_area'];
    $route_start = $_POST['route_start'];

    $sql = "INSERT INTO waste_collectors (name, email, phone, assigned_area, route_start_time)
            VALUES ('$name', '$email', '$phone', '$assigned_area', '$route_start')";

    if ($conn->query($sql) === TRUE) {
        echo "New waste collector record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

</body>
</html>