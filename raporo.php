<!DOCTYPE html>
<html>
<head>
    <title>Insert Collection Data</title>
</head>
<body>
    <?php 
    include 'db_connect.php'; // Include your database connection file

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch all user_ids from the users table
    $data = mysqli_query($conn, "SELECT * FROM users WHERE role='waste_collector'");

    ?>

    <form action="" method="POST">
        <label for="username">Username:</label><br><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="userid">User ID:</label><br><br>
        <select id="userid" name="userid" required>
            <option value="">Select User ID</option>
            <?php 
            // Display user_id as options in the dropdown
            while ($row = mysqli_fetch_assoc($data)) {
                echo "<option value='" . $row['userid'] . "'>" . $row['userid'] . "</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" name="submit" value="Insert Collection Data">
    </form>

    <?php
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Get the user_id from form input
        $user_id = $_POST['userid'];
        $username = $_POST['username']; // Assuming you want to use this as well

        // Check if user_id exists in users table (not strictly needed since we already fetched it above)
        $userQuery = $conn->prepare("SELECT userid FROM users WHERE userid = ?");
        $userQuery->bind_param("i", $user_id);
        $userQuery->execute();
        $userQuery->store_result();

        if ($userQuery->num_rows > 0) {
            // Insert into collections table
            $stmt = $conn->prepare("INSERT INTO collections (user_id) VALUES (?)");
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                echo "New collection record inserted successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "User not found.";
        }

        // Close user query
        $userQuery->close();
    }

    // Close the connection
    $conn->close();
    ?>

</body>
</html>
