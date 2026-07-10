<?php
// Fetch all claims with detailed information
$result = $conn->query("SELECT c.*, 
                        u.full_name, u.email, u.phone,
                        COALESCE(l.item_name, f.item_name) as item_name,
                        COALESCE(l.description, f.description) as item_description,
                        COALESCE(l.image, f.image) as item_image,
                        IF(c.lost_item_id IS NOT NULL, 'lost', 'found') as item_type,
                        IF(c.lost_item_id IS NOT NULL, l.location_lost, f.location_found) as location
                        FROM Claims c
                        JOIN Users u ON c.claimant_id = u.id
                        LEFT JOIN Lost_Items l ON c.lost_item_id = l.id
                        LEFT JOIN Found_Items f ON c.found_item_id = f.id
                        ORDER BY 
                            CASE c.status 
                                WHEN 'Pending' THEN 1 
                                WHEN 'Approved' THEN 2 
                                WHEN 'Rejected' THEN 3 
                            END,
                            c.created_at DESC");

$pending_count = $conn->query("SELECT COUNT(*) as count FROM Claims WHERE status='Pending'")->fetch_assoc()['count'];
?>

<div class="row mb-4">
    <div class="col-md-12">
        <?php if ($pending_count > 0): ?>
        <div class="alert alert-warning d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
            <div>
                <strong>Action Required:</strong> You have <?php echo $pending_count; ?> pending claim(s) awaiting verification.
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="card section-card">
    <div class="card-header bg-warning text-dark d-flex align-items-center justify-content-between">
        <span class="fw-semibold"><i class="bi bi-clipboard-check-fill me-2"></i>Claims Management</span>
        <div class="btn-group btn-group-sm">
            <button class="btn btn-light" onclick="filterClaims('all')">All</button>
            <button class="btn btn-warning" onclick="filterClaims('Pending')">Pending</button>
            <button class="btn btn-success" onclick="filterClaims('Approved')">Approved</button>
            <button class="btn btn-danger" onclick="filterClaims('Rejected')">Rejected</button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle" id="claimsTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Claimant</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Verification</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr data-status="<?php echo $row['status']; ?>">
                <td class="fw-bold">#<?php echo $row['id']; ?></td>
                <td>
                    <div class="fw-semibold"><?php echo htmlspecialchars($row['full_name']); ?></div>
                    <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                </td>
                <td>
                    <div class="fw-semibold"><?php echo htmlspecialchars($row['item_name'] ?? 'N/A'); ?></div>
                    <span class="badge <?php echo $row['item_type'] === 'lost' ? 'bg-danger' : 'bg-success'; ?>">
                        <?php echo ucfirst($row['item_type'] ?? 'N/A'); ?>
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="viewClaimDetails(<?php echo $row['id']; ?>)">
                        <i class="bi bi-eye"></i> View Details
                    </button>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <?php if ($row['otp_verified']): ?>
                        <span class="badge bg-success" title="OTP Verified">
                            <i class="bi bi-shield-check"></i> OTP
                        </span>
                        <?php endif; ?>
                        <?php if ($row['qr_verified']): ?>
                        <span class="badge bg-primary" title="QR Verified">
                            <i class="bi bi-qr-code"></i> QR
                        </span>
                        <?php endif; ?>
                        <?php if (!$row['otp_verified'] && !$row['qr_verified']): ?>
                        <span class="badge bg-secondary">Not Verified</span>
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                    <?php
                    $status = $row['status'];
                    $badge = 'bg-secondary';
                    if ($status === 'Approved') $badge = 'bg-success';
                    elseif ($status === 'Rejected') $badge = 'bg-danger';
                    elseif ($status === 'Pending') $badge = 'bg-warning text-dark';
                    ?>
                    <span class="badge <?php echo $badge; ?>">
                        <?php echo $status; ?>
                    </span>
                </td>
                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                    <button class="btn btn-sm btn-success" 
                            onclick="processClaim(<?php echo $row['id']; ?>, 'Approved')"
                            title="Approve Claim">
                        <i class="bi bi-check-circle"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" 
                            onclick="processClaim(<?php echo $row['id']; ?>, 'Rejected')"
                            title="Reject Claim">
                        <i class="bi bi-x-circle"></i>
                    </button>
                    <?php else: ?>
                    <span class="text-muted small">Processed</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<!-- Claim Details Modal -->
<div class="modal fade" id="claimDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-file-text me-2"></i>Claim Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="claimDetailsContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterClaims(status) {
    const rows = document.querySelectorAll('#claimsTable tbody tr');
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function viewClaimDetails(claimId) {
    const modal = new bootstrap.Modal(document.getElementById('claimDetailsModal'));
    modal.show();
    
    fetch(`../api/get_claim_details.php?claim_id=${claimId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('claimDetailsContent').innerHTML = data.html;
            } else {
                document.getElementById('claimDetailsContent').innerHTML = 
                    `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            document.getElementById('claimDetailsContent').innerHTML = 
                '<div class="alert alert-danger">Failed to load claim details.</div>';
        });
}

function processClaim(claimId, action) {
    const message = action === 'Approved' 
        ? 'Are you sure you want to approve this claim?' 
        : 'Are you sure you want to reject this claim?';
    
    if (!confirm(message)) return;
    
    const notes = prompt('Add notes (optional):');
    
    fetch('../api/process_claim.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({claim_id: claimId, action: action, notes: notes})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Failed to process claim.');
    });
}
</script>
