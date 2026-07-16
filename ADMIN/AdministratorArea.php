<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>

<!doctype html>
<html>

    <head>
        <title>Administrator Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="Admin CSS/Admin_Dashboard.css" />
    </head>

    <body>
        <!-- Header section with logo and navigation links -->
        <header>
            <section class="Main-name">
                <img src="../Assets/Images/logo.png" class="header-logo"
                    alt="Library Logo" />
                <span> Library Management System</span>
            </section>
            <nav>
                <a href="AdministratorArea.html" class="active">Dashboard</a>
                <a href="Admin_ManageBooks.php">Manage Books</a>
                <a href="Admin_BorrowRequest.php">Borrow Request</a>
                <a href="Admin_Syllabus.php">Syllabus</a>
                <a href="Admin_BookRequest.php">New Books Request</a>
                <a href="Admin_Contact.php">Feedbacks</a>
                <a href="Admin_UserAccount.php">User Accounts</a>
            </nav>
        </header>

        <!-- Body Part -->
        <section class="dashboard-header">
            <h1><i class="fa fa-dashboard"></i> Administrator Dashboard</h1>
            <p>Manage all library operations efficiently from here.</p>
        </section>

        <!-- Dashboard buttons for different administrative tasks -->
        <div class="container">
            <a href="Admin_ManageBooks.php">
                <button>
                    <div class="icon-wrapper">
                        <i class="fa fa-book"></i>
                    </div>
                    <b>Manage Books</b>
                    <p>Upload, edit, or remove books</p>
                </button>
            </a>

            <a href="Admin_BorrowRequest.php">
                <button>
                    <div class="icon-wrapper">
                        <i class="fa fa-handshake-o"></i>
                    </div>
                    <b>Borrow Request</b>
                    <p>Approve/disapprove borrow requests</p>
                </button>
            </a>

            <a href="Admin_Syllabus.php">
                <button>
                    <div class="icon-wrapper">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <b>Manage Syllabus</b>
                    <p>Upload and manage academic syllabus</p>
                </button>
            </a>

            <a href="Admin_BookRequest.php">
                <button>
                    <div class="icon-wrapper">
                        <i class="fa fa-plus-circle"></i>
                    </div>
                    <b>Book Requests</b>
                    <p>Review and respond to book requests</p>
                </button>
            </a>

            <a href="Admin_Contact.php">
                <button>
                    <div class="icon-wrapper">
                        <i class="fa fa-comments"></i>
                    </div>
                    <b>Feedbacks</b>
                    <p>View and respond to student feedback</p>
                </button>
            </a>

            <a href="Admin_UserAccount.php">
                <button>
                    <div class="icon-wrapper">
                        <i class="fa fa-users"></i>
                    </div>
                    <b>User Accounts</b>
                    <p>Manage library user accounts</p>
                </button>
            </a>
        </div>
    </body>
</html>