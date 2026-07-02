<?php
    $conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
    $sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
    mysqli_query($conn, $sql) or die("Failed to create database");
    mysqli_select_db($conn, "Library_Management_System");

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
    
    if(isset($_POST['submit'])) {
        $BookName = $_POST["BookName"];
        $Author = $_POST["Author"];
        $ISBN = $_POST["ISBN"];
        $Name = $_POST["Name"];
        $StudentID = $_POST['StudentID'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $ReturnDate = $_POST['ReturnDate'];

        $insert = "INSERT INTO BorrowBook (BookName, Author, ISBN, Name, StudentID, Email, phone, ReturnDate, Status) 
                   VALUES ('$BookName', '$Author', '$ISBN', '$Name', '$StudentID', '$Email', '$Phone', '$ReturnDate', 'Pending')";

        if(mysqli_query($conn, $insert)) {
            echo "$Name! $BookName borrow request has been submitted.";
        } 
        else {
            die("Error: ". mysqli_error($conn));
        }
    }
?>