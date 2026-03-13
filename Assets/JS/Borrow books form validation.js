// Form Validation Script

// Get the form element
const borrowForm = document.getElementById('borrowForm');

// Validation functions
function validateName(name) {
    // Only alphabets and spaces allowed
    const nameRegex = /^[A-Za-z\s]+$/;
    return nameRegex.test(name);
}

function validateEmail(email) {
    // Email should not start with numbers or symbols, must end with "@gmail.com"
    const emailRegex = /^[A-Za-z][A-Za-z0-9._]*@gmail\.com$/;
    return emailRegex.test(email);
}

function validatePhone(phone) {
    // Phone should start with 98 and have exactly 10 digits
    const phoneRegex = /^98[0-9]{8}$/;
    return phoneRegex.test(phone);
}

function validateStudentID(studentID) {
    // Student ID should not contain any special symbols or spaces
    const studentIDRegex = /^[A-Za-z0-9]+$/;
    return studentIDRegex.test(studentID);
}

// Error message display function
function showError(inputElement, message) {
    // Remove any existing error message
    const existingError = inputElement.parentElement.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Create and insert error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.color = '#ff5961';
    errorDiv.style.fontSize = '14px';
    errorDiv.style.marginTop = '5px';
    errorDiv.style.marginLeft = '32px';
    errorDiv.textContent = message;
    
    inputElement.parentElement.appendChild(errorDiv);
    
    // Highlight input field
    inputElement.style.borderColor = '#ff5961';
}

// Clear error function
function clearError(inputElement) {
    const error = inputElement.parentElement.querySelector('.error-message');
    if (error) {
        error.remove();
    }
    inputElement.style.borderColor = '#e0e0e0';
}

// Main validation function
function validateForm(event) {
    event.preventDefault();
    
    // Get form values
    const name = document.getElementById('Name');
    const email = document.getElementById('Email');
    const phone = document.getElementById('Phone');
    const studentID = document.getElementById('StudentID');
    const bookName = document.getElementById('BookName');
    const returnDate = document.getElementById('ReturnDate');
    
    let isValid = true;
    
    // Clear all previous errors
    [name, email, phone, studentID, bookName, returnDate].forEach(field => {
        if (field) clearError(field);
    });
    
    // Validate Name
    if (!name.value.trim()) {
        showError(name, 'Name is required');
        isValid = false;
    } else if (!validateName(name.value.trim())) {
        showError(name, 'Name should only contain alphabets and spaces');
        isValid = false;
    }
    
    // Validate Email
    if (!email.value.trim()) {
        showError(email, 'Email is required');
        isValid = false;
    } else if (!validateEmail(email.value.trim())) {
        showError(email, 'Email must start with a letter and end with @gmail.com');
        isValid = false;
    }
    
    // Validate Phone
    if (!phone.value.trim()) {
        showError(phone, 'Phone number is required');
        isValid = false;
    } else if (!validatePhone(phone.value.trim())) {
        showError(phone, 'Phone number must start with 98 and have exactly 10 digits');
        isValid = false;
    }
    
    // Validate Student ID
    if (!studentID.value.trim()) {
        showError(studentID, 'Student ID is required');
        isValid = false;
    } else if (!validateStudentID(studentID.value.trim())) {
        showError(studentID, 'Student ID should not contain special symbols or spaces');
        isValid = false;
    }
    
    // Validate Book Name
    if (!bookName.value.trim()) {
        showError(bookName, 'Please select a book first');
        isValid = false;
    }
    
    // Validate Return Date
    if (!returnDate.value) {
        showError(returnDate, 'Return date is required');
        isValid = false;
    } else {
        const selectedDate = new Date(returnDate.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            showError(returnDate, 'Return date cannot be in the past');
            isValid = false;
        }
    }
    
    // If form is valid, show success message and close modal
    if (isValid) {
        // Format date for display
        const formattedDate = new Date(returnDate.value).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Success message
        alert(`✅ Success, ${name.value}!\n\nYou have successfully requested to borrow "${bookName.value}".\nStudent ID: ${studentID.value}\nReturn Date: ${formattedDate}\n\nA confirmation email has been sent to ${email.value}.`);
        
        // Close modal
        if (typeof closeModal === 'function') {
            closeModal();
        }
    }
    
    return false;
}

// Real-time validation
function setupRealTimeValidation() {
    const name = document.getElementById('Name');
    const email = document.getElementById('Email');
    const phone = document.getElementById('Phone');
    const studentID = document.getElementById('StudentID');
    const returnDate = document.getElementById('ReturnDate');
    
    if (name) {
        name.addEventListener('input', function() {
            if (this.value.trim() && !validateName(this.value.trim())) {
                this.style.borderColor = '#ff5961';
            } else if (this.value.trim() && validateName(this.value.trim())) {
                clearError(this);
                this.style.borderColor = '#22eca9';
            } else {
                this.style.borderColor = '#e0e0e0';
            }
        });
    }
    
    if (email) {
        email.addEventListener('input', function() {
            if (this.value.trim() && !validateEmail(this.value.trim())) {
                this.style.borderColor = '#ff5961';
            } else if (this.value.trim() && validateEmail(this.value.trim())) {
                clearError(this);
                this.style.borderColor = '#22eca9';
            } else {
                this.style.borderColor = '#e0e0e0';
            }
        });
    }
    
    if (phone) {
        phone.addEventListener('input', function() {
            if (this.value.trim() && !validatePhone(this.value.trim())) {
                this.style.borderColor = '#ff5961';
            } else if (this.value.trim() && validatePhone(this.value.trim())) {
                clearError(this);
                this.style.borderColor = '#22eca9';
            } else {
                this.style.borderColor = '#e0e0e0';
            }
        });
    }
    
    if (studentID) {
        studentID.addEventListener('input', function() {
            if (this.value.trim() && !validateStudentID(this.value.trim())) {
                this.style.borderColor = '#ff5961';
            } else if (this.value.trim() && validateStudentID(this.value.trim())) {
                clearError(this);
                this.style.borderColor = '#22eca9';
            } else {
                this.style.borderColor = '#e0e0e0';
            }
        });
    }
    
    if (returnDate) {
        returnDate.addEventListener('change', function() {
            if (this.value) {
                const selectedDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (selectedDate >= today) {
                    clearError(this);
                    this.style.borderColor = '#22eca9';
                } else {
                    this.style.borderColor = '#ff5961';
                }
            } else {
                this.style.borderColor = '#e0e0e0';
            }
        });
    }
}

// Initialize validation when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Form validation script loaded');
    
    // Attach validation to form submit
    if (borrowForm) {
        // Remove any existing submit handlers
        borrowForm.removeEventListener('submit', validateForm);
        borrowForm.addEventListener('submit', validateForm);
        setupRealTimeValidation();
    } else {
        console.error('Form with id "borrowForm" not found');
    }
});