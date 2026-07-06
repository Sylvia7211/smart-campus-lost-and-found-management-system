<?php
include("../config/database.php");
session_start();

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_id = $_POST['item_id'];
    $reason = $_POST['reason'];

    $sql = "INSERT INTO claims (user_id, item_id, reason, status) VALUES (?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user_id, $item_id, $reason);

    if ($stmt->execute()) {
        echo "<p>Claim submitted successfully</p>";
    } else {
        echo "<p>Error submitting claim</p>";
    }
}

// Get item ID from URL
$item_id = $_GET['item_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Claim Item</title>
</head>
<body>

<h2>Claim Item</h2>

<form method="POST">
    <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">

    <label>Reason:</label><br>
    <textarea name="reason" required></textarea><br><br>

    <button type="submit">Submit Claim</button>
</form>

</body>
</html>