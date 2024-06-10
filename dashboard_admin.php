<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dallas Family Clinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .main-content {
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .main-content h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .btn-dashboard {
            background-color: #471b98;
            padding: 12.5px 30px;
            border: 0;
            border-radius: 100px;
            color: #ffffff;
            font-weight: bold;
            transition: all 0.5s;
            margin: 10px;
        }

        .btn-dashboard:hover {
            background-color: #7b49d6;
            box-shadow: 0 0 20px #6fc5ff50;
            transform: scale(1.1);
        }

        .btn-dashboard:active {
            background-color: #3d94cf;
            transition: all 0.25s;
            box-shadow: none;
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
        <a href="dashboard_admin.php" class="sidebar-link"><a href="dashboard_admin.php" class="sidebar-link"><h1>Admin Dashboard</h1></a></a>
            <a href="view_patients.php" class="sidebar-link">Manage Patients</a>
            <a href="view_doctors.php" class="sidebar-link">Manage Doctors</a>
            <a href="appointments.php" class="sidebar-link">Create an Appointment</a>
            <a href="view_appointments.php" class="sidebar-link">View Appointments</a>
            <a href="view_medicines.php" class="sidebar-link">Manage Medicines</a>
            <a href="generate_reports.php" class="sidebar-link">Generate Reports</a>
            <a href="manage_beds.php" class="sidebar-link">Manage Beds</a>
            <a href="manage_clinic.php" class="sidebar-link">Manage Clinic</a>
            <a href="logout.php" class="sidebar-link">Logout</a>
        </div>
        <div class="main-content">
            <h1>Welcome, Admin</h1>
            <a href="view_patients.php" class="btn-dashboard">View Patients</a>
            <a href="view_doctors.php" class="btn-dashboard">View Doctors</a>
            <a href="appointments.php" class="btn-dashboard">New Appointment</a>
            <a href="view_medicines.php" class="btn-dashboard">View Medicines</a>
            <a href="generate_reports.php" class="btn-dashboard">Generate Reports</a>
            <a href="manage_clinic.php" class="btn-dashboard">Manage Clinic</a>
            <a href="manage_beds.php" class="btn-dashboard">Manage Beds</a>
        </div>
    </div>
</body>
</html>
