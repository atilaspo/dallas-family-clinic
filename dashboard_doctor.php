<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h1>Doctor Dashboard</h1>
            <a href="doctors_view_appointments.php" class="sidebar-link">View Appointments</a>
            <a href="order_medicine.php" class="sidebar-link">Order Medicine</a>
            <a href="view_medicine_orders.php" class="sidebar-link">View Medicine Orders</a>
            <a href="logout.php" class="sidebar-link">Logout</a>
        </div>
        <div class="main-content">
            <h1>Welcome, Doctor</h1>
        </div>
    </div>
</body>
</html>
