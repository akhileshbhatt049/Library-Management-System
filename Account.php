<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// ✅ Store admin status in a variable for later use
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

// Database connection
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
mysqli_select_db($conn, "Library_Management_System") or die("Failed to select database");

// Check if profile_picture column exists in Accounts table, if not add it
$checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM Accounts LIKE 'profile_picture'");
if (mysqli_num_rows($checkColumn) == 0) {
    $alterQuery = "ALTER TABLE Accounts ADD COLUMN profile_picture VARCHAR(255) DEFAULT NULL";
    mysqli_query($conn, $alterQuery) or die("Failed to add profile_picture column: " . mysqli_error($conn));
}

// Get user data from Accounts table
$user_id = $_SESSION['user_id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM Accounts WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    // User not found, redirect to login
    session_destroy();
    header("Location: index.php");
    exit();
}

$user = mysqli_fetch_assoc($result);

// Handle profile picture upload
$upload_message = "";
$upload_message_type = "";

if (isset($_POST['upload_picture'])) {
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/profile/";

        // Create folder if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = mime_content_type($_FILES['profile_picture']['tmp_name']);

        if (!in_array($file_type, $allowed_types)) {
            $upload_message = "Only JPG, PNG, GIF, and WEBP images are allowed.";
            $upload_message_type = "error";
        } else {
            // Generate unique filename
            $extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            $filename = "user_" . $user['id'] . "_" . time() . "." . $extension;
            $upload_file = $upload_dir . $filename;

            // Delete old profile picture if exists
            if (!empty($user['profile_picture']) && file_exists($user['profile_picture'])) {
                unlink($user['profile_picture']);
            }

            // Move uploaded file
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
                // Update database with new profile picture path
                $update_stmt = mysqli_prepare($conn, "UPDATE Accounts SET profile_picture = ? WHERE user_id = ?");
                mysqli_stmt_bind_param($update_stmt, "ss", $upload_file, $user_id);
                if (mysqli_stmt_execute($update_stmt)) {
                    $upload_message = "Profile picture updated successfully!";
                    $upload_message_type = "success";
                    // Refresh user data
                    $user['profile_picture'] = $upload_file;
                } else {
                    $upload_message = "Error updating database: " . mysqli_error($conn);
                    $upload_message_type = "error";
                }
                mysqli_stmt_close($update_stmt);
            } else {
                $upload_message = "Error uploading file.";
                $upload_message_type = "error";
            }
        }
    } else {
        $upload_message = "Please select a file to upload.";
        $upload_message_type = "error";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Navigation Bar.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Accounts.css">

    <style>

    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <header class="header">
        <div class="Logo-Name">
            <img src="Assets/Images/logo.png" alt="Library Logo">
            <span>Library Management System</span>
        </div>

        <nav class="nav">
            <a href="Home.html" class="nav-link" id="Size">Home</a>
            <a href="BorrowBooks.php" class="nav-link" id="Size">Borrow Books</a>
            <a href="Syllabus.php" class="nav-link" id="Size">Syllabus</a>
            <a href="RequestBook.php" class="nav-link" id="Size">Request Books</a>

            <!-- Account Dropdown -->
            <div class="nav-item-dropdown">
                <a href="#" class="nav-link active" id="Size">Account</a>
                <div class="dropdown-content">
                    <a href="Account.php">User Account</a>

                    <!-- ✅ Only show Admin if user is admin -->
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <a href="ADMIN/AdministratorArea.php">Admin</a>
                    <?php endif; ?>

                    <a href="PHP/login/auth/logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
                </div>
            </div>

            <a href="Contact.php" class="nav-link" id="Size">Contacts</a>

        </nav>
    </header>

    <!-- Body Content -->
    <main class="account-wrapper">
        <div class="account-container">
            <aside class="account-sidebar">
                <h2 class="sidebar-title">My Account</h2>
                <div class="sidebar-menu">
                    <a href="#" class="menu-item active">Account Details</a>
                    <a href="#" class="menu-item">Borrowed Books</a>
                    <a href="#" class="menu-item">Books Requests</a>
                </div>
            </aside>

            <section class="account-details-panel">
                <h3 class="panel-heading">Account Details</h3>

                <!-- Upload Message -->
                <?php if (!empty($upload_message)): ?>
                    <div class="alert-upload <?php echo $upload_message_type; ?>">
                        <?php echo $upload_message; ?>
                    </div>
                <?php endif; ?>

                <div class="details-content">
                    <div class="avatar-column">
                        <div class="avatar-frame">
                            <?php if (!empty($user['profile_picture']) && file_exists($user['profile_picture'])): ?>
                                <img src="<?php echo $user['profile_picture']; ?>" alt="Profile">
                            <?php else: ?>
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo $user['user_id']; ?>" alt="Profile">
                            <?php endif; ?>
                        </div>
                        <form method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 10px; align-items: center;">
                            <input type="file" name="profile_picture" accept="image/*" style="font-size: 12px;" required>
                            <button type="submit" name="upload_picture" class="btn-action upload-btn">
                                <i class="fa fa-upload"></i> Change Picture
                            </button>
                        </form>
                    </div>

                    <div class="form-column">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($user['fullname']); ?>" readonly>
                        </div>
                        <div class="input-field">
                            <label>Student ID</label>
                            <input type="text" value="<?php echo htmlspecialchars($user['user_id']); ?>" readonly>
                        </div>
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                        </div>
                        <div class="input-field">
                            <label>Phone</label>
                            <input type="text" value="<?php echo htmlspecialchars($user['phone']); ?>" readonly>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

</body>

</html>