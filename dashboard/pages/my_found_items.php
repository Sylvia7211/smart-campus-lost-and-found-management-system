<?php
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM Found_Items WHERE user_id=? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card section-card">
    <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
        <span class="fw-semibold"><i class="bi bi-grid-fill me-2"></i>My Found Items</span>
        <a href="dashboard.php?page=report_found" class="btn btn-sm btn-light">
            <i class="bi bi-plus-circle-fill me-1"></i> Report New Found Item
        </a>
    </div>
    <div class="card-body p-0">

        <?php if ($result->num_rows === 0): ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted" style="font-size:3rem;"></i>
            <p class="text-muted mt-3 mb-0">You haven't reported any found items yet.</p>
            <a href="dashboard.php?page=report_found" class="btn btn-success btn-sm mt-3">Report Found Item</a>
        </div>
        <?php else: ?>

        <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Date Found</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <?php if (!empty($row['image'])): ?>
                    <img src="../assets/uploads/found/<?php echo htmlspecialchars($row['image']); ?>"
                         width="60" height="60" class="rounded object-fit-cover" alt="Item">
                    <?php else: ?>
                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center"
                         style="width:60px;height:60px;">
                        <i class="bi bi-image"></i>
                    </div>
                    <?php endif; ?>
                </td>
                <td class="fw-semibold"><?php echo htmlspecialchars($row['item_name']); ?></td>
                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['category']); ?></span></td>
                <td><?php echo htmlspecialchars($row['location_found']); ?></td>
                <td><?php echo htmlspecialchars($row['date_found']); ?></td>
                <td>
                    <?php
                    $status = $row['status'];
                    $badge  = $status === 'Claimed' ? 'bg-primary' : 'bg-success';
                    ?>
                    <span class="badge <?php echo $badge; ?>">
                        <?php echo htmlspecialchars($status); ?>
                    </span>
                </td>
                <td class="text-center">
                    <a href="../found/edit_found.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-sm btn-primary" title="Edit">
                       <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="../found/delete_found.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Delete this item?')" title="Delete">
                       <i class="bi bi-trash-fill"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>

        <?php endif; ?>

    </div>
</div>
