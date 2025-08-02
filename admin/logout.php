<?php
session_start();

// Destroy all session variables
session_unset();
session_destroy();

// Redirect to the index.php page
header("Location: index.php"); // Adjust the path if necessary
exit;
?>
