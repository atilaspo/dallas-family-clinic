<?php
require_once 'config.php';

$users = [
    ['username' => 'admin', 'password' => 'adminpassword', 'role' => 'admin'],
    ['username' => 'doctor1', 'password' => 'doctorpassword', 'role' => 'doctor']
];

foreach ($users as $user) {
    $username = $user['username'];
    $password = password_hash($user['password'], PASSWORD_DEFAULT);
    $role = $user['role'];

    $sql = "INSERT INTO Users (Username, Password, Role) VALUES ('$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "User $username created successfully.<br>";
    } else {
        echo "Error creating user $username: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
