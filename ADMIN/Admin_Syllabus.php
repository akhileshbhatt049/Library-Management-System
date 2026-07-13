  <!-- PHP Code to delete data form database -->
  <?php
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
  $sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
  mysqli_query($conn, $sql) or die("Failed to create database");
  mysqli_select_db($conn, "Library_Management_System");

  // Delete Syllabus
  if (isset($_POST['delete_id'])) { // Check if delete request was made 
    $id = $_POST['delete_id'];

    // First get the file path to delete the PDF file
    $query = "SELECT Course_PDF FROM ADMIN_SYLLABUS WHERE id = ?"; // Select the PDF file name from the database
    $stmt = $conn->prepare($query); //Prepare the SQL statement 
    $stmt->bind_param("i", $id); // Bind the ID parameter
    $stmt->execute(); // Execute the statement or run the query
    $result = $stmt->get_result();  // Get the result of the query
    $row = $result->fetch_assoc();  // Fetch the result as an associative array

    if ($row && !empty($row['Course_PDF'])) { // Check if the PDF file exists
      $file_path = "../ADMIN/ Admin PHP/" . $row['Course_PDF']; // Construct the file path to the PDF file
      if (file_exists($file_path)) {  // Check if the file exists
        unlink($file_path); // Unlink the file from the database but not delete from device
      }
    }

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM ADMIN_SYLLABUS WHERE id = ?");  // Prepare the SQL statement to delete the record from the database
    $stmt->bind_param("i", $id);  // Bind the ID parameter

    if ($stmt->execute()) { // Execute the statement or run the query
      echo "<script>alert('Syllabus deleted successfully!');</script>"; // Show an alert message to the user
      echo "<script>window.location='Admin_Syllabus.php';</script>";  // Redirect the user to the same page to refresh the list of syllabus
      exit(); // Exit the script to prevent further execution
    } else {  // If the query fails, show an error message
      echo "<script>alert('Error deleting syllabus!');</script>"; // Show an alert message to the user
    }

    $stmt->close(); // Close the statement
  }
  ?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Manage Syllabus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />
    <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Syllabus.css" />
  </head>

  <body>
    <!-- Logo and Name of the Library Management System -->
    <section class="Main-name">
      <img
        src="../Assets/Images/logo.png"
        class="header-logo"
        alt="Library Logo" />
      <span>Library Management System</span>
    </section>

    <!-- Navigation bar for the admin panel that is on the left side -->
    <div class="container">
      <nav>
        <a href="AdministratorArea.html" id="Dashboard">Dashboard</a>
        <a href="Admin_ManageBooks.php" id="ManageBooks">Manage <br> Books</a>
        <a href="Admin_BorrowRequest.php" id="BorrowRequest">Borrow <br> Request</a>
        <a href="Admin_Syllabus.php" id="Syllabus" style="background:#3b82f6; color:white; border-radius:8px;">Syllabus</a>
        <a href="Admin_BookRequest.php" id="NewBooksRequest">New <br> Books <br> Request</a>
        <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
        <a href="Admin_UserAccount.php" id="UserAccounts">User's <br> Accounts</a>
      </nav>

      <!-- Main content area for managing syllabus -->
      <div class="Main-content">
        <div class="Syllabus" id="Syllabusform">
          <div class="Upload-syllabus">
            <h1>📚 Manage Syllabus</h1>
            <h3>Upload and manage academic syllabus for different courses.</h3>

            <!-- Form for uploading new syllabus -->
            <form action="../ADMIN/Admin PHP/AdminSyllabus.php" method="post" enctype="multipart/form-data">
              <label for="courseName">Course Name:</label>
              <input type="text" name="courseName" id="courseName" required placeholder="Enter course name" />

              <label for="Semester">Choose Semester:</label>
              <select name="Semester" id="Semester" required>
                <option value="Choose Semester" selected disabled>Choose semester</option>
                <option value="semester 1">Semester 1</option>
                <option value="semester 2">Semester 2</option>
                <option value="semester 3">Semester 3</option>
                <option value="semester 4">Semester 4</option>
                <option value="semester 5">Semester 5</option>
                <option value="semester 6">Semester 6</option>
                <option value="semester 7">Semester 7</option>
                <option value="semester 8">Semester 8</option>
              </select>

              <label for="syllabusFile">Syllabus File (PDF):</label>
              <input type="file" name="syllabusFile" id="syllabusFile" accept=".pdf" required />

              <input type="submit" name="Upload_Syllabus" value="📤 Upload Syllabus" />
            </form>
          </div>

          <!-- Display existing syllabus -->
          <div class="Existing-syllabus">
            <h3>📖 Existing Syllabus</h3>

            <!-- Table to display existing syllabus -->
            <div class="table-container">
              <?php
              // Connect to the database
              $conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
              $sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
              mysqli_query($conn, $sql) or die("Failed to create database");
              mysqli_select_db($conn, "Library_Management_System");

              //Retrieve existing syllabus from the database
              $result = mysqli_query($conn, "SELECT * FROM ADMIN_SYLLABUS");

              // table format to display the existing syllabus
              echo "<table>";
              echo "<tr>
                    <th>S.No.</th>
                    <th>Course Name</th>
                    <th>Semester</th>
                    <th>Syllabus PDF</th>
                    <th>Action</th>
                  </tr>";

              $count = 1;

              while ($row = mysqli_fetch_assoc($result)) {  // Loop through each syllabus record and display it in the table
                echo "<tr>";
                echo "<td><span class='id-number'>{$count}</span></td>";
                echo "<td><span class='course-name'>" . $row['Course_Name'] . "</span></td>";
                echo "<td><span class='semester-badge'>" . $row['Semester'] . "</span></td>";
                echo "<td>";

                if (!empty($row['Course_PDF'])) { // Check if the PDF file exists
                  // Add ../ADMIN/ to the path
                  echo "<a href='../ADMIN/Admin PHP/" . $row['Course_PDF'] . "' target='_blank'>
            <i class='fa fa-file-pdf-o'></i> View PDF
          </a>";  // Show PDF in new tab
                } else {
                  echo "<span class='no-pdf'>No PDF</span>";  // Show message if no PDF is available
                }

                echo "</td>";

                // Delete Button
                echo "<td>
                      <form method='POST' onsubmit=\"return confirm('Are you sure you want to delete this syllabus?');\">
                        <input type='hidden' name='delete_id' value='{$row['ID']}'>
                        <button type='submit' class='btn-delete'><i class='fa fa-trash'></i> Delete</button>
                      </form>
                    </td>";

                echo "</tr>";

                $count++;   // Increment the count for the next syllabus record
              }

              echo "</table>";

              mysqli_close($conn);  // Close the database connection
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

  </html>