<?php
require_once 'config.php';

if (isset($_GET['bedID'])) {
    $bedID = $_GET['bedID'];

    $sql = "DELETE FROM Beds WHERE BedID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $bedID);
        if ($stmt->execute()) {
            header("Location: manage_beds.php");
        } else {
            echo "Error deleting bed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No bedID specified";
}
?>
