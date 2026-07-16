<?php
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect");
mysqli_select_db($conn, "Library_Management_System");

// Admin details
$user_id = "ADMIN001";
$fullname = "Admin";
$email = "admin@example.com";
$phone = "9702617996";
$password = password_hash("Admin@123", PASSWORD_DEFAULT);
$is_admin = 1;

// Insert admin
$stmt = mysqli_prepare($conn, "INSERT INTO Accounts (user_id, fullname, email, phone, password, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssssi", $user_id, $fullname, $email, $phone, $password, $is_admin);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin account created successfully!<br>";
    echo "Email: admin@example.com<br>";
    echo "Password: Admin@123";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
