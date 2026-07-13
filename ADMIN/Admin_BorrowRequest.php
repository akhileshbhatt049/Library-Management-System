<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Approve Request
if (isset($_POST['approve'])) { // Check if the approve button is clicked
  $id = $_POST['id']; // Get the ID of the request to approve
  mysqli_query($conn, "UPDATE BorrowBook SET Status='Approved', RejectReason=NULL WHERE id=$id"); // Update the status of the request to 'Approved' and clear any reject reason
  $message = "Request Approved!"; // Set a message to indicate that the request has been approved
}

// Reject Request
if (isset($_POST['reject'])) {  // Check if the reject button is clicked
  $id = $_POST['id']; // Get the ID of the request to reject
  $reason = $_POST['reject_reason'];  // Get the reason for rejection from the form input
  mysqli_query($conn, "UPDATE BorrowBook SET Status='Rejected', RejectReason='$reason' WHERE id=$id");  // Update the status of the request to 'Rejected' and store the reason for rejection in the database
  $message = "Request Rejected!"; // Set a message to indicate that the request has been rejected
}

// Filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Pending'; // Get the filter value from the URL parameter, default to 'Pending' if not set
if ($filter == 'All') { // If the filter is set to 'All', retrieve all borrow requests from the database
  $result = mysqli_query($conn, "SELECT * FROM BorrowBook"); // Retrieve all borrow requests from the database
} else {
  $result = mysqli_query($conn, "SELECT * FROM BorrowBook WHERE Status='$filter'"); // Retrieve borrow requests from the database based on the selected filter (Pending, Approved, or Rejected)
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Borrow Requests</title>
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_BorrowRequest.css" />
</head>

<body>

  <section class="Main-name">
    <img src="../Assets/Images/logo.png" class="header-logo" alt="Logo" />
    <span>Library Management System</span>
  </section>

  <div class="container">
    <nav>
      <a href="AdministratorArea.html" id="Dashboard">Dashboard</a>
      <a href="Admin_ManageBooks.php" id="ManageBooks">Manage <br /> Books</a>
      <a href="Admin_BorrowRequest.php" id="BorrowRequest" style="background:#3b82f6; color:white; border-radius:8px;">Borrow <br /> Request</a>
      <a href="Admin_Syllabus.php" id="Syllabus">Syllabus</a>
      <a href="Admin_BookRequest.php" id="NewBooksRequest">New <br /> Books <br /> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="UserAccounts">User's <br /> Accounts</a>
    </nav>

    <div class="Borrow-request">
      <h1>Borrow Requests</h1>
      <p>Review and manage borrow requests from library users.</p>

      <!-- Show message -->
      <?php if (isset($message)) { ?> <!-- Check if a message is set (either for approval or rejection) -->
        <div class="alert"><?php echo $message; ?></div> <!-- Display the message in an alert box -->
      <?php } ?>

      <!-- Filter tabs -->
      <div class="filter-tabs">
        <a href="?filter=All" class="filter-tab <?php if ($filter == 'All') echo 'active'; ?>">All</a> <!-- Link to show all requests, with 'active' class if the current filter is 'All' -->
        <a href="?filter=Pending" class="filter-tab <?php if ($filter == 'Pending') echo 'active'; ?>">Pending</a> <!-- Link to show pending requests, with 'active' class if the current filter is 'Pending' -->
        <a href="?filter=Approved" class="filter-tab <?php if ($filter == 'Approved') echo 'active'; ?>">Approved</a> <!-- Link to show approved requests, with 'active' class if the current filter is 'Approved' -->
        <a href="?filter=Rejected" class="filter-tab <?php if ($filter == 'Rejected') echo 'active'; ?>">Rejected</a> <!-- Link to show rejected requests, with 'active' class if the current filter is 'Rejected' -->
      </div>

      <?php if (mysqli_num_rows($result) > 0) { ?> <!-- Check if there are any borrow requests to display -->
        <table>
          <tr>
            <th>Student Name</th>
            <th>Student ID</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Book Name</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>

          <?php while ($row = mysqli_fetch_assoc($result)) { ?> <!-- Loop through each borrow request and display its details in a table row -->
            <tr>
              <td><?php echo $row['Name']; ?></td> <!-- Display the student's name -->
              <td><?php echo $row['StudentID']; ?></td> <!-- Display the student's ID -->
              <td><?php echo $row['Email']; ?></td> <!-- Display the student's email -->
              <td><?php echo $row['phone']; ?></td> <!-- Display the student's phone number -->
              <td><?php echo $row['BookName']; ?></td> <!-- Display the name of the book requested -->
              <td><?php echo $row['ReturnDate']; ?></td> <!-- Display the return date for the borrowed book -->
              <td>
                <?php if ($row['Status'] == 'Pending') { ?> <!-- Check the status of the borrow request -->
                  <span class="status-pending">Pending</span>
                <?php } elseif ($row['Status'] == 'Approved') { ?> <!-- If the request is approved -->
                  <span class="status-approved">Approved</span>
                <?php } elseif ($row['Status'] == 'Rejected') { ?> <!-- If the request is rejected -->
                  <span class="rejected-wrapper">
                    <span class="status-rejected">Rejected</span>
                    <?php if ($row['RejectReason'] != '') { ?> <!-- Check if there is a reason for rejection -->
                      <span class="tooltip-text"><?php echo $row['RejectReason']; ?></span> <!-- Display the reason for rejection in a tooltip -->
                    <?php } ?>
                  </span>
                <?php } ?>
              </td>
              <td>
                <?php if ($row['Status'] == 'Pending') { ?> <!-- If the request is still pending, show the approve and reject buttons -->
                  <!-- Approve Form -->
                  <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> <!-- Hidden input to pass the ID of the request to approve -->
                    <button type="submit" name="approve" class="btn btn-approve">Approve</button>
                  </form>

                  <!-- Reject Button -->
                  <button onclick="openModal(<?php echo $row['id']; ?>, '<?php echo $row['Name']; ?>')" class="btn btn-reject">Reject</button> <!-- Button to open the reject modal, passing the ID and name of the student -->
                <?php } else { ?>
                  <span style="color:#999; font-size:13px;">Done</span>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </table>
      <?php } else { ?>
        <div class="empty">
          <h3>No requests found</h3>
          <p>No borrow requests with status: <?php echo $filter; ?></p> <!-- Display a message if there are no borrow requests found for the selected filter -->
        </div>
      <?php } ?>

    </div>
  </div>

  <!-- Reject Modal -->
  <div id="rejectModal" class="modal">
    <div class="modal-content">
      <h3>Reject Request</h3>
      <p>Reason for rejecting <b id="studentName"></b>'s request:</p>
      <form method="POST">
        <input type="hidden" name="id" id="rejectId">
        <textarea name="reject_reason" id="rejectReason" placeholder="Enter reason..." required></textarea>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
          <button type="submit" name="reject" class="btn-confirm">Reject</button>
        </div>
      </form>
    </div>
  </div>

  <script src="Admin JS/Admin_BorrowRequest_Model.js"></script>

</body>

</html>

<?php
mysqli_close($conn);
?>