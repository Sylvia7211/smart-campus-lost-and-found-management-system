<?php
include("../config/database.php");
session_start();

// Get logged-in user ID
$user_id = $_SESSION['user_id'];

// Prepare SQL
$sql = "SELECT * FROM notifications WHERE user_id=?";
$stmt = $conn->prepare($sql);

// Bind parameter
$stmt->bind_param("i", $user_id);

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
</head>
<body>

<h2>Your Notifications</h2>

<?php
while($row = $result->fetch_assoc()){
    echo "<p>" . $row['message'] . "</p>";
}
?>

</body>
</html>