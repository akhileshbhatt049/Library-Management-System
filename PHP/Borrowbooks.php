<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Create the BorrowBook table if it doesn't exist
$CreateTable = "CREATE TABLE IF NOT EXISTS BorrowBook (
        id INT AUTO_INCREMENT PRIMARY KEY,
        BookName VARCHAR(150),
        Author VARCHAR(150),
        ISBN VARCHAR(50),
        Name VARCHAR(150),
        StudentID VARCHAR(50),
        Email varchar(70),
        phone VARCHAR(10),
        ReturnDate TEXT,
        Status VARCHAR(20) DEFAULT 'Pending',
        RejectReason TEXT NULL
    )";
mysqli_query($conn, $CreateTable) or die("Failed to create table");

// Handle form submission
if (isset($_POST['submit'])) {
    $BookName = $_POST["BookName"];
    $Author = $_POST["Author"];
    $ISBN = $_POST["ISBN"];
    $Name = $_POST["Name"];
    $StudentID = $_POST['StudentID'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $ReturnDate = $_POST['ReturnDate'];

    // Insert the form data into the BorrowBook table
    $insert = "INSERT INTO BorrowBook (BookName, Author, ISBN, Name, StudentID, Email, phone, ReturnDate, Status) 
                   VALUES ('$BookName', '$Author', '$ISBN', '$Name', '$StudentID', '$Email', '$Phone', '$ReturnDate', 'Pending')";

    // Check if the insertion was successful or not and display appropriate message
    if (mysqli_query($conn, $insert)) {
        // Redirect the user to the same page to refresh the list of books
        echo "<script>window.location='../BorrowBooks.html';</script>";    
     } else {
        die("Error: " . mysqli_error($conn));
    }
}
