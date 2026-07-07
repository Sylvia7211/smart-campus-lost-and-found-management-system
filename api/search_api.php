<?php
include("../config/database.php");

$query = $_GET['query'];

$sql = "SELECT * FROM lost_items WHERE item_name LIKE ?";
$stmt = $conn->prepare($sql);

$search = "%" . $query . "%";
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();