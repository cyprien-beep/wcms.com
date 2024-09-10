<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboards</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Waste Collection Monitoring System</h1>
        <nav>
            <ul>
                <li><a href="#" onclick="showDashboard('waste_owner')">Waste Owner Dashboard</a></li>
                <li><a href="#" onclick="showDashboard('waste_collector')">Waste Collector Dashboard</a></li>
                <li><a href="#" onclick="showDashboard('admin')">Admin Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <main id="dashboard-content">
        <!-- Waste Owner Dashboard -->
        <section id="waste_owner" class="dashboard hidden">
            <h2>Waste Owner Dashboard</h2>
            <p>Welcome, Waste Owner! Here is your dashboard.</p>
            <!-- Add specific features and data for the Waste Owner -->
        </section>

        <!-- Waste Collector Dashboard -->
        <section id="waste_collector" class="dashboard hidden">
            <h2>Waste Collector Dashboard</h2>
            <p>Welcome, Waste Collector! Here is your dashboard.
            pppp</p>
            <!-- Add specific features and data for the Waste Collector -->
        </section>

        <!-- Admin Dashboard -->
        <section id="admin" class="dashboard hidden">
            <h2>Admin Dashboard</h2>
            <p>Welcome, Admin! Here is your dashboard.</p>
            <!-- Add specific features and data for the Admin -->
            
            <footer>follow us on  facebook users</footer>
        </section>
    </main>

    <script src="script.js"></script>
    <footer>follow us on  facebook</footer>
</body>
</html>
