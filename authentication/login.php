<?php
session_start();

$message = "";

if(isset($_SESSION['success'])){
    $message = "<div class='alert alert-success'>".$_SESSION['success']."</div>";
    unset($_SESSION['success']);
}

if(isset($_SESSION['error'])){
    $message = "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login | Smart Campus Lost & Found</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f5;
}

.card{
    margin-top:80px;
    border-radius:15px;
}

</style>

</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-primary text-white text-center">

<h3>User Login</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form action="../api/login_api.php" method="POST">

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
class="btn btn-primary w-100"
type="submit">

Login

</button>

</form>

<hr>

<div class="text-center">

Don't have an account?

<a href="register.php">

Register

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>