<!DOCTYPE html>
<html>

<head>
    <title>Request Books</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
        href="Assets/CSS/Navigation Bar.css">
    <link rel="stylesheet" type="text/css"
        href="Assets/CSS/RequestBook.css">

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
            <a href="RequestBook.php" class="nav-link active" id="Size">Request Books</a>

            <!-- Account Dropdown -->
            <div class="nav-item-dropdown">
                <a href="#" class="nav-link" id="Size">Account</a>
                <div class="dropdown-content">
                    <a href="Account.php">User Account</a>

                    <!-- ✅ Only show Admin if user is admin -->
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <a href="ADMIN/AdministratorArea.html">Admin</a>
                    <?php endif; ?>

                    <a href="PHP/login/auth/logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
                </div>
            </div>

            <a href="Contact.php" class="nav-link" id="Size">Contacts</a>

        </nav>
    </header>

    <!-- Body Part -->
    <h1 class="details">Request a new book</h1>
    <hr class="divider-light" />
    <p>Fill out the form below to request a new book to be added to the
        library.
        Our team will review your request and get back to you as soon as
        possible.</p>

    <!-- Form Part -->
    <section>
        <form action="PHP/requestbook.php" method="post">
            <div class="form-request">
                <label><i class="fa fa-user"></i> Full Name:</label>
                <input type="text" id="name" name="Name"
                    placeholder="Full Name">
            </div>
            <div class="form-request">
                <label><i class="fa fa-envelope"></i> Email:</label>
                <input type="email" id="email" name="Email"
                    placeholder="Email">
            </div>
            <div class="form-request">
                <label><i class="fa fa-book"></i> Book Title:</label>
                <input type="text" id="Book title" name="BookTitle"
                    placeholder="Book Title">
            </div>
            <div class="form-request">
                <label><i class="fa fa-user"></i> Author:</label>
                <input type="text" id="Author" name="Author"
                    placeholder="Author Name">
            </div>
            <div class="form-request">
                <label><i class="fa fa-pencil"></i> Reason for
                    Request:</label>
                <input type="text" id="reason" name="Reason"
                    placeholder="Enter the reason you would like this book added to the library...">
            </div>
            <button type="submit" name="submit" class="submit-btn">
                <i class="fa fa-paper-plane"></i> Submit Request
            </button>
        </form>

        <!-- Right Side Image -->
        <img src="Assets/Images/Request book.png" alt="Book" title="Book">
    </section>
</body>

</html>