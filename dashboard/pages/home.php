<?php
$user_id   = $_SESSION['user_id'];
$full_name = htmlspecialchars($_SESSION['full_name']);

// Stats
$lost_count  = 0;
$found_count = 0;
$claim_count = 0;
$notif_count = 0;

$q = $conn->prepare("SELECT COUNT(*) FROM Lost_Items WHERE user_id = ?");
if ($q) { $q->bind_param("i", $user_id); $q->execute(); $q->bind_result($lost_count);  $q->fetch(); $q->close(); }

$q = $conn->prepare("SELECT COUNT(*) FROM Found_Items WHERE user_id = ?");
if ($q) { $q->bind_param("i", $user_id); $q->execute(); $q->bind_result($found_count); $q->fetch(); $q->close(); }

$q = $conn->prepare("SELECT COUNT(*) FROM Claims WHERE claimant_id = ?");
if ($q) { $q->bind_param("i", $user_id); $q->execute(); $q->bind_result($claim_count); $q->fetch(); $q->close(); }

$q = $conn->prepare("SELECT COUNT(*) FROM Notifications WHERE user_id = ? AND is_read = 0");
if ($q) { $q->bind_param("i", $user_id); $q->execute(); $q->bind_result($notif_count); $q->fetch(); $q->close(); }

// Recent lost items (last 5)
$recent_lost = [];
$q = $conn->prepare("SELECT item_name, category, status, date_lost FROM Lost_Items WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
if ($q) {
    $q->bind_param("i", $user_id);
    $q->execute();
    $recent_lost = $q->get_result()->fetch_all(MYSQLI_ASSOC);
    $q->close();
}

// Recent found items (last 5)
$recent_found = [];
$q = $conn->prepare("SELECT item_name, category, status, date_found FROM Found_Items WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
if ($q) {
    $q->bind_param("i", $user_id);
    $q->execute();
    $recent_found = $q->get_result()->fetch_all(MYSQLI_ASSOC);
    $q->close();
}
?>

<!-- Welcome banner -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Welcome back, <?php echo $full_name; ?> 👋</h4>
        <p class="text-muted small mb-0">Here's what's happening with your items today.</p>
    </div>
    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
        <?php echo date('D, d M Y'); ?>
    </span>
</div>

<!-- Stat cards -->
<div class="row g-3 mb-4">

    <div class="col-6 col-lg-3">
        <a href="dashboard.php?page=my_lost_items" class="text-decoration-none">
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
        <a href="dashboard.php?page=my_found_items" class="text-decoration-none">
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
                    <div class="small text-muted">Claims</div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="dashboard.php?page=notifications" class="text-decoration-none">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-info-subtle text-info">
                    <i class="bi bi-bell-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-dark"><?php echo $notif_count; ?></div>
                    <div class="small text-muted">Unread Alerts</div>
                </div>
            </div>
        </div>
        </a>
    </div>

</div>

<!-- Quick actions -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <h6 class="fw-semibold text-muted text-uppercase" style="font-size:.72rem;letter-spacing:.07em;">Quick Actions</h6>
    </div>
    <div class="col-6 col-md-3">
        <a href="dashboard.php?page=report_lost" class="btn btn-danger w-100 d-flex align-items-center gap-2 justify-content-center py-2">
            <i class="bi bi-exclamation-circle-fill"></i> Report Lost
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="dashboard.php?page=report_found" class="btn btn-success w-100 d-flex align-items-center gap-2 justify-content-center py-2">
            <i class="bi bi-plus-circle-fill"></i> Report Found
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="dashboard.php?page=search" class="btn btn-outline-primary w-100 d-flex align-items-center gap-2 justify-content-center py-2">
            <i class="bi bi-search"></i> Search Items
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="dashboard.php?page=profile" class="btn btn-outline-secondary w-100 d-flex align-items-center gap-2 justify-content-center py-2">
            <i class="bi bi-person-circle"></i> My Profile
        </a>
    </div>
</div>

<!-- Recent items tables -->
<div class="row g-3">

    <!-- Recent lost -->
    <div class="col-12 col-xl-6">
        <div class="card section-card h-100">
            <div class="card-header bg-danger text-white d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-exclamation-circle-fill me-2"></i>Recent Lost Items</span>
                <a href="dashboard.php?page=my_lost_items" class="btn btn-sm btn-light">View all</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recent_lost)): ?>
                <p class="text-muted text-center py-4 mb-0">No lost items reported yet.</p>
                <?php else: ?>
                <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th><th>Category</th><th>Date</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recent_lost as $r): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($r['item_name']); ?></td>
                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($r['category']); ?></span></td>
                        <td><?php echo htmlspecialchars($r['date_lost']); ?></td>
                        <td>
                            <span class="badge <?php echo $r['status'] === 'Claimed' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                <?php echo htmlspecialchars($r['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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
                <a href="dashboard.php?page=my_found_items" class="btn btn-sm btn-light">View all</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recent_found)): ?>
                <p class="text-muted text-center py-4 mb-0">No found items reported yet.</p>
                <?php else: ?>
                <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th><th>Category</th><th>Date</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recent_found as $r): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($r['item_name']); ?></td>
                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($r['category']); ?></span></td>
                        <td><?php echo htmlspecialchars($r['date_found']); ?></td>
                        <td>
                            <span class="badge <?php echo $r['status'] === 'Claimed' ? 'bg-primary' : 'bg-success'; ?>">
                                <?php echo htmlspecialchars($r['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
