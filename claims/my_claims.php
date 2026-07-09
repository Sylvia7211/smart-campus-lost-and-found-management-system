<?php
include("../config/database.php");
session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM claims WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Claims</title>
</head>
<body>

<h2>My Claims</h2>

<table border="1">
<tr>
    <th>Item ID</th>
    <th>Reason</th>
    <th>Status</th>
</tr>

<?php
while($row = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>".$row['item_id']."</td>";
    echo "<td>".$row['reason']."</td>";
    echo "<td>".$row['status']."</td>";
    echo "</tr>";
}
?>

</table>

</body>
</html>