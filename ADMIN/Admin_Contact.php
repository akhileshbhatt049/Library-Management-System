<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Create Contacts table if it doesn't exist with proper structure
$createTable = "CREATE TABLE IF NOT EXISTS Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Message TEXT NOT NULL,
    Response TEXT,
    Status VARCHAR(50) DEFAULT 'Pending'
)";
mysqli_query($conn, $createTable) or die("Failed to create Contacts table: " . mysqli_error($conn));

// Check if Status column exists, if not add it
$checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM Contacts LIKE 'Status'");
if (mysqli_num_rows($checkColumn) == 0) {
  $alterQuery = "ALTER TABLE Contacts ADD COLUMN Status VARCHAR(50) DEFAULT 'Pending'";
  mysqli_query($conn, $alterQuery) or die("Failed to add Status column: " . mysqli_error($conn));
}

// Check if Response column exists, if not add it
$checkResponse = mysqli_query($conn, "SHOW COLUMNS FROM Contacts LIKE 'Response'");
if (mysqli_num_rows($checkResponse) == 0) {
  $alterResponse = "ALTER TABLE Contacts ADD COLUMN Response TEXT";
  mysqli_query($conn, $alterResponse) or die("Failed to add Response column: " . mysqli_error($conn));
}

// Handle Respond Action
if (isset($_POST['respond'])) {
  $id = intval($_POST['id']);
  $response = mysqli_real_escape_string($conn, $_POST['response_message']);

  // Use prepared statement for security
  $stmt = mysqli_prepare($conn, "UPDATE Contacts SET Response = ?, Status = 'Replied' WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "si", $response, $id);

  if (mysqli_stmt_execute($stmt)) {
    $message = "Response sent successfully!";
    $message_type = "success";
  } else {
    $message = "Error sending response: " . mysqli_error($conn);
    $message_type = "error";
  }
  mysqli_stmt_close($stmt);
}

// Filter with proper error handling
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';

// Use prepared statements for security
if ($filter == 'All') {
  $result = mysqli_query($conn, "SELECT * FROM Contacts ORDER BY id DESC");
} elseif ($filter == 'Replied') {
  $stmt = mysqli_prepare($conn, "SELECT * FROM Contacts WHERE Status = ? ORDER BY id DESC");
  mysqli_stmt_bind_param($stmt, "s", $filter);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
} elseif ($filter == 'Pending') {
  $stmt = mysqli_prepare($conn, "SELECT * FROM Contacts WHERE Status = ? ORDER BY id DESC");
  mysqli_stmt_bind_param($stmt, "s", $filter);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
} else {
  $result = mysqli_query($conn, "SELECT * FROM Contacts WHERE Status IS NULL OR Status = '' ORDER BY id DESC");
}

// Check if query was successful
if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedbacks - Library Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Contact.css" />
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
      <a href="Admin_BookRequest.php" id="NewBooksRequest">New <br> Books <br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks" style="background:#3b82f6; color:white; border-radius:8px;">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="UserAccounts">User's <br> Accounts</a>
    </nav>

    <div class="Main-content">
      <div class="Contact-us" id="Contact_Us">
        <h1>💬 Feedbacks</h1>
        <p>View and respond to messages from library users.</p>

        <!-- Display Message -->
        <?php if (isset($message)): ?>
          <div class="alert alert-<?php echo $message_type; ?>">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
          <a href="?filter=All" class="filter-tab <?php if ($filter == 'All') echo 'active'; ?>">
            All
          </a>
          <a href="?filter=Pending" class="filter-tab <?php if ($filter == 'Pending') echo 'active'; ?>">
            Pending
          </a>
          <a href="?filter=Replied" class="filter-tab <?php if ($filter == 'Replied') echo 'active'; ?>">
            Replied
          </a>
        </div>

        <?php
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0):
        ?>
          <div class="table-container">
            <table>
              <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Response</th>
                <th>Action</th>
              </tr>

              <?php
              $count = 1;
              while ($row = mysqli_fetch_assoc($result)):
                $has_response = !empty($row['Response']);
              ?>
                <tr>
                  <td><span class="sno"><?php echo $count; ?></span></td>
                  <td><strong><?php echo htmlspecialchars($row['Name']); ?></strong></td>
                  <td><?php echo htmlspecialchars($row['Email']); ?></td>
                  <td><span class="message-text"><?php echo htmlspecialchars($row['Message']); ?></span></td>
                  <td>
                    <?php if ($has_response): ?>
                      <span class="response-text">
                        <i class="fa fa-check-circle" style="color:#10b981;"></i>
                        <?php echo htmlspecialchars($row['Response']); ?>
                      </span>
                    <?php else: ?>
                      <span class="no-response">No response yet</span>
                    <?php endif; ?>
                  </td>
                  <td class="action-column">
                    <?php if (!$has_response): ?>
                      <button type="button" class="btn btn-respond" onclick="openModal(
                                                <?php echo $row['id']; ?>,
                                                '<?php echo htmlspecialchars(addslashes($row['Name'])); ?>',
                                                '<?php echo htmlspecialchars(addslashes($row['Email'])); ?>',
                                                '<?php echo htmlspecialchars(addslashes($row['Message'])); ?>'
                                            )">
                        <i class="fa fa-reply"></i> Respond
                      </button>
                    <?php else: ?>
                      <span class="btn-done">
                        <i class="fa fa-check-circle"></i> Replied
                      </span>
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
            <div class="icon">💬</div>
            <h3>No messages found</h3>
            <p>There are no messages with status: <?php echo htmlspecialchars($filter); ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Respond Modal -->
  <div id="respondModal" class="modal">
    <div class="modal-content">
      <h3><i class="fa fa-reply" style="color:#3b82f6;"></i> Respond to Message</h3>

      <div class="user-info">
        <div><span class="label">From:</span> <strong id="userNameDisplay"></strong></div>
        <div><span class="label">Email:</span> <strong id="userEmailDisplay"></strong></div>
        <div style="margin-top:8px; padding-top:8px; border-top:1px solid #e5e7eb;">
          <span class="label">Message:</span><br>
          <span id="userMessageDisplay" style="color:#1f2937;"></span>
        </div>
      </div>

      <form method="POST" id="respondForm">
        <input type="hidden" name="id" id="respondId">
        <label style="font-weight:600; color:#374151; font-size:14px;">Your Response:</label>
        <textarea name="response_message" id="responseMessage" placeholder="Type your response here..." required></textarea>

        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
          <button type="submit" name="respond" class="btn-send">
            <i class="fa fa-send"></i> Send Response
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="Admin JS/Admin_Contact_Model.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>