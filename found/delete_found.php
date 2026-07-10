<?php
require_once "../config/database.php";
require_once "../config/session.php";

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT image FROM Found_Items WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Item not found.");
}

$item = $result->fetch_assoc();

if (!empty($item['image'])) {
    $imagePath = "../assets/uploads/found/" . $item['image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

$delete = $conn->prepare("DELETE FROM Found_Items WHERE id=?");
$delete->bind_param("i", $id);

if ($delete->execute()) {

    echo "<script>
            alert('Found item deleted successfully!');
            window.location='my_found_items.php';
          </script>";

} else {

    echo "Error: " . $delete->error;

}

$delete->close();
$conn->close();
?>