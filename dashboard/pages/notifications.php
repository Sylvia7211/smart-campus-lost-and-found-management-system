<?php
$user_id = $_SESSION['user_id'];

// Mark all as read if requested
if (isset($_GET['mark_all_read'])) {
    $upd = $conn->prepare("UPDATE Notifications SET is_read = 1 WHERE user_id = ?");
    $upd->bind_param("i", $user_id);
    $upd->execute();
    $upd->close();
    header("Location: dashboard.php?page=notifications");
    exit();
}

// Mark single as read
if (isset($_GET['mark_read'])) {
    $notif_id = intval($_GET['mark_read']);
    $upd = $conn->prepare("UPDATE Notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
    $upd->bind_param("ii", $notif_id, $user_id);
    $upd->execute();
    $upd->close();
    header("Location: dashboard.php?page=notifications");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM Notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card section-card">
    <div class="card-header bg-info text-white d-flex align-items-center justify-content-between">
        <span class="fw-semibold"><i class="bi bi-bell-fill me-2"></i>Notifications</span>
        <?php if ($result->num_rows > 0): ?>
        <a href="dashboard.php?page=notifications&mark_all_read=1" class="btn btn-sm btn-light">
            <i class="bi bi-check-all me-1"></i> Mark All as Read
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body p-0">

        <?php if ($result->num_rows === 0): ?>
        <div class="text-center py-5">
            <i class="bi bi-bell-slash text-muted" style="font-size:3rem;"></i>
            <p class="text-muted mt-3 mb-0">No notifications yet.</p>
        </div>
        <?php else: ?>

        <div class="list-group list-group-flush">
            <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            $is_read = $row['is_read'] == 1;
            $bg_class = $is_read ? '' : 'bg-light';
            ?>
            <div class="list-group-item list-group-item-action d-flex gap-3 <?php echo $bg_class; ?>">
                <div class="flex-shrink-0">
                    <?php if (!$is_read): ?>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:40px;height:40px;">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <?php else: ?>
                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:40px;height:40px;">
                        <i class="bi bi-bell"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold"><?php echo htmlspecialchars($row['message']); ?></div>
                    <small class="text-muted"><?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></small>
                </div>
                <?php if (!$is_read): ?>
                <div class="flex-shrink-0">
                    <a href="dashboard.php?page=notifications&mark_read=<?php echo $row['id']; ?>"
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-check"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>

        <?php endif; ?>

    </div>
</div>
