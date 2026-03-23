document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    // Get all form fields
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const bookTitleInput = document.getElementById('Book title');
    const authorInput = document.getElementById('Author');
    const reasonInput = document.getElementById('reason');

    // Function to show error
    function showError(input, message) {
        // Remove any existing error message
        const existingError = input.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        // Add error class to input
        input.classList.add('error');

        // Create and insert error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = '#ff4444';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '5px';
        errorDiv.textContent = message;
        input.parentElement.appendChild(errorDiv);
    }

    // Function to remove error
    function removeError(input) {
        input.classList.remove('error');
        const existingError = input.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
    }

    // Validate Name: at least 2 words, only letters and spaces, no numbers or symbols
    function validateName() {
        const name = nameInput.value.trim();

        if (name === '') {
            showError(nameInput, 'Name is required');
            return false;
        }

        // Check for numbers or special characters (only letters and spaces allowed)
        if (!/^[a-zA-Z\s]+$/.test(name)) {
            showError(nameInput, 'Name can only contain letters and spaces (no numbers or special characters)');
            return false;
        }

        // Check for at least 2 words (at least one space between words)
        const words = name.trim().split(/\s+/);
        if (words.length < 2) {
            showError(nameInput, 'Name must contain at least 2 words (first and last name)');
            return false;
        }

        // Check each word has at least one character
        for (let i = 0; i < words.length; i++) {
            if (words[i].length < 1) {
                showError(nameInput, 'Each word in name must have at least one character');
                return false;
            }
        }

        removeError(nameInput);
        return true;
    }

    // Validate Email: must contain @gmail.com, no other symbols or spaces
    function validateEmail() {
        const email = emailInput.value.trim();

        if (email === '') {
            showError(emailInput, 'Email is required');
            return false;
        }

        // Check for spaces
        if (email.includes(' ')) {
            showError(emailInput, 'Email cannot contain spaces');
            return false;
        }

        // Check for any special characters other than @ and . 
        // Email should only contain letters, numbers, @, ., and maybe _ before @
        // But specifically must end with @gmail.com
        const gmailPattern = /^[a-zA-Z0-9._]+@gmail\.com$/;

        if (!gmailPattern.test(email)) {
            showError(emailInput, 'Email must be a valid Gmail address (e.g., username@gmail.com) and cannot contain special characters');
            return false;
        }

        // Check that it ends with @gmail.com (already covered by pattern but double-check)
        if (!email.endsWith('@gmail.com')) {
            showError(emailInput, 'Email must end with @gmail.com');
            return false;
        }

        removeError(emailInput);
        return true;
    }

    // Validate Book Title: only alphabet and spaces, no numbers or special symbols
    function validateBookTitle() {
        const bookTitle = bookTitleInput.value.trim();

        if (bookTitle === '') {
            showError(bookTitleInput, 'Book title is required');
            return false;
        }

        // Only letters and spaces allowed
        if (!/^[a-zA-Z\s]+$/.test(bookTitle)) {
            showError(bookTitleInput, 'Book title can only contain letters and spaces (no numbers or special characters)');
            return false;
        }

        // Check that it's not just spaces
        if (bookTitle.trim() === '') {
            showError(bookTitleInput, 'Book title cannot be empty');
            return false;
        }

        removeError(bookTitleInput);
        return true;
    }

    // Validate Author: words without numbers and symbols, can have spaces
    function validateAuthor() {
        const author = authorInput.value.trim();

        if (author === '') {
            showError(authorInput, 'Author name is required');
            return false;
        }

        // Only letters and spaces allowed
        if (!/^[a-zA-Z\s]+$/.test(author)) {
            showError(authorInput, 'Author name can only contain letters and spaces (no numbers or special characters)');
            return false;
        }

        // Check that it has at least one word
        if (author.trim().split(/\s+/).length < 1) {
            showError(authorInput, 'Author name must contain at least one word');
            return false;
        }

        removeError(authorInput);
        return true;
    }

    // Validate Reason: exactly 15 characters, no numbers or symbols, only letters and spaces
    function validateReason() {
        const reason = reasonInput.value;

        if (reason === '') {
            showError(reasonInput, 'Reason for request is required');
            return false;
        }

        // Check for exactly 15 characters (including spaces)
        if (reason.length < 15) {
            showError(reasonInput, 'Reason must be more than 15 characters long (currently ' + reason.length + ' characters)');
            return false;
        }

        // Check for no numbers or special characters (only letters and spaces allowed)
        if (!/^[a-zA-Z\s]+$/.test(reason)) {
            showError(reasonInput, 'Reason can only contain letters and spaces (no numbers or special characters)');
            return false;
        }

        removeError(reasonInput);
        return true;
    }

    // Add real-time validation on blur (when user leaves the field)
    nameInput.addEventListener('blur', validateName);
    emailInput.addEventListener('blur', validateEmail);
    bookTitleInput.addEventListener('blur', validateBookTitle);
    authorInput.addEventListener('blur', validateAuthor);
    reasonInput.addEventListener('blur', validateReason);

    // Add real-time validation on input (as user types)
    nameInput.addEventListener('input', function () {
        if (nameInput.value.trim() !== '') {
            validateName();
        } else {
            removeError(nameInput);
        }
    });

    emailInput.addEventListener('input', function () {
        if (emailInput.value.trim() !== '') {
            validateEmail();
        } else {
            removeError(emailInput);
        }
    });

    bookTitleInput.addEventListener('input', function () {
        if (bookTitleInput.value.trim() !== '') {
            validateBookTitle();
        } else {
            removeError(bookTitleInput);
        }
    });

    authorInput.addEventListener('input', function () {
        if (authorInput.value.trim() !== '') {
            validateAuthor();
        } else {
            removeError(authorInput);
        }
    });

    reasonInput.addEventListener('input', function () {
        if (reasonInput.value !== '') {
            validateReason();
        } else {
            removeError(reasonInput);
        }
    });

    // Form submit validation
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        // Validate all fields
        const isNameValid = validateName();
        const isEmailValid = validateEmail();
        const isBookTitleValid = validateBookTitle();
        const isAuthorValid = validateAuthor();
        const isReasonValid = validateReason();

        // If all fields are valid, submit the form
        if (isNameValid && isEmailValid && isBookTitleValid && isAuthorValid && isReasonValid) {
            // Show success message
            alert('Thank you! Your book request has been submitted successfully. Our team will review it and get back to you soon.');

            // Optional: Reset form after successful submission
            // form.reset();

            // If you want to actually submit to server, uncomment the line below
            // form.submit();
        } else {
            // Scroll to the first error field
            const firstError = document.querySelector('.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            alert('Please fill out all fields correctly before submitting.');
        }
    });
});