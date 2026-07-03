// Script to hide the success message after 5 seconds
setTimeout(function() {

      var msg = document.getElementById("message");

      if (msg) {
        msg.style.display = "none";
      }
    }, 5000);