<?php
$result = $conn->query("SELECT * FROM Users ORDER BY created_at DESC");
?>

<div class="card section-card">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-people-fill me-2"></i>
        <span class="fw-semibold">Manage Users</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td class="fw-semibold"><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                <td>
                    <span class="badge <?php echo $row['role'] === 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                        <?php echo ucfirst(htmlspecialchars($row['role'])); ?>
                    </span>
                </td>
                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
