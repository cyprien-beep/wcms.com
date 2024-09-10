<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Form</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            border-radius: 5px;
        }

        .form-group i {
            margin-right: 8px;
            color: #007bff;
        }

        .btn-custom {
            width: 100%;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form action="process_form.php" method="POST">
        <h3>Register Form</h3>

        <div class="form-group">
            <label for="name"><i class="bi bi-person-fill"></i> Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email"><i class="bi bi-envelope-fill"></i> Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password"><i class="bi bi-lock-fill"></i> Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="repassword"><i class="bi bi-lock-fill"></i> Re-enter Password:</label>
            <input type="password" class="form-control" id="repassword" name="repassword" required>
        </div>

        <div class="form-group">
            <label for="role"><i class="bi bi-briefcase-fill"></i> Role:</label>
            <select class="form-select" id="role" name="role" required>
                <option value="waste_owner">Waste Owner</option>
                <option value="waste_collector">Waste Collector</option>
            </select>
        </div>

        <div class="form-group">
            <label for="phone"><i class="bi bi-telephone-fill"></i> Phone:</label>
            <input type="tel" class="form-control" id="phone" name="phone" required minlength="10">
        </div>
<button type="submit" name="submit" class="btn btn-custom"><i class="bi bi-check-circle"></i> Submit </button>
        
      <h3>Arleady have account?<a href="login.html">Login here</a>  </h3>
    </form>     
</div>

<!-- Bootstrap JS (optional for additional features like tooltips) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
