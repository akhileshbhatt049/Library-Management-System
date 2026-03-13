// Get modal element
var modal = document.getElementById('borrowModal');

// Set minimum date for return date (today)
var today = new Date().toISOString().split('T')[0];
document.getElementById('ReturnDate').setAttribute('min', today);

// Function to open modal with selected book
function openModal(bookName) {
    document.getElementById('BookName').value = bookName;
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

// Function to close modal
function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto'; // Restore scrolling
    document.getElementById('borrowForm').reset(); // Reset form
    
    // Clear all error messages when closing
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(error => error.remove());
    
    // Reset border colors
    const inputs = document.querySelectorAll('#borrowForm input');
    inputs.forEach(input => {
        input.style.borderColor = '#e0e0e0';
    });
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target == modal) {
        closeModal();
    }
}

// Add keyboard support (ESC to close)
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && modal.style.display === 'block') {
        closeModal();
    }
});
