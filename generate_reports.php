<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports - Dallas Family Clinic</title>
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
            <h1>Generate Reports</h1>
            <form action="generate_reports.php" method="get" class="report-form">
                <label for="reportType">Select Report Type:</label>
                <select name="reportType" id="reportType" required>
                    <option value="">Select Report</option>
                    <option value="patients">Patients</option>
                    <option value="doctors">Doctors</option>
                    <option value="appointments">Appointments</option>
                    <option value="medicines">Medicines</option>
                    <option value="beds">Beds</option>
                </select>
                <input type="submit" value="Generate Report">
            </form>

            <?php
            if (isset($_GET['reportType']) && !empty($_GET['reportType'])) {
                require_once 'config.php';
                $reportType = $_GET['reportType'];

                switch ($reportType) {
                    case 'patients':
                        $sql = "SELECT * FROM Patients";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<h2>Patients Report</h2>";
                            echo "<table><thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Health Number</th><th>Postal Code</th><th>Country</th><th>Address</th><th>City</th></tr></thead><tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>{$row['PatientID']}</td><td>{$row['FirstName']}</td><td>{$row['LastName']}</td><td>{$row['PhoneNumber']}</td><td>{$row['HealthNumber']}</td><td>{$row['PostalCode']}</td><td>{$row['Country']}</td><td>{$row['Address']}</td><td>{$row['City']}</td></tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p>No patients found.</p>";
                        }
                        break;

                    case 'doctors':
                        $sql = "SELECT * FROM Doctors";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<h2>Doctors Report</h2>";
                            echo "<table><thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Specialty</th><th>Email</th><th>Availability</th></tr></thead><tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>{$row['DoctorID']}</td><td>{$row['FirstName']}</td><td>{$row['LastName']}</td><td>{$row['PhoneNumber']}</td><td>{$row['Specialty']}</td><td>{$row['Email']}</td><td>{$row['Availability']}</td></tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p>No doctors found.</p>";
                        }
                        break;

                    case 'appointments':
                        $sql = "SELECT a.AppointmentID, p.FirstName AS PatientFirstName, p.LastName AS PatientLastName, 
                                d.FirstName AS DoctorFirstName, d.LastName AS DoctorLastName, a.AppointmentDate, a.Details, a.IsNewPatient 
                                FROM Appointments a 
                                JOIN Patients p ON a.PatientID = p.PatientID 
                                JOIN Doctors d ON a.DoctorID = d.DoctorID";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<h2>Appointments Report</h2>";
                            echo "<table><thead><tr><th>ID</th><th>Patient Name</th><th>Doctor Name</th><th>Appointment Date</th><th>Details</th><th>New Patient</th></tr></thead><tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>{$row['AppointmentID']}</td><td>{$row['PatientFirstName']} {$row['PatientLastName']}</td><td>{$row['DoctorFirstName']} {$row['DoctorLastName']}</td><td>{$row['AppointmentDate']}</td><td>{$row['Details']}</td><td>" . ($row['IsNewPatient'] ? 'Yes' : 'No') . "</td></tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p>No appointments found.</p>";
                        }
                        break;

                    case 'medicines':
                        $sql = "SELECT * FROM Medicines";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<h2>Medicines Report</h2>";
                            echo "<table><thead><tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th></tr></thead><tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>{$row['MedicineID']}</td><td>{$row['Name']}</td><td>{$row['Quantity']}</td><td>{$row['Price']}</td></tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p>No medicines found.</p>";
                        }
                        break;

                    case 'beds':
                        $sql = "SELECT b.BedID, b.BedNumber, b.Status, p.FirstName, p.LastName 
                                FROM Beds b 
                                LEFT JOIN Patients p ON b.PatientID = p.PatientID";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<h2>Beds Availability Report</h2>";
                            echo "<table><thead><tr><th>ID</th><th>Bed Number</th><th>Status</th><th>Patient Name</th></tr></thead><tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>{$row['BedID']}</td><td>{$row['BedNumber']}</td><td>{$row['Status']}</td><td>" . ($row['FirstName'] ? "{$row['FirstName']} {$row['LastName']}" : 'N/A') . "</td></tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p>No beds found.</p>";
                        }
                        break;

                    default:
                        echo "<p>Invalid report type selected.</p>";
                        break;
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
