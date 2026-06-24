document.addEventListener("DOMContentLoaded", function () {
    const ManageBookslink = document.getElementById("ManageBooks");
    const BorrowRequestlink = document.getElementById("BorrowRequest");
    const Syllabuslink = document.getElementById("Syllabus");
    const NewBooksRequestlink = document.getElementById("NewBooksRequest");
    const Feedbackslink = document.getElementById("Feedbacks");
    const UserAccountslink = document.getElementById("UserAccounts");

    const Manage_BooksDash = document.getElementById("Manage_Books");
    const Borrow_RequestDash = document.getElementById("Borrow_Request");
    const Syllabus_formDash = document.getElementById("Syllabusform");
    const Books_RequestDash = document.getElementById("Books_Request");
    const Contact_UsDash = document.getElementById("Contact_Us");
    const User_AccountsDash = document.getElementById("User_Accounts");

    let arrDash = [Manage_BooksDash, Borrow_RequestDash, Syllabus_formDash, Books_RequestDash, Contact_UsDash, User_AccountsDash];

    let arrLink = [ManageBookslink, BorrowRequestlink, Syllabuslink, NewBooksRequestlink, Feedbackslink, UserAccountslink];

    function hideall() {
        arrDash.forEach(dash => {
            dash.style.display = "none";
        })
    }

    //Hide all at first
    hideall();
    arrDash[0].style.display = "block";

    arrLink.forEach((link, index) => {
        link.addEventListener("click", function () {
            hideall();
            arrDash[index].style.display = "block";
        });
    });
});
   
//     Manage_BooksDash.style.display = "block";
    
//     ManageBookslink.addEventListener("click", function () {
//         Manage_BooksDash.style.display = "block";
//         Borrow_RequestDash.style.display = "none";
//         Syllabus_formDash.style.display = "none";
//         Books_RequestDash.style.display = "none";
//         Contact_UsDash.style.display = "none";
//         User_AccountsDash.style.display = "none";
//     });
    
//     BorrowRequestlink.addEventListener("click", function () {
//         Borrow_RequestDash.style.display = "block";
//         Manage_BooksDash.style.display = "none";
//         Syllabus_formDash.style.display = "none";
//         Books_RequestDash.style.display = "none";
//         Contact_UsDash.style.display = "none";
//         User_AccountsDash.style.display = "none";
//     });
    
//     Syllabuslink.addEventListener("click", function () {
//         Syllabus_formDash.style.display = "block";
//         Manage_BooksDash.style.display = "none";
//         Borrow_RequestDash.style.display = "none";
//         Books_RequestDash.style.display = "none";
//         Contact_UsDash.style.display = "none";
//         User_AccountsDash.style.display = "none";
//     });
    
//     NewBooksRequestlink.addEventListener("click", function () {
//         Books_RequestDash.style.display = "block";
//         Manage_BooksDash.style.display = "none";
//         Borrow_RequestDash.style.display = "none";
//         Syllabus_formDash.style.display = "none";
//         Contact_UsDash.style.display = "none";
//         User_AccountsDash.style.display = "none";
//     });
    
//     Feedbackslink.addEventListener("click", function () {
//         Contact_UsDash.style.display = "block";
//         Manage_BooksDash.style.display = "none";
//         Borrow_RequestDash.style.display = "none";
//         Syllabus_formDash.style.display = "none";
//         Books_RequestDash.style.display = "none";
//         User_AccountsDash.style.display = "none";
//     }); 
    
//     UserAccountslink.addEventListener("click", function () {
//         User_AccountsDash.style.display = "block";
//         Manage_BooksDash.style.display = "none";
//         Borrow_RequestDash.style.display = "none";
//         Syllabus_formDash.style.display = "none";
//         Books_RequestDash.style.display = "none";
//         Contact_UsDash.style.display = "none";
//     });
// });