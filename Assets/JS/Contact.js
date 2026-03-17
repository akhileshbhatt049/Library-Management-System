document
  .getElementById("contactForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    // Get form fields
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const message = document.getElementById("message");

    // Remove any existing error messages
    document.querySelectorAll(".error-message").forEach((el) => el.remove());
    [name, email, message].forEach((field) => {
      field.classList.remove("error", "valid");
    });

    let isValid = true;

    // Validate Name (only alphabets and spaces)
    if (!name.value.trim()) {
      showError(name, "Name is required");
      isValid = false;
    } else if (!/^[A-Za-z\s]+$/.test(name.value.trim())) {
      showError(name, "Name should only contain letters and spaces");
      isValid = false;
    } else {
      name.classList.add("valid");
    }

    // Validate Email
    if (!email.value.trim()) {
      showError(email, "Email is required");
      isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
      showError(email, "Please enter a valid email address");
      isValid = false;
    } else {
      email.classList.add("valid");
    }

    // Validate Message
    if (!message.value.trim()) {
      showError(message, "Message is required");
      isValid = false;
    } else if (message.value.trim().length < 10) {
      showError(message, "Message must be at least 10 characters");
      isValid = false;
    } else {
      message.classList.add("valid");
    }

    // If valid, show success message
    if (isValid) {
      alert(
        `Thank you ${name.value.trim()}! Your message has been sent successfully.`,
      );
      this.reset();
      [name, email, message].forEach((field) =>
        field.classList.remove("valid"),
      );
    }
  });

function showError(inputElement, message) {
  inputElement.classList.add("error");

  const errorDiv = document.createElement("div");
  errorDiv.className = "error-message";
  errorDiv.innerHTML = `<i class="fa fa-exclamation-circle"></i> ${message}`;

  inputElement.parentElement.appendChild(errorDiv);
}

// Real-time validation feedback
document.getElementById("name").addEventListener("input", function () {
  if (this.value.trim() && /^[A-Za-z\s]+$/.test(this.value.trim())) {
    this.classList.add("valid");
    this.classList.remove("error");
  } else {
    this.classList.remove("valid");
  }
});

document.getElementById("email").addEventListener("input", function () {
  if (
    this.value.trim() &&
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value.trim())
  ) {
    this.classList.add("valid");
    this.classList.remove("error");
  } else {
    this.classList.remove("valid");
  }
});
