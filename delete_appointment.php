<?php
require_once 'config.php';

if (isset($_GET['appointmentID'])) {
    $appointmentID = $_GET['appointmentID'];

    $sql = "DELETE FROM Appointments WHERE AppointmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointmentID);
    
    if ($stmt->execute()) {
        header("Location: view_appointments.php");
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
} else {
    header("Location: view_appointments.php");
}
?>
