<?php
$conn = mysqli_connect("localhost", "root", "");
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS Library_Management_System");
mysqli_select_db($conn, "Library_Management_System");

mysqli_query($conn, " CREATE TABLE IF NOT EXISTS ADMIN_SYLLABUS(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Course_Name TEXT,
    Semester TEXT,
    Course_PDF TEXT 
)");

if (isset($_POST['Upload_Syllabus'])) {
    $courseName = $_POST['courseName'];
    $Semester = $_POST['Semester'];

    $syllabusFile = "";

    if ($_FILES['syllabusFile']['name'] != "") {
        if (!is_dir("Syllabus_PDF")) {
            mkdir("Syllabus_PDF");
        }

        $syllabusFile = "Syllabus_PDF/" . time() . "_" . $_FILES['syllabusFile']['name'];

        move_uploaded_file(
            $_FILES['syllabusFile']['tmp_name'],
            $syllabusFile
        );
    }
    $sql = "INSERT INTO ADMIN_SYLLABUS
            (Course_Name, Semester, Course_PDF)
            VALUES
            ('$courseName', '$Semester', '$syllabusFile')";

    if (mysqli_query($conn, $sql)) {
        echo "$courseName added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
