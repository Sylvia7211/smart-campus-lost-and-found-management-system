<?php
include("../config/database.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p>Please login first.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Get item ID safely from URL
$item_id = $_GET['item_id'] ?? null;

if (!$item_id) {
    echo "<p>No item selected.</p>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_id = $_POST['item_id'] ?? null;
    $reason = $_POST['reason'] ?? '';

    if ($item_id && $reason) {

        $sql = "INSERT INTO claims (user_id, item_id, reason, status) VALUES (?, ?, ?, 'pending')";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("iis", $user_id, $item_id, $reason);

            if ($stmt->execute()) {
                echo "<p>Claim submitted successfully</p>";
            } else {
                echo "<p>Error submitting claim</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Database error.</p>";
        }

    } else {
        echo "<p>All fields are required.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Claim Item</title>
</head>
<body>

<h2>Claim Item</h2>

<form method="POST">
    <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item_id); ?>">

    <label>Reason:</label><br>
    <textarea name="reason" required></textarea><br><br>

    <button type="submit">Submit Claim</button>
</form>

</body>
</html>