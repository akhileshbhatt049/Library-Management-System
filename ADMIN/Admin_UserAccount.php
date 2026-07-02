<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css"/>

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
      <a href="Admin_ManageBooks.php" id="ManageBooks">Manage </br> Books</a>
      <a href="Admin_BorrowRequest.php" id="BorrowRequest">Borrow </br> Request</a>
      <a href="Admin_Syllabus.php" id="Syllabus">Syllabus</a>
      <a href="Admin_BookRequest.php" id="NewBooksRequest">New </br> Books </br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="Feedbacks">User's </br> Accounts</a>
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
        <th>Password</th>
      </tr>
      <tr>
        <td>1</td>
        <td>12345</td>
        <td>Akhliesh Bhatt</td>
        <td>akhileshbhatt049@gmail.com</td>
        <td>********</td>
      </tr>
    </table>
  </div>
  </div>
</body>
</html>