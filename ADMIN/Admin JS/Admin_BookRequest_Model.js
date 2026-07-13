// Open Reject Modal
function openModal(id, studentName) {
  document.getElementById("rejectId").value = id;
  document.getElementById("studentNameDisplay").textContent = studentName;
  document.getElementById("rejectModal").style.display = "flex";
}

// Close Reject Modal
function closeModal() {
  document.getElementById("rejectModal").style.display = "none";
  document.getElementById("rejectReason").value = "";
}

// Close modal when clicking outside
window.onclick = function (event) {
  const modal = document.getElementById("rejectModal");
  if (event.target == modal) {
    closeModal();
  }
};

// Close modal with Escape key
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    const modal = document.getElementById("rejectModal");
    if (modal.style.display === "flex") {
      closeModal();
    }
  }
});

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
