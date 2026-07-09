<?php

// Start session only if one does not already exist
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Ensure the user is logged in.
 */
function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "Please log in first.";
        header("Location: ../authentication/login.php");
        exit();
    }
}

/**
 * Ensure the logged-in user is an admin.
 */
function requireAdmin()
{
    requireLogin();

    if ($_SESSION['role'] !== "admin") {
        $_SESSION['error'] = "Access denied.";
        header("Location: ../dashboard/dashboard.php");
        exit();
    }
}

/**
 * Ensure the logged-in user is a student.
 */
function requireStudent()
{
    requireLogin();

    if ($_SESSION['role'] !== "student") {
        $_SESSION['error'] = "Access denied.";
        header("Location: ../admin/dashboard.php");
        exit();
    }
}
?>