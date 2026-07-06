<?php
include("../config/database.php");
session_start();

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];

$sql = "UPDATE users SET name=?, phone=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $phone, $user_id);

if($stmt->execute()){
    echo "Profile updated";
}
?>