<?php
session_start();

// Connect to the database
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");
mysqli_select_db($conn, "Library_Management_System");

// Create the BorrowBook table if it doesn't exist
$CreateTable = "CREATE TABLE IF NOT EXISTS BorrowBook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    BookName VARCHAR(150),
    Author VARCHAR(150),
    ISBN VARCHAR(50),
    Name VARCHAR(150),
    StudentID VARCHAR(50),
    Email varchar(70),
    phone VARCHAR(10),
    ReturnDate TEXT,
    Status VARCHAR(20) DEFAULT 'Pending',
    RejectReason TEXT NULL
)";
mysqli_query($conn, $CreateTable) or die("Failed to create table: " . mysqli_error($conn));

// Handle form submission
$message = "";
$message_type = "";

if (isset($_POST['submit'])) {
    $BookName = mysqli_real_escape_string($conn, $_POST["BookName"]);
    $Author = mysqli_real_escape_string($conn, $_POST["Author"]);
    $ISBN = mysqli_real_escape_string($conn, $_POST["ISBN"]);
    $Name = mysqli_real_escape_string($conn, $_POST["Name"]);
    $StudentID = mysqli_real_escape_string($conn, $_POST['StudentID']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Phone = mysqli_real_escape_string($conn, $_POST['Phone']);
    $ReturnDate = mysqli_real_escape_string($conn, $_POST['ReturnDate']);

    // Insert using prepared statement for security
    $stmt = mysqli_prepare($conn, "INSERT INTO BorrowBook (BookName, Author, ISBN, Name, StudentID, Email, phone, ReturnDate, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
    mysqli_stmt_bind_param($stmt, "ssssssss", $BookName, $Author, $ISBN, $Name, $StudentID, $Email, $Phone, $ReturnDate);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Book borrowed successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . mysqli_error($conn);
        $message_type = "error";
    }
    mysqli_stmt_close($stmt);
}

// Fetch available books
$books_result = mysqli_query($conn, "SELECT * FROM ManageBooksAdmin");

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Borrow Books</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Navigation Bar.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Borrow Books.css">

    <style>
        .alert-message {
            max-width: 800px;
            margin: 15px auto;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            display: none;
        }

        .alert-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }

        .alert-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }
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
            <a href="BorrowBooks.php" class="nav-link active" id="Size">Borrow Books</a>
            <a href="Syllabus.php" class="nav-link" id="Size">Syllabus</a>
            <a href="RequestBook.html" class="nav-link" id="Size">Request Books</a>
            <a href="Account.php" class="nav-link" id="Size">Account</a>
            <a href="Contact.html" class="nav-link" id="Size">Contacts</a>
        </nav>
    </header>

    <!-- Display Message -->
    <?php if (!empty($message)): ?>
        <div class="alert-message <?php echo $message_type; ?>">
            <i class="fa <?php echo ($message_type == 'success') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Display available books for borrowing with two columns -->
    <div class="books-table">
        <table>
            <thead>
                <tr>
                    <th>Book Names</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($books_result) > 0): ?>
                    <?php while ($book = mysqli_fetch_assoc($books_result)): ?>
                        <tr>
                            <td class="book-title"><?php echo htmlspecialchars($book['BookTitle']); ?></td>
                            <td>
                                <button class="borrow-btn" onclick="openModal('<?php echo htmlspecialchars($book['BookTitle']); ?>','<?php echo htmlspecialchars($book['Author']); ?>','<?php echo htmlspecialchars($book['ISBN']); ?>')">
                                    <i class="fa fa-book"></i> Borrow
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">
                            <div class="no-books">
                                <i class="fa fa-book"></i>
                                No books available.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Popup Screen to display book borrowing details -->
    <div id="borrowModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fa fa-book"></i> Borrow Book</h2>
                <span class="close-btn" onclick="closeModal()">&times;</span>
            </div>

            <!-- Form submits to the same page -->
            <form action="" method="post" class="borrow-form">
                <div class="form-group">
                    <label><i class="fa fa-book"></i> Book Name:</label>
                    <input type="text" id="BookName" name="BookName" readonly required>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-user"></i> Author:</label>
                    <input type="text" id="Author" name="Author" readonly required>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-barcode"></i> ISBN:</label>
                    <input type="text" id="ISBN" name="ISBN" readonly required>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-user"></i> Full Name:</label>
                    <input type="text" id="Name" name="Name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-id-card"></i> Student ID:</label>
                    <input type="text" id="StudentID" name="StudentID" placeholder="e.g., STU2024001" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fa fa-envelope"></i> Email:</label>
                        <input type="email" id="Email" name="Email" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fa fa-phone"></i> Phone:</label>
                        <input type="tel" id="Phone" name="Phone" placeholder="10 digit number" pattern="[0-9]{10}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-calendar"></i> Return Date:</label>
                    <input type="date" id="ReturnDate" name="ReturnDate" required>
                </div>

                <button type="submit" name="submit" class="submit-btn">
                    <i class="fa fa-check-circle"></i> Submit
                </button>
            </form>
        </div>
    </div>

    <script src="Assets/JS/Borrow_Books.js"></script>

    <script>
        // Auto-hide alert after 5 seconds on success
        setTimeout(function() {
            const alert = document.querySelector('.alert-message.success');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            }
        }, 5000);
    </script>
</body>

</html>