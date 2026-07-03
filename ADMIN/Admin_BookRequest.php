<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Approve Request
if (isset($_POST['approve'])) { // Check if the approve button is clicked
  $id = $_POST['id'];   // Get the ID of the request to be approved
  mysqli_query($conn, "UPDATE Request_Book SET Status='Approved' WHERE id=$id");  // Update the status of the request to 'Approved' in the database
  $message = "Request Approved!"; // Set a success message to be displayed to the user
  $message_type = "success";  // Set the message type to 'success' for styling purposes
}

// Reject Request
if (isset($_POST['reject'])) { // Check if the reject button is clicked
  $id = $_POST['id'];   // Get the ID of the request to be rejected
  $reason = $_POST['reject_reason'];   // Get the reason for rejection
  mysqli_query($conn, "UPDATE Request_Book SET Status='Rejected', RejectReason='$reason' WHERE id=$id");  // Update the status and rejection reason in the database
  $message = "Request Rejected!"; // Set a success message to be displayed to the user
  $message_type = "success";  // Set the message type to 'success' for styling purposes
}

// Filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Pending'; // Get the filter value from the URL, default to 'Pending' if not set
if ($filter == 'All') { // If the filter is set to 'All', retrieve all book requests from the database
  $result = mysqli_query($conn, "SELECT * FROM Request_Book ORDER BY id DESC"); // Retrieve all book requests from the database and order them by ID in descending order
} else {
  $result = mysqli_query($conn, "SELECT * FROM Request_Book WHERE Status='$filter'"); // Retrieve book requests from the database based on the selected filter and order them by ID in descending order
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Request Review</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_BookRequest.css" />

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

  <!-- Navigation -->
  <div class="container">
    <nav>
      <a href="AdministratorArea.html" id="Dashboard">Dashboard</a>
      <a href="Admin_ManageBooks.php" id="ManageBooks">Manage <br> Books</a>
      <a href="Admin_BorrowRequest.php" id="BorrowRequest">Borrow <br> Request</a>
      <a href="Admin_Syllabus.php" id="Syllabus">Syllabus</a>
      <a href="Admin_BookRequest.php" id="NewBooksRequest" style="background:#3b82f6; color:white; border-radius:8px;">New <br> Books <br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="Feedbacks">User's <br> Accounts</a>
    </nav>

    <!-- Main Content -->
    <div class="Main-content">
      <div class="Books-Request" id="Books_Request">
        <h1>📚 Book Requests</h1>
        <p>Review and respond to book requests from library users.</p>

        <!-- Display Message -->
        <?php if (isset($message)): ?> <!-- Check if there is a message to display -->
          <div class="alert alert-<?php echo $message_type; ?>"> <!-- Display the message with appropriate styling based on the message type -->
            <?php echo $message; ?> <!-- Output the message content -->
          </div>
        <?php endif; ?>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
          <a href="?filter=All" class="filter-tab <?php if ($filter == 'All') echo 'active'; ?>">All</a> <!-- Link to filter all book requests, and add 'active' class if the current filter is 'All' -->
          <a href="?filter=Pending" class="filter-tab <?php if ($filter == 'Pending') echo 'active'; ?>">Pending</a> <!--filters pending requests -->
          <a href="?filter=Approved" class="filter-tab <?php if ($filter == 'Approved') echo 'active'; ?>">Approved</a> <!--filters approved requests -->
          <a href="?filter=Rejected" class="filter-tab <?php if ($filter == 'Rejected') echo 'active'; ?>">Rejected</a> <!--filters rejected requests -->
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?> <!-- Check if there are any book requests to display -->
          <div class="table-container">
            <table>
              <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Book Title</th>
                <th>Author Name</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
              </tr>

              <?php
              $count = 1;
              while ($row = mysqli_fetch_assoc($result)): // Loop through each book request and display it in the table
              ?>
                <tr>
                  <td><span class="sno"><?php echo $count; ?></span></td> <!-- Display the serial number for each request -->
                  <td><strong><?php echo htmlspecialchars($row['Name']); ?></strong></td> <!-- Display the student's name in bold -->
                  <td><?php echo htmlspecialchars($row['Email']); ?></td> <!-- Display the student's email address -->
                  <td><strong><?php echo htmlspecialchars($row['BookTitle']); ?></strong></td> <!-- Display the book title in bold -->
                  <td><?php echo htmlspecialchars($row['Author']); ?></td> <!-- Display the author's name -->
                  <td><span class="reason-text"><?php echo htmlspecialchars($row['Reason']); ?></span></td> <!-- Display the reason for the request -->
                  <td>
                    <?php if ($row['Status'] == 'Pending'): ?> <!-- Check if the request status is 'Pending' -->
                      <span class="status-pending">Pending</span>
                    <?php elseif ($row['Status'] == 'Approved'): ?> <!-- Check if the request status is 'Approved' -->
                      <span class="status-approved">Approved</span>
                    <?php elseif ($row['Status'] == 'Rejected'): ?> <!-- Check if the request status is 'Rejected' -->
                      <span class="status-rejected-wrapper">
                        <span class="status-rejected">Rejected</span> <!-- Display the rejected status -->
                        <?php if (!empty($row['RejectReason'])): ?>
                          <span class="tooltip-text"><?php echo htmlspecialchars($row['RejectReason']); ?></span> <!-- Display the rejection reason in a tooltip if it exists -->
                        <?php endif; ?>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="action-column">
                    <?php if ($row['Status'] == 'Pending'): ?> <!-- Check if the request status is 'Pending' to show action buttons -->

                      <!-- Approve Form -->
                      <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> <!-- Hidden input to store the request ID for approval -->
                        <button type="submit" name="approve" class="btn btn-approve">Approve</button> <!-- Button to approve the request -->
                      </form>

                      <!-- Reject Button -->
                      <button type="button" class="btn btn-reject" onclick="openModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['Name']); ?>')">Reject</button> <!-- Button to open the rejection modal and pass the request -->
                    <?php else: ?>
                      <span class="btn-done">Done</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php
                $count++;
              endwhile;
              ?>
            </table>
          </div>
        <?php else: ?>
          <div class="empty-state">
            <div class="icon">📖</div>
            <h3>No requests found</h3>
            <p>There are no book requests with status: <?php echo htmlspecialchars($filter); ?></p> <!-- Display a message when there are no requests found for the selected filter -->
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Reject Modal -->
  <div id="rejectModal" class="modal">
    <div class="modal-content">
      <h3>Reject Book Request</h3>
      <p style="color:#6b7280; margin-bottom:10px;">
        Please provide a reason for rejecting <b id="studentNameDisplay"></b>'s request.
      </p>
      <form method="POST" id="rejectForm">
        <input type="hidden" name="id" id="rejectId">
        <textarea name="reject_reason" id="rejectReason" placeholder="Enter reason for rejection..." required></textarea>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
          <button type="submit" name="reject" class="btn-confirm">Reject Request</button>
        </div>
      </form>
    </div>
  </div>

  <script src="Admin JS/Admin_BookRequest_Model.js"></script>

</body>

</html>

<?php
mysqli_close($conn);
?>