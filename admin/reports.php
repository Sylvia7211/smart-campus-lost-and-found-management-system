<?php
include('../includes/db.php');
?>

<h2>Reports</h2>

<?php
$users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$claims = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM claims"));
?>

<p>Total Users: <?php echo $users; ?></p>
<p>Total Claims: <?php echo $claims; ?></p>