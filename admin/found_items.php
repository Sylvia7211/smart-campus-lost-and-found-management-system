<?php
include('../includes/db.php');

$result = mysqli_query($conn, "SELECT * FROM found_items");
?>

<h2>Found Items</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Item Name</th>
    <th>Description</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['item_name']; ?></td>
    <td><?php echo $row['description']; ?></td>
</tr>
<?php } ?>
</table>