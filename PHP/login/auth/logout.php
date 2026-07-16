<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page - Fix the path
header("Location: ../../../index.php");
exit();
?>