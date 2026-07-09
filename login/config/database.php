<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";


// Connect to MySQL server

$conn = new mysqli(
    $host,
    $username,
    $password
);


if($conn->connect_error){

    die("MySQL connection failed");

}


// Create database

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";


if(!$conn->query($sql)){

    die("Database creation failed");

}


// Connect database

$conn = new mysqli(
    $host,
    $username,
    $password,
    $dbname
);


if($conn->connect_error){

    die("Database connection failed");

}



// Create users table

$sql = "

CREATE TABLE IF NOT EXISTS users(

id INT AUTO_INCREMENT PRIMARY KEY,

user_id VARCHAR(4) UNIQUE,

fullname VARCHAR(100) NOT NULL,

email VARCHAR(100) UNIQUE NOT NULL,

phone VARCHAR(15) UNIQUE NOT NULL,

password VARCHAR(255) NOT NULL,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)

";


if(!$conn->query($sql)){

    die("Table creation failed");

}


?>