<!DOCTYPE html>
<html lang="en">

<head>
  <title>Manage Syllabus</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />

  <!-- Delete PHP Code -->
  <?php
  $conn = mysqli_connect("localhost", "root", "", "Library_Management_System");

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Delete Syllabus
  if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // First get the file path to delete the PDF file
    $query = "SELECT Course_PDF FROM ADMIN_SYLLABUS WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && !empty($row['Course_PDF'])) {
      $file_path = "../ADMIN/ Admin PHP/" . $row['Course_PDF']; // Adjust path if needed
      if (file_exists($file_path)) {
        unlink($file_path); // Delete the physical PDF file
      }
    }

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM ADMIN_SYLLABUS WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      echo "<script>alert('Syllabus deleted successfully!');</script>";
      echo "<script>window.location='Admin_Syllabus.php';</script>";
      exit();
    } else {
      echo "<script>alert('Error deleting syllabus!');</script>";
    }

    $stmt->close();
  }
  ?>

  <style>
    /* General Reset */
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
    }

    /* Main Content Area */
    .Main-content {
      flex: 1;
      padding: 20px;
    }

    /* Syllabus Container */
    .Syllabus {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      max-width: 100%;
      display: flex;
      gap: 40px;
      flex-wrap: wrap;
    }

    /* Upload Section */
    .Upload-syllabus {
      flex: 1;
      min-width: 300px;
      background: #f8fafc;
      padding: 25px 30px;
      border-radius: 10px;
      border: 1px solid #e5e7eb;
    }

    .Upload-syllabus h1 {
      color: #1f2937;
      font-size: 24px;
      margin-top: 0;
      margin-bottom: 5px;
    }

    .Upload-syllabus h3 {
      color: #6b7280;
      font-weight: 400;
      font-size: 15px;
      margin-top: 0;
      margin-bottom: 25px;
    }

    .Upload-syllabus form label {
      font-weight: 600;
      color: #374151;
      font-size: 14px;
      display: block;
      margin-bottom: 5px;
    }

    .Upload-syllabus form input,
    .Upload-syllabus form select {
      width: 100%;
      padding: 10px 12px;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: white;
      font-family: inherit;
      margin-bottom: 15px;
    }

    .Upload-syllabus form input:focus,
    .Upload-syllabus form select:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .Upload-syllabus form input[type="file"] {
      padding: 8px;
      border: 2px dashed #d1d5db;
      background: #f9fafb;
      cursor: pointer;
    }

    .Upload-syllabus form input[type="file"]:hover {
      border-color: #3b82f6;
      background: #eff6ff;
    }

    .Upload-syllabus form input[type="submit"] {
      background: #3b82f6;
      color: white;
      border: none;
      padding: 12px 30px;
      font-size: 16px;
      font-weight: 600;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
      width: auto;
      margin-top: 5px;
    }

    .Upload-syllabus form input[type="submit"]:hover {
      background: #2563eb;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    /* Existing Syllabus Section */
    .Existing-syllabus {
      flex: 2;
      min-width: 400px;
    }

    .Existing-syllabus h3 {
      color: #1f2937;
      margin-top: 0;
      margin-bottom: 20px;
      font-size: 18px;
    }

    /* Table Styles */
    .table-container {
      overflow-x: auto;
      border-radius: 10px;
    }

    .Existing-syllabus table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .Existing-syllabus table th {
      background: #1e293b;
      color: white;
      padding: 14px 12px;
      text-align: center;
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .Existing-syllabus table td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #f1f5f9;
      font-size: 14px;
      color: #334155;
    }

    .Existing-syllabus table tr {
      transition: all 0.3s ease;
    }

    .Existing-syllabus table tr:hover {
      background: #f8fafc;
      transform: scale(1.002);
    }

    .Existing-syllabus table tr:last-child td {
      border-bottom: none;
    }

    /* View PDF Link */
    .Existing-syllabus table a {
      display: inline-block;
      background: #3b82f6;
      color: white;
      padding: 6px 18px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .Existing-syllabus table a:hover {
      background: #2563eb;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .Existing-syllabus table a i {
      margin-right: 5px;
    }

    /* No PDF text */
    .no-pdf {
      color: #94a3b8;
      font-size: 13px;
    }

    /* Course name styling */
    .course-name {
      font-weight: 600;
      color: #1e293b;
    }

    /* Semester badge */
    .semester-badge {
      display: inline-block;
      background: #f1f5f9;
      color: #475569;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 500;
    }

    /* ID styling */
    .id-number {
      font-weight: 700;
      color: #3b82f6;
    }

    /* Delete Button */
    .btn-delete {
      background: #ef4444;
      color: white;
      border: none;
      padding: 6px 16px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 13px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-delete:hover {
      background: #dc2626;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .btn-delete i {
      margin-right: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .Syllabus {
        flex-direction: column;
        padding: 15px;
      }

      .Upload-syllabus {
        min-width: auto;
        padding: 20px;
      }

      .Existing-syllabus {
        min-width: auto;
      }

      .Existing-syllabus table {
        font-size: 12px;
      }

      .Existing-syllabus table th,
      .Existing-syllabus table td {
        padding: 8px 6px;
      }
    }

    @media (max-width: 480px) {
      .Upload-syllabus form input[type="submit"] {
        width: 100%;
      }

      .Existing-syllabus table {
        font-size: 11px;
      }

      .Existing-syllabus table th,
      .Existing-syllabus table td {
        padding: 6px 4px;
      }
    }

    /* Scrollbar Styling */
    .table-container::-webkit-scrollbar {
      height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 4px;
    }

    .table-container::-webkit-scrollbar-thumb {
      background: #94a3b8;
      border-radius: 4px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
      background: #64748b;
    }
  </style>

</head>

<body>
  <section class="Main-name">
    <img
      src="../Assets/Images/logo.png"
      class="header-logo"
      alt="Library Logo" />
    <span>Library Management System</span>
  </section>

  <div class="container">
    <nav>
      <a href="AdministratorArea.html" id="Dashboard">Dashboard</a>
      <a href="Admin_ManageBooks.php" id="ManageBooks">Manage <br> Books</a>
      <a href="Admin_BorrowRequest.php" id="BorrowRequest">Borrow <br> Request</a>
      <a href="Admin_Syllabus.php" id="Syllabus" style="background:#3b82f6; color:white; border-radius:8px;">Syllabus</a>
      <a href="Admin_BookRequest.php" id="NewBooksRequest">New <br> Books <br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="Feedbacks">User's <br> Accounts</a>
    </nav>

    <div class="Main-content">
      <div class="Syllabus" id="Syllabusform">
        <div class="Upload-syllabus">
          <h1>📚 Manage Syllabus</h1>
          <h3>Upload and manage academic syllabus for different courses.</h3>

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

        <div class="Existing-syllabus">
          <h3>📖 Existing Syllabus</h3>

          <div class="table-container">
            <?php
            $conn = mysqli_connect("localhost", "root", "", "Library_Management_System");

            $result = mysqli_query($conn, "SELECT * FROM ADMIN_SYLLABUS ORDER BY id DESC");

            echo "<table>";
            echo "<tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Semester</th>
                    <th>Syllabus PDF</th>
                    <th>Action</th>
                  </tr>";

            $count = 1;

            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td><span class='id-number'>{$count}</span></td>";
              echo "<td><span class='course-name'>" . $row['Course_Name'] . "</span></td>";
              echo "<td><span class='semester-badge'>" . $row['Semester'] . "</span></td>";
              echo "<td>";

              if (!empty($row['Course_PDF'])) {
                // Add ../ADMIN/ to the path
                echo "<a href='../ADMIN/Admin PHP/" . $row['Course_PDF'] . "' target='_blank'>
            <i class='fa fa-file-pdf-o'></i> View PDF
          </a>";
              } else {
                echo "<span class='no-pdf'>No PDF</span>";
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

              $count++;
            }

            echo "</table>";

            mysqli_close($conn);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>