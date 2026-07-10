<?php

session_start();

require_once "../config/database.php";

$email = trim($_POST['email']);
$password = $_POST['password'];

if(empty($email) || empty($password)){

    $_SESSION['error'] = "Email and Password are required.";

    header("Location: ../authentication/login.php");

    exit();

}

$sql = "SELECT * FROM Users WHERE email = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s",$email);

$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 1){

    $user = $result->fetch_assoc();

    if(password_verify($password,$user['password'])){

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if($user['role']=="admin"){

            header("Location: ../admin/dashboard.php");

        }else{

            header("Location: ../dashboard/dashboard.php");

        }

        exit();

    }else{

        $_SESSION['error']="Invalid email or password.";

        header("Location: ../authentication/login.php");

        exit();

    }

}else{

    $_SESSION['error']="Invalid email or password.";

    header("Location: ../authentication/login.php");

    exit();

}

$stmt->close();

$conn->close();

?>