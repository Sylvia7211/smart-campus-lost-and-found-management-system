<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Campus Lost & Found - Test Center</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Arial, sans-serif;
            background:#f4f6f9;
        }

        header{
            background:#0d6efd;
            color:white;
            padding:20px;
            text-align:center;
        }

        .container{
            width:90%;
            max-width:1000px;
            margin:40px auto;
        }

        .grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:20px;
        }

        .card{
            background:white;
            border-radius:10px;
            padding:25px;
            text-align:center;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
        }

        .card h3{
            margin-bottom:15px;
            color:#333;
        }

        .card p{
            color:#666;
            margin-bottom:20px;
        }

        .btn{
            display:inline-block;
            padding:10px 20px;
            background:#0d6efd;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }

        .btn:hover{
            background:#084298;
        }

        footer{
            text-align:center;
            margin-top:40px;
            color:#666;
        }
    </style>
</head>

<body>

<header>
    <h1>Smart Campus Lost & Found Management System</h1>
    <p>System Test Center</p>
</header>

<div class="container">

<div class="grid">

<div class="card">
<h3>Database Test</h3>
<p>Test database connectivity.</p>
<a class="btn" href="database_test.php">Open</a>
</div>

<div class="card">
<h3>Authentication Test</h3>
<p>Login and Register module.</p>
<a class="btn" href="login_test.php">Open</a>
</div>

<div class="card">
<h3>Lost Items Test</h3>
<p>Report and manage lost items.</p>
<a class="btn" href="lost_test.php">Open</a>
</div>

<div class="card">
<h3>Found Items Test</h3>
<p>Report and manage found items.</p>
<a class="btn" href="found_test.php">Open</a>
</div>

<div class="card">
<h3>Search Test</h3>
<p>Search for lost or found items.</p>
<a class="btn" href="search_test.php">Open</a>
</div>

<div class="card">
<h3>Claims Test</h3>
<p>View and submit claims.</p>
<a class="btn" href="claims_test.php">Open</a>
</div>

<div class="card">
<h3>Notifications Test</h3>
<p>View user notifications.</p>
<a class="btn" href="notifications_test.php">Open</a>
</div>

<div class="card">
<h3>Profile Test</h3>
<p>Edit user profile.</p>
<a class="btn" href="profile_test.php">Open</a>
</div>

<div class="card">
<h3>Admin Dashboard Test</h3>
<p>Open the administrator dashboard.</p>
<a class="btn" href="admin_test.php">Open</a>
</div>

</div>

<footer>
    <p>&copy; 2026 Smart Campus Lost & Found Management System</p>
</footer>

</div>

</body>
</html>