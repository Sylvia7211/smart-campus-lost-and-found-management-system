<?php
session_start();

$message = "";

if (isset($_SESSION['success'])) {
    $message = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <i class='bi bi-check-circle-fill'></i> " . $_SESSION['success'] . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    $message = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <i class='bi bi-exclamation-triangle-fill'></i> " . $_SESSION['error'] . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Forgot Password | Smart Campus Lost & Found</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{

    background:linear-gradient(135deg,#0d6efd,#4a90e2);

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    font-family:'Segoe UI',sans-serif;

}

.card{

    border:none;

    border-radius:18px;

    overflow:hidden;

}

.card-header{

    background:#0d6efd;

    color:white;

    text-align:center;

    padding:25px;

}

.logo{

    font-size:55px;

}

.card-body{

    padding:35px;

}

.form-control{

    height:50px;

}

.btn-primary{

    height:50px;

    font-size:18px;

}

.footer-text{

    font-size:14px;

    color:gray;

}

</style>

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-5 col-md-7">

<div class="card shadow-lg">

<div class="card-header">

<div class="logo">

<i class="bi bi-shield-lock-fill"></i>

</div>

<h3 class="mt-2">

Smart Campus Lost & Found

</h3>

<p class="mb-0">

Password Recovery

</p>

</div>

<div class="card-body">

<?php echo $message; ?>

<h4 class="text-center mb-3">

Forgot Password

</h4>

<p class="text-center text-muted">

Enter the email address associated with your account.
We will verify your account before allowing you to reset your password.

</p>

<form action="../api/forgot_password_api.php" method="POST">

<div class="mb-4">

<label class="form-label">

<i class="bi bi-envelope-fill"></i>

Email Address

</label>

<input

type="email"

name="email"

class="form-control"

placeholder="Enter your registered email"

required

>

</div>

<div class="d-grid">

<button

type="submit"

class="btn btn-primary">

<i class="bi bi-arrow-repeat"></i>

Continue

</button>

</div>

</form>

<hr>

<div class="text-center">

<a href="login.php" class="text-decoration-none">

<i class="bi bi-arrow-left-circle"></i>

Back to Login

</a>

</div>

</div>

<div class="card-footer text-center footer-text">

© <?php echo date("Y"); ?>

Smart Campus Lost & Found Management System

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>