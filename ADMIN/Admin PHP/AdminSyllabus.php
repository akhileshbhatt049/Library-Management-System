<?php 
$conn = mysqli_connect("localhost","root","");
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS Library_Management_System");
mysqli_select_db($conn, "Library_Management_System");

// ✅ FIXED: Changed table name to match INSERT
mysqli_query($conn, " CREATE TABLE IF NOT EXISTS ADMIN_SYLLABUS(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Course_Name TEXT,
    Course_PDF TEXT 
)");

if(isset($_POST['Upload_Syllabus'])) {
    $courseName = $_POST['courseName'];

    $syllabusFile = "";

    if($_FILES['syllabusFile']['name'] != "")
    {
        if(!is_dir("Syllabus_PDF"))
        {
            mkdir("Syllabus_PDF");
        }

        $syllabusFile = "Syllabus_PDF/" . time() . "_" . $_FILES['syllabusFile']['name'];

        move_uploaded_file(
            $_FILES['syllabusFile']['tmp_name'],
            $syllabusFile
        );
    }

    // ✅ FIXED: Changed table name to match CREATE TABLE
    $sql = "INSERT INTO ADMIN_SYLLABUS
            (Course_Name, Course_PDF)
            VALUES
            ('$courseName', '$syllabusFile')";

    if(mysqli_query($conn, $sql))
    {
        echo "$courseName added successfully.";
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}
?>