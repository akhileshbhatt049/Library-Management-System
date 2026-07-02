function openModal(book, author, isbn) {
  // Pass book title, Author, and ISBN data to JS and Open modal with book details
  document.getElementById("BookName").value = book;
  document.getElementById("Author").value = author;
  document.getElementById("ISBN").value = isbn;
  document.getElementById("borrowModal").style.display = "block";
}

function closeModal() {
  // Close the modal when the close button is clicked
  document.getElementById("borrowModal").style.display = "none";
}

// Set the minimum date for the return date input to today's date
document.getElementById("ReturnDate").min = new Date()
  .toISOString()
  .split("T")[0];
