document.addEventListener("DOMContentLoaded", function () {
  // Get all form elements
  const form = document.getElementById("requestForm");
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const bookTitleInput = document.getElementById("bookTitle");
  const authorInput = document.getElementById("author");
  const reasonInput = document.getElementById("reason");
  const submitBtn = document.getElementById("submitBtn");
  const successMessage = document.getElementById("successMessage");
  const successText = document.getElementById("successText");
  const charCounter = document.getElementById("charCounter");

  // Define validation rules
  const validations = {
    name: {
      regex: /^[A-Za-z][A-Za-z\s]*$/,
      minLength: 3,
      required: true,
      errorMessages: {
        required: "Please enter your full name.",
        pattern:
          "Full name should contain only letters and spaces, and must start with a letter.",
        minLength: "Full name must be at least 3 characters long.",
        startsWithSpace: "Full name cannot start with a space.",
      },
    },
    email: {
      regex: /^[a-zA-Z][a-zA-Z0-9._%+-]*@gmail\.com$/,
      required: true,
      errorMessages: {
        required: "Please enter your email address.",
        pattern:
          "Please enter a valid Gmail address (e.g., username@gmail.com).",
      },
    },
    bookTitle: {
      regex: /^[A-Za-z][A-Za-z\s]*$/,
      minLength: 2,
      required: true,
      errorMessages: {
        required: "Please enter the book title.",
        pattern: "Book title should contain only letters and spaces.",
        minLength: "Book title must be at least 2 characters long.",
        startsWithSpace: "Book title cannot start with a space.",
      },
    },
    author: {
      regex: /^[A-Za-z][A-Za-z\s]*$/,
      minLength: 2,
      required: true,
      errorMessages: {
        required: "Please enter the author's name.",
        pattern:
          "Author name should contain only letters and spaces, and must start with a letter.",
        minLength: "Author name must be at least 3 characters long.",
        startsWithSpace: "Author name cannot start with a space.",
      },
    },
    reason: {
      regex: /^[A-Za-z][A-Za-z\s.,/]*$/,
      minLength: 10,
      maxLength: 500,
      required: true,
      errorMessages: {
        required: "Please enter the reason for your request.",
        pattern: "Reason can only contain letters, spaces, and dots.",
        minLength: "Reason must be at least 10 characters long.",
        maxLength: "Reason must be no more than 500 characters long.",
        startsWithSpace: "Reason cannot start with a space.",
      },
    },
  };

  // Function to validate a single field
  function validateField(input, fieldName) {
    const value = input.value;
    const rules = validations[fieldName];
    const errorSpan = document.getElementById(fieldName + "Error");

    // Reset error state
    input.classList.remove("valid", "invalid");
    errorSpan.textContent = "";
    errorSpan.className = "error-message";

    // Required field check
    if (rules.required && value.trim() === "") {
      input.classList.add("invalid");
      errorSpan.textContent = rules.errorMessages.required;
      return false;
    }

    // Check if starts with space
    if (value.length > 0 && value[0] === " ") {
      input.classList.add("invalid");
      errorSpan.textContent =
        rules.errorMessages.startsWithSpace ||
        "Field cannot start with a space.";
      return false;
    }

    // Pattern check
    if (rules.regex && !rules.regex.test(value)) {
      input.classList.add("invalid");
      errorSpan.textContent = rules.errorMessages.pattern;
      return false;
    }

    // Min length check (using trimmed value for length check)
    const trimmedValue = value.trim();
    if (rules.minLength && trimmedValue.length < rules.minLength) {
      input.classList.add("invalid");
      errorSpan.textContent = rules.errorMessages.minLength;
      return false;
    }

    // Max length check
    if (rules.maxLength && value.length > rules.maxLength) {
      input.classList.add("invalid");
      errorSpan.textContent = rules.errorMessages.maxLength;
      return false;
    }

    // Valid field
    input.classList.add("valid");
    errorSpan.textContent = "";
    return true;
  }

  // Real-time validation on blur
  nameInput.addEventListener("blur", function () {
    validateField(this, "name");
  });

  emailInput.addEventListener("blur", function () {
    validateField(this, "email");
  });

  bookTitleInput.addEventListener("blur", function () {
    validateField(this, "bookTitle");
  });

  authorInput.addEventListener("blur", function () {
    validateField(this, "author");
  });

  reasonInput.addEventListener("blur", function () {
    validateField(this, "reason");
  });

  // Real-time character counter for reason
  reasonInput.addEventListener("input", function () {
    const length = this.value.length;
    const maxLength = validations.reason.maxLength;
    charCounter.textContent = length + " / " + maxLength + " characters";

    // Update counter class for color coding
    charCounter.classList.remove("warning", "danger");
    if (length > maxLength) {
      charCounter.classList.add("danger");
    } else if (length > maxLength * 0.8) {
      charCounter.classList.add("warning");
    }

    // Validate in real-time
    validateField(this, "reason");
  });

  // Real-time validation on input (for better UX)
  nameInput.addEventListener("input", function () {
    if (this.value.trim() !== "") {
      validateField(this, "name");
    }
  });

  emailInput.addEventListener("input", function () {
    if (this.value.trim() !== "") {
      validateField(this, "email");
    }
  });

  bookTitleInput.addEventListener("input", function () {
    if (this.value.trim() !== "") {
      validateField(this, "bookTitle");
    }
  });

  authorInput.addEventListener("input", function () {
    if (this.value.trim() !== "") {
      validateField(this, "author");
    }
  });

  // Form submission
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    // Validate all fields
    const isNameValid = validateField(nameInput, "name");
    const isEmailValid = validateField(emailInput, "email");
    const isBookTitleValid = validateField(bookTitleInput, "bookTitle");
    const isAuthorValid = validateField(authorInput, "author");
    const isReasonValid = validateField(reasonInput, "reason");

    // Check if all fields are valid
    const allValid =
      isNameValid &&
      isEmailValid &&
      isBookTitleValid &&
      isAuthorValid &&
      isReasonValid;

    if (allValid) {
      // Show success message with animation
      successMessage.style.display = "flex";
      successMessage.style.animation = "slideDown 0.5s ease forwards";

      // Update success text with user's name
      successText.textContent = `Thank you, ${nameInput.value.trim()}! Your book request has been submitted successfully.`;

      // Disable submit button
      submitBtn.disabled = true;
      submitBtn.style.opacity = "0.6";
      submitBtn.style.cursor = "not-allowed";

      // Submit the form after a short delay
      setTimeout(function () {
        form.submit();
      }, 1500);
    } else {
      // Scroll to the first invalid field
      const firstInvalid = form.querySelector(".invalid");
      if (firstInvalid) {
        firstInvalid.focus();
        firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
      }
    }
  });
});
