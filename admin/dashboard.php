<?php
require_once("../config/session.php");
requireAdmin();

require_once("../config/database.php");

// Count Users
$userResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Users");
$userCount = mysqli_fetch_assoc($userResult)['total'];

// Count Lost Items
$lostResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Lost_Items");
$lostCount = mysqli_fetch_assoc($lostResult)['total'];

// Count Found Items
$foundResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Found_Items");
$foundCount = mysqli_fetch_assoc($foundResult)['total'];

// Count Claims
$claimResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Claims");
$claimCount = mysqli_fetch_assoc($claimResult)['total'];

// Count Notifications
$notificationResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Notifications");
$notificationCount = mysqli_fetch_assoc($notificationResult)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
            font-family:Arial, sans-serif;
        }

        .header{
            background:#0d6efd;
            color:#fff;
            padding:20px;
            text-align:center;
        }

        .container{
            margin-top:30px;
        }

        .card{
            border:none;
            border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,.1);
        }

        .card h2{
            color:#0d6efd;
            font-size:40px;
            font-weight:bold;
        }

        .logout{
            margin-top:30px;
            text-align:center;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Smart Campus Lost & Found Management System</h1>
    <h4>Admin Dashboard</h4>

    <p>
        Welcome,
        <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong>
    </p>
</div>

<div class="container">

<div class="row g-4">

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Total Users</h5>
<h2><?php echo $userCount; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Lost Items</h5>
<h2><?php echo $lostCount; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Found Items</h5>
<h2><?php echo $foundCount; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Claims</h5>
<h2><?php echo $claimCount; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 text-center">
<h5>Notifications</h5>
<h2><?php echo $notificationCount; ?></h2>
</div>
</div>

</div>

<div class="logout">
    <a href="../authentication/logout.php" class="btn btn-danger">
        Logout
    </a>
</div>

</div>

</body>
</html>