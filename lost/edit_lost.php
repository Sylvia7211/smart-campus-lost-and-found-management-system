<?php
require_once "../config/database.php";
require_once "../config/session.php";

if (!isset($_GET['id'])) {
    die("Invalid Request");
}

$id = $_GET['id'];

// Fetch the item
$stmt = $conn->prepare("SELECT * FROM Lost_Items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Lost item not found.");
}

$item = $result->fetch_assoc();

// Update item
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_name = trim($_POST['item_name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $location_lost = trim($_POST['location_lost']);
    $date_lost = $_POST['date_lost'];
    $reward = $_POST['reward'];

    $update = $conn->prepare("
        UPDATE Lost_Items
        SET item_name=?,
            category=?,
            description=?,
            location_lost=?,
            date_lost=?,
            reward=?
        WHERE id=?
    ");

    $update->bind_param(
        "sssssdi",
        $item_name,
        $category,
        $description,
        $location_lost,
        $date_lost,
        $reward,
        $id
    );

    if ($update->execute()) {

        echo "<script>
                alert('Lost item updated successfully.');
                window.location='my_lost_items.php';
              </script>";
        exit;
    } else {
        echo "Error: " . $update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Lost Item</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3>Edit Lost Item</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Item Name</label>
<input
type="text"
name="item_name"
class="form-control"
value="<?= htmlspecialchars($item['item_name']) ?>"
required>
</div>

<div class="mb-3">
<label>Category</label>
<input
type="text"
name="category"
class="form-control"
value="<?= htmlspecialchars($item['category']) ?>"
required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea
name="description"
class="form-control"
rows="4"
required><?= htmlspecialchars($item['description']) ?></textarea>
</div>

<div class="mb-3">
<label>Location Lost</label>
<input
type="text"
name="location_lost"
class="form-control"
value="<?= htmlspecialchars($item['location_lost']) ?>"
required>
</div>

<div class="mb-3">
<label>Date Lost</label>
<input
type="date"
name="date_lost"
class="form-control"
value="<?= $item['date_lost'] ?>"
required>
</div>

<div class="mb-3">
<label>Reward</label>
<input
type="number"
step="0.01"
name="reward"
class="form-control"
value="<?= $item['reward'] ?>">
</div>

<button class="btn btn-primary">
Update Item
</button>

<a href="my_lost_items.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</div>

</div>

</body>
</html>