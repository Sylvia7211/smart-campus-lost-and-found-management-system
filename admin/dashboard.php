<?php
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

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
            margin:0;
            padding:30px;
        }

        h1{
            text-align:center;
            color:#333;
        }

        .container{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            margin-top:30px;
        }

        .card{
            background:#fff;
            padding:20px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            text-align:center;
        }

        .card h2{
            font-size:40px;
            color:#007bff;
            margin:10px 0;
        }

        .card p{
            font-size:18px;
            color:#555;
        }
    </style>
</head>

<body>

<h1>Admin Dashboard</h1>

<div class="container">

    <div class="card">
        <p>Total Users</p>
        <h2><?php echo $userCount; ?></h2>
    </div>

    <div class="card">
        <p>Lost Items</p>
        <h2><?php echo $lostCount; ?></h2>
    </div>

    <div class="card">
        <p>Found Items</p>
        <h2><?php echo $foundCount; ?></h2>
    </div>

    <div class="card">
        <p>Claims</p>
        <h2><?php echo $claimCount; ?></h2>
    </div>

    <div class="card">
        <p>Notifications</p>
        <h2><?php echo $notificationCount; ?></h2>
    </div>

</div>

</body>
</html>