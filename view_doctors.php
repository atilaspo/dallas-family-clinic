<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="js/scripts.js"></script>
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
            <h1>Doctors</h1>
            <form action="view_doctors.php" method="get" class="search-form">
                <label for="searchDoctor">Search by Last Name:</label>
                <input type="text" name="searchDoctor" id="searchDoctor" required>
                <input type="submit" value="Search">
                <button type="button" onclick="resetSearch()">Reset</button>
            </form>
            <button onclick="openModal('addDoctorModal')" class="btn btn-add">Add New Doctor</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Specialty</th>
                        <th>Email</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'config.php';

                    // Handle doctor delete operation
                    if (isset($_GET['delete_doctor_id'])) {
                        $delete_id = $_GET['delete_doctor_id'];
                        $sql = "DELETE FROM Doctors WHERE DoctorID='$delete_id'";
                        $conn->query($sql);
                    }

                    // Handle doctor add operation
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addDoctor'])) {
                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $phoneNumber = $_POST['phoneNumber'];
                        $specialty = $_POST['specialty'];
                        $email = $_POST['email'];

                        // Process availability
                        $availability = [];
                        if (isset($_POST['days'])) {
                            $days = $_POST['days'];
                            foreach ($days as $day) {
                                $start_time = $_POST["start_time_" . strtolower($day)];
                                $end_time = $_POST["end_time_" . strtolower($day)];
                                $availability[] = "$day: $start_time-$end_time";
                            }
                        }
                        $availability_str = implode(", ", $availability);

                        $sql = "INSERT INTO Doctors (FirstName, LastName, PhoneNumber, Specialty, Email, Availability)
                                VALUES ('$firstName', '$lastName', '$phoneNumber', '$specialty', '$email', '$availability_str')";
                        $conn->query($sql);
                    }

                    // Handle doctor update operation
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateDoctor'])) {
                        $id = $_POST['doctorID'];
                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $phoneNumber = $_POST['phoneNumber'];
                        $specialty = $_POST['specialty'];
                        $email = $_POST['email'];

                        $sql = "UPDATE Doctors SET FirstName='$firstName', LastName='$lastName', PhoneNumber='$phoneNumber', Specialty='$specialty', Email='$email' WHERE DoctorID='$id'";
                        $conn->query($sql);
                    }

                    // Retrieve doctor data
                    $search_query = "";
                    if (isset($_GET['searchDoctor'])) {
                        $search = $_GET['searchDoctor'];
                        $search_query = "WHERE LastName LIKE '%$search%'";
                    }

                    $sql = "SELECT * FROM Doctors $search_query";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["DoctorID"] . "</td>
                                <td>" . $row["FirstName"] . "</td>
                                <td>" . $row["LastName"] . "</td>
                                <td>" . $row["PhoneNumber"] . "</td>
                                <td>" . $row["Specialty"] . "</td>
                                <td>" . $row["Email"] . "</td>
                                <td>" . $row["Availability"] . "</td>
                                <td>
                                    <button onclick=\"openEditModal('doctor', '" . $row["DoctorID"] . "', '" . $row["FirstName"] . "', '" . $row["LastName"] . "', '" . $row["PhoneNumber"] . "', '" . $row["Specialty"] . "', '" . $row["Email"] . "')\" class='btn btn-edit'>Edit</button>
                                    <button onclick=\"openAvailabilityModal('" . $row["DoctorID"] . "', '" . addslashes($row["Availability"]) . "')\" class='btn btn-availability'>Edit Availability</button>
                                    <a href='view_doctors.php?delete_doctor_id=" . $row["DoctorID"] . "' class='btn btn-delete'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No doctors found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Doctor Modal -->
    <div id="addDoctorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addDoctorModal')">&times;</span>
            <h2>Add New Doctor</h2>
            <form action="view_doctors.php" method="post">
                <input type="hidden" name="addDoctor" value="1">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" required>
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" required>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" required>
                <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" required>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="availability">Availability:</label>
                <div id="availability">
                    <div>
                        <input type="checkbox" name="days[]" value="Monday"> Monday
                        <select name="start_time_monday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_monday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday
                        <select name="start_time_tuesday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_tuesday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday
                        <select name="start_time_wednesday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_wednesday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox" name="days[]" value="Thursday"> Thursday
                        <select name="start_time_thursday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_thursday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox" name="days[]" value="Friday"> Friday
                        <select name="start_time_friday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_friday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <input type="submit" value="Add Doctor">
            </form>
        </div>
    </div>

    <!-- Edit Doctor Modal -->
    <div id="editDoctorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editDoctorModal')">&times;</span>
            <h2>Edit Doctor</h2>
            <form action="view_doctors.php" method="post">
                <input type="hidden" name="updateDoctor" value="1">
                <input type="hidden" name="doctorID" id="editDoctorID">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" id="editDoctorFirstName" required>
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" id="editDoctorLastName" required>
                <label for="phoneNumber">Phone Number:</label>
                <input type="text" name="phoneNumber" id="editDoctorPhoneNumber" required>
                <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" id="editDoctorSpecialty" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="editDoctorEmail" required>
                <input type="submit" value="Update Doctor">
            </form>
        </div>
    </div>

    <!-- Edit Availability Modal -->
    <div id="editAvailabilityModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editAvailabilityModal')">&times;</span>
            <h2>Edit Availability</h2>
            <form id="editAvailabilityForm" action="update_availability.php" method="post">
                <input type="hidden" name="doctorID" id="availabilityDoctorID">
                <div id="availability">
                    <div>
                        <input type="checkbox" name="days[]" value="Monday"> Monday
                        <select name="start_time_monday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_monday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday
                        <select name="start_time_tuesday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_tuesday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday
                        <select name="start_time_wednesday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_wednesday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox" name="days[]" value="Thursday"> Thursday
                        <select name="start_time_thursday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_thursday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox" name="days[]" value="Friday"> Friday
                        <select name="start_time_friday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                        to
                        <select name="end_time_friday">
                            <?php for($i = 9; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <input type="submit" value="Update Availability">
            </form>
        </div>
    </div>

    <script src="js/scripts.js"></script>
    <script>
        function resetSearch() {
            window.location.href = 'view_doctors.php';
        }

        function openAvailabilityModal(doctorID, availability) {
            document.getElementById('availabilityDoctorID').value = doctorID;
            // Parse the availability string and pre-check the relevant checkboxes and select options
            const availabilityArray = availability.split(', ');
            availabilityArray.forEach(function(item) {
                const [day, times] = item.split(': ');
                const [start, end] = times.split('-');
                document.querySelector(`input[value="${day}"]`).checked = true;
                document.querySelector(`select[name="start_time_${day.toLowerCase()}"]`).value = start;
                document.querySelector(`select[name="end_time_${day.toLowerCase()}"]`).value = end;
            });
            openModal('editAvailabilityModal');
        }
    </script>
</body>
</html>
