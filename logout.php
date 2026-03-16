<?php
session_start();

// Remove all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to homepage (or login page)
header("Location: /echo/index.php");
exit();
?>