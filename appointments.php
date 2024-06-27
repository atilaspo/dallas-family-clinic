<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment - Dallas Family Clinic</title>
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
            <h1>Create Appointment</h1>
            <form action="create_appointment.php" method="post">
                <label for="patient">Select Patient:</label>
                <select name="patient" id="patient">
                    <?php
                    require_once 'config.php';
                    $sql = "SELECT PatientID, FirstName, LastName FROM Patients";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["PatientID"] . "'>" . $row["FirstName"] . " " . $row["LastName"] . "</option>";
                        }
                    }
                    ?>
                </select>

                <label for="doctor">Select Doctor:</label>
                <select name="doctor" id="doctor" onchange="updateAvailability()">
                    <?php
                    $sql = "SELECT DoctorID, FirstName, LastName, Availability FROM Doctors";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["DoctorID"] . "' data-availability='" . $row["Availability"] . "'>" . $row["FirstName"] . " " . $row["LastName"] . " - " . $row["Availability"] . "</option>";
                        }
                    }
                    ?>
                </select>

                <label for="appointmentDate">Appointment Date:</label>
                <input type="date" name="appointmentDate" id="appointmentDate" onchange="updateTimeSlots()" required>

                <label for="appointmentTime">Appointment Time:</label>
                <select name="appointmentTime" id="appointmentTime" required></select>
                
                <label for="details">Details:</label>
                <textarea name="details" id="details"></textarea>

                <label for="isNewPatient">Is New Patient:</label>
                <input type="checkbox" name="isNewPatient" id="isNewPatient">

                <input type="submit" value="Create Appointment">
            </form>
        </div>
    </div>

    <script>
        function updateAvailability() {
            var availability = document.getElementById('doctor').selectedOptions[0].getAttribute('data-availability');
            var availableDays = availability.split(', ').map(function(dayTime) {
                return dayTime.split(': ')[0];
            });
            var appointmentDate = document.getElementById('appointmentDate');
            var currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 1); // Set to tomorrow for demo purposes

            // Reset date input
            appointmentDate.value = '';
            appointmentDate.setAttribute('min', currentDate.toISOString().split('T')[0]);

            var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var disabledDays = dayNames.filter(function(day) {
                return !availableDays.includes(day);
            });

            // Disable unavailable days
            appointmentDate.oninput = function() {
                var selectedDate = new Date(this.value);
                var selectedDay = dayNames[selectedDate.getUTCDay()];
                if (disabledDays.includes(selectedDay)) {
                    alert('The selected doctor is not available on this day.');
                    this.value = '';
                } else {
                    updateTimeSlots();
                }
            };
        }

        function updateTimeSlots() {
            var appointmentDate = document.getElementById('appointmentDate').value;
            var doctor = document.getElementById('doctor');
            var availability = doctor.selectedOptions[0].getAttribute('data-availability');

            var availableTimes = [];
            if (appointmentDate) {
                var selectedDate = new Date(appointmentDate);
                var dayName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][selectedDate.getUTCDay()];
                var availabilityArray = availability.split(', ');

                availabilityArray.forEach(function(item) {
                    var [day, times] = item.split(': ');
                    if (day === dayName) {
                        availableTimes = times.split('-');
                    }
                });
            }

            var appointmentTime = document.getElementById('appointmentTime');
            appointmentTime.innerHTML = '';

            if (availableTimes.length) {
                var [start, end] = availableTimes;
                var startHour = parseInt(start.split(':')[0]);
                var endHour = parseInt(end.split(':')[0]);

                for (var i = startHour; i < endHour; i++) {
                    var timeOption = document.createElement('option');
                    timeOption.value = i + ':00';
                    timeOption.text = i + ':00';
                    appointmentTime.add(timeOption);

                    timeOption = document.createElement('option');
                    timeOption.value = i + ':30';
                    timeOption.text = i + ':30';
                    appointmentTime.add(timeOption);
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateAvailability();
        });
    </script>
</body>
</html>
