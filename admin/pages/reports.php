<?php
// Generate basic reports
$total_users = $conn->query("SELECT COUNT(*) as count FROM Users")->fetch_assoc()['count'];
$total_lost = $conn->query("SELECT COUNT(*) as count FROM Lost_Items")->fetch_assoc()['count'];
$total_found = $conn->query("SELECT COUNT(*) as count FROM Found_Items")->fetch_assoc()['count'];
$total_claims = $conn->query("SELECT COUNT(*) as count FROM Claims")->fetch_assoc()['count'];

$lost_status = $conn->query("SELECT status, COUNT(*) as count FROM Lost_Items GROUP BY status");
$found_status = $conn->query("SELECT status, COUNT(*) as count FROM Found_Items GROUP BY status");
$claim_status = $conn->query("SELECT status, COUNT(*) as count FROM Claims GROUP BY status");

$category_stats = $conn->query("SELECT category, COUNT(*) as count FROM Lost_Items GROUP BY category ORDER BY count DESC LIMIT 5");
?>

<div class="card section-card mb-4">
    <div class="card-header bg-info text-white">
        <i class="bi bi-file-earmark-bar-graph-fill me-2"></i>
        <span class="fw-semibold">System Reports &amp; Analytics</span>
    </div>
    <div class="card-body">
        <h6 class="fw-semibold mb-3">Overview Statistics</h6>
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="text-center p-3 bg-light rounded">
                    <div class="fs-3 fw-bold text-primary"><?php echo $total_users; ?></div>
                    <div class="small text-muted">Total Users</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center p-3 bg-light rounded">
                    <div class="fs-3 fw-bold text-danger"><?php echo $total_lost; ?></div>
                    <div class="small text-muted">Lost Items</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center p-3 bg-light rounded">
                    <div class="fs-3 fw-bold text-success"><?php echo $total_found; ?></div>
                    <div class="small text-muted">Found Items</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="text-center p-3 bg-light rounded">
                    <div class="fs-3 fw-bold text-warning"><?php echo $total_claims; ?></div>
                    <div class="small text-muted">Claims</div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-semibold mb-3">Lost Items by Status</h6>
                <ul class="list-group">
                <?php while ($r = $lost_status->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo ucfirst(htmlspecialchars($r['status'])); ?>
                        <span class="badge bg-primary rounded-pill"><?php echo $r['count']; ?></span>
                    </li>
                <?php endwhile; ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="fw-semibold mb-3">Claims by Status</h6>
                <ul class="list-group">
                <?php while ($r = $claim_status->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo ucfirst(htmlspecialchars($r['status'])); ?>
                        <span class="badge bg-warning rounded-pill"><?php echo $r['count']; ?></span>
                    </li>
                <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <hr>

        <h6 class="fw-semibold mb-3">Top 5 Lost Item Categories</h6>
        <ul class="list-group">
        <?php while ($r = $category_stats->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo htmlspecialchars($r['category']); ?>
                <span class="badge bg-secondary rounded-pill"><?php echo $r['count']; ?></span>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
</div>
