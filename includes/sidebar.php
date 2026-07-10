<div class="bg-dark text-white p-3 vh-100" style="width:250px;">

    <h4 class="text-center mb-4">
        Menu
    </h4>

    <ul class="nav flex-column">

        <li class="nav-item mb-2">
            <a href="../dashboard/dashboard.php" class="nav-link text-white">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="../lost/report_lost.php" class="nav-link text-white">
                <i class="bi bi-exclamation-circle"></i>
                Report Lost Item
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="../found/report_found.php" class="nav-link text-white">
                <i class="bi bi-check-circle"></i>
                Report Found Item
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="../claims/my_claims.php" class="nav-link text-white">
                <i class="bi bi-file-earmark-text"></i>
                My Claims
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="../profile/profile.php" class="nav-link text-white">
                <i class="bi bi-person-circle"></i>
                Profile
            </a>
        </li>

        <?php
        if(isset($_SESSION['role']) && $_SESSION['role']=="admin")
        {
        ?>

        <li class="nav-item mt-3">

            <h6 class="text-warning">
                Admin
            </h6>

        </li>

        <li class="nav-item mb-2">
            <a href="../admin/dashboard.php" class="nav-link text-white">
                Admin Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="../admin/users.php" class="nav-link text-white">
                Manage Users
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="../admin/reports.php" class="nav-link text-white">
                Reports
            </a>
        </li>

        <?php
        }
        ?>

    </ul>

</div>