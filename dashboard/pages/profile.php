<?php
$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM Users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    echo '<div class="alert alert-danger">User not found.</div>';
    return;
}
?>

<div class="row g-3">

    <!-- Profile card -->
    <div class="col-12 col-lg-4">
        <div class="card section-card text-center">
            <div class="card-body py-4">
                <div class="avatar-lg mx-auto mb-3">
                    <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                </div>
                <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($user['full_name']); ?></h5>
                <p class="text-muted mb-3"><?php echo htmlspecialchars($user['email']); ?></p>
                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                    <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                </span>
            </div>
        </div>

        <div class="card section-card mt-3">
            <div class="card-header bg-light">
                <span class="fw-semibold"><i class="bi bi-info-circle me-2"></i>Account Info</span>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">Phone</small>
                    <div class="fw-semibold"><?php echo htmlspecialchars($user['phone'] ?? 'Not set'); ?></div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Member Since</small>
                    <div class="fw-semibold"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit profile form -->
    <div class="col-12 col-lg-8">
        <div class="card section-card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-pencil-square me-2"></i>
                <span class="fw-semibold">Edit Profile</span>
            </div>
            <div class="card-body">
                <form action="../api/profile_api.php" method="POST" class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="full_name" class="form-control"
                               value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="+254 700 000 000">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Role</label>
                        <input type="text" class="form-control" value="<?php echo ucfirst(htmlspecialchars($user['role'])); ?>" disabled>
                    </div>

                    <div class="col-12">
                        <hr>
                        <h6 class="fw-semibold mb-3">Change Password (Optional)</h6>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Leave blank to keep current">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle-fill me-1"></i> Update Profile
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

<style>
    .avatar-lg {
        width: 100px; height: 100px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 2.5rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
</style>
