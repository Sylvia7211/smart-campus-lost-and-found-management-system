<?php
$user_id = $_SESSION['user_id'];

$sql = "SELECT c.*, 
        COALESCE(l.item_name, f.item_name) as item_name,
        COALESCE(l.category, f.category) as category,
        IF(c.lost_item_id IS NOT NULL, 'lost', 'found') as item_type
        FROM Claims c
        LEFT JOIN Lost_Items l ON c.lost_item_id = l.id
        LEFT JOIN Found_Items f ON c.found_item_id = f.id
        WHERE c.claimant_id = ?
        ORDER BY c.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card section-card">
    <div class="card-header bg-warning text-dark">
        <i class="bi bi-clipboard-check-fill me-2"></i>
        <span class="fw-semibold">My Claims</span>
    </div>
    <div class="card-body p-0">

        <?php if ($result->num_rows === 0): ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted" style="font-size:3rem;"></i>
            <p class="text-muted mt-3 mb-0">You haven't made any claims yet.</p>
        </div>
        <?php else: ?>

        <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td class="fw-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'N/A'); ?></td>
                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['category'] ?? 'N/A'); ?></span></td>
                <td>
                    <?php
                    $type_badge = $row['item_type'] === 'lost' ? 'bg-danger' : 'bg-success';
                    ?>
                    <span class="badge <?php echo $type_badge; ?>">
                        <?php echo ucfirst(htmlspecialchars($row['item_type'] ?? 'N/A')); ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($row['reason']); ?></td>
                <td>
                    <?php
                    $status = $row['status'];
                    $badge = 'bg-secondary';
                    if ($status === 'Approved') $badge = 'bg-success';
                    elseif ($status === 'Rejected') $badge = 'bg-danger';
                    elseif ($status === 'Pending') $badge = 'bg-warning text-dark';
                    ?>
                    <span class="badge <?php echo $badge; ?>">
                        <?php echo ucfirst(htmlspecialchars($status)); ?>
                    </span>
                </td>
                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>

        <?php endif; ?>

    </div>
</div>
