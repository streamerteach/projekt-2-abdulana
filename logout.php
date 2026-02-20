<?php
session_start();

// Loggar ut användaren genom att rensa sessionen
session_destroy();

// Skickar användaren direkt till startsidan
header("Location: index.php");
exit;
?>