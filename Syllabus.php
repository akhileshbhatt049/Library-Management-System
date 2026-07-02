<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "Library_Management_System");

// Get selected course and semester from URL
$selected_course = isset($_GET['course']) ? $_GET['course'] : '';
$selected_semester = isset($_GET['semester']) ? $_GET['semester'] : '';

// Get all the courses form the database and stored in a variable named course_result
$course_result = mysqli_query($conn, "SELECT DISTINCT Course_Name FROM ADMIN_SYLLABUS");

// Get the stored semesters for the selected course
$semesters = [];
if ($selected_course) {
  $semester_result = mysqli_query($conn, "SELECT DISTINCT Semester FROM ADMIN_SYLLABUS WHERE Course_Name = '$selected_course' ORDER BY Semester ASC");
  while ($row = mysqli_fetch_assoc($semester_result)) {
    $semesters[] = $row['Semester'];
  }
}

// Fetch PDF for selected course and semester
$pdf_data = null;
if ($selected_course && $selected_semester) {
  $pdf_result = mysqli_query($conn, "SELECT * FROM ADMIN_SYLLABUS WHERE Course_Name = '$selected_course' AND Semester = '$selected_semester'");
  $pdf_data = mysqli_fetch_assoc($pdf_result);
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Syllabus</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="Assets/CSS/Navigation Bar.css">
  <link rel="stylesheet" type="text/css" href="Assets/CSS/Syllabus.css">
</head>

<body>
  <!-- Navigation Bar -->
  <header class="header">
    <div class="Logo-Name">
      <img src="Assets/Images/logo.png" alt="Library Logo">
      <span>Library Management System</span>
    </div>
    <nav class="nav">
      <a href="Index.html" class="nav-link" id="Size">Home</a>
      <a href="BorrowBooks.php" class="nav-link " id="Size">Borrow Books</a>
      <a href="Syllabus.php" class="nav-link active" id="Size">Syllabus</a>
      <a href="RequestBook.html" class="nav-link" id="Size">Request Books</a>
      <a href="Contact.html" class="nav-link" id="Size">Contacts</a>
      <a href="Account.html" class="nav-link" id="Size">Account</a>
      <a href="ADMIN/AdministratorArea.html" class="nav-link" id="Size">Admin</a>
    </nav>
  </header>

  <!-- Body Part -->
  <div class="page-header">
    <h1><i class="fa fa-file-text"></i> Academic Syllabus</h1>
    <p>Select your course and semester to view syllabus</p>
  </div>

  <div class="syllabus-container">
    <?php if (mysqli_num_rows($course_result) > 0): ?> <!-- Checks whether there is more than zero course in database -->

      <!-- Course Buttons -->
      <div class="course-buttons">
        <?php while ($course = mysqli_fetch_assoc($course_result)): // start loop to get all the courses from the database
          $is_active = ($selected_course == $course['Course_Name']); // Check if the current course is the selected course
        ?>
        <!-- When clicked, reloads page with ?course=course_name in URL and convert special characters to HTML entities -->
          <a href="?course=<?php echo urlencode($course['Course_Name']); ?>" class="course-btn <?php echo $is_active ? 'active' : ''; ?>"> 
            <?php echo htmlspecialchars($course['Course_Name']); ?> <!-- Display the course name inside the button -->
          </a>
        <?php endwhile; ?> <!-- End loop -->
      </div>

      <!-- Semester Buttons -->
      <?php if ($selected_course): ?>  <!-- Check if a course is selected -->
        <div class="semester-section">
          <h3><i class="fa fa-graduation-cap"></i> Select Semester</h3>
          <div class="semester-buttons">
            <?php if (!empty($semesters)): ?> <!-- Check if there are semesters available for the selected course -->
              <!-- When clicked, reloads page with ?course=course_name&semester=semester_name in URL and convert special characters to HTML entities -->
              <?php foreach ($semesters as $semester): // Loop through each semester for the selected course
                $is_active = ($selected_semester == $semester); // Check if the current semester is the selected semester
              ?>
              <!-- When clicked, reloads page with ?course=course_name&semester=semester_name in URL and convert special characters to HTML entities -->
                <a href="?course=<?php echo urlencode($selected_course); ?>&semester=<?php echo urlencode($semester); ?>" class="semester-btn <?php echo $is_active ? 'active' : ''; ?>"> 
                  <?php echo htmlspecialchars(ucfirst($semester)); ?> <!-- Display the semester name inside the button -->
                </a>
              <?php endforeach; ?> <!-- End loop -->
            <?php else: ?> <!-- If no semesters are available for the selected course -->
              <p style="color:#94a3b8;">No semesters available for this course.</p>
            <?php endif; ?> <!-- End check for semesters -->
          </div>
        </div>
      <?php endif; ?> <!-- End check for selected course -->

      <!-- PDF Display -->

      <!-- Check if a course and semester are selected and if PDF data is available -->
      <?php if ($selected_course && $selected_semester && $pdf_data): ?> 
        <div class="pdf-section">
          <h3><i class="fa fa-file-pdf-o"></i> Syllabus PDF</h3>
          <div class="pdf-card">
            <div class="pdf-info">
              <i class="fa fa-file-pdf-o"></i>
              <div>
                <div class="file-name">
                  <i class="fa fa-book"></i> <?php echo htmlspecialchars($pdf_data['Course_Name']); ?> <!-- Display the course name from the PDF data -->
                </div>
                <div style="font-size:12px; color:#94a3b8; margin-top:3px;">
                  <i class="fa fa-file"></i> <?php echo basename($pdf_data['Course_PDF']); ?> <!-- Display the PDF file name -->
                </div>
              </div>
            </div>
            <a href="../Library Management System/ADMIN/Admin PHP/<?php echo $pdf_data['Course_PDF']; ?>" target="_blank" class="btn-view"> <!-- connect PDF through URL and open in new tab -->
              <i class="fa fa-eye"></i> View PDF
            </a>
          </div>
        </div>
      <?php elseif ($selected_course && $selected_semester && !$pdf_data): ?> <!-- If no PDF data is available for the selected course and semester -->
        <div class="no-data">
          <p>No PDF available for this semester.</p>
        </div>
      <?php endif; ?> <!-- End check for PDF data -->

    <?php else: ?>
      <div class="no-data">
        <div class="icon"><i class="fa fa-file-text-o"></i></div>
        <h3>No Syllabus Available</h3>
        <p>Please check back later for syllabus updates.</p>
      </div>
    <?php endif; ?> <!-- End check for courses -->
  </div>

</body>

</html>

<?php
mysqli_close($conn); // Close the database connection
?>