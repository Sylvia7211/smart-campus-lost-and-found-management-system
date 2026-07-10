<?php
require_once "../config/session.php";
requireAdmin();
require_once "../config/database.php";

header('Content-Type: application/json');

$claim_id = $_GET['claim_id'] ?? null;

if (!$claim_id) {
    echo json_encode(['success' => false, 'message' => 'No claim ID provided']);
    exit();
}

// Fetch claim with all details
$stmt = $conn->prepare("SELECT c.*, 
                       u.full_name, u.email, u.phone, u.reg_number,
                       COALESCE(l.item_name, f.item_name) as item_name,
                       COALESCE(l.description, f.description) as item_description,
                       COALESCE(l.category, f.category) as category,
                       COALESCE(l.image, f.image) as item_image,
                       IF(c.lost_item_id IS NOT NULL, 'lost', 'found') as item_type,
                       IF(c.lost_item_id IS NOT NULL, l.location_lost, f.location_found) as location,
                       IF(c.lost_item_id IS NOT NULL, l.date_lost, f.date_found) as incident_date
                       FROM Claims c
                       JOIN Users u ON c.claimant_id = u.id
                       LEFT JOIN Lost_Items l ON c.lost_item_id = l.id
                       LEFT JOIN Found_Items f ON c.found_item_id = f.id
                       WHERE c.id = ?");
$stmt->bind_param("i", $claim_id);
$stmt->execute();
$claim = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$claim) {
    echo json_encode(['success' => false, 'message' => 'Claim not found']);
    exit();
}

// Build HTML content
$html = '<div class="row g-3">';

// Claimant Information
$html .= '<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-light">
            <i class="bi bi-person-fill me-2"></i><strong>Claimant Information</strong>
        </div>
        <div class="card-body">
            <table class="table table-sm mb-0">
                <tr><th width="40%">Name:</th><td>' . htmlspecialchars($claim['full_name']) . '</td></tr>
                <tr><th>Email:</th><td>' . htmlspecialchars($claim['email']) . '</td></tr>
                <tr><th>Phone:</th><td>' . htmlspecialchars($claim['phone']) . '</td></tr>
                <tr><th>Reg Number:</th><td>' . htmlspecialchars($claim['reg_number']) . '</td></tr>
            </table>
        </div>
    </div>
</div>';

// Item Information
$image_path = $claim['item_type'] === 'lost' ? 'lost' : 'found';
$html .= '<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-light">
            <i class="bi bi-box me-2"></i><strong>Item Information</strong>
        </div>
        <div class="card-body">
            <table class="table table-sm mb-0">
                <tr><th width="40%">Item:</th><td>' . htmlspecialchars($claim['item_name']) . '</td></tr>
                <tr><th>Category:</th><td>' . htmlspecialchars($claim['category']) . '</td></tr>
                <tr><th>Type:</th><td><span class="badge ' . ($claim['item_type'] === 'lost' ? 'bg-danger' : 'bg-success') . '">' . ucfirst($claim['item_type']) . '</span></td></tr>
                <tr><th>Location:</th><td>' . htmlspecialchars($claim['location']) . '</td></tr>
                <tr><th>Date:</th><td>' . htmlspecialchars($claim['incident_date']) . '</td></tr>
            </table>
        </div>
    </div>
</div>';

// Item Image
if (!empty($claim['item_image'])) {
    $html .= '<div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light"><i class="bi bi-image me-2"></i><strong>Item Image</strong></div>
            <div class="card-body text-center">
                <img src="../assets/uploads/' . $image_path . '/' . htmlspecialchars($claim['item_image']) . '" 
                     class="img-fluid rounded" style="max-height:300px;">
            </div>
        </div>
    </div>';
}

// Claim Description
$html .= '<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-light"><i class="bi bi-chat-left-text me-2"></i><strong>Claim Description</strong></div>
        <div class="card-body">
            <p class="mb-2"><strong>Claimant\'s Description:</strong></p>
            <p>' . nl2br(htmlspecialchars($claim['claim_description'] ?? 'No description provided')) . '</p>
        </div>
    </div>
</div>';

// Verification Status
$html .= '<div class="col-12">
    <div class="card">
        <div class="card-header bg-light"><i class="bi bi-shield-check me-2"></i><strong>Verification Status</strong></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="mb-2">' . ($claim['otp_verified'] ? '<i class="bi bi-check-circle-fill text-success fs-2"></i>' : '<i class="bi bi-x-circle-fill text-danger fs-2"></i>') . '</div>
                    <strong>OTP Verification</strong>
                    <div class="text-muted small">' . ($claim['otp_verified'] ? 'Verified' : 'Not Verified') . '</div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-2">' . ($claim['qr_verified'] ? '<i class="bi bi-check-circle-fill text-success fs-2"></i>' : '<i class="bi bi-x-circle-fill text-danger fs-2"></i>') . '</div>
                    <strong>QR Code Verification</strong>
                    <div class="text-muted small">' . ($claim['qr_verified'] ? 'Verified' : 'Not Verified') . '</div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-2">';
                    
$status_icon = 'bi-hourglass-split text-warning';
if ($claim['status'] === 'Approved') $status_icon = 'bi-check-circle-fill text-success';
elseif ($claim['status'] === 'Rejected') $status_icon = 'bi-x-circle-fill text-danger';

$html .= '<i class="bi ' . $status_icon . ' fs-2"></i></div>
                    <strong>Admin Review</strong>
                    <div class="text-muted small">' . htmlspecialchars($claim['status']) . '</div>
                </div>
            </div>
        </div>
    </div>
</div>';

// Admin Notes (if any)
if (!empty($claim['admin_notes'])) {
    $html .= '<div class="col-12">
        <div class="alert alert-info">
            <strong><i class="bi bi-info-circle me-2"></i>Admin Notes:</strong>
            <p class="mb-0">' . nl2br(htmlspecialchars($claim['admin_notes'])) . '</p>
        </div>
    </div>';
}

$html .= '</div>';

echo json_encode(['success' => true, 'html' => $html]);
?>
