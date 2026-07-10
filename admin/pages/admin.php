<?php
// Count users
$users_result = $conn->query("SELECT COUNT(*) as count FROM Users");
$user_count = $users_result->fetch_assoc()['count'];

// Count lost items
$lost_result = $conn->query("SELECT COUNT(*) as count FROM Lost_Items");
$lost_count = $lost_result->fetch_assoc()['count'];

// Count found items
$found_result = $conn->query("SELECT COUNT(*) as count FROM Found_Items");
$found_count = $found_result->fetch_assoc()['count'];

// Count claims
$claims_result = $conn->query("SELECT COUNT(*) as count FROM Claims");
$claim_count = $claims_result->fetch_assoc()['count'];

// Count pending claims
$pending_claims = $conn->query("SELECT COUNT(*) as count FROM Claims WHERE status='Pending'")->fetch_assoc()['count'];

// Recent activity
$recent_lost = $conn->query("SELECT l.*, u.full_name FROM Lost_Items l 
                             JOIN Users u ON l.user_id = u.id 
                             ORDER BY l.created_at DESC LIMIT 5");

$recent_found = $conn->query("SELECT f.*, u.full_name FROM Found_Items f 
                              JOIN Users u ON f.user_id = u.id 
                              ORDER BY f.created_at DESC LIMIT 5");
?>

<!-- Welcome banner -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Admin Dashboard 🛡️</h4>
        <p class="text-muted small mb-0">Monitor and manage the Lost &amp; Found system.</p>
    </div>
    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
        <?php echo date('D, d M Y'); ?>
    </span>
</div>

<!-- Stat cards -->
<div class="row g-3 mb-4">

    <div class="col-6 col-lg-3">
        <a href="dashboard.php?page=users" class="text-decoration-none">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-dark"><?php echo $user_count; ?></div>
                    <div class="small text-muted">Total Users</div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="dashboard.php?page=lost_items" class="text-decoration-none">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-dark"><?php echo $lost_count; ?></div>
                    <div class="small text-muted">Lost Items</div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="dashboard.php?page=found_items" class="text-decoration-none">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-dark"><?php echo $found_count; ?></div>
                    <div class="small text-muted">Found Items</div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="dashboard.php?page=claims" class="text-decoration-none">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-clipboard-check-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-dark"><?php echo $claim_count; ?></div>
                    <div class="small text-muted">Total Claims</div>
                </div>
            </div>
        </div>
        </a>
    </div>

</div>

<?php if ($pending_claims > 0): ?>
<div class="alert alert-warning d-flex align-items-center gap-3 mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
    <div>
        <strong>Attention:</strong> You have <?php echo $pending_claims; ?> pending claim(s) that need review.
        <a href="dashboard.php?page=claims" class="alert-link">Review now</a>
    </div>
</div>
<?php endif; ?>

<!-- Recent activity tables -->
<div class="row g-3">

    <!-- Recent lost -->
    <div class="col-12 col-xl-6">
        <div class="card section-card h-100">
            <div class="card-header bg-danger text-white d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-exclamation-circle-fill me-2"></i>Recent Lost Items</span>
                <a href="dashboard.php?page=lost_items" class="btn btn-sm btn-light">View all</a>
            </div>
            <div class="card-body p-0">
                <?php if ($recent_lost->num_rows === 0): ?>
                <p class="text-muted text-center py-4 mb-0">No lost items yet.</p>
                <?php else: ?>
                <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th><th>Reporter</th><th>Status</th><th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($r = $recent_lost->fetch_assoc()): ?>
                    <tr>
                        <td class="fw-semibold"><?php echo htmlspecialchars($r['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($r['full_name']); ?></td>
                        <td>
                            <span class="badge <?php echo $r['status'] === 'Claimed' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                <?php echo htmlspecialchars($r['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d', strtotime($r['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent found -->
    <div class="col-12 col-xl-6">
        <div class="card section-card h-100">
            <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-hand-thumbs-up-fill me-2"></i>Recent Found Items</span>
                <a href="dashboard.php?page=found_items" class="btn btn-sm btn-light">View all</a>
            </div>
            <div class="card-body p-0">
                <?php if ($recent_found->num_rows === 0): ?>
                <p class="text-muted text-center py-4 mb-0">No found items yet.</p>
                <?php else: ?>
                <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th><th>Reporter</th><th>Status</th><th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($r = $recent_found->fetch_assoc()): ?>
                    <tr>
                        <td class="fw-semibold"><?php echo htmlspecialchars($r['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($r['full_name']); ?></td>
                        <td>
                            <span class="badge <?php echo $r['status'] === 'Claimed' ? 'bg-primary' : 'bg-success'; ?>">
                                <?php echo htmlspecialchars($r['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d', strtotime($r['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
