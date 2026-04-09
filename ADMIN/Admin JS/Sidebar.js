
document.addEventListener("DOMContentLoaded", function () {

    // ===== Links =====
    const ManageBookslink = document.getElementById("ManageBooks");
    const BorrowRequestlink = document.getElementById("BorrowRequest");
    const Syllabuslink = document.getElementById("Syllabus");
    const NewBooksRequestlink = document.getElementById("NewBooksRequest");
    const Feedbackslink = document.getElementById("Feedbacks");
    const UserAccountslink = document.getElementById("UserAccounts");

    // ===== Sections =====
    const Manage_BooksDash = document.getElementById("Manage_Books");
    const Borrow_RequestDash = document.getElementById("Borrow_Request");
    const Syllabus_formDash = document.getElementById("Syllabusform");
    const Books_RequestDash = document.getElementById("Books_Request");
    const Contact_UsDash = document.getElementById("Contact_Us");
    const User_AccountsDash = document.getElementById("User_Accounts");

    // ===== Hide All Function =====
    function hideAll() {
        Manage_BooksDash.style.display = "none";
        Borrow_RequestDash.style.display = "none";
        Syllabus_formDash.style.display = "none";
        Books_RequestDash.style.display = "none";
        Contact_UsDash.style.display = "none";
        User_AccountsDash.style.display = "none";
    }

    // ===== Show Section Function =====
    function showSection(section) {
        hideAll();

        if (section === "ManageBooks") {
            Manage_BooksDash.style.display = "block";
        } else if (section === "BorrowRequest") {
            Borrow_RequestDash.style.display = "block";
        } else if (section === "Syllabus") {
            Syllabus_formDash.style.display = "block";
        } else if (section === "NewBooksRequest") {
            Books_RequestDash.style.display = "block";
        } else if (section === "Feedbacks") {
            Contact_UsDash.style.display = "block";
        } else if (section === "UserAccounts") {
            User_AccountsDash.style.display = "block";
        } else {
            // Default
            Manage_BooksDash.style.display = "block";
        }
    }

    // ===== Handle URL (IMPORTANT PART) =====
    const params = new URLSearchParams(window.location.search);
    const sectionFromURL = params.get("section");

    showSection(sectionFromURL); // auto open correct section

    // ===== Click Events =====
    ManageBookslink.addEventListener("click", function () {
        showSection("ManageBooks");
    });

    BorrowRequestlink.addEventListener("click", function () {
        showSection("BorrowRequest");
    });

    Syllabuslink.addEventListener("click", function () {
        showSection("Syllabus");
    });

    NewBooksRequestlink.addEventListener("click", function () {
        showSection("NewBooksRequest");
    });

    Feedbackslink.addEventListener("click", function () {
        showSection("Feedbacks");
    });

    UserAccountslink.addEventListener("click", function () {
        showSection("UserAccounts");
    });

});