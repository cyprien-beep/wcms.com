<?php
session_start();
// Generate a CSRF token for security
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validateForm() {
            const amount = document.getElementById('amount').value;
            if (amount <= 0) {
                alert('Amount must be a positive number');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Payments</h2>
        <form action="payment.php" method="POST" onsubmit="return validateForm();">
            <!-- CSRF Token for security -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" id="amount" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select id="payment_method" name="payment_method" class="form-select" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="mobile_money">Mobile Money</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <button  class="btn btn-primary"><a href="owner_dash.php">Back</a></button>
</body>
</html>
