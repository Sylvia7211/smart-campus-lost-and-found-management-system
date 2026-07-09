<?php
include('../includes/db.php');

$result = mysqli_query($conn, "SELECT * FROM claims");
?>

<h2>Claims</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Item ID</th>
    <th>User ID</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['item_id']; ?></td>
    <td><?php echo $row['user_id']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td>
        <a href="approve.php?id=<?php echo $row['id']; ?>">Approve</a> |
        <a href="reject.php?id=<?php echo $row['id']; ?>">Reject</a>
    </td>
</tr>
<?php } ?>
</table>