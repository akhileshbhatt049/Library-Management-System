// Open modal
function openModal(id, name) {
  document.getElementById("rejectId").value = id;
  document.getElementById("studentName").textContent = name;
  document.getElementById("rejectModal").classList.add("active");
}

// Close modal
function closeModal() {
  document.getElementById("rejectModal").classList.remove("active");
  document.getElementById("rejectReason").value = "";
}

// Close modal when clicking outside
window.onclick = function (event) {
  if (event.target == document.getElementById("rejectModal")) {
    closeModal();
  }
};

// Auto hide message after 5 seconds
setTimeout(function () {
  var alert = document.querySelector(".alert");
  if (alert) {
    alert.style.opacity = "0";
    alert.style.transition = "opacity 0.5s";
    setTimeout(function () {
      alert.style.display = "none";
    }, 500);
  }
}, 5000);
