<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Create Request_Book table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS Request_Book (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Email VARCHAR(100),
    BookTitle VARCHAR(200),
    Author VARCHAR(100),
    Reason TEXT,
    Status VARCHAR(50) DEFAULT 'Pending',
    RejectReason TEXT
)";
mysqli_query($conn, $createTable) or die("Failed to create table: " . mysqli_error($conn));

// Handle form submission
$message = "";
$message_type = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['Name']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $bookTitle = mysqli_real_escape_string($conn, $_POST['BookTitle']);
    $author = mysqli_real_escape_string($conn, $_POST['Author']);
    $reason = mysqli_real_escape_string($conn, $_POST['Reason']);
    
    if (empty($name) || empty($email) || empty($bookTitle) || empty($author) || empty($reason)) {
        $message = "All fields are required!";
        $message_type = "error";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO Request_Book (Name, Email, BookTitle, Author, Reason) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $bookTitle, $author, $reason);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Book request submitted successfully!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);

// Redirect back to RequestBook.html with message
header("Location: ../RequestBook.html?message=" . urlencode($message) . "&type=" . $message_type);
exit();
?>