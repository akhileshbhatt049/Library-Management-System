<?php 
$conn = mysqli_connect("localhost","root","") or die("Connection failed");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die ("Failed to create database");
mysqli_select_db($conn, 'Library_Management_System');

$CreateTable = "CREATE TABLE IF NOT EXISTS Request_Book (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50),
    Email VARCHAR(90),
    BookTitle VARCHAR(90),
    Author VARCHAR(100),
    Reason TEXT
)";
mysqli_query($conn, $CreateTable) or die("Failed to create table");
if(isset($_POST['submit']))
    {
        $Name = $_POST["Name"];
        $Email = $_POST["Email"];
        $BookTitle = $_POST["BookTitle"];
        $Author = $_POST["Author"];
        $Reason = $_POST["Reason"];

        $insert = "INSERT INTO Request_Book (Name, Email, BookTitle, Author, Reason) VALUES ('$Name', '$Email', '$BookTitle', '$Author', '$Reason')";

if(!mysqli_query($conn,$insert)){
    die("Error: " . mysqli_error($conn));
}        echo "Thank you, $Name! Your message has been sucessfully send.";
    }
?>