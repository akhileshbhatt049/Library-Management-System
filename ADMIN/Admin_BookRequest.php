<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Create the Request_Book table if it doesn't exist
$CreateTable = "CREATE TABLE IF NOT EXISTS Request_Book (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Email VARCHAR(100),
    BookTitle VARCHAR(200),
    Author VARCHAR(100),
    Reason TEXT,
    Status VARCHAR(50) DEFAULT 'Pending',
    RejectReason TEXT
)";
mysqli_query($conn, $CreateTable) or die("Failed to create table: " . mysqli_error($conn));

// Check if Status column exists, if not add it
$checkStatus = mysqli_query($conn, "SHOW COLUMNS FROM Request_Book LIKE 'Status'");
if (mysqli_num_rows($checkStatus) == 0) {
  $alterQuery = "ALTER TABLE Request_Book ADD COLUMN Status VARCHAR(50) DEFAULT 'Pending'";
  mysqli_query($conn, $alterQuery) or die("Failed to add Status column: " . mysqli_error($conn));
}

// Check if RejectReason column exists, if not add it
$checkReason = mysqli_query($conn, "SHOW COLUMNS FROM Request_Book LIKE 'RejectReason'");
if (mysqli_num_rows($checkReason) == 0) {
  $alterReason = "ALTER TABLE Request_Book ADD COLUMN RejectReason TEXT";
  mysqli_query($conn, $alterReason) or die("Failed to add RejectReason column: " . mysqli_error($conn));
}

// Approve Request
if (isset($_POST['approve'])) {
  $id = intval($_POST['id']);
  $stmt = mysqli_prepare($conn, "UPDATE Request_Book SET Status='Approved', RejectReason=NULL WHERE id=?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  if (mysqli_stmt_execute($stmt)) {
    $message = "Request Approved!";
    $message_type = "success";
  } else {
    $message = "Error approving request: " . mysqli_error($conn);
    $message_type = "error";
  }
  mysqli_stmt_close($stmt);
}

// Reject Request
if (isset($_POST['reject'])) {
  $id = intval($_POST['id']);
  $reason = mysqli_real_escape_string($conn, $_POST['reject_reason']);
  $stmt = mysqli_prepare($conn, "UPDATE Request_Book SET Status='Rejected', RejectReason=? WHERE id=?");
  mysqli_stmt_bind_param($stmt, "si", $reason, $id);
  if (mysqli_stmt_execute($stmt)) {
    $message = "Request Rejected!";
    $message_type = "success";
  } else {
    $message = "Error rejecting request: " . mysqli_error($conn);
    $message_type = "error";
  }
  mysqli_stmt_close($stmt);
}

// Filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Pending';

if ($filter == 'All') {
  $result = mysqli_query($conn, "SELECT * FROM Request_Book ORDER BY id DESC");
} else {
  $stmt = mysqli_prepare($conn, "SELECT * FROM Request_Book WHERE Status = ? ORDER BY id DESC");
  mysqli_stmt_bind_param($stmt, "s", $filter);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
}

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
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
  <section class="Main-name">
    <img src="../Assets/Images/logo.png" class="header-logo" alt="Library Logo" />
    <span>Library Management System</span>
  </section>

  <div class="container">
    <nav>
      <a href="AdministratorArea.html" id="Dashboard">Dashboard</a>
      <a href="Admin_ManageBooks.php" id="ManageBooks">Manage <br> Books</a>
      <a href="Admin_BorrowRequest.php" id="BorrowRequest">Borrow <br> Request</a>
      <a href="Admin_Syllabus.php" id="Syllabus">Syllabus</a>
      <a href="Admin_BookRequest.php" id="NewBooksRequest" style="background:#3b82f6; color:white; border-radius:8px;">New <br> Books <br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="UserAccounts">User's <br> Accounts</a>
    </nav>

    <div class="Main-content">
      <div class="Books-Request" id="Books_Request">
        <h1>📚 Book Requests</h1>
        <p>Review and respond to book requests from library users.</p>

        <?php if (isset($message)): ?>
          <div class="alert alert-<?php echo $message_type; ?>">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <div class="filter-tabs">
          <a href="?filter=All" class="filter-tab <?php if ($filter == 'All') echo 'active'; ?>">All</a>
          <a href="?filter=Pending" class="filter-tab <?php if ($filter == 'Pending') echo 'active'; ?>">Pending</a>
          <a href="?filter=Approved" class="filter-tab <?php if ($filter == 'Approved') echo 'active'; ?>">Approved</a>
          <a href="?filter=Rejected" class="filter-tab <?php if ($filter == 'Rejected') echo 'active'; ?>">Rejected</a>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
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
              while ($row = mysqli_fetch_assoc($result)):
                // If Status is NULL or empty, set it to 'Pending'
                if (empty($row['Status'])) {
                  $row['Status'] = 'Pending';
                }
              ?>
                <tr>
                  <td><span class="sno"><?php echo $count; ?></span></td>
                  <td><strong><?php echo htmlspecialchars($row['Name']); ?></strong></td>
                  <td><?php echo htmlspecialchars($row['Email']); ?></td>
                  <td><strong><?php echo htmlspecialchars($row['BookTitle']); ?></strong></td>
                  <td><?php echo htmlspecialchars($row['Author']); ?></td>
                  <td><span class="reason-text"><?php echo htmlspecialchars($row['Reason']); ?></span></td>
                  <td>
                    <?php if ($row['Status'] == 'Pending'): ?>
                      <span class="status-pending">Pending</span>
                    <?php elseif ($row['Status'] == 'Approved'): ?>
                      <span class="status-approved">✅ Approved</span>
                    <?php elseif ($row['Status'] == 'Rejected'): ?>
                      <span class="status-rejected-wrapper">
                        <span class="status-rejected">❌ Rejected</span>
                        <?php if (!empty($row['RejectReason'])): ?>
                          <span class="tooltip-text"><?php echo htmlspecialchars($row['RejectReason']); ?></span>
                        <?php endif; ?>
                      </span>
                    <?php else: ?>
                      <span class="status-pending">⏳ Pending</span>
                    <?php endif; ?>
                  </td>
                  <td class="action-column">
                    <?php if ($row['Status'] == 'Pending'): ?>
                      <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="approve" class="btn btn-approve">Approve</button>
                      </form>
                      <button type="button" class="btn btn-reject" onclick="openModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['Name']); ?>')">Reject</button>
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
            <p>There are no book requests with status: <?php echo htmlspecialchars($filter); ?></p>
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