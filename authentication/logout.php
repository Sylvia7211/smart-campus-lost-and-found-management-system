<?php
// Start the session
session_start();

// Remove all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Delete the session cookie if it exists
if (ini_get("session.use_cookies")) {

    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Start a new session only to store a success message
session_start();
$_SESSION['success'] = "You have logged out successfully.";

// Redirect to the login page
header("Location: login.php");
exit();
?>