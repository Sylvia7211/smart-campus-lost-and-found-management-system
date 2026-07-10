<?php
require_once("../config/database.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];
$full_name = trim($_POST['name']);
$phone = trim($_POST['phone']);

$sql = "UPDATE Users SET full_name = ?, phone = ? WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("ssi", $full_name, $phone, $user_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Profile updated successfully.";
    header("Location: ../profile/edit_profile.php");
    exit();
} else {
    echo "Error updating profile: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>