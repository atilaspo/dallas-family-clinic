<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicineID = $_POST['medicineID'];
    $name = $_POST['name'];
    $manufacturer = $_POST['manufacturer'];
    $expiryDate = $_POST['expiryDate'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "UPDATE Medicines 
            SET Name='$name', Manufacturer='$manufacturer', ExpiryDate='$expiryDate', Quantity='$quantity', Price='$price'
            WHERE MedicineID='$medicineID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_medicines.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $medicineID = $_GET['id'];
    $sql = "SELECT * FROM Medicines WHERE MedicineID='$medicineID'";
    $result = $conn->query($sql);
    $medicine = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medicine - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <a href="view_medicines.php" class="btn btn-dashboard">Back to Dashboard</a>
        <h1>Edit Medicine</h1>
        <form action="edit_medicine.php" method="post">
            <input type="hidden" name="medicineID" value="<?php echo $medicine['MedicineID']; ?>">
            
            <label for="name">Medicine Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $medicine['Name']; ?>" required>
            
            <label for="manufacturer">Manufacturer:</label>
            <input type="text" name="manufacturer" id="manufacturer" value="<?php echo $medicine['Manufacturer']; ?>">
            
            <label for="expiryDate">Expiry Date:</label>
            <input type="date" name="expiryDate" id="expiryDate" value="<?php echo $medicine['ExpiryDate']; ?>">
            
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo $medicine['Quantity']; ?>" required>
            
            <label for="price">Price:</label>
            <input type="text" name="price" id="price" value="<?php echo $medicine['Price']; ?>" required>
            
            <input type="submit" value="Update Medicine">
        </form>
    </div>
</body>
</html>
