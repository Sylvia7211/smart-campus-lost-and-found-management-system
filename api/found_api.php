<?php
require_once "../config/database.php";
require_once "../config/session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    $item_name = trim($_POST['item_name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $location_found = trim($_POST['location_found']);
    $date_found = $_POST['date_found'];

    $image = "";

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $targetDir = "../assets/uploads/found/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $imageName;
        }
    }

    $sql = "INSERT INTO Found_Items
            (user_id, item_name, category, description, location_found, date_found, image)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "issssss",
        $user_id,
        $item_name,
        $category,
        $description,
        $location_found,
        $date_found,
        $image
    );

    if ($stmt->execute()) {

        $_SESSION['success'] = "Found Item Reported Successfully!";
        header("Location: ../dashboard/dashboard.php?page=my_found_items");
        exit();

    } else {

        $_SESSION['error'] = "Database Error: " . $stmt->error;
        header("Location: ../dashboard/dashboard.php?page=report_found");
        exit();

    }

    $stmt->close();
    $conn->close();
}
?>