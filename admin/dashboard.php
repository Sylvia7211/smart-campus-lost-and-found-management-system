<?php
require_once "../config/session.php";
requireAdmin();

include('../includes/db.php');

// Count users
$users = mysqli_query($conn, "SELECT * FROM users");
$user_count = mysqli_num_rows($users);

// Count lost items
$lost = mysqli_query($conn, "SELECT * FROM lost_items");
$lost_count = mysqli_num_rows($lost);

// Count claims
$claims = mysqli_query($conn, "SELECT * FROM claims");
$claim_count = mysqli_num_rows($claims);
?>

<h2>Admin Dashboard</h2>

<p>Total Users: <?php echo $user_count; ?></p>
<p>Total Lost Items: <?php echo $lost_count; ?></p>
<p>Total Claims: <?php echo $claim_count; ?></p>