# Library Management System

A web-based Library Management System developed to simplify and manage library operations, including book browsing, borrowing requests, syllabus management, and administrative activities.

## About the Project

The Library Management System is designed to provide an organized platform for managing library resources and handling basic library operations.

Users can explore available books, browse syllabus information, and submit book requests. Administrators can manage library content and oversee different operations through the admin panel.

This project was developed as part of my learning journey in web development, applying frontend and backend technologies to build a functional web application.

## Technologies Used

- **HTML5** – Structure and content of web pages.
- **CSS3** – Styling and responsive layouts.
- **JavaScript** – Client-side functionality and form validation.
- **PHP** – Backend development and server-side processing.
- **MySQL** – Database management.

## Features

- **Home Page** – Provides an overview of the library system.
- **Borrow Books** – Allows users to explore and request books.
- **Syllabus Management** – Provides access to academic syllabus information.
- **Book Request** – Allows users to submit book requests.
- **Contact Page** – Includes a contact form with validation.
- **Admin Panel** – Provides administrative functionality for managing library operations.
- **Form Validation** – Validates user inputs to improve data accuracy.

## Project Structure

```text
## Project Structure

```text
Library-Management-System/
│
├── ADMIN/
│   │
│   ├── Admin CSS/
│   │   ├── AdminIndexNavBar.css
│   │   ├── Admin_BookRequest.css
│   │   ├── Admin_BorrowRequest.css
│   │   ├── Admin_Contact.css
│   │   ├── Admin_Dashboard.css
│   │   ├── Admin_Data_Nav.css
│   │   ├── Admin_ManageBooks.css
│   │   ├── Admin_Syllabus.css
│   │   └── Admin_UserAccount.css
│   │
│   ├── Admin JS/
│   │   ├── Admin_BookRequest_Model.js
│   │   ├── Admin_BorrowRequest_Model.js
│   │   ├── Admin_Contact_Model.js
│   │   └── Other admin JavaScript files
│   │
│   └── Admin PHP/
│       ├── AdminSyllabus.php
│       ├── ManageBooks.php
│       ├── Admin_BookRequest.php
│       ├── Admin_BorrowRequest.php
│       ├── Admin_Contact.php
│       ├── Admin_ManageBooks.php
│       ├── Admin_Syllabus.php
│       ├── Admin_UserAccount.php
│       └── AdministratorArea.php
│
├── Assets/                 # Images and other resources
│
├── PHP/                    # Backend PHP files
│
├── Account.php             # Account management
├── BorrowBooks.php         # Book borrowing page
├── Contact.html            # Contact page
├── Home.html               # Homepage
├── RequestBook.html        # Book request page
├── Syllabus.php            # Syllabus page
├── create_admin.php        # Admin account creation
├── index.php               # Main entry point
│
└── README.md               # Project documentation

```

## Installation & Setup

Follow these steps to run the project locally.

### Prerequisites

- XAMPP
- PHP
- MySQL
- Web browser

### Steps

1. Clone the repository:

   ```bash
   git clone https://github.com/akhileshbhatt049/Library-Management-System.git
   ```

2. Move the project folder into the XAMPP `htdocs` directory.

3. Start Apache and MySQL from the XAMPP Control Panel.

4. Configure the database connection according to your local MySQL setup.

5. If a database SQL file is available, import it through phpMyAdmin.

6. Open the project in your browser:

   ```text
   http://localhost/Library-Management-System/
   ```

## Project Repository

[View Source Code on GitHub](https://github.com/akhileshbhatt049/Library-Management-System)

## Author

**Akhilesh Bhatt**

GitHub: [@akhileshbhatt049](https://github.com/akhileshbhatt049)

---

This project represents my practical experience with PHP, MySQL, and frontend web development.

Thank you for visiting this repository!
