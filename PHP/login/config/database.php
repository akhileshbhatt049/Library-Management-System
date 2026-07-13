<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Create Accounts table if not exists
$createTable = "CREATE TABLE IF NOT EXISTS Accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(10) UNIQUE,
    fullname VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20) UNIQUE,
    password VARCHAR(255)
)";
mysqli_query($conn, $createTable) or die("Failed to create Accounts table: " . mysqli_error($conn));

// Check if table was created successfully
$check = mysqli_query($conn, "SHOW TABLES LIKE 'Accounts'");
if(mysqli_num_rows($check) == 0) {
    die("Accounts table was not created. Please check your database permissions.");
}
?>