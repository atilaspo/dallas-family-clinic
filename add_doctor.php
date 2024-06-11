<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor - Dallas Family Clinic</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="btn btn-dashboard">Back to Dashboard</a>
        <h1>Add New Doctor</h1>
        <form action="view_doctors.php" method="post">
            <input type="hidden" name="addDoctor" value="1">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" required>
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" required>
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" required>
            <label for="specialty">Specialty:</label>
            <input type="text" name="specialty" required>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="availability">Availability:</label>
            <div id="availability">
                <div>
                    <input type="checkbox" name="days[]" value="Monday"> Monday
                    <select name="start_time_monday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                    to
                    <select name="end_time_monday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <input type="checkbox" name="days[]" value="Tuesday"> Tuesday
                    <select name="start_time_tuesday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                    to
                    <select name="end_time_tuesday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <input type="checkbox" name="days[]" value="Wednesday"> Wednesday
                    <select name="start_time_wednesday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                    to
                    <select name="end_time_wednesday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <input type="checkbox" name="days[]" value="Thursday"> Thursday
                    <select name="start_time_thursday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                    to
                    <select name="end_time_thursday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <input type="checkbox" name="days[]" value="Friday"> Friday
                    <select name="start_time_friday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                    to
                    <select name="end_time_friday">
                        <?php for($i = 9; $i <= 17; $i++): ?>
                            <option value="<?php echo $i; ?>:00"><?php echo $i; ?>:00</option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <input type="submit" value="Add Doctor">
        </form>
    </div>
</body>
</html>
