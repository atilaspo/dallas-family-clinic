<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments - Dallas Family Clinic</title>
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
            <h1>View Appointments</h1>
            <form action="doctors_view_appointments.php" method="get" class="search-form">
                <label for="doctor">Filter by Doctor:</label>
                <select name="doctor" id="doctor" required>
                    <option value="">Select Doctor</option>
                    <?php
                    require_once 'config.php';
                    $sql = "SELECT DoctorID, FirstName, LastName FROM Doctors";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['DoctorID'] . "'>" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Filter">
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Appointment Date</th>
                        <th>New Patient</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['doctor']) && !empty($_GET['doctor'])) {
                        $doctorID = $_GET['doctor'];
                        $sql = "SELECT a.AppointmentID, p.FirstName AS PatientFirstName, p.LastName AS PatientLastName, 
                                d.FirstName AS DoctorFirstName, d.LastName AS DoctorLastName, a.AppointmentDate, a.Details, a.IsNewPatient, p.*
                                FROM Appointments a 
                                JOIN Patients p ON a.PatientID = p.PatientID 
                                JOIN Doctors d ON a.DoctorID = d.DoctorID 
                                WHERE a.DoctorID = '$doctorID'";
                    } else {
                        $sql = "SELECT a.AppointmentID, p.FirstName AS PatientFirstName, p.LastName AS PatientLastName, 
                                d.FirstName AS DoctorFirstName, d.LastName AS DoctorLastName, a.AppointmentDate, a.Details, a.IsNewPatient, p.*
                                FROM Appointments a 
                                JOIN Patients p ON a.PatientID = p.PatientID 
                                JOIN Doctors d ON a.DoctorID = d.DoctorID";
                    }
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["AppointmentID"] . "</td>
                                <td>" . $row["PatientFirstName"] . " " . $row["PatientLastName"] . "</td>
                                <td>" . $row["DoctorFirstName"] . " " . $row["DoctorLastName"] . "</td>
                                <td>" . $row["AppointmentDate"] . "</td>
                                <td>" . ($row["IsNewPatient"] ? 'Yes' : 'No') . "</td>
                                <td><button class='btn btn-details' onclick='openDetailsModal(" . json_encode($row) . ")'>Details</button></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No appointments found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Details Modal -->
        <div id="detailsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('detailsModal')">&times;</span>
                <h2>Appointment Details</h2>
                <p><strong>Appointment ID:</strong> <span id="modalAppointmentID"></span></p>
                <p><strong>Patient Name:</strong> <span id="modalPatientName"></span></p>
                <p><strong>Doctor Name:</strong> <span id="modalDoctorName"></span></p>
                <p><strong>Appointment Date:</strong> <span id="modalAppointmentDate"></span></p>
                <p><strong>Details:</strong> <span id="modalDetails"></span></p>
                <p><strong>New Patient:</strong> <span id="modalIsNewPatient"></span></p>
                <h3>Patient Information</h3>
                <p><strong>Phone Number:</strong> <span id="modalPhoneNumber"></span></p>
                <p><strong>Health Number:</strong> <span id="modalHealthNumber"></span></p>
                <p><strong>Postal Code:</strong> <span id="modalPostalCode"></span></p>
                <p><strong>Country:</strong> <span id="modalCountry"></span></p>
                <p><strong>Address:</strong> <span id="modalAddress"></span></p>
                <p><strong>City:</strong> <span id="modalCity"></span></p>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>
</body>
</html>
