<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Accounts</title>
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_UserAccount.css" />

</head>

<body>
  <?php
  // Database connection
  $conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
  mysqli_select_db($conn, "Library_Management_System");

  // Fetch users from database (excluding password)
  $query = "SELECT id, user_id, fullname, email, phone FROM Accounts ORDER BY id ASC";
  $result = mysqli_query($conn, $query);
  $count = 1;
  ?>

  <section class="Main-name">
    <img src="../Assets/Images/logo.png" class="header-logo" alt="Library Logo" />
    <span>Library Management System</span>
  </section>

  <div class="container">
    <nav>
      <a href="AdministratorArea.html" id="Dashboard">Dashboard</a>
      <a href="Admin_ManageBooks.php" id="ManageBooks">Manage </br> Books</a>
      <a href="Admin_BorrowRequest.php" id="BorrowRequest">Borrow </br> Request</a>
      <a href="Admin_Syllabus.php" id="Syllabus">Syllabus</a>
      <a href="Admin_BookRequest.php" id="NewBooksRequest">New </br> Books </br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="UserAccounts" style="background:#3b82f6; color:white; border-radius:8px;">User's </br> Accounts</a>
    </nav>

    <div class="User-Account" id="User_Accounts">
      <h1>User Accounts</h1>
      <p>Manage library user accounts and permissions.</p>

      <table border="1" cellpadding="10">
        <tr>
          <th>S.No.</th>
          <th>Student ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo htmlspecialchars($row['user_id']); ?></td>
              <td><?php echo htmlspecialchars($row['fullname']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" style="text-align: center;">No users found</td>
          </tr>
        <?php endif; ?>
      </table>
    </div>
  </div>

  <?php mysqli_close($conn); ?>
</body>

</html>