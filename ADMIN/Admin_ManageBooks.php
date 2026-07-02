<!-- To delete a row -->
<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Delete Book
if (isset($_POST['delete_id'])) { // Check if the delete_id is set in the POST request
  $id = $_POST['delete_id'];  // Get the ID of the book to be deleted

  $stmt = $conn->prepare("DELETE FROM ManageBooksAdmin WHERE id = ?");  // Prepare the SQL statement to delete the book with the specified ID
  $stmt->bind_param("i", $id);  // Bind the ID parameter to the prepared statement

  if ($stmt->execute()) { // Execute the statement or run the query
    echo "<script>alert('Book deleted successfully!');</script>"; // Show an alert message to the user
    echo "<script>window.location='Admin_ManageBooks.php';</script>"; // Redirect the user to the same page to refresh the list of books
    exit(); // Exit the script to prevent further execution
  }

  $stmt->close(); // Close the statement
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
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_ManageBooks.css" />

  <!-- Script to hide the success message after 5 seconds -->
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
        </div>";   // Show success message when a book is added successfully
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
        </div>";  // Show error message when a book fails to be added
    }
  }
  ?>

  <!-- Logo and Name -->
  <section class="Main-name">
    <img
      src="../Assets/Images/logo.png"
      class="header-logo"
      alt="Library Logo" />
    <span>Library Management System</span>
  </section>

  <!-- Left side navigation -->
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

    <!-- Main Content -->
    <div class="Main-content">
      <div class="Manage-books" id="Manage_Books">
        <div class="Upload-books">
          <h1>📚 Manage Books</h1>
          <h3>Upload new books to the library collection.</h3>

          <!-- Form for adding new books to the library collection -->
          <form action="Admin PHP/ManageBooks.php" method="post" enctype="multipart/form-data">
            <label for="bookTitle">Book Title:</label>
            <input type="text" name="bookTitle" id="bookTitle" required placeholder="Enter book title" />

            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required placeholder="Enter author name" />

            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn" required placeholder="Enter ISBN number" /> <br /><br />

            <input type="submit" name="submit" value="➕ Add Book" />
          </form>
        </div>

        <div class="Existing-books">
          <h3>📖 Manage Existing Books</h3>

          <!-- Table to display existing books by retrieving from the database -->
          <div class="table-container">
            <?php
            // Connect to the database
            $conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
            $sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
            mysqli_query($conn, $sql) or die("Failed to create database");
            mysqli_select_db($conn, "Library_Management_System");

            // Retrieve existing books from the database
            $result = mysqli_query($conn, "SELECT * FROM ManageBooksAdmin");

            // Table format to display books
            echo "<table>";
            echo "<tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>ISBN</th>
                  <th>Action</th>
                  </tr>";
            $count = 1;

            while ($row = mysqli_fetch_assoc($result)) {  // Loop through each book record and display it in the table

              echo "<tr>";

              echo "<td><strong>{$count}</strong></td>";  // Display the count number for each book
              echo "<td><strong>{$row['BookTitle']}</strong></td>"; // Display the book title
              echo "<td>{$row['Author']}</td>"; // Display the author name
              echo "<td>{$row['ISBN']}</td>"; // Display the ISBN number
              echo "</td>";

              // Delete Button
              echo "<td>
              <form method='POST' onsubmit=\"return confirm('Are you sure you want to delete this book?');\">
                  <input type='hidden' name='delete_id' value='{$row['id']}'>
                  <input type='submit' value='🗑 Delete' style='background:#ef4444;color:white;border:none;padding:6px 16px;cursor:pointer;border-radius:6px;font-size:13px;font-weight:500;transition:all 0.3s ease;'>
              </form>
            </td>";

              echo "</tr>";

              $count++; // Increment the count for the next book record
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