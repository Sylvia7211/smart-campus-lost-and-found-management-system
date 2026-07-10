<?php
require_once "../config/session.php";
requireLogin();
require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION['user_id'];
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email address.";
        header("Location: ../dashboard/dashboard.php?page=profile");
        exit();
    }

    // Check if email is already taken by another user
    $stmt = $conn->prepare("SELECT id FROM Users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['error'] = "Email is already taken by another user.";
        $stmt->close();
        header("Location: ../dashboard/dashboard.php?page=profile");
        exit();
    }
    $stmt->close();

    // Update profile
    if (!empty($new_password)) {
        // Validate password match
        if ($new_password !== $confirm_password) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: ../dashboard/dashboard.php?page=profile");
            exit();
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE Users SET full_name = ?, email = ?, phone = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $full_name, $email, $phone, $hashed_password, $user_id);
    } else {
        $sql = "UPDATE Users SET full_name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $full_name, $email, $phone, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }

    $stmt->close();
    header("Location: ../dashboard/dashboard.php?page=profile");
    exit();
}
?>