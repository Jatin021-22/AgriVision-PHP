<?php
// Check if the session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Check for any output before redirecting
if (!headers_sent()) {
    // Redirect the user to the login page
    header("Location: ../../login.php");

    exit();
} else {
    // Optional: If headers are already sent, use a JavaScript redirect as a fallback
    echo "<script type='text/javascript'>window.location.href='../login.php';</script>";
    exit();
}
?>
