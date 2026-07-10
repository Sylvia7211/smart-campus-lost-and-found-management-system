<?php
require_once "../config/session.php";
requireAdmin();
require_once "../config/database.php";

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$claim_id = $input['claim_id'] ?? null;
$action = $input['action'] ?? null;
$notes = $input['notes'] ?? '';

if (!$claim_id || !in_array($action, ['Approved', 'Rejected'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$admin_id = $_SESSION['user_id'];

// Start transaction
$conn->begin_transaction();

try {
    // Update claim status
    $stmt = $conn->prepare("UPDATE Claims SET status = ?, admin_notes = ?, verified_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssi", $action, $notes, $claim_id);
    $stmt->execute();
    $stmt->close();
    
    // Log the verification
    $stmt = $conn->prepare("INSERT INTO Claim_Verification_Logs (claim_id, verification_type, verified_by, status, notes) 
                           VALUES (?, 'Admin', ?, 'Success', ?)");
    $stmt->bind_param("iis", $claim_id, $admin_id, $notes);
    $stmt->execute();
    $stmt->close();
    
    // Get claim details for notification
    $stmt = $conn->prepare("SELECT c.*, u.email, u.full_name,
                           COALESCE(l.item_name, f.item_name) as item_name
                           FROM Claims c
                           JOIN Users u ON c.claimant_id = u.id
                           LEFT JOIN Lost_Items l ON c.lost_item_id = l.id
                           LEFT JOIN Found_Items f ON c.found_item_id = f.id
                           WHERE c.id = ?");
    $stmt->bind_param("i", $claim_id);
    $stmt->execute();
    $claim = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    // Send notification to user
    $message = $action === 'Approved' 
        ? "Your claim for '{$claim['item_name']}' has been approved. You can now proceed to collect your item."
        : "Your claim for '{$claim['item_name']}' has been rejected. " . ($notes ? "Reason: $notes" : "");
    
    $stmt = $conn->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $claim['claimant_id'], $message);
    $stmt->execute();
    $stmt->close();
    
    // TODO: Send email notification here
    // mail($claim['email'], "Claim Update", $message);
    
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => "Claim has been {$action}!"
    ]);
    
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
