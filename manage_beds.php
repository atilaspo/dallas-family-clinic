<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Beds - Dallas Family Clinic</title>
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
            <h1>Manage Beds</h1>
            <button class='btn' onclick='openModal("addBedModal")'>Add Bed</button>
            <table>
                <thead>
                    <tr>
                        <th>Bed ID</th>
                        <th>Bed Number</th>
                        <th>Status</th>
                        <th>Patient Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'config.php';
                    $sql = "SELECT b.BedID, b.BedNumber, b.Status, p.FirstName, p.LastName 
                            FROM Beds b 
                            LEFT JOIN Patients p ON b.PatientID = p.PatientID";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['BedID']}</td>
                                <td>{$row['BedNumber']}</td>
                                <td>{$row['Status']}</td>
                                <td>" . ($row['FirstName'] ? "{$row['FirstName']} {$row['LastName']}" : 'N/A') . "</td>
                                <td>
                                    <button class='btn' onclick='editBed({$row['BedID']}, \"{$row['Status']}\", \"{$row['BedNumber']}\")'>Edit</button>
                                    <button class='btn btn-delete' onclick='deleteBed({$row['BedID']})'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No beds found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Add Bed Modal -->
        <div id="addBedModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addBedModal')">&times;</span>
                <h2>Add Bed</h2>
                <form action="add_bed.php" method="post">
                    <label for="addBedNumber">Bed Number:</label>
                    <input type="text" name="bedNumber" id="addBedNumber" required>
                    <label for="addStatus">Status:</label>
                    <select name="status" id="addStatus" required>
                        <option value="Available">Available</option>
                        <option value="Occupied">Occupied</option>
                    </select>
                    <label for="addPatient">Assign to Patient (optional):</label>
                    <select name="patientID" id="addPatient">
                        <option value="">None</option>
                        <?php
                        $patientSql = "SELECT PatientID, FirstName, LastName FROM Patients";
                        $patientResult = $conn->query($patientSql);
                        while ($patientRow = $patientResult->fetch_assoc()) {
                            echo "<option value='{$patientRow['PatientID']}'>{$patientRow['FirstName']} {$patientRow['LastName']}</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Add Bed">
                </form>
            </div>
        </div>

        <!-- Edit Bed Modal -->
        <div id="editBedModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editBedModal')">&times;</span>
                <h2>Edit Bed</h2>
                <form action="update_bed.php" method="post">
                    <input type="hidden" name="bedID" id="editBedID">
                    <label for="editBedNumber">Bed Number:</label>
                    <input type="text" name="bedNumber" id="editBedNumber" required>
                    <label for="editStatus">Status:</label>
                    <select name="status" id="editStatus" required>
                        <option value="Available">Available</option>
                        <option value="Occupied">Occupied</option>
                    </select>
                    <label for="editPatient">Assign to Patient (optional):</label>
                    <select name="patientID" id="editPatient">
                        <option value="">None</option>
                        <?php
                        $patientSql = "SELECT PatientID, FirstName, LastName FROM Patients";
                        $patientResult = $conn->query($patientSql);
                        while ($patientRow = $patientResult->fetch_assoc()) {
                            echo "<option value='{$patientRow['PatientID']}'>{$patientRow['FirstName']} {$patientRow['LastName']}</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Update Bed">
                </form>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>
</body>
</html>
