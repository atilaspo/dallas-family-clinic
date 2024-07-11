<?php
require_once 'config.php';

if (isset($_GET['order_id'])) {
    $orderID = $_GET['order_id'];
    $sql = "SELECT o.OrderID, p.FirstName AS PatientFirstName, p.LastName AS PatientLastName, 
            d.FirstName AS DoctorFirstName, d.LastName AS DoctorLastName,
            m.Name AS MedicineName, o.Quantity, o.OrderDate
            FROM MedicineOrders o
            JOIN Patients p ON o.PatientID = p.PatientID
            JOIN Doctors d ON o.DoctorID = d.DoctorID
            JOIN Medicines m ON o.MedicineID = m.MedicineID
            WHERE o.OrderID = '$orderID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        die("Order not found.");
    }
} else {
    die("No order ID specified.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Medicine Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
        }
        .signature {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Medicine Order</h1>
        <p><strong>Order ID:</strong> <?php echo $order['OrderID']; ?></p>
        <p><strong>Patient Name:</strong> <?php echo $order['PatientFirstName'] . ' ' . $order['PatientLastName']; ?></p>
        <p><strong>Doctor Name:</strong> <?php echo $order['DoctorFirstName'] . ' ' . $order['DoctorLastName']; ?></p>
        <p><strong>Medicine Name:</strong> <?php echo $order['MedicineName']; ?></p>
        <p><strong>Quantity:</strong> <?php echo $order['Quantity']; ?></p>
        <p><strong>Order Date:</strong> <?php echo $order['OrderDate']; ?></p>

        <div class="signature">
            <p>__________________________________</p>
            <p>Doctor's Signature</p>
        </div>
    </div>
</body>
</html>
