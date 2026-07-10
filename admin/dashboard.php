<?php
require_once "../config/session.php";
requireAdmin();
require_once "../config/database.php";

$page = $_GET['page'] ?? 'admin';

// Whitelist allowed admin pages
$allowed_pages = ['admin', 'users', 'lost_items', 'found_items', 'claims', 'reports'];

if (!in_array($page, $allowed_pages)) {
    $page = 'admin';
}

$partial = __DIR__ . "/pages/{$page}.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard &mdash; Smart Campus</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* ── Layout ─────────────────────────────────── */
        :root {
            --sidebar-width: 240px;
            --topbar-height: 60px;
            --sidebar-bg: #1a1f36;
            --sidebar-hover: #2d3561;
            --sidebar-active: #4361ee;
            --brand-color: #4361ee;
            --footer-h: 46px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6fc;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Sidebar ─────────────────────────────────── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: #cdd5e0;
            position: fixed;
            top: 0; left: 0;
            z-index: 1040;
            overflow-y: auto;
            transition: transform .25s ease;
        }

        #sidebar .sidebar-brand {
            color: #fff;
            background: rgba(255,255,255,.05);
        }
        #sidebar .sidebar-brand:hover { background: rgba(255,255,255,.1); }

        #sidebar .sidebar-divider {
            border-color: rgba(255,255,255,.1);
            margin: .25rem .75rem;
        }

        #sidebar .sidebar-section-label {
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #7a8599;
            padding: .6rem 1rem .2rem;
        }

        #sidebar .nav-link {
            color: #b0bcd0;
            border-radius: 8px;
            padding: .5rem .85rem;
            font-size: .875rem;
            transition: background .18s, color .18s;
        }
        #sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }
        #sidebar .nav-link.active {
            background: var(--sidebar-active);
            color: #fff;
            font-weight: 600;
        }

        /* ── Topbar ──────────────────────────────────── */
        .topbar {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e4e8f0;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 1030;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }

        .topbar-title { color: #1a1f36; }

        .avatar-sm {
            width: 30px; height: 30px;
            background: var(--brand-color);
            color: #fff;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .8rem;
        }

        /* ── Main content ────────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
        }

        .content-area {
            margin-top: var(--topbar-height);
            padding: 1.75rem;
            flex: 1;
        }

        /* ── Footer ──────────────────────────────────── */
        .main-footer {
            background: #fff;
            border-top: 1px solid #e4e8f0;
            height: var(--footer-h);
            line-height: var(--footer-h);
            padding: 0 1.75rem;
        }

        /* ── Cards / misc ────────────────────────────── */
        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            transition: transform .2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        .section-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
        }
        .section-card .card-header {
            border-radius: 14px 14px 0 0 !important;
            border-bottom: none;
            padding: 1rem 1.25rem;
        }

        /* ── Flash messages ──────────────────────────── */
        .flash { border-radius: 10px; font-size: .9rem; }

        /* ── Mobile sidebar overlay ──────────────────── */
        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1039;
        }

        @media (max-width: 991.98px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            .topbar { left: 0; }
            .main-wrapper { margin-left: 0; width: 100%; }
        }
    </style>
</head>
<body>

<!-- Sidebar overlay (mobile) -->
<div id="sidebarOverlay"></div>

<?php include "../includes/sidebar.php"; ?>

<div class="main-wrapper">

    <?php include "../includes/header.php"; ?>

    <main class="content-area">

        <?php
        // Flash messages
        if (!empty($_SESSION['success'])) {
            echo '<div class="alert alert-success flash alert-dismissible fade show" role="alert">'
                . htmlspecialchars($_SESSION['success'])
                . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            unset($_SESSION['success']);
        }
        if (!empty($_SESSION['error'])) {
            echo '<div class="alert alert-danger flash alert-dismissible fade show" role="alert">'
                . htmlspecialchars($_SESSION['error'])
                . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            unset($_SESSION['error']);
        }
        ?>

        <?php
        if (file_exists($partial)) {
            include $partial;
        } else {
            echo '<div class="alert alert-warning">Page not found.</div>';
        }
        ?>

    </main>

    <?php include "../includes/footer.php"; ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mobile sidebar toggle
    const sidebar        = document.getElementById('sidebar');
    const overlay        = document.getElementById('sidebarOverlay');
    const toggleBtn      = document.getElementById('sidebarToggle');

    function openSidebar()  { sidebar.classList.add('show');    overlay.style.display = 'block'; }
    function closeSidebar() { sidebar.classList.remove('show'); overlay.style.display = 'none'; }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
</script>
</body>
</html>
