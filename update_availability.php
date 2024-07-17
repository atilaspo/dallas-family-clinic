<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorID = $_POST['doctorID'];

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

    $sql = "UPDATE Doctors SET Availability='$availability_str' WHERE DoctorID='$doctorID'";
    if ($conn->query($sql) === TRUE) {
        echo "Availability updated successfully";
    } else {
        echo "Error updating availability: " . $conn->error;
    }

    $conn->close();
    header("Location: view_doctors.php");
    exit();
}
?>
