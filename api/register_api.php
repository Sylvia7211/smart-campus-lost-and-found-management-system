<?php

session_start();

require_once "../config/database.php";

$full_name = trim($_POST['full_name']);
$reg_number = trim($_POST['reg_number']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if(
empty($full_name) ||
empty($reg_number) ||
empty($email) ||
empty($phone) ||
empty($password) ||
empty($confirm_password)
){

$_SESSION['error']="All fields are required.";

header("Location: ../authentication/register.php");

exit();

}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

$_SESSION['error']="Invalid email.";

header("Location: ../authentication/register.php");

exit();

}

if(strlen($password)<8){

$_SESSION['error']="Password must be at least 8 characters.";

header("Location: ../authentication/register.php");

exit();

}

if($password!=$confirm_password){

$_SESSION['error']="Passwords do not match.";

header("Location: ../authentication/register.php");

exit();

}

/*
Check duplicate email
*/

$sql="SELECT id FROM Users WHERE email=?";

$stmt=$conn->prepare($sql);

$stmt->bind_param("s",$email);

$stmt->execute();

$stmt->store_result();

if($stmt->num_rows>0){

$_SESSION['error']="Email already exists.";

header("Location: ../authentication/register.php");

exit();

}

$stmt->close();

/*
Check duplicate registration number
*/

$sql="SELECT id FROM Users WHERE reg_number=?";

$stmt=$conn->prepare($sql);

$stmt->bind_param("s",$reg_number);

$stmt->execute();

$stmt->store_result();

if($stmt->num_rows>0){

$_SESSION['error']="Registration Number already exists.";

header("Location: ../authentication/register.php");

exit();

}

$stmt->close();

/*
Encrypt Password
*/

$hashed_password=password_hash($password,PASSWORD_DEFAULT);

/*
Insert User
*/

$sql="INSERT INTO Users(full_name,reg_number,email,phone,password)

VALUES(?,?,?,?,?)";

$stmt=$conn->prepare($sql);

$stmt->bind_param(

"sssss",

$full_name,

$reg_number,

$email,

$phone,

$hashed_password

);

if($stmt->execute()){

$_SESSION['success']="Registration Successful. Login to continue.";

header("Location: ../authentication/register.php");

}else{

$_SESSION['error']="Registration Failed.";

header("Location: ../authentication/register.php");

}

$stmt->close();

$conn->close();

?>