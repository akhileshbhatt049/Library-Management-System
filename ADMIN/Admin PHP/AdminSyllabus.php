<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "");
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS Library_Management_System");
mysqli_select_db($conn, "Library_Management_System");

// Create the ADMIN_SYLLABUS table if it doesn't exist
mysqli_query($conn, " CREATE TABLE IF NOT EXISTS ADMIN_SYLLABUS(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Course_Name TEXT,
    Semester TEXT,
    Course_PDF TEXT 
)");

// Handle form submission for syllabus upload
if (isset($_POST['Upload_Syllabus'])) {
    $courseName = $_POST['courseName'];
    $Semester = $_POST['Semester'];
    $syllabusFile = "";
    // Check if a file was uploaded by creating a directory and moving the uploaded file to that directory
    if ($_FILES['syllabusFile']['name'] != "") {
        if (!is_dir("Syllabus_PDF")) {
            mkdir("Syllabus_PDF");
        }

        // Move the uploaded file to the Syllabus_PDF directory with a unique name based on the current timestamp
        $syllabusFile = "Syllabus_PDF/" . time() . "_" . $_FILES['syllabusFile']['name'];

        // Move the uploaded file to the specified location
        move_uploaded_file(
            $_FILES['syllabusFile']['tmp_name'],
            $syllabusFile
        );
    }
    // Insert the syllabus information into the ADMIN_SYLLABUS table
    $sql = "INSERT INTO ADMIN_SYLLABUS
            (Course_Name, Semester, Course_PDF)
            VALUES
            ('$courseName', '$Semester', '$syllabusFile')";

    // Check if the insertion was successful and display an appropriate message
    if (mysqli_query($conn, $sql)) {
        echo "$courseName added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
