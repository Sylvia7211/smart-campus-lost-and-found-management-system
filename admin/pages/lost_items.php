<?php
$result = $conn->query("SELECT l.*, u.full_name FROM Lost_Items l 
                        JOIN Users u ON l.user_id = u.id 
                        ORDER BY l.created_at DESC");
?>

<div class="card section-card">
    <div class="card-header bg-danger text-white">
        <i class="bi bi-exclamation-circle-fill me-2"></i>
        <span class="fw-semibold">All Lost Items</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Reporter</th>
                    <th>Location</th>
                    <th>Date Lost</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <?php if (!empty($row['image'])): ?>
                    <img src="../assets/uploads/lost/<?php echo htmlspecialchars($row['image']); ?>"
                         width="50" height="50" class="rounded object-fit-cover">
                    <?php else: ?>
                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;">
                        <i class="bi bi-image"></i>
                    </div>
                    <?php endif; ?>
                </td>
                <td class="fw-semibold"><?php echo htmlspecialchars($row['item_name']); ?></td>
                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['category']); ?></span></td>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['location_lost']); ?></td>
                <td><?php echo htmlspecialchars($row['date_lost']); ?></td>
                <td>
                    <span class="badge <?php echo $row['status'] === 'Claimed' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                        <?php echo htmlspecialchars($row['status']); ?>
                    </span>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
