<?php
require_once "../config/database.php";
require_once "../config/session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Temporary user ID until authentication is completed
    $user_id = 1;

    $item_name = trim($_POST['item_name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $location_lost = trim($_POST['location_lost']);
    $date_lost = $_POST['date_lost'];
    $reward = !empty($_POST['reward']) ? $_POST['reward'] : 0;

    // Image Upload
    $image = "";

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $targetDir = "../assets/uploads/lost/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $imageName;
        }
    }

    // Insert into database
    $sql = "INSERT INTO Lost_Items
            (user_id, item_name, category, description, location_lost, date_lost, image, reward)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "issssssd",
        $user_id,
        $item_name,
        $category,
        $description,
        $location_lost,
        $date_lost,
        $image,
        $reward
    );

    if ($stmt->execute()) {

        echo "<script>
                alert('Lost Item Reported Successfully!');
                window.location='../lost/report_lost.php';
              </script>";

    } else {

        echo "Database Error: " . $stmt->error;

    }

    $stmt->close();
    $conn->close();
}
?>