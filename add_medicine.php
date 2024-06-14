<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <a href="dashboard_admin.php" class="sidebar-link"><h1>Admin Dashboard</h1></a>
            <a href="view_patients.php" class="sidebar-link">Manage Patients</a>
            <a href="view_doctors.php" class="sidebar-link">Manage Doctors</a>
            <a href="appointments.php" class="sidebar-link">Create an Appointment</a>
            <a href="view_medicines.php" class="sidebar-link">Manage Medicines</a>
            <a href="generate_reports.php" class="sidebar-link">Generate Reports</a>
            <a href="manage_beds.php" class="sidebar-link">Manage Beds</a>
            <a href="logout.php" class="sidebar-link">Logout</a>
        </div>
        <div class="main-content">
            <h1>Add New Medicine</h1>
            <form action="add_medicine.php" method="post">
                <label for="name">Medicine Name:</label>
                <input type="text" name="name" id="name" required>
                
                <label for="manufacturer">Manufacturer:</label>
                <input type="text" name="manufacturer" id="manufacturer">
                
                <label for="expiryDate">Expiry Date:</label>
                <input type="date" name="expiryDate" id="expiryDate">
                
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" required>
                
                <label for="price">Price:</label>
                <input type="text" name="price" id="price" required>
                
                <input type="submit" value="Add Medicine">
            </form>
        </div>
    </div>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once 'config.php';
        
        $name = $_POST['name'];
        $manufacturer = $_POST['manufacturer'];
        $expiryDate = $_POST['expiryDate'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        
        $sql = "INSERT INTO Medicines (Name, Manufacturer, ExpiryDate, Quantity, Price) 
                VALUES ('$name', '$manufacturer', '$expiryDate', '$quantity', '$price')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New medicine added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
    }
    ?>
</body>
</html>
