<?php
$conn = mysqli_connect("localhost", "root", "", "Library_Management_System");
$result = mysqli_query($conn, "SELECT * FROM ADMIN_SYLLABUS");

echo "<h2>Database Records:</h2>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
    echo "<hr>";
    
    // Check if file exists
    $file_path = $row['Course_PDF'];
    echo "File path in DB: " . $file_path . "<br>";
    
    // Try different path combinations
    echo "Checking if file exists:<br>";
    echo "1. " . $file_path . " - " . (file_exists($file_path) ? "✅ EXISTS" : "❌ NOT FOUND") . "<br>";
    echo "2. ../" . $file_path . " - " . (file_exists("../" . $file_path) ? "✅ EXISTS" : "❌ NOT FOUND") . "<br>";
    echo "3. ./" . $file_path . " - " . (file_exists("./" . $file_path) ? "✅ EXISTS" : "❌ NOT FOUND") . "<br>";
    echo "<br><br>";
}

mysqli_close($conn);
?>