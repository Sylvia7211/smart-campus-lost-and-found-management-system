<?php
session_start();
require_once "../config/database.php";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../authentication/register.php");
    exit();
}

// Get and sanitize input
$full_name = trim($_POST['full_name'] ?? '');
$reg_number = trim($_POST['reg_number'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate required fields
if (empty($full_name) || empty($reg_number) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ../authentication/register.php");
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: ../authentication/register.php");
    exit();
}

// Validate password length
if (strlen($password) < 8) {
    $_SESSION['error'] = "Password must be at least 8 characters long.";
    header("Location: ../authentication/register.php");
    exit();
}

// Validate password match
if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: ../authentication/register.php");
    exit();
}

// Check for duplicate email
$stmt = $conn->prepare("SELECT id FROM Users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Email address is already registered.";
    $stmt->close();
    header("Location: ../authentication/register.php");
    exit();
}
$stmt->close();

// Check for duplicate registration number
$stmt = $conn->prepare("SELECT id FROM Users WHERE reg_number = ?");
$stmt->bind_param("s", $reg_number);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Registration number is already in use.";
    $stmt->close();
    header("Location: ../authentication/register.php");
    exit();
}
$stmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user (default role is 'student')
$stmt = $conn->prepare("INSERT INTO Users (full_name, reg_number, email, phone, password, role, created_at) 
                        VALUES (?, ?, ?, ?, ?, 'student', NOW())");
$stmt->bind_param("sssss", $full_name, $reg_number, $email, $phone, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['success'] = "Registration successful! Please login to continue.";
    header("Location: ../authentication/login.php");
} else {
    $_SESSION['error'] = "Registration failed. Please try again.";
    header("Location: ../authentication/register.php");
}

$stmt->close();
$conn->close();
?>
