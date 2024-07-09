<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clinic Information - Dallas Family Clinic</title>
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
            <a href="manage_clinic.php" class="sidebar-link">Manage Clinic</a>
            <a href="logout.php" class="sidebar-link">Logout</a>
        </div>
        <div class="main-content">
            <h1>Manage Clinic Information</h1>
            <?php
            require_once 'config.php';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $address = $_POST['address'];
                $contactNumber = $_POST['contactNumber'];
                $openingHours = $_POST['openingHours'];

                $sql = "UPDATE ClinicInfo SET Name=?, Address=?, ContactNumber=?, OpeningHours=? WHERE ClinicID=1";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }

                $stmt->bind_param("ssss", $name, $address, $contactNumber, $openingHours);

                if ($stmt->execute()) {
                    echo "<p>Clinic information updated successfully.</p>";
                } else {
                    echo "<p>Error updating clinic information: " . htmlspecialchars($stmt->error) . "</p>";
                }

                $stmt->close();
            }

            $sql = "SELECT * FROM ClinicInfo WHERE ClinicID=1";
            $result = $conn->query($sql);
            if ($result === false) {
                die('Query failed: ' . htmlspecialchars($conn->error));
            }
            $clinic = $result->fetch_assoc();
            if (!$clinic) {
                die('No clinic information found.');
            }
            ?>
            <form action="manage_clinic.php" method="post">
                <label for="name">Clinic Name:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($clinic['Name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($clinic['Address'], ENT_QUOTES, 'UTF-8'); ?>" required>
                <label for="contactNumber">Contact Number:</label>
                <input type="text" name="contactNumber" id="contactNumber" value="<?php echo htmlspecialchars($clinic['ContactNumber'], ENT_QUOTES, 'UTF-8'); ?>" required>
                <label for="openingHours">Opening Hours:</label>
                <textarea name="openingHours" id="openingHours" required><?php echo htmlspecialchars($clinic['OpeningHours'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                <input type="submit" value="Update Clinic Information">
            </form>
        </div>
    </div>
</body>
</html>
