<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="js/scripts.js"></script>
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
            <a href="logout.php" class="sidebar-link">Logout</a>
        </div>
        <div class="main-content">
            <h1>Patients</h1>
            <form action="view_patients.php" method="get" class="search-form">
                <label for="searchPatient">Search by Last Name:</label>
                <input type="text" name="searchPatient" id="searchPatient" required>
                <input type="submit" value="Search">
                <button type="button" onclick="resetSearch()">Reset</button>
            </form>
            <button onclick="openModal('addPatientModal')" class="btn btn-add">Add New Patient</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Health Number</th>
                        <th>Postal Code</th>
                        <th>Country</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'config.php';

                    include 'session_check.php';
                    if ($user_role !== 'admin') {
                        header("Location: unauthorized.php");
                        exit();
                    }

                    // Handle patient delete operation
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletePatient'])) {
                        $delete_id = $_POST['delete_patient_id'];
                        $sql = "DELETE FROM Patients WHERE PatientID='$delete_id'";
                        $conn->query($sql);
                    }

                    // Handle patient add operation
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addPatient'])) {
                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $phoneNumber = $_POST['phoneNumber'];
                        $healthNumber = $_POST['healthNumber'];
                        $postalCode = $_POST['postalCode'];
                        $country = $_POST['country'];
                        $address = $_POST['address'];
                        $city = $_POST['city'];

                        $sql = "INSERT INTO Patients (FirstName, LastName, PhoneNumber, HealthNumber, PostalCode, Country, Address, City)
                                VALUES ('$firstName', '$lastName', '$phoneNumber', '$healthNumber', '$postalCode', '$country', '$address', '$city')";
                        $conn->query($sql);
                    }

                    // Handle patient update operation
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatePatient'])) {
                        $id = $_POST['patientID'];
                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $phoneNumber = $_POST['phoneNumber'];
                        $healthNumber = $_POST['healthNumber'];
                        $postalCode = $_POST['postalCode'];
                        $country = $_POST['country'];
                        $address = $_POST['address'];
                        $city = $_POST['city'];

                        $sql = "UPDATE Patients SET FirstName='$firstName', LastName='$lastName', PhoneNumber='$phoneNumber', HealthNumber='$healthNumber', PostalCode='$postalCode', Country='$country', Address='$address', City='$city' WHERE PatientID='$id'";
                        $conn->query($sql);
                    }

                    // Retrieve patient data
                    $search_query = "";
                    if (isset($_GET['searchPatient'])) {
                        $search = $_GET['searchPatient'];
                        $search_query = "WHERE LastName LIKE '%$search%'";
                    }

                    $sql = "SELECT * FROM Patients $search_query";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["PatientID"] . "</td>
                                <td>" . $row["FirstName"] . "</td>
                                <td>" . $row["LastName"] . "</td>
                                <td>" . $row["PhoneNumber"] . "</td>
                                <td>" . $row["HealthNumber"] . "</td>
                                <td>" . $row["PostalCode"] . "</td>
                                <td>" . $row["Country"] . "</td>
                                <td>" . $row["Address"] . "</td>
                                <td>" . $row["City"] . "</td>
                                <td>
                                    <button onclick=\"openEditModal('patient', '" . $row["PatientID"] . "', '" . $row["FirstName"] . "', '" . $row["LastName"] . "', '" . $row["PhoneNumber"] . "', '" . $row["HealthNumber"] . "', '" . $row["PostalCode"] . "', '" . $row["Country"] . "', '" . $row["Address"] . "', '" . $row["City"] . "')\" class='btn btn-edit'>Edit</button>
                                    <form action='view_patients.php' method='post' style='display:inline-block;'>
                                        <input type='hidden' name='delete_patient_id' value='" . $row["PatientID"] . "'>
                                        <input type='hidden' name='deletePatient' value='1'>
                                        <button type='submit' class='btn btn-delete'>Delete</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No patients found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Patient Modal -->
    <div id="addPatientModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addPatientModal')">&times;</span>
            <h2>Add New Patient</h2>
            <form action="view_patients.php" method="post">
                <input type="hidden" name="addPatient" value="1">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" required>
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" required>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" required>
                <label for="healthNumber">Health Number:</label>
                <input type="text" name="healthNumber" required>
                <label for="postalCode">Postal Code:</label>
                <input type="text" name="postalCode" required>
                <label for="country">Country:</label>
                <input type="text" name="country" required>
                <label for="address">Address:</label>
                <input type="text" name="address" required>
                <label for="city">City:</label>
                <input type="text" name="city" required>
                <input type="submit" value="Add Patient">
            </form>
        </div>
    </div>

    <!-- Edit Patient Modal -->
    <div id="editPatientModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editPatientModal')">&times;</span>
            <h2>Edit Patient</h2>
            <form action="view_patients.php" method="post">
                <input type="hidden" name="updatePatient" value="1">
                <input type="hidden" name="patientID" id="editPatientID">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" id="editFirstName" required>
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" id="editLastName" required>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" id="editPhoneNumber" required>
                <label for="healthNumber">Health Number:</label>
                <input type="text" name="healthNumber" id="editHealthNumber" required>
                <label for="postalCode">Postal Code:</label>
                <input type="text" name="postalCode" id="editPostalCode" required>
                <label for="country">Country:</label>
                <input type="text" name="country" id="editCountry" required>
                <label for="address">Address:</label>
                <input type="text" name="address" id="editAddress" required>
                <label for="city">City:</label>
                <input type="text" name="city" id="editCity" required>
                <input type="submit" value="Update Patient">
            </form>
        </div>
    </div>

    <script src="js/scripts.js"></script>
    <script>
        function resetSearch() {
            window.location.href = 'view_patients.php';
        }
    </script>
</body>
</html>
