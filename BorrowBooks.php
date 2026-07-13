<!-- Made connection to database -->
<?php
$conn = mysqli_connect("localhost", "root", "") or die("Failed to connect database");
$sql = "CREATE DATABASE IF NOT EXISTS Library_Management_System";
mysqli_query($conn, $sql) or die("Failed to create database");

mysqli_select_db($conn, "Library_Management_System");$books = mysqli_query($conn, "SELECT * FROM ManageBooksAdmin");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Borrow Books</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Navigation Bar.css">
    <link rel="stylesheet" type="text/css" href="Assets/CSS/Borrow Books.css">
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
            <a href="Contact.html" class="nav-link" id="Size">Contacts</a>
            <a href="Account.html" class="nav-link" id="Size">Account</a>
            <a href="ADMIN/AdministratorArea.html" class="nav-link" id="Size">Admin</a>

        </nav>
    </header>

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
                <?php if (mysqli_num_rows($books) > 0): ?> <!-- Checking if there are any books available in the database -->
                    <?php while ($book = mysqli_fetch_assoc($books)): ?> <!-- Get a book at a time from database and a row for each book -->
                        <tr>
                            <td class="book-title"><?php echo $book['BookTitle']; ?></td> <!-- Display the book title -->
                            <td>
                                <button class="borrow-btn" onclick="openModal('<?php echo $book['BookTitle']; ?>','<?php echo $book['Author']; ?>','<?php echo $book['ISBN']; ?>')"> <!-- Pass book title, Author, and ISBN data to JS and Open modal with book details -->
                                    <i class="fa fa-book"></i> Borrow
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?> <!-- End of while loop -->
                <?php else: ?> <!-- If no books are available, display a message -->
                    <tr>
                        <td colspan="2">
                            <div class="no-books">
                                <i class="fa fa-book"></i>
                                No books available.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?> <!-- End of if statement -->
            </tbody>
        </table>
    </div>

    <!-- Popup Screen to display book borrowing details -->
    <div id="borrowModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fa fa-book"></i> Borrow Book</h2>
                <span class="close-btn" onclick="closeModal()">&times;</span> <!-- Close button to close the modal -->
            </div>

            <!-- Form to collect user details for borrowing the book -->
            <form action="PHP/Borrowbooks.php" method="post" class="borrow-form">
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
    <script src="Assets/JS/Borrow_Books.js"></script> <!-- JS file to handle modal open and close functionality -->
</body>

</html>

<?php mysqli_close($conn); ?> <!-- Close the database connection -->