<?php
$conn = mysqli_connect("localhost", "root", "");

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS Library_Management_System");
mysqli_select_db($conn, "Library_Management_System");

mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS ManageBooksAdmin(
    id INT AUTO_INCREMENT PRIMARY KEY,
    BookTitle VARCHAR(150),
    Author VARCHAR(150),
    ISBN VARCHAR(50),
    Description TEXT,
    CoverImage VARCHAR(255)
)");

if(isset($_POST['submit']))
{
    $bookTitle = $_POST['bookTitle'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $description = $_POST['description'];

    $coverImage = "";

    if($_FILES['coverImage']['name'] != "")
    {
        if(!is_dir("Books_Image"))
        {
            mkdir("Books_Image");
        }

        $coverImage = "Books_Image/" . time() . "_" . $_FILES['coverImage']['name'];

        move_uploaded_file(
            $_FILES['coverImage']['tmp_name'],
            $coverImage
        );
    }

    $sql = "INSERT INTO ManageBooksAdmin
            (BookTitle, Author, ISBN, Description, CoverImage)
            VALUES
            ('$bookTitle', '$author', '$isbn', '$description', '$coverImage')";

    if(mysqli_query($conn, $sql))
    {
        echo "$bookTitle added successfully.";
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}
?>