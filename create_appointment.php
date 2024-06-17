<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientID = $_POST['patient'];
    $doctorID = $_POST['doctor'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $details = $_POST['details'];
    $isNewPatient = isset($_POST['isNewPatient']) ? 1 : 0;

    $appointmentDateTime = $appointmentDate . ' ' . $appointmentTime;

    $sql = "INSERT INTO Appointments (PatientID, DoctorID, AppointmentDate, Details, IsNewPatient) 
            VALUES ('$patientID', '$doctorID', '$appointmentDateTime', '$details', '$isNewPatient')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_appointments.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
