<?php
require_once "../config/database.php";
require_once "../config/session.php";

// Temporary user until login module is ready
$user_id = 1;

$sql = "SELECT * FROM Lost_Items
        WHERE user_id = ?
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>My Lost Items</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-danger text-white">

            <h3>My Lost Items</h3>

        </div>

        <div class="card-body">

            <a href="report_lost.php" class="btn btn-success mb-3">
                Report New Lost Item
            </a>

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                <tr>

                    <th>Image</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Date Lost</th>
                    <th>Reward</th>
                    <th>Status</th>
                    <th>Actions</th>

                </tr>

                </thead>

                <tbody>

                <?php while($row = $result->fetch_assoc()){ ?>

                <tr>

                    <td>

                        <?php if(!empty($row['image'])){ ?>

                        <img src="../assets/uploads/lost/<?php echo $row['image']; ?>"
                             width="80"
                             class="img-thumbnail">

                        <?php } ?>

                    </td>

                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>

                    <td><?php echo htmlspecialchars($row['category']); ?></td>

                    <td><?php echo htmlspecialchars($row['location_lost']); ?></td>

                    <td><?php echo htmlspecialchars($row['date_lost']); ?></td>

                    <td>Ksh <?php echo number_format($row['reward'],2); ?></td>

                    <td>

                        <span class="badge bg-warning text-dark">

                            <?php echo htmlspecialchars($row['status']); ?>

                        </span>

                    </td>

                    <td>

                        <a href="edit_lost.php?id=<?php echo $row['id']; ?>"
                           class="btn btn-primary btn-sm">
                           Edit
                        </a>

                        <a href="delete_lost.php?id=<?php echo $row['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this lost item?')">
                           Delete
                        </a>

                    </td>

                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>

</html>