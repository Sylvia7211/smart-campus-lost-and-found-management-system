<?php
require_once "../config/session.php";
requireLogin();
require_once "../config/database.php";

// Default page
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Allowed pages
$allowedPages = [
    'dashboard',
    'report_lost',
    'report_found',
    'claims',
    'profile'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Smart Campus Lost & Found</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    background:#f4f4f4;
    font-family:Arial,Helvetica,sans-serif;
}
.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100%;
    background:#212529;
    color:#fff;
    padding-top:20px;
}
.sidebar h2{
    text-align:center;
    margin-bottom:30px;
}
.sidebar a{
    display:block;
    color:white;
    padding:15px 25px;
    text-decoration:none;
}
.sidebar a:hover{
    background:#0d6efd;
}
.content{
    margin-left:250px;
    padding:30px;
}
.card{
    border:none;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}
footer{
    margin-top:50px;
    background:#0d6efd;
    color:white;
    text-align:center;
    padding:15px;
}
</style>

</head>

<body>

<div class="sidebar">

<h2>Menu</h2>

<a href="?page=dashboard">🏠 Dashboard</a>
<a href="?page=report_lost">❗ Report Lost Item</a>
<a href="?page=report_found">✅ Report Found Item</a>
<a href="?page=claims">📄 My Claims</a>
<a href="?page=profile">👤 Profile</a>
<a href="../authentication/logout.php">🚪 Logout</a>

</div>

<div class="content">

<?php

if(!in_array($page,$allowedPages)){
    $page='dashboard';
}

switch($page){

    case 'dashboard':
        echo "<h2>Welcome, ".htmlspecialchars($_SESSION['full_name'])."</h2>";
        echo "<p>Email: ".htmlspecialchars($_SESSION['email'])."</p>";
        echo "<p>Role: ".htmlspecialchars($_SESSION['role'])."</p>";
        break;

    case 'report_lost':
        if(file_exists("../lost/report_lost.php")){
            include "../lost/report_lost.php";
        }else{
            echo "<div class='alert alert-warning'>Report Lost Item page not found.</div>";
        }
        break;

    case 'report_found':
        if(file_exists("../found/report_found.php")){
            include "../found/report_found.php";
        }else{
            echo "<div class='alert alert-warning'>Report Found Item page not found.</div>";
        }
        break;

    case 'claims':
        if(file_exists("../claims/my_claims.php")){
            include "../claims/my_claims.php";
        }else{
            echo "<div class='alert alert-warning'>Claims page not found.</div>";
        }
        break;

    case 'profile':
        if(file_exists("../profile/profile.php")){
            include "../profile/profile.php";
        }else{
            echo "<div class='alert alert-warning'>Profile page not found.</div>";
        }
        break;
}

?>

<footer>
© 2026 Smart Campus Lost & Found Management System. All Rights Reserved.
</footer>

</div>

</body>
</html>