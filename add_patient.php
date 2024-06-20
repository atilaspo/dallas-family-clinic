<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <a href="dashboard_admin.php" class="btn btn-dashboard">Back to Dashboard</a>
        <h1>Add New Patient</h1>
        <form action="view_patients.php" method="post">
            <input type="hidden" name="addPatient" value="1">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" required>
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" required>
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" required>
            <label for="healthNumber">Health Number:</label>
            <input type="text" name="healthNumber" required>
            <label for="postalCode">Postal Code:</label>
            <input type="text" name="postalCode" required>
            <label for="country">Country:</label>
            <input type="text" name="country" required>
            <label for="address">Address:</label>
            <input type="text" name="address" required>
            <label for="city">City:</label>
            <input type="text" name="city" required>
            <input type="submit" value="Add Patient">
        </form>
    </div>
</body>
</html>
