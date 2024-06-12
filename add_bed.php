<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bedNumber = $_POST['bedNumber'];
    $status = $_POST['status'];
    $patientID = empty($_POST['patientID']) ? NULL : $_POST['patientID'];
    
    $sql = "INSERT INTO Beds (BedNumber, Status, PatientID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $bedNumber, $status, $patientID);
    
    if ($stmt->execute()) {
        header("Location: manage_beds.php");
    } else {
        echo "Error adding bed: " . $conn->error;
    }
}
?>
