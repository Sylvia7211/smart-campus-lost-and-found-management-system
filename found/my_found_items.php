<?php
require_once "../config/database.php";
require_once "../config/session.php";

$user_id = 1; // Temporary until login is complete

$stmt = $conn->prepare("SELECT * FROM Found_Items WHERE user_id=? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Found Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">
<h3>My Found Items</h3>
</div>

<div class="card-body">

<a href="report_found.php" class="btn btn-success mb-3">
Report New Found Item
</a>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Image</th>
<th>Item</th>
<th>Category</th>
<th>Location</th>
<th>Date Found</th>
<th>Status</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td>

<?php if(!empty($row['image'])){ ?>

<img src="../assets/uploads/found/<?php echo $row['image']; ?>" width="80">

<?php } ?>

</td>

<td><?= htmlspecialchars($row['item_name']) ?></td>

<td><?= htmlspecialchars($row['category']) ?></td>

<td><?= htmlspecialchars($row['location_found']) ?></td>

<td><?= htmlspecialchars($row['date_found']) ?></td>

<td>

<span class="badge bg-success">

<?= htmlspecialchars($row['status']) ?>

</span>

</td>

<td>

<a href="edit_found.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
Edit
</a>

<a href="delete_found.php?id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this item?')">
Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>