<?php
require_once "../config/database.php";
require_once "../config/session.php";

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);

// Get the image filename before deleting
$stmt = $conn->prepare("SELECT image FROM Lost_Items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Lost item not found.");
}

$item = $result->fetch_assoc();

// Delete the image from the uploads folder if it exists
if (!empty($item['image'])) {
    $imagePath = "../assets/uploads/lost/" . $item['image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

// Delete the record from the database
$delete = $conn->prepare("DELETE FROM Lost_Items WHERE id = ?");
$delete->bind_param("i", $id);

if ($delete->execute()) {

    echo "<script>
            alert('Lost item deleted successfully.');
            window.location='my_lost_items.php';
          </script>";

} else {

    echo "Error: " . $delete->error;

}

$delete->close();
$conn->close();
?>