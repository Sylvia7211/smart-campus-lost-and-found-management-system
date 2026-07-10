<?php
$query = $_GET['query'] ?? '';
$results_lost  = [];
$results_found = [];

if (!empty($query)) {
    $search_term = "%{$query}%";

    // Search lost items
    $stmt = $conn->prepare("SELECT * FROM Lost_Items
                            WHERE (item_name LIKE ? OR category LIKE ? OR description LIKE ?)
                            AND status = 'Searching'
                            ORDER BY created_at DESC");
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    $stmt->execute();
    $results_lost = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Search found items
    $stmt = $conn->prepare("SELECT * FROM Found_Items
                            WHERE (item_name LIKE ? OR category LIKE ? OR description LIKE ?)
                            AND status = 'Available'
                            ORDER BY created_at DESC");
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    $stmt->execute();
    $results_found = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

<div class="card section-card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-search me-2"></i>
        <span class="fw-semibold">Search Lost &amp; Found Items</span>
    </div>
    <div class="card-body">
        <form method="GET" action="dashboard.php" class="row g-3 align-items-end">
            <input type="hidden" name="page" value="search">
            <div class="col">
                <label class="form-label fw-semibold">Search by item name, category, or description</label>
                <input type="text" name="query" class="form-control form-control-lg"
                       placeholder="e.g. laptop, wallet, keys..."
                       value="<?php echo htmlspecialchars($query); ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-search me-1"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($query)): ?>

    <div class="mb-4">
        <h6 class="text-muted">
            Showing results for "<strong><?php echo htmlspecialchars($query); ?></strong>"
        </h6>
    </div>

    <!-- Lost items results -->
    <div class="card section-card mb-4">
        <div class="card-header bg-danger text-white">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            Lost Items (<?php echo count($results_lost); ?>)
        </div>
        <div class="card-body p-0">
            <?php if (empty($results_lost)): ?>
            <p class="text-muted text-center py-4 mb-0">No lost items found.</p>
            <?php else: ?>
            <div class="row g-3 p-3">
                <?php foreach ($results_lost as $item): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border">
                        <?php if (!empty($item['image'])): ?>
                        <img src="../assets/uploads/lost/<?php echo htmlspecialchars($item['image']); ?>"
                             class="card-img-top" style="height:180px;object-fit:cover;" alt="Item">
                        <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                            <i class="bi bi-image text-muted" style="font-size:3rem;"></i>
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title fw-bold"><?php echo htmlspecialchars($item['item_name']); ?></h6>
                            <p class="card-text small text-muted mb-2"><?php echo htmlspecialchars($item['description']); ?></p>
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($item['category']); ?></span>
                                <span class="badge bg-warning text-dark"><?php echo htmlspecialchars($item['status']); ?></span>
                            </div>
                            <div class="small">
                                <div><strong>Location:</strong> <?php echo htmlspecialchars($item['location_lost']); ?></div>
                                <div><strong>Date:</strong> <?php echo htmlspecialchars($item['date_lost']); ?></div>
                                <?php if ($item['reward'] > 0): ?>
                                <div class="text-success"><strong>Reward:</strong> Ksh <?php echo number_format($item['reward'], 2); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="../claims/claim_item.php?item_id=<?php echo $item['id']; ?>&type=lost"
                               class="btn btn-sm btn-danger w-100">
                                <i class="bi bi-hand-thumbs-up me-1"></i> I Found This
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Found items results -->
    <div class="card section-card">
        <div class="card-header bg-success text-white">
            <i class="bi bi-hand-thumbs-up-fill me-2"></i>
            Found Items (<?php echo count($results_found); ?>)
        </div>
        <div class="card-body p-0">
            <?php if (empty($results_found)): ?>
            <p class="text-muted text-center py-4 mb-0">No found items found.</p>
            <?php else: ?>
            <div class="row g-3 p-3">
                <?php foreach ($results_found as $item): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border">
                        <?php if (!empty($item['image'])): ?>
                        <img src="../assets/uploads/found/<?php echo htmlspecialchars($item['image']); ?>"
                             class="card-img-top" style="height:180px;object-fit:cover;" alt="Item">
                        <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                            <i class="bi bi-image text-muted" style="font-size:3rem;"></i>
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title fw-bold"><?php echo htmlspecialchars($item['item_name']); ?></h6>
                            <p class="card-text small text-muted mb-2"><?php echo htmlspecialchars($item['description']); ?></p>
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($item['category']); ?></span>
                                <span class="badge bg-success"><?php echo htmlspecialchars($item['status']); ?></span>
                            </div>
                            <div class="small">
                                <div><strong>Location:</strong> <?php echo htmlspecialchars($item['location_found']); ?></div>
                                <div><strong>Date:</strong> <?php echo htmlspecialchars($item['date_found']); ?></div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="../claims/claim_item.php?item_id=<?php echo $item['id']; ?>&type=found"
                               class="btn btn-sm btn-success w-100">
                                <i class="bi bi-clipboard-check me-1"></i> Claim This Item
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>
