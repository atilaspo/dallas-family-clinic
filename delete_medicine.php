<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $medicineID = $_GET['id'];
    $sql = "DELETE FROM Medicines WHERE MedicineID='$medicineID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_medicines.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
