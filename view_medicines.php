<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Medicines - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <a href="dashboard_admin.php" class="sidebar-link"><h1>Admin Dashboard</h1></a>
            <a href="view_patients.php" class="sidebar-link">Manage Patients</a>
            <a href="view_doctors.php" class="sidebar-link">Manage Doctors</a>
            <a href="appointments.php" class="sidebar-link">Create an Appointment</a>
            <a href="view_appointments.php" class="sidebar-link">View Appointments</a>
            <a href="view_medicines.php" class="sidebar-link">Manage Medicines</a>
            <a href="generate_reports.php" class="sidebar-link">Generate Reports</a>
            <a href="manage_beds.php" class="sidebar-link">Manage Beds</a>
            <a href="logout.php" class="sidebar-link">Logout</a>
        </div>
        <div class="main-content">
            <h1>View Medicines</h1>
            <a href="add_medicine.php" class="btn btn-add">Add New Medicine</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Manufacturer</th>
                        <th>Expiry Date</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'config.php';
                    $sql = "SELECT * FROM Medicines";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["MedicineID"] . "</td>
                                <td>" . $row["Name"] . "</td>
                                <td>" . $row["Manufacturer"] . "</td>
                                <td>" . $row["ExpiryDate"] . "</td>
                                <td>" . $row["Quantity"] . "</td>
                                <td>" . $row["Price"] . "</td>
                                <td>
                                    <a href='edit_medicine.php?id=" . $row["MedicineID"] . "' class='btn btn-edit'>Edit</a>
                                    <a href='delete_medicine.php?id=" . $row["MedicineID"] . "' class='btn btn-delete'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No medicines found</td></tr>";
                    }
                    
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
