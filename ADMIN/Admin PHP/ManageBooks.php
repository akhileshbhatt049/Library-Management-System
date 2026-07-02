<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "");
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS Library_Management_System");
mysqli_select_db($conn, "Library_Management_System");

// Create the ManageBooksAdmin table if it doesn't exist
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS ManageBooksAdmin(
    id INT AUTO_INCREMENT PRIMARY KEY,
    BookTitle VARCHAR(150),
    Author VARCHAR(150),
    ISBN VARCHAR(50)
)");

// Handle form submission for adding a book
if (isset($_POST['submit'])) {
    $bookTitle = $_POST['bookTitle'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];

    // Insert the book information into the ManageBooksAdmin table
    $sql = "INSERT INTO ManageBooksAdmin
            (BookTitle, Author, ISBN)
            VALUES
            ('$bookTitle', '$author', '$isbn')";

    // Check if the insertion was successful and redirect to the manage books page with a success or error message
    if (mysqli_query($conn, $sql)) {
        header("Location: ../Admin_ManageBooks.php?success=1");
        exit();
    } else {
        header("Location: ../Admin_ManageBooks.php?success=0");
        exit();
    }
}
