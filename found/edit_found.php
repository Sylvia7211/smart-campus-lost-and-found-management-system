<?php
require_once "../config/database.php";
require_once "../config/session.php";

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM Found_Items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Item not found.");
}

$item = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_name = trim($_POST['item_name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $location_found = trim($_POST['location_found']);
    $date_found = $_POST['date_found'];

    $update = $conn->prepare("
        UPDATE Found_Items
        SET item_name=?,
            category=?,
            description=?,
            location_found=?,
            date_found=?
        WHERE id=?
    ");

    $update->bind_param(
        "sssssi",
        $item_name,
        $category,
        $description,
        $location_found,
        $date_found,
        $id
    );

    if ($update->execute()) {
        echo "<script>
                alert('Found item updated successfully!');
                window.location='my_found_items.php';
              </script>";
        exit;
    } else {
        echo "Error: " . $update->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Found Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">
    <h3>Edit Found Item</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Item Name</label>
<input type="text" name="item_name" class="form-control"
value="<?= htmlspecialchars($item['item_name']) ?>" required>
</div>

<div class="mb-3">
<label>Category</label>
<input type="text" name="category" class="form-control"
value="<?= htmlspecialchars($item['category']) ?>" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($item['description']) ?></textarea>
</div>

<div class="mb-3">
<label>Location Found</label>
<input type="text" name="location_found" class="form-control"
value="<?= htmlspecialchars($item['location_found']) ?>" required>
</div>

<div class="mb-3">
<label>Date Found</label>
<input type="date" name="date_found" class="form-control"
value="<?= $item['date_found'] ?>" required>
</div>

<button class="btn btn-success">Update Item</button>

<a href="my_found_items.php" class="btn btn-secondary">Cancel</a>

</form>

</div>

</div>

</div>

</body>
</html>