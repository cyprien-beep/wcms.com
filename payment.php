<?php
session_start();
include 'db_connect.php';

// Assuming you have the user's mobile money details stored in the session or database
$userid = $_SESSION['userid'];
$amount = $_POST['amount'];
$payment_method = $_POST['payment_method']; // Assume this contains mobile money provider info
$mobile_money_number = '0790734580'; // Retrieve from database or session

// Payment Gateway API URL and credentials (replace with your actual API details)
$api_url = "https://api.mobilemoneyprovider.com/v1/payments";
$api_key = "YOUR_API_KEY";
$api_secret = "YOUR_API_SECRET";

// Prepare the data for the API request
$data = [
    'amount' => $amount,
    'currency' => 'rwf', // e.g., USD, KES
    'payment_method' => $payment_method, // Specify the mobile money provider
    'receiver_number' => $mobile_money_number, // User's mobile money number
    'description' => 'Waste Collection Payment',
    'callback_url' => 'https://yourwebsite.com/payment_callback.php', // For async notification
];

// Initialize cURL
$ch = curl_init($api_url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
]);

// Execute the API request
$response = curl_exec($ch);
$response_data = json_decode($response, true);

// Close cURL
curl_close($ch);

// Check the response from the payment gateway
if ($response_data['status'] == 'success') {
    // Insert payment record into the database
    $sql = "INSERT INTO payments (user_id, amount, payment_method) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ids', $userid, $amount, $payment_method);

    if ($stmt->execute()) {
        echo "<script>alert('Payment successful'); window.location.href='payment.html';</script>";
    } else {
        echo "<script>alert('Payment recorded failed'); window.location.href='payment.html';</script>";
    }

    $stmt->close();
} else {
    // Handle payment failure
    echo "<script>alert('Payment failed: " . $response_data['message'] . "'); window.location.href='payments.php';</script>";
}

$conn->close();
?>
