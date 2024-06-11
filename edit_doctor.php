<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="btn btn-dashboard">Back to Dashboard</a>
        <h1>Edit Doctor</h1>
        <form action="view_doctors.php" method="post">
            <input type="hidden" name="updateDoctor" value="1">
            <input type="hidden" name="doctorID" id="editDoctorID">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" id="editDoctorFirstName" required>
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" id="editDoctorLastName" required>
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" id="editDoctorPhoneNumber" required>
            <label for="specialty">Specialty:</label>
            <input type="text" name="specialty" id="editDoctorSpecialty" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="editDoctorEmail" required>
            <input type="submit" value="Update Doctor">
        </form>
    </div>
</body>
</html>
