<?php

require_once "../config/session.php";

?>

<!DOCTYPE html>

<html>

<head>

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>

Welcome,

<?php echo htmlspecialchars($_SESSION['full_name']); ?>

</h2>

<p>

Email:
<?php echo htmlspecialchars($_SESSION['email']); ?>

</p>

<p>

Role:
<?php echo htmlspecialchars($_SESSION['role']); ?>

</p>

<a
href="../authentication/logout.php"
class="btn btn-danger">

Logout

</a>

</div>

</body>

</html>