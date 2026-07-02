<!-- To delete a row -->
<?php
$conn = mysqli_connect("localhost", "root", "", "Library_Management_System");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Delete Book
if (isset($_POST['delete_id'])) {

  $id = $_POST['delete_id'];

  $stmt = $conn->prepare("DELETE FROM ManageBooksAdmin WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    echo "<script>alert('Book deleted successfully!');</script>";
    echo "<script>window.location='Admin_ManageBooks.php';</script>";
    exit();
  }

  $stmt->close();
}
?>

<!-- Website page -->
<!doctype html>
<html>

<head>
  <title>Manage Books</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZMNWXWP3NH"> </script>

  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-ZMNWXWP3NH');
  </script>

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

    /* Manage-books Container */
    .Manage-books {
      display: flex;
      gap: 40px;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      max-width: 100%;
      flex-wrap: wrap;
    }

    /* Upload Section */
    .Upload-books {
      flex: 1;
      min-width: 300px;
      background: #f8fafc;
      padding: 25px 30px;
      border-radius: 10px;
      border: 1px solid #e5e7eb;
    }

    .Upload-books h1 {
      color: #1f2937;
      font-size: 24px;
      margin-top: 0;
      margin-bottom: 5px;
    }

    .Upload-books h3 {
      color: #6b7280;
      font-weight: 400;
      font-size: 15px;
      margin-top: 0;
      margin-bottom: 25px;
    }

    .Upload-books form label {
      font-weight: 600;
      color: #374151;
      font-size: 14px;
      display: block;
      margin-bottom: 5px;
    }

    .Upload-books form input,
    .Upload-books form textarea {
      width: 100%;
      padding: 10px 12px;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: white;
      font-family: inherit;
    }

    .Upload-books form input:focus,
    .Upload-books form textarea:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .Upload-books form textarea {
      min-height: 80px;
      resize: vertical;
    }

    .Upload-books form input[type="file"] {
      padding: 8px;
      border: 2px dashed #d1d5db;
      background: #f9fafb;
      cursor: pointer;
    }

    .Upload-books form input[type="file"]:hover {
      border-color: #3b82f6;
      background: #eff6ff;
    }

    .Upload-books form input[type="submit"] {
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

    .Upload-books form input[type="submit"]:hover {
      background: #2563eb;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    /* Existing Books Section */
    .Existing-books {
      flex: 2;
      min-width: 400px;
    }

    .Existing-books h3 {
      color: #1f2937;
      margin-top: 0;
      margin-bottom: 20px;
      font-size: 18px;
    }

    /* Table Styles */
    .Existing-books table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .Existing-books table th {
      background: #1e293b;
      color: white;
      padding: 14px 12px;
      text-align: center;
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .Existing-books table td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #f1f5f9;
      font-size: 14px;
      color: #334155;
    }

    .Existing-books table tr {
      transition: all 0.3s ease;
    }

    .Existing-books table tr:hover {
      background: #f8fafc;
      transform: scale(1.002);
    }

    .Existing-books table tr:last-child td {
      border-bottom: none;
    }

    /* Description toggle */
    .short-desc {
      color: #475569;
    }

    .full-desc {
      color: #1e293b;
    }

    .Existing-books table a {
      color: #3b82f6;
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      margin-left: 5px;
      cursor: pointer;
    }

    .Existing-books table a:hover {
      color: #2563eb;
      text-decoration: underline;
    }

    /* Book Image */
    .Existing-books table img {
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      max-width: 80px;
      height: auto;
    }

    .Existing-books table img:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    /* Delete Button */
    .Existing-books table form input[type="submit"] {
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

    .Existing-books table form input[type="submit"]:hover {
      background: #dc2626;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    /* Message Alert */
    #message {
      margin: 15px 20px;
      padding: 15px 20px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 500;
      animation: slideDown 0.3s ease;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-15px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Scrollable table container */
    .table-container {
      overflow-x: auto;
      border-radius: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .Manage-books {
        flex-direction: column;
        padding: 15px;
      }

      .Upload-books {
        min-width: auto;
        padding: 20px;
      }

      .Existing-books {
        min-width: auto;
      }

      .Existing-books table {
        font-size: 12px;
      }

      .Existing-books table th,
      .Existing-books table td {
        padding: 8px 6px;
      }

      .Existing-books table img {
        max-width: 50px;
      }
    }

    @media (max-width: 480px) {
      .Upload-books form input[type="submit"] {
        width: 100%;
      }

      .Existing-books table {
        font-size: 11px;
      }

      .Existing-books table th,
      .Existing-books table td {
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

  <script>
    setTimeout(function() {

      var msg = document.getElementById("message");

      if (msg) {
        msg.style.display = "none";
      }

    }, 5000);
  </script>
</head>

<body>
  <?php
  if (isset($_GET['success'])) {
    if ($_GET['success'] == 1) {
      echo "
        <div id='message' style='
            background:#d1fae5;
            color:#065f46;
            padding:15px 20px;
            margin:15px 20px;
            border-radius:10px;
            font-size:16px;
            text-align:center;
            font-weight:500;
            border-left:4px solid #10b981;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        '>
            ✅ Book added successfully!
        </div>";
    }

    if ($_GET['success'] == 0) {
      echo "
        <div id='message' style='
            background:#fee2e2;
            color:#991b1b;
            padding:15px 20px;
            margin:15px 20px;
            border-radius:10px;
            font-size:16px;
            text-align:center;
            font-weight:500;
            border-left:4px solid #ef4444;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        '>
            ❌ Failed to add book. Please try again.
        </div>";
    }
  }
  ?>


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
      <a href="Admin_ManageBooks.php" id="ManageBooks" style="background:#3b82f6; color:white; border-radius:8px;">Manage <br> Books</a>
      <a href="Admin_BorrowRequest.php" id="BorrowRequest">Borrow <br> Request</a>
      <a href="Admin_Syllabus.php" id="Syllabus">Syllabus</a>
      <a href="Admin_BookRequest.php" id="NewBooksRequest">New <br> Books <br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="Feedbacks">User's <br> Accounts</a>
    </nav>

    <div class="Main-content">
      <div class="Manage-books" id="Manage_Books">
        <div class="Upload-books">
          <h1>📚 Manage Books</h1>
          <h3>Upload new books to the library collection.</h3>

          <form action="Admin PHP/ManageBooks.php" method="post" enctype="multipart/form-data">
            <label for="bookTitle">Book Title:</label>
            <input type="text" name="bookTitle" id="bookTitle" required placeholder="Enter book title" />

            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required placeholder="Enter author name" />

            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn" required placeholder="Enter ISBN number" /> <br/><br/>

            <input type="submit" name="submit" value="➕ Add Book" />
          </form>
        </div>

        <div class="Existing-books">
          <h3>📖 Manage Existing Books</h3>

          <div class="table-container">
            <?php
            $conn = mysqli_connect("localhost", "root", "", "Library_Management_System");

            $result = mysqli_query($conn, "SELECT * FROM ManageBooksAdmin");

            echo "<table>";
            echo "<tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>ISBN</th>
                  <th>Action</th>
                  </tr>";
            $count = 1;

            while ($row = mysqli_fetch_assoc($result)) {

              echo "<tr>";

              echo "<td><strong>{$count}</strong></td>";
              echo "<td><strong>{$row['BookTitle']}</strong></td>";
              echo "<td>{$row['Author']}</td>";
              echo "<td>{$row['ISBN']}</td>";
              echo "</td>";

              // Delete Button
              echo "<td>
              <form method='POST' onsubmit=\"return confirm('Are you sure you want to delete this book?');\">
                  <input type='hidden' name='delete_id' value='{$row['id']}'>
                  <input type='submit' value='🗑 Delete' style='background:#ef4444;color:white;border:none;padding:6px 16px;cursor:pointer;border-radius:6px;font-size:13px;font-weight:500;transition:all 0.3s ease;'>
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