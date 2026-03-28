<?php 
    $conn = mysqli_connect("localhost","root","") or die ("Failed to connect database");
    $sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
    mysqli_query($conn, $sql) or die("Failed to create database");
    mysqli_select_db($conn, 'Library_Management_System');

    $CreateTable = "CREATE TABLE IF NOT EXISTS Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50),
    Email VARCHAR(90),
    Message TEXT
    )";

    mysqli_query($conn, $CreateTable) or die("Failed to create table");
    if(isset($_POST['submit']))
        {
            $Name = $_POST["Name"];
            $Email = $_POST["Email"];
            $Message = $_POST["Message"];

            $insert = "INSERT INTO Contacts (Name, Email, Message) VALUES ('$Name', '$Email', '$Message')";

    if(!mysqli_query($conn,$insert)){
        die("Error: " . mysqli_error($conn));
    }        echo "Thank you, $Name! Your message has been sucessfully send.";
    }
?>