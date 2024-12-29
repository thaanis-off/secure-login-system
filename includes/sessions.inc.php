<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to login page if not authenticated
    header("Location: index.php");
    exit();
}
