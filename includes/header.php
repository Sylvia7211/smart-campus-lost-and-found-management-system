<?php
// Page title map
$page_titles = [
    'home'           => 'Dashboard',
    'report_lost'    => 'Report Lost Item',
    'my_lost_items'  => 'My Lost Items',
    'report_found'   => 'Report Found Item',
    'my_found_items' => 'My Found Items',
    'search'         => 'Search Items',
    'profile'        => 'My Profile',
    'claims'         => 'My Claims',
    'notifications'  => 'Notifications',
    'admin'          => 'Admin Dashboard',
];

$current_page  = $_GET['page'] ?? 'home';
$page_title    = $page_titles[$current_page] ?? 'Dashboard';
$full_name     = htmlspecialchars($_SESSION['full_name'] ?? 'User');
$role          = htmlspecialchars($_SESSION['role'] ?? '');

// Unread notifications count
$notif_count = 0;
if (isset($conn)) {
    $uid = $_SESSION['user_id'];
    $nq  = $conn->prepare("SELECT COUNT(*) FROM Notifications WHERE user_id = ? AND is_read = 0");
    if ($nq) {
        $nq->bind_param("i", $uid);
        $nq->execute();
        $nq->bind_result($notif_count);
        $nq->fetch();
        $nq->close();
    }
}
?>

<header class="topbar d-flex align-items-center justify-content-between px-4">

    <!-- Hamburger (mobile) -->
    <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle">
        <i class="bi bi-list fs-5"></i>
    </button>

    <!-- Page title -->
    <h5 class="mb-0 fw-semibold topbar-title"><?php echo $page_title; ?></h5>

    <!-- Right side -->
    <div class="d-flex align-items-center gap-3">

        <!-- Notifications bell -->
        <a href="dashboard.php?page=notifications" class="position-relative text-decoration-none text-dark">
            <i class="bi bi-bell-fill fs-5"></i>
            <?php if ($notif_count > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.6rem;">
                <?php echo $notif_count; ?>
            </span>
            <?php endif; ?>
        </a>

        <!-- User avatar/name -->
        <div class="dropdown">
            <button class="btn btn-sm btn-light d-flex align-items-center gap-2 dropdown-toggle" data-bs-toggle="dropdown">
                <div class="avatar-sm">
                    <?php echo strtoupper(substr($full_name, 0, 1)); ?>
                </div>
                <span class="d-none d-md-inline"><?php echo $full_name; ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><span class="dropdown-item-text small text-muted"><?php echo $role; ?></span></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="dashboard.php?page=profile">
                        <i class="bi bi-person me-2"></i>Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="../authentication/logout.php">
                        <i class="bi bi-box-arrow-left me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>

</header>
