<?php
require_once "../config/session.php";
requireLogin();
require_once "../config/database.php";

$user_id = $_SESSION['user_id'];
$claim_id = $_GET['claim_id'] ?? null;

if (!$claim_id) {
    $_SESSION['error'] = "Invalid claim.";
    header("Location: ../dashboard/dashboard.php?page=claims");
    exit();
}

// Fetch claim details
$stmt = $conn->prepare("SELECT c.*, 
                       COALESCE(l.item_name, f.item_name) as item_name
                       FROM Claims c
                       LEFT JOIN Lost_Items l ON c.lost_item_id = l.id
                       LEFT JOIN Found_Items f ON c.found_item_id = f.id
                       WHERE c.id = ? AND c.claimant_id = ?");
$stmt->bind_param("ii", $claim_id, $user_id);
$stmt->execute();
$claim = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$claim) {
    $_SESSION['error'] = "Claim not found.";
    header("Location: ../dashboard/dashboard.php?page=claims");
    exit();
}

// Generate OTP if not exists or expired
if (empty($claim['otp_code']) || strtotime($claim['otp_expires_at']) < time()) {
    $otp = sprintf("%06d", mt_rand(0, 999999));
    $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    
    $stmt = $conn->prepare("UPDATE Claims SET otp_code = ?, otp_expires_at = ? WHERE id = ?");
    $stmt->bind_param("ssi", $otp, $expires, $claim_id);
    $stmt->execute();
    $stmt->close();
    
    // TODO: Send OTP email
    // For now, display it (in production, only send via email)
    $otp_generated = $otp;
    
    // Send notification
    $message = "Your OTP for item claim verification is: $otp. It expires in 15 minutes.";
    $stmt = $conn->prepare("INSERT INTO Notifications (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();
    $stmt->close();
}

// Handle OTP verification
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['verify_otp'])) {
    $entered_otp = trim($_POST['otp_code']);
    
    // Fetch current OTP
    $stmt = $conn->prepare("SELECT otp_code, otp_expires_at FROM Claims WHERE id = ?");
    $stmt->bind_param("i", $claim_id);
    $stmt->execute();
    $otp_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    if (strtotime($otp_data['otp_expires_at']) < time()) {
        $_SESSION['error'] = "OTP has expired. Please request a new one.";
    } elseif ($entered_otp === $otp_data['otp_code']) {
        // OTP verified - generate QR code
        require_once '../vendor/phpqrcode/phpqrcode-master/qrlib.php';
        
        $qr_data = "CLAIM:" . $claim_id . ":USER:" . $user_id . ":TIME:" . time();
        $qr_filename = "claim_" . $claim_id . "_" . time() . ".png";
        $qr_path = "../assets/qrcodes/";
        
        if (!is_dir($qr_path)) {
            mkdir($qr_path, 0777, true);
        }
        
        QRcode::png($qr_data, $qr_path . $qr_filename, QR_ECLEVEL_L, 10);
        
        // Update claim
        $stmt = $conn->prepare("UPDATE Claims SET otp_verified = 1, qr_code = ? WHERE id = ?");
        $stmt->bind_param("si", $qr_filename, $claim_id);
        $stmt->execute();
        $stmt->close();
        
        // Log verification
        $stmt = $conn->prepare("INSERT INTO Claim_Verification_Logs (claim_id, verification_type, status) 
                               VALUES (?, 'OTP', 'Success')");
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['success'] = "OTP verified successfully! Your QR code has been generated.";
        header("Location: verify_claim.php?claim_id=$claim_id");
        exit();
    } else {
        $_SESSION['error'] = "Invalid OTP. Please try again.";
    }
}

// Refresh claim data
$stmt = $conn->prepare("SELECT * FROM Claims WHERE id = ?");
$stmt->bind_param("i", $claim_id);
$stmt->execute();
$claim = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Claim | Smart Campus</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .verify-container { max-width: 600px; margin: 3rem auto; }
        .verify-card { background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .verify-header { background: linear-gradient(135deg, #4361ee, #3f37c9); color: white; padding: 2rem; border-radius: 20px 20px 0 0; text-align: center; }
        .otp-input { font-size: 2rem; text-align: center; letter-spacing: 1rem; font-weight: bold; }
        .qr-code-display { text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="verify-card">
            <div class="verify-header">
                <i class="bi bi-shield-check fs-1 mb-3 d-block"></i>
                <h3 class="mb-0">Claim Verification</h3>
                <p class="mb-0 small">Item: <?php echo htmlspecialchars($claim['item_name']); ?></p>
            </div>

            <div class="p-4">
                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (!$claim['otp_verified']): ?>
                <!-- OTP Verification Step -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-envelope-fill text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5>Step 1: Email Verification</h5>
                    <p class="text-muted">We've sent a 6-digit OTP to your email address.</p>
                    
                    <?php if (isset($otp_generated)): ?>
                    <div class="alert alert-info">
                        <strong>Development Mode:</strong> Your OTP is <strong><?php echo $otp_generated; ?></strong>
                    </div>
                    <?php endif; ?>
                </div>

                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-center d-block">Enter OTP</label>
                        <input type="text" name="otp_code" class="form-control otp-input" 
                               maxlength="6" pattern="\d{6}" required 
                               placeholder="000000" autocomplete="off">
                        <div class="form-text text-center">OTP expires in 15 minutes</div>
                    </div>

                    <button type="submit" name="verify_otp" class="btn btn-primary w-100 btn-lg">
                        <i class="bi bi-check-circle me-2"></i>Verify OTP
                    </button>
                </form>

                <?php else: ?>
                <!-- QR Code Display -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-success">Email Verified!</h5>
                </div>

                <div class="qr-code-display mb-4">
                    <h6 class="mb-3">Step 2: Your Collection QR Code</h6>
                    <img src="../assets/qrcodes/<?php echo htmlspecialchars($claim['qr_code']); ?>" 
                         alt="QR Code" class="img-fluid mb-3" style="max-width: 300px;">
                    <p class="text-muted small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Present this QR code when collecting your item
                    </p>
                </div>

                <div class="alert alert-warning">
                    <strong><i class="bi bi-exclamation-triangle me-2"></i>Next Steps:</strong>
                    <ol class="mb-0 mt-2">
                        <li>Admin will review your claim description</li>
                        <li>You'll be notified once approved</li>
                        <li>Bring this QR code to collect your item</li>
                        <li>The QR code will be scanned for verification</li>
                    </ol>
                </div>

                <div class="d-flex gap-2">
                    <button onclick="window.print()" class="btn btn-outline-primary flex-fill">
                        <i class="bi bi-printer me-2"></i>Print QR Code
                    </button>
                    <button onclick="downloadQR()" class="btn btn-outline-success flex-fill">
                        <i class="bi bi-download me-2"></i>Download
                    </button>
                </div>
                <?php endif; ?>

                <hr class="my-4">

                <div class="text-center">
                    <a href="../dashboard/dashboard.php?page=claims" class="btn btn-link">
                        <i class="bi bi-arrow-left me-2"></i>Back to My Claims
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function downloadQR() {
            const qrImage = document.querySelector('.qr-code-display img');
            const link = document.createElement('a');
            link.href = qrImage.src;
            link.download = 'claim_qr_code.png';
            link.click();
        }

        // Auto-focus OTP input
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.querySelector('.otp-input');
            if (otpInput) {
                otpInput.focus();
            }
        });
    </script>
</body>
</html>
