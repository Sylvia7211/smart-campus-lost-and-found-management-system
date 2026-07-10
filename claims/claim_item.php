<?php
require_once "../config/session.php";
requireLogin();
require_once "../config/database.php";

$user_id = $_SESSION['user_id'];
$item_id = $_GET['item_id'] ?? null;
$item_type = $_GET['type'] ?? null; // 'lost' or 'found'

if (!$item_id || !in_array($item_type, ['lost', 'found'])) {
    $_SESSION['error'] = "Invalid item selection.";
    header("Location: ../dashboard/dashboard.php?page=search");
    exit();
}

// Fetch item details
if ($item_type === 'lost') {
    $stmt = $conn->prepare("SELECT * FROM Lost_Items WHERE id = ?");
} else {
    $stmt = $conn->prepare("SELECT * FROM Found_Items WHERE id = ?");
}
$stmt->bind_param("i", $item_id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$item) {
    $_SESSION['error'] = "Item not found.";
    header("Location: ../dashboard/dashboard.php?page=search");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $claim_description = trim($_POST['claim_description']);
    $contact_phone = trim($_POST['contact_phone']);
    $contact_email = trim($_POST['contact_email']);
    
    if (empty($claim_description)) {
        $_SESSION['error'] = "Please provide a detailed description.";
    } else {
        // Insert claim
        $lost_item_id = $item_type === 'lost' ? $item_id : null;
        $found_item_id = $item_type === 'found' ? $item_id : null;
        
        $claim_message = "Claim for: " . $item['item_name'];
        
        $stmt = $conn->prepare("INSERT INTO Claims 
                               (lost_item_id, found_item_id, claimant_id, claim_message, claim_description, status) 
                               VALUES (?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("iiiss", $lost_item_id, $found_item_id, $user_id, $claim_message, $claim_description);
        
        if ($stmt->execute()) {
            $claim_id = $conn->insert_id;
            $_SESSION['success'] = "Claim submitted successfully! You will receive a verification email shortly.";
            
            // TODO: Generate OTP and send email
            // For now, redirect to verification page
            header("Location: verify_claim.php?claim_id=$claim_id");
            exit();
        } else {
            $_SESSION['error'] = "Failed to submit claim. Please try again.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Claim Item | Smart Campus</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body { background: #f4f6fc; font-family: 'Segoe UI', sans-serif; }
        .claim-container { max-width: 900px; margin: 2rem auto; }
        .claim-card { background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .item-preview { background: #f8f9fa; padding: 1.5rem; border-radius: 10px; }
        .item-preview img { max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="claim-container">
        <div class="mb-3">
            <a href="../dashboard/dashboard.php?page=search" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Search
            </a>
        </div>

        <div class="claim-card p-4">
            <h3 class="mb-4">
                <i class="bi bi-clipboard-check-fill text-primary me-2"></i>
                Claim Item Ownership
            </h3>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Item Preview -->
            <div class="item-preview mb-4">
                <h5 class="mb-3">Item You're Claiming:</h5>
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <?php if (!empty($item['image'])): 
                            $img_path = $item_type === 'lost' ? 'lost' : 'found';
                        ?>
                        <img src="../assets/uploads/<?php echo $img_path; ?>/<?php echo htmlspecialchars($item['image']); ?>" 
                             alt="Item" class="mb-3">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <h5 class="fw-bold"><?php echo htmlspecialchars($item['item_name']); ?></h5>
                        <p class="mb-2">
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($item['category']); ?></span>
                            <span class="badge <?php echo $item_type === 'lost' ? 'bg-danger' : 'bg-success'; ?>">
                                <?php echo ucfirst($item_type); ?>
                            </span>
                        </p>
                        <p class="text-muted"><?php echo htmlspecialchars($item['description']); ?></p>
                        <p class="mb-0">
                            <strong>Location:</strong> 
                            <?php echo htmlspecialchars($item_type === 'lost' ? $item['location_lost'] : $item['location_found']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Claim Form -->
            <form method="POST" class="needs-validation" novalidate>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Important:</strong> To verify your ownership, please provide a detailed description of the item. 
                    This information will only be visible to administrators for verification purposes.
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-chat-left-text me-2"></i>Detailed Description of the Item *
                    </label>
                    <textarea name="claim_description" class="form-control" rows="6" required
                              placeholder="Provide specific details that prove your ownership:&#10;- Unique features or marks&#10;- Color, brand, model&#10;- Contents (for bags/wallets)&#10;- Any identifiable characteristics&#10;- Serial numbers or special features&#10;&#10;The more specific you are, the faster we can verify your claim."></textarea>
                    <div class="form-text">Be as specific as possible. Include unique identifiers, marks, or features.</div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-telephone me-2"></i>Contact Phone Number *
                        </label>
                        <input type="tel" name="contact_phone" class="form-control" 
                               value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>" required
                               placeholder="+254 700 000 000">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-envelope me-2"></i>Contact Email *
                        </label>
                        <input type="email" name="contact_email" class="form-control" 
                               value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                    </div>
                </div>

                <div class="alert alert-warning mt-4">
                    <h6 class="alert-heading">
                        <i class="bi bi-shield-check me-2"></i>Verification Process
                    </h6>
                    <ol class="mb-0">
                        <li>After submission, you'll receive an OTP (One-Time Password) via email</li>
                        <li>Enter the OTP to verify your email address</li>
                        <li>You'll receive a QR code to scan when collecting the item</li>
                        <li>Admin will review your description and approve/reject the claim</li>
                        <li>Once approved, you can collect your item by presenting the QR code</li>
                    </ol>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-send-fill me-2"></i>Submit Claim
                    </button>
                    <a href="../dashboard/dashboard.php?page=search" class="btn btn-outline-secondary btn-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
