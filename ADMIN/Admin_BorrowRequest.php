<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "Library_Management_System");

// Approve Request
if (isset($_POST['approve'])) {
  $id = $_POST['id'];
  mysqli_query($conn, "UPDATE BorrowBook SET Status='Approved', RejectReason=NULL WHERE id=$id");
  $message = "Request Approved!";
}

// Reject Request
if (isset($_POST['reject'])) {
  $id = $_POST['id'];
  $reason = $_POST['reject_reason'];
  mysqli_query($conn, "UPDATE BorrowBook SET Status='Rejected', RejectReason='$reason' WHERE id=$id");
  $message = "Request Rejected!";
}

// Filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Pending';
if ($filter == 'All') {
  $result = mysqli_query($conn, "SELECT * FROM BorrowBook ORDER BY id DESC");
} else {
  $result = mysqli_query($conn, "SELECT * FROM BorrowBook WHERE Status='$filter' ORDER BY id DESC");
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
      <a href="AdministratorArea.html">Dashboard</a>
      <a href="Admin_ManageBooks.php">Manage <br/> Books</a>
      <a href="Admin_BorrowRequest.php" style="background:#3b82f6; color:white; border-radius:8px;">Borrow <br/> Request</a>
      <a href="Admin_Syllabus.php">Syllabus</a>
      <a href="Admin_BookRequest.php">New <br/> Books <br/> Request</a>
      <a href="Admin_Contact.php">Feedbacks</a>
      <a href="Admin_UserAccount.php">User's <br/> Accounts</a>
    </nav>

    <div class="Borrow-request">
      <h1>Borrow Requests</h1>
      <p>Review and manage borrow requests from library users.</p>

      <!-- Show message -->
      <?php if (isset($message)) { ?>
        <div class="alert"><?php echo $message; ?></div>
      <?php } ?>

      <!-- Filter tabs -->
      <div class="filter-tabs">
        <a href="?filter=All" class="filter-tab <?php if ($filter == 'All') echo 'active'; ?>">All</a>
        <a href="?filter=Pending" class="filter-tab <?php if ($filter == 'Pending') echo 'active'; ?>">Pending</a>
        <a href="?filter=Approved" class="filter-tab <?php if ($filter == 'Approved') echo 'active'; ?>">Approved</a>
        <a href="?filter=Rejected" class="filter-tab <?php if ($filter == 'Rejected') echo 'active'; ?>">Rejected</a>
      </div>

      <?php if (mysqli_num_rows($result) > 0) { ?>
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

          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['Name']; ?></td>
              <td><?php echo $row['StudentID']; ?></td>
              <td><?php echo $row['Email']; ?></td>
              <td><?php echo $row['phone']; ?></td>
              <td><?php echo $row['BookName']; ?></td>
              <td><?php echo $row['ReturnDate']; ?></td>
              <td>
                <?php if ($row['Status'] == 'Pending') { ?>
                  <span class="status-pending">Pending</span>
                <?php } elseif ($row['Status'] == 'Approved') { ?>
                  <span class="status-approved">Approved</span>
                <?php } elseif ($row['Status'] == 'Rejected') { ?>
                  <span class="rejected-wrapper">
                    <span class="status-rejected">Rejected</span>
                    <?php if ($row['RejectReason'] != '') { ?>
                      <span class="tooltip-text"><?php echo $row['RejectReason']; ?></span>
                    <?php } ?>
                  </span>
                <?php } ?>
              </td>
              <td>
                <?php if ($row['Status'] == 'Pending') { ?>
                  <!-- Approve Form -->
                  <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="approve" class="btn btn-approve">Approve</button>
                  </form>

                  <!-- Reject Button -->
                  <button onclick="openModal(<?php echo $row['id']; ?>, '<?php echo $row['Name']; ?>')" class="btn btn-reject">Reject</button>
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
          <p>No borrow requests with status: <?php echo $filter; ?></p>
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

  <script>
    // Open modal
    function openModal(id, name) {
      document.getElementById('rejectId').value = id;
      document.getElementById('studentName').textContent = name;
      document.getElementById('rejectModal').classList.add('active');
    }

    // Close modal
    function closeModal() {
      document.getElementById('rejectModal').classList.remove('active');
      document.getElementById('rejectReason').value = '';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      if (event.target == document.getElementById('rejectModal')) {
        closeModal();
      }
    }

    // Auto hide message after 5 seconds
    setTimeout(function() {
      var alert = document.querySelector('.alert');
      if (alert) {
        alert.style.opacity = '0';
        alert.style.transition = 'opacity 0.5s';
        setTimeout(function() {
          alert.style.display = 'none';
        }, 500);
      }
    }, 5000);
  </script>

</body>

</html>

<?php
mysqli_close($conn);
?>