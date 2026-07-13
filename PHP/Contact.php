<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, 'Library_Management_System');

// Create the Contacts table if it doesn't exist
$CreateTable = "CREATE TABLE IF NOT EXISTS Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50),
    Email VARCHAR(90),
    Message TEXT
    )";
mysqli_query($conn, $CreateTable) or die("Failed to create table");

// Handle form submission
if (isset($_POST['submit'])) {
    $Name = $_POST["Name"];
    $Email = $_POST["Email"];
    $Message = $_POST["Message"];

    // Insert the form data into the Contacts table
    $insert = "INSERT INTO Contacts (Name, Email, Message) VALUES ('$Name', '$Email', '$Message')";

    // Check if the insertion was successful
    if (!mysqli_query($conn, $insert)) {
        die("Error: " . mysqli_error($conn));
    }

    // Redirect the user to the same page to refresh the list of books
    echo "<script>window.location='../Contact.html';</script>"; 
}
