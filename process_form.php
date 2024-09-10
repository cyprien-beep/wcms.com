<?php
include 'db_connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/vendor/autoload.php'; // Adjust the path if necessary

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    //$userid = $_POST['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];

    // Validate form data
    if ($password !== $repassword) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $role, $phone);

    // Execute the statement
    if ($stmt->execute()) {
        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'cypriennzayisenga4@gmail.com';             // SMTP username
            $mail->Password   = 'Cyprien@250';                // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
            $mail->Port       = 587;                                   // TCP port to connect to

            //Recipients
            $mail->setFrom('cypriennzayisenga4@gmail.com', 'CYpp');
            $mail->addAddress($email, $name);                         // Add a recipient

            // Content
            $mail->isHTML(true);                                      // Set email format to HTML
            $mail->Subject = 'Registration Confirmation';
            $mail->Body    = '<h1>Welcome, ' . htmlspecialchars($name) . '!</h1><p>Thank you for registering.</p>';
            $mail->AltBody = 'Welcome, ' . htmlspecialchars($name) . '! Thank you for registering.';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        header("Location: login.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
