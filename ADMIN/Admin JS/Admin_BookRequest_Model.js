// Open Reject Modal
function openModal(id, studentName) {
  document.getElementById("rejectId").value = id;
  document.getElementById("studentNameDisplay").textContent = studentName;
  document.getElementById("rejectModal").classList.add("active");
}

// Close Reject Modal
function closeModal() {
  document.getElementById("rejectModal").classList.remove("active");
  document.getElementById("rejectReason").value = "";
}

// Close modal when clicking outside
window.onclick = function (event) {
  const modal = document.getElementById("rejectModal");
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
