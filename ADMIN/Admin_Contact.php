  <?php
  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
  $sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
  mysqli_query($conn, $sql) or die("Failed to create database");
  mysqli_select_db($conn, "Library_Management_System");

  // Handle Respond Action
  if (isset($_POST['respond'])) { // Check if the respond button is clicked
    $id = $_POST['id'];   // Get the ID of the message to respond to
    $response = mysqli_real_escape_string($conn, $_POST['response_message']); // Get the response message and escape special characters

    $query = "UPDATE Contacts SET Response = '$response', Status = 'Replied' WHERE id = $id"; // Update the response and status in the database

    if (mysqli_query($conn, $query)) {  // If the query is successful
      $message = "Response sent successfully!"; // Set a success message
      $message_type = "success";  // Set the message type to success
    } else {
      $message = "Error sending response: " . mysqli_error($conn);    // If the query fails, set an error message with the error details
      $message_type = "error";  // Set the message type to error
    }
  }

  // Filter
  $filter = isset($_GET['filter']) ? $_GET['filter'] : 'All'; // Get the filter value from the URL, default to 'All' if not set
  if ($filter == 'All') {   // If the filter is 'All', select all messages
    $result = mysqli_query($conn, "SELECT * FROM Contacts");  // Select all messages from the Contacts table
  } elseif ($filter == 'Replied') { // If the filter is 'Replied', select only messages with status 'Replied'
    $result = mysqli_query($conn, "SELECT * FROM Contacts WHERE Status = 'Replied'");   // Select messages with status 'Replied' from the Contacts table
  } elseif ($filter == 'Pending') { // If the filter is 'Pending', select only messages with status 'Pending'
    $result = mysqli_query($conn, "SELECT * FROM Contacts WHERE Status = 'Pending'"); // Select messages with status 'Pending' from the Contacts table
  } else {
    $result = mysqli_query($conn, "SELECT * FROM Contacts WHERE Status IS NULL OR Status = ''");  // Select messages with no status from the Contacts table
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
          <?php if (isset($message)): ?> <!-- If there is a message to display (success or error) -->
            <div class="alert alert-<?php echo $message_type; ?>"> <!-- Determine message style -->
              <?php echo $message; ?> <!-- Actual message display -->
            </div>
          <?php endif; ?>

          <!-- Filter Tabs -->
          <div class="filter-tabs">
            <a href="?filter=All" class="filter-tab <?php if ($filter == 'All') echo 'active'; ?>"> <!-- Filters all the messages -->
              All
            </a>
            <a href="?filter=Pending" class="filter-tab <?php if ($filter == 'Pending') echo 'active'; ?>"> <!-- Filters pending messages -->
              Pending
            </a>
            <a href="?filter=Replied" class="filter-tab <?php if ($filter == 'Replied') echo 'active'; ?>"> <!-- filters replied messages -->
              Replied
            </a>
          </div>

          <?php
          $row_count = mysqli_num_rows($result);  // Count how many rows will are in the database
          if ($row_count > 0):  // Check if there is atleast one row
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
                while ($row = mysqli_fetch_assoc($result)): // take every data from database row by row
                  $has_response = !empty($row['Response']); // Check if response column has value or not
                ?>
                  <tr>
                    <td><span class="sno"><?php echo $count; ?></span></td> <!-- display count values -->
                    <td><strong><?php echo htmlspecialchars($row['Name']); ?></strong></td> <!-- display name -->
                    <td><?php echo htmlspecialchars($row['Email']); ?></td> <!-- display email -->
                    <td><span class="message-text"><?php echo htmlspecialchars($row['Message']); ?></span></td> <!-- display message -->
                    <td>
                      <?php if ($has_response): ?> <!-- check if admin response to feedback -->
                        <span class="response-text">
                          <i class="fa fa-check-circle" style="color:#10b981;"></i>
                          <?php echo htmlspecialchars($row['Response']); ?> <!-- Display the response -->
                        </span>
                      <?php else: ?>
                        <span class="no-response">No response yet</span> <!-- Display if admin did not response to feedback -->
                      <?php endif; ?>
                    </td>
                    <td class="action-column">
                      <?php if (!$has_response): ?> <!-- Check if reponse doesn't exist -->
                        <!-- Respond Button -->
                        <button type="button" class="btn btn-respond" onclick="openModal( //open model after clicking on response button
                        <?php echo $row['id']; ?>,  // display ID by retrieving from database
                        '<?php echo htmlspecialchars($row['Name']); ?>',  // Display name by retrieving from database
                        '<?php echo htmlspecialchars($row['Email']); ?>',   // Display email bu retrieving from database
                        '<?php echo htmlspecialchars(addslashes($row['Message'])); ?>' // display message/response by retrieving from database
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

    <script src="Admin_Contact_Model.js"></script>

  </body>

  </html>

  <?php
  mysqli_close($conn);
  ?>