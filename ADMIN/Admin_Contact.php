<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedbacks - Library Management System</title>
  <link rel="stylesheet" href="../ADMIN/Admin CSS/Admin_Data_Nav.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

  <?php
  // Database connection
  $conn = mysqli_connect("localhost", "root", "", "Library_Management_System");

  // Handle Respond Action
  if (isset($_POST['respond'])) {
      $id = $_POST['id'];
      $response = mysqli_real_escape_string($conn, $_POST['response_message']);
      
      $query = "UPDATE Contacts SET Response = '$response', Status = 'Replied' WHERE id = $id";
      
      if (mysqli_query($conn, $query)) {
          $message = "Response sent successfully!";
          $message_type = "success";
      } else {
          $message = "Error sending response: " . mysqli_error($conn);
          $message_type = "error";
      }
  }

  // Filter
  $filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';
  if ($filter == 'All') {
      $result = mysqli_query($conn, "SELECT * FROM Contacts ORDER BY id DESC");
  } elseif ($filter == 'Replied') {
      $result = mysqli_query($conn, "SELECT * FROM Contacts WHERE Status = 'Replied' ORDER BY id DESC");
  } else {
      $result = mysqli_query($conn, "SELECT * FROM Contacts WHERE Status IS NULL OR Status = '' ORDER BY id DESC");
  }
  ?>

  <style>
    /* General Styles */
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
    }

    .Main-content {
      flex: 1;
      padding: 20px;
    }

    /* Contact-us Container */
    .Contact-us {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      max-width: 100%;
    }

    .Contact-us h1 {
      color: #1f2937;
      font-size: 24px;
      margin-top: 0;
      margin-bottom: 5px;
    }

    .Contact-us p {
      color: #6b7280;
      margin-top: 0;
      margin-bottom: 25px;
    }

    /* Alert Message */
    .alert {
      padding: 12px 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      animation: slideDown 0.3s ease;
    }

    .alert-success {
      background: #d1fae5;
      color: #065f46;
      border-left: 4px solid #10b981;
    }

    .alert-error {
      background: #fee2e2;
      color: #991b1b;
      border-left: 4px solid #ef4444;
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

    /* Filter Tabs */
    .filter-tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .filter-tab {
      padding: 8px 20px;
      background: #f3f4f6;
      border-radius: 8px;
      text-decoration: none;
      color: #374151;
      font-weight: 500;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .filter-tab:hover {
      background: #e5e7eb;
      transform: translateY(-2px);
    }

    .filter-tab.active {
      background: #3b82f6;
      color: white;
      border-color: #3b82f6;
    }

    .filter-tab .count {
      background: rgba(0,0,0,0.1);
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 12px;
      margin-left: 5px;
    }

    .filter-tab.active .count {
      background: rgba(255,255,255,0.2);
    }

    /* Table Styles */
    .table-container {
      overflow-x: auto;
      border-radius: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    table th {
      background: #1e293b;
      color: white;
      padding: 14px 12px;
      text-align: center;
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    table td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #f1f5f9;
      font-size: 14px;
      color: #334155;
    }

    table tr {
      transition: all 0.3s ease;
    }

    table tr:hover {
      background: #f8fafc;
      transform: scale(1.002);
    }

    table tr:last-child td {
      border-bottom: none;
    }

    /* S.No. styling */
    .sno {
      font-weight: 700;
      color: #3b82f6;
    }

    /* Message styling */
    .message-text {
      max-width: 250px;
      display: inline-block;
      text-align: left;
      word-wrap: break-word;
    }

    /* Response styling */
    .response-text {
      max-width: 250px;
      display: inline-block;
      text-align: left;
      word-wrap: break-word;
      color: #065f46;
    }

    .response-text i {
      margin-right: 5px;
    }

    /* No response yet */
    .no-response {
      color: #94a3b8;
      font-size: 13px;
      font-style: italic;
    }

    /* Status Badge */
    .status-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-replied {
      background: #d1fae5;
      color: #065f46;
    }

    .status-pending {
      background: #fef3c7;
      color: #92400e;
    }

    /* Buttons */
    .btn {
      padding: 6px 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 13px;
      font-weight: 500;
      transition: all 0.3s ease;
      margin: 2px 4px;
    }

    .btn-respond {
      background: #3b82f6;
      color: white;
    }
    
    .btn-respond:hover {
      background: #2563eb;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-respond i {
      margin-right: 5px;
    }

    .btn-done {
      color: #6b7280;
      font-size: 13px;
    }

    .btn-done i {
      margin-right: 5px;
      color: #10b981;
    }

    .action-column {
      min-width: 120px;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }

    .modal.active {
      display: flex;
    }

    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 12px;
      max-width: 500px;
      width: 90%;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
      from {
        transform: translateY(-30px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .modal-content h3 {
      margin-top: 0;
      color: #1f2937;
    }

    .modal-content .user-info {
      background: #f8fafc;
      padding: 12px 15px;
      border-radius: 8px;
      margin: 10px 0 15px 0;
      border-left: 4px solid #3b82f6;
    }

    .modal-content .user-info strong {
      color: #1f2937;
    }

    .modal-content .user-info .label {
      color: #6b7280;
      font-size: 13px;
    }

    .modal-content textarea {
      width: 100%;
      padding: 10px;
      border: 2px solid #e5e7eb;
      border-radius: 6px;
      margin: 10px 0;
      min-height: 100px;
      resize: vertical;
      font-family: inherit;
      font-size: 14px;
    }

    .modal-content textarea:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .modal-actions {
      display: flex;
      gap: 10px;
      justify-content: flex-end;
      margin-top: 15px;
    }

    .modal-actions button {
      padding: 8px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .modal-actions .btn-send {
      background: #3b82f6;
      color: white;
    }

    .modal-actions .btn-send:hover {
      background: #2563eb;
    }

    .modal-actions .btn-cancel {
      background: #e5e7eb;
      color: #374151;
    }

    .modal-actions .btn-cancel:hover {
      background: #d1d5db;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #6b7280;
    }

    .empty-state .icon {
      font-size: 48px;
      margin-bottom: 10px;
    }

    .empty-state h3 {
      color: #1f2937;
      margin-bottom: 5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .Contact-us {
        padding: 15px;
      }

      table {
        font-size: 12px;
      }
      
      table th,
      table td {
        padding: 8px 6px;
      }
      
      .filter-tabs {
        gap: 5px;
      }
      
      .filter-tab {
        padding: 6px 12px;
        font-size: 12px;
      }

      .action-column {
        min-width: 100px;
      }

      .message-text,
      .response-text {
        max-width: 150px;
      }
    }

    @media (max-width: 480px) {
      table {
        font-size: 11px;
      }
      
      table th,
      table td {
        padding: 6px 4px;
      }

      .btn {
        padding: 4px 10px;
        font-size: 11px;
      }

      .modal-content {
        padding: 20px;
      }
    }

    /* Scrollbar */
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
      <a href="Admin_BookRequest.php" id="NewBooksRequest">New <br> Books <br> Request</a>
      <a href="Admin_Contact.php" id="Feedbacks" style="background:#3b82f6; color:white; border-radius:8px;">Feedbacks</a>
      <a href="Admin_UserAccount.php" id="Feedbacks">User's <br> Accounts</a>
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
          <a href="?filter=All" class="filter-tab <?php if($filter=='All') echo 'active'; ?>">
            All
          </a>
          <a href="?filter=Pending" class="filter-tab <?php if($filter=='Pending') echo 'active'; ?>">
            Pending
          </a>
          <a href="?filter=Replied" class="filter-tab <?php if($filter=='Replied') echo 'active'; ?>">
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
                <th>#</th>
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
                      <!-- Respond Button -->
                      <button type="button" class="btn btn-respond" onclick="openModal(
                        <?php echo $row['id']; ?>, 
                        '<?php echo htmlspecialchars($row['Name']); ?>', 
                        '<?php echo htmlspecialchars($row['Email']); ?>', 
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

  <script>
    // Open Respond Modal
    function openModal(id, name, email, message) {
      document.getElementById('respondId').value = id;
      document.getElementById('userNameDisplay').textContent = name;
      document.getElementById('userEmailDisplay').textContent = email;
      document.getElementById('userMessageDisplay').textContent = message;
      document.getElementById('responseMessage').value = '';
      document.getElementById('respondModal').classList.add('active');
    }

    // Close Respond Modal
    function closeModal() {
      document.getElementById('respondModal').classList.remove('active');
      document.getElementById('responseMessage').value = '';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modal = document.getElementById('respondModal');
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