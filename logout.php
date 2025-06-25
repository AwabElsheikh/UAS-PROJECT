<?php
// Start the session to ensure access to $_SESSION
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("location: login.html?status=logged_out");
exit;
?>
