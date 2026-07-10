<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Campus Lost & Found Management System</title>

    <style>
        body{
            margin:0;
            font-family:Arial, sans-serif;
            background:#f4f6f9;
        }

        header{
            background:#007bff;
            color:white;
            padding:20px;
            text-align:center;
        }

        .container{
            width:90%;
            margin:40px auto;
        }

        .grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:20px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,.1);
            text-align:center;
        }

        .card h3{
            margin-bottom:15px;
        }

        .card a{
            text-decoration:none;
            background:#007bff;
            color:white;
            padding:10px 20px;
            border-radius:5px;
            display:inline-block;
        }

        .card a:hover{
            background:#0056b3;
        }
    </style>
</head>

<body>

<header>
    <h1>Smart Campus Lost & Found Management System</h1>
    <p>Welcome to the Team Project</p>
</header>

<div class="container">

<div class="grid">

<div class="card">
<h3>Report Lost Item</h3>
<a href="lost/report_lost.php">Open</a>
</div>

<div class="card">
<h3>My Lost Items</h3>
<a href="lost/my_lost_items.php">Open</a>
</div>

<div class="card">
<h3>Report Found Item</h3>
<a href="found/report_found.php">Open</a>
</div>

<div class="card">
<h3>My Found Items</h3>
<a href="found/my_found_items.php">Open</a>
</div>

<div class="card">
<h3>Search</h3>
<a href="search/search.php">Open</a>
</div>

<div class="card">
<h3>Profile</h3>
<a href="profile/edit_profile.php">Open</a>
</div>

<div class="card">
<h3>Claims</h3>
<a href="claims/my_claims.php">Open</a>
</div>

<div class="card">
<h3>Notifications</h3>
<a href="notification/notification.php">Open</a>
</div>

<div class="card">
<h3>Admin Dashboard</h3>
<a href="admin/dashboard.php">Open</a>
</div>

</div>

</div>

</body>
</html>