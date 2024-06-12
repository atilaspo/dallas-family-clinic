<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bedID = $_POST['bedID'];
    $bedNumber = $_POST['bedNumber'];
    $status = $_POST['status'];
    $patientID = empty($_POST['patientID']) ? NULL : $_POST['patientID'];
    
    $sql = "UPDATE Beds SET BedNumber = ?, Status = ?, PatientID = ? WHERE BedID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $bedNumber, $status, $patientID, $bedID);
    
    if ($stmt->execute()) {
        header("Location: manage_beds.php");
    } else {
        echo "Error updating bed: " . $conn->error;
    }
}
?>
