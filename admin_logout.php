<?php
session_start();

// Destroy all sessions and redirect to the login page
session_unset();
session_destroy();

echo "<script>alert('You have been logged out successfully.'); window.location.href='admin_login.php';</script>";
exit();
?>
