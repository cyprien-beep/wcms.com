<!DOCTYPE html >
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
<form action="" method="POST">
    <h3>Waste Owner Form</h3>
    <label for="owner-name">Name:</label>
    <input type="text" id="owner-name" name="owner_name" required><br><br>

    <label for="owner-email">Email:</label>
    <input type="email" id="owner-email" name="owner_email" required><br><br>

    <label for="owner-phone">Phone:</label>
    <input type="tel" id="owner-phone" name="owner_phone" required><br><br>

    <label for="owner-address">Address:</label>
    <textarea id="owner-address" name="owner_address" required></textarea><br><br>

    <label for="collection-date">Preferred Collection Date:</label>
    <input type="date" id="collection-date" name="collection_date"><br><br>

    <button type="submit" name="submit">Submit</button>
    <?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['owner_name'];
    $email = $_POST['owner_email'];
    $phone = $_POST['owner_phone'];
    $address = $_POST['owner_address'];
    $collection_date = $_POST['collection_date'];

    $sql = "INSERT INTO waste_owners (name, email, phone, address, preferred_collection_date)
            VALUES ('$name', '$email', '$phone', '$address', '$collection_date')";

    if ($conn->query($sql) === TRUE) {
        echo "New waste owner record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

</form>
</body>
</html>
