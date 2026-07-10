<?php
require_once "../config/database.php";
require_once "../config/session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

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

        $_SESSION['success'] = "Lost Item Reported Successfully!";
        header("Location: ../dashboard/dashboard.php?page=my_lost_items");
        exit();

    } else {

        $_SESSION['error'] = "Database Error: " . $stmt->error;
        header("Location: ../dashboard/dashboard.php?page=report_lost");
        exit();

    }

    $stmt->close();
    $conn->close();
}
?>