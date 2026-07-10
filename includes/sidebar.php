<?php
// Determine current page for active state
$current_page = $_GET['page'] ?? 'home';

// Determine base path depending on whether we are in /dashboard or /admin
$is_in_admin = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false);
$base = $is_in_admin ? 'dashboard.php' : 'dashboard.php';

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<nav id="sidebar" class="d-flex flex-column flex-shrink-0 p-0">

    <!-- Brand -->
    <a href="<?php echo $base; ?>" class="sidebar-brand d-flex align-items-center gap-2 px-3 py-3 text-decoration-none">
        <i class="bi bi-search-heart-fill fs-4"></i>
        <span class="fw-bold fs-6">Smart Campus</span>
    </a>

    <hr class="sidebar-divider">

    <ul class="nav nav-pills flex-column px-2 gap-1 flex-grow-1">

        <?php if ($is_in_admin): ?>
        <!-- Admin navigation -->
        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=admin"
               class="nav-link <?php echo $current_page === 'admin' ? 'active' : ''; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=users"
               class="nav-link <?php echo $current_page === 'users' ? 'active' : ''; ?>">
                <i class="bi bi-people-fill me-2"></i> Users
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=lost_items"
               class="nav-link <?php echo $current_page === 'lost_items' ? 'active' : ''; ?>">
                <i class="bi bi-exclamation-circle-fill me-2"></i> Lost Items
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=found_items"
               class="nav-link <?php echo $current_page === 'found_items' ? 'active' : ''; ?>">
                <i class="bi bi-hand-thumbs-up-fill me-2"></i> Found Items
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=claims"
               class="nav-link <?php echo $current_page === 'claims' ? 'active' : ''; ?>">
                <i class="bi bi-clipboard-check-fill me-2"></i> Claims
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=reports"
               class="nav-link <?php echo $current_page === 'reports' ? 'active' : ''; ?>">
                <i class="bi bi-file-earmark-bar-graph-fill me-2"></i> Reports
            </a>
        </li>

        <li class="nav-item sidebar-section-label">User View</li>

        <li class="nav-item">
            <a href="../dashboard/dashboard.php" class="nav-link">
                <i class="bi bi-arrow-left-circle me-2"></i> Back to User Dashboard
            </a>
        </li>

        <?php else: ?>
        <!-- Student navigation -->

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=home"
               class="nav-link <?php echo $current_page === 'home' ? 'active' : ''; ?>">
                <i class="bi bi-house-door-fill me-2"></i> Home
            </a>
        </li>

        <li class="nav-item sidebar-section-label">Lost Items</li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=report_lost"
               class="nav-link <?php echo $current_page === 'report_lost' ? 'active' : ''; ?>">
                <i class="bi bi-exclamation-circle-fill me-2"></i> Report Lost Item
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=my_lost_items"
               class="nav-link <?php echo $current_page === 'my_lost_items' ? 'active' : ''; ?>">
                <i class="bi bi-list-ul me-2"></i> My Lost Items
            </a>
        </li>

        <li class="nav-item sidebar-section-label">Found Items</li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=report_found"
               class="nav-link <?php echo $current_page === 'report_found' ? 'active' : ''; ?>">
                <i class="bi bi-plus-circle-fill me-2"></i> Report Found Item
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=my_found_items"
               class="nav-link <?php echo $current_page === 'my_found_items' ? 'active' : ''; ?>">
                <i class="bi bi-grid-fill me-2"></i> My Found Items
            </a>
        </li>

        <li class="nav-item sidebar-section-label">Other</li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=search"
               class="nav-link <?php echo $current_page === 'search' ? 'active' : ''; ?>">
                <i class="bi bi-search me-2"></i> Search
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=profile"
               class="nav-link <?php echo $current_page === 'profile' ? 'active' : ''; ?>">
                <i class="bi bi-person-circle me-2"></i> Profile
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=claims"
               class="nav-link <?php echo $current_page === 'claims' ? 'active' : ''; ?>">
                <i class="bi bi-clipboard-check-fill me-2"></i> Claims
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $base; ?>?page=notifications"
               class="nav-link <?php echo $current_page === 'notifications' ? 'active' : ''; ?>">
                <i class="bi bi-bell-fill me-2"></i> Notifications
            </a>
        </li>

        <?php if ($is_admin): ?>
        <li class="nav-item sidebar-section-label">Admin</li>
        <li class="nav-item">
            <a href="../admin/dashboard.php"
               class="nav-link">
                <i class="bi bi-shield-lock-fill me-2"></i> Admin Dashboard
            </a>
        </li>
        <?php endif; ?>

        <?php endif; // end student nav ?>

    </ul>

    <hr class="sidebar-divider">

    <!-- Logout -->
    <div class="px-3 pb-3">
        <a href="../authentication/logout.php" class="btn btn-outline-danger btn-sm w-100">
            <i class="bi bi-box-arrow-left me-1"></i> Logout
        </a>
    </div>

</nav>
