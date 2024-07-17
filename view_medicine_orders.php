<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Medicine Orders - Dallas Family Clinic</title>
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
            <h1>View Medicine Orders</h1>
            <form action="view_medicine_orders.php" method="get" class="search-form">
                <label for="patient">Select Patient:</label>
                <select name="patient" id="patient">
                    <option value="">All Patients</option>
                    <?php
                    require_once 'config.php';
                    $sql = "SELECT PatientID, FirstName, LastName FROM Patients";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $selected = (isset($_GET['patient']) && $_GET['patient'] == $row["PatientID"]) ? "selected" : "";
                        echo "<option value='" . $row["PatientID"] . "' $selected>" . $row["FirstName"] . " " . $row["LastName"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Filter Orders">
                <button type="button" onclick="resetFilter()">Reset</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Doctor Name</th>
                        <th>Medicine Name</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT o.OrderID, d.FirstName AS DoctorFirstName, d.LastName AS DoctorLastName, 
                            m.Name AS MedicineName, o.Quantity, o.OrderDate
                            FROM MedicineOrders o
                            JOIN Doctors d ON o.DoctorID = d.DoctorID
                            JOIN Medicines m ON o.MedicineID = m.MedicineID";
                    
                    if (isset($_GET['patient']) && !empty($_GET['patient'])) {
                        $patientID = $_GET['patient'];
                        $sql .= " WHERE o.PatientID = '$patientID'";
                    }
                    
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["OrderID"] . "</td>
                                <td>" . $row["DoctorFirstName"] . " " . $row["DoctorLastName"] . "</td>
                                <td>" . $row["MedicineName"] . "</td>
                                <td>" . $row["Quantity"] . "</td>
                                <td>" . $row["OrderDate"] . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function resetFilter() {
            window.location.href = 'view_medicine_orders.php';
        }
    </script>
</body>
</html>
