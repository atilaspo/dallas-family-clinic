<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Medicine - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h1>Doctor Dashboard</h1>
            <a href="doctors_view_appointments.php" class="sidebar-link">View Appointments</a>
            <a href="order_medicine.php" class="sidebar-link">Order Medicine</a>
            <a href="view_medicine_orders.php" class="sidebar-link">View Medicine Orders</a>
            <a href="logout.php" class="sidebar-link">Logout</a>
        </div>
        <div class="main-content">
            <h1>Order Medicine</h1>
            <form action="order_medicine.php" method="post">
                <label for="patient">Select Patient:</label>
                <select name="patient" id="patient" required>
                    <?php
                    require_once 'config.php';
                    $sql = "SELECT PatientID, FirstName, LastName FROM Patients";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["PatientID"] . "'>" . $row["FirstName"] . " " . $row["LastName"] . "</option>";
                    }
                    ?>
                </select>
                
                <label for="doctor">Select Doctor:</label>
                <select name="doctor" id="doctor" required>
                    <?php
                    $sql = "SELECT DoctorID, FirstName, LastName FROM Doctors";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["DoctorID"] . "'>" . $row["FirstName"] . " " . $row["LastName"] . "</option>";
                    }
                    ?>
                </select>
                
                <label for="medicine">Select Medicine:</label>
                <select name="medicine" id="medicine" required>
                    <?php
                    $sql = "SELECT MedicineID, Name FROM Medicines";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["MedicineID"] . "'>" . $row["Name"] . "</option>";
                    }
                    ?>
                </select>
                
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" required>
                <input type="submit" value="Order Medicine">
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $patientID = $_POST['patient'];
                $doctorID = $_POST['doctor'];
                $medicineID = $_POST['medicine'];
                $quantity = $_POST['quantity'];

                $sql = "INSERT INTO MedicineOrders (PatientID, DoctorID, MedicineID, Quantity, OrderDate) VALUES (?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iiii", $patientID, $doctorID, $medicineID, $quantity);

                if ($stmt->execute()) {
                    $orderID = $stmt->insert_id; // Obtener el ID de la orden recién insertada
                    echo "<p>Medicine ordered successfully.</p>";
                    echo "<a href='print_medicine_order.php?order_id=$orderID' target='_blank'>Print Order</a>";
                } else {
                    echo "<p>Error ordering medicine: " . $conn->error . "</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
