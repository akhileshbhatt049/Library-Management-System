// Open Respond Modal
function openModal(id, name, email, message) {
  document.getElementById("respondId").value = id;
  document.getElementById("userNameDisplay").textContent = name;
  document.getElementById("userEmailDisplay").textContent = email;
  document.getElementById("userMessageDisplay").textContent = message;
  document.getElementById("responseMessage").value = "";
  document.getElementById("respondModal").classList.add("active");
}

// Close Respond Modal
function closeModal() {
  document.getElementById("respondModal").classList.remove("active");
  document.getElementById("responseMessage").value = "";
}

// Close modal when clicking outside
window.onclick = function (event) {
  const modal = document.getElementById("respondModal");
  if (event.target == modal) {
    closeModal();
  }
};

// Auto-hide alerts after 5 seconds
setTimeout(function () {
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach(function (alert) {
    alert.style.transition = "opacity 0.5s ease";
    alert.style.opacity = "0";
    setTimeout(function () {
      alert.style.display = "none";
    }, 500);
  });
}, 5000);
