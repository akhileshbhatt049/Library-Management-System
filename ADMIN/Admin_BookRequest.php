<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Request Review</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_BookRequest.css" />

  <?php
  // Database connection
  $conn = mysqli_connect("localhost", "root", "", "Library_Management_System");

  // Approve Request
  if (isset($_POST['approve'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "UPDATE Request_Book SET Status='Approved' WHERE id=$id");
    $message = "Request Approved!";
    $message_type = "success";
  }

  // Reject Request
  if (isset($_POST['reject'])) {
    $id = $_POST['id'];
    $reason = $_POST['reject_reason'];
    mysqli_query($conn, "UPDATE Request_Book SET Status='Rejected', RejectReason='$reason' WHERE id=$id");
    $message = "Request Rejected!";
    $message_type = "success";
  }

  // Filter
  $filter = isset($_GET['filter']) ? $_GET['filter'] : 'Pending';
  if ($filter == 'All') {
    $result = mysqli_query($conn, "SELECT * FROM Request_Book ORDER BY id DESC");
  } else {
    $result = mysqli_query($conn, "SELECT * FROM Request_Book WHERE Status='$filter' ORDER BY id DESC");
  }
  ?>

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
      <a href="Admin_Syllabus.php" id="Syllabus">Syllabus</a>
      <a href="Admin_BookRequest.php" id="NewBooksRequest" style="background:#3b82f6; color:white; border-radius:8px;">New <br> Books <br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="Feedbacks">User's <br> Accounts</a>
    </nav>

    <div class="Main-content">
      <div class="Books-Request" id="Books_Request">
        <h1>📚 Book Requests</h1>
        <p>Review and respond to book requests from library users.</p>

        <!-- Display Message -->
        <?php if (isset($message)): ?>
          <div class="alert alert-<?php echo $message_type; ?>">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <!-- Filter Tabs -->
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
                      <span class="status-approved">Approved</span>
                    <?php elseif ($row['Status'] == 'Rejected'): ?>
                      <span class="status-rejected-wrapper">
                        <span class="status-rejected">Rejected</span>
                        <?php if (!empty($row['RejectReason'])): ?>
                          <span class="tooltip-text"><?php echo htmlspecialchars($row['RejectReason']); ?></span>
                        <?php endif; ?>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="action-column">
                    <?php if ($row['Status'] == 'Pending'): ?>
                      <!-- Approve Form -->
                      <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="approve" class="btn btn-approve">Approve</button>
                      </form>

                      <!-- Reject Button -->
                      <button type="button" class="btn btn-reject" onclick="openModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['Name']); ?>')">Reject</button>
                    <?php else: ?>
                      <span class="btn-done">✓ Done</span>
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

  <script>
    // Open Reject Modal
    function openModal(id, studentName) {
      document.getElementById('rejectId').value = id;
      document.getElementById('studentNameDisplay').textContent = studentName;
      document.getElementById('rejectModal').classList.add('active');
    }

    // Close Reject Modal
    function closeModal() {
      document.getElementById('rejectModal').classList.remove('active');
      document.getElementById('rejectReason').value = '';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modal = document.getElementById('rejectModal');
      if (event.target == modal) {
        closeModal();
      }
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(function() {
          alert.style.display = 'none';
        }, 500);
      });
    }, 5000);
  </script>

</body>

</html>

<?php
mysqli_close($conn);
?>