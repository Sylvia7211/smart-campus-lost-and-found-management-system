<div class="card section-card">
    <div class="card-header bg-success text-white">
        <i class="bi bi-plus-circle-fill me-2"></i>
        <span class="fw-semibold">Report Found Item</span>
    </div>
    <div class="card-body">
        <form action="../api/found_api.php" method="POST" enctype="multipart/form-data" class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Item Name <span class="text-danger">*</span></label>
                <input type="text" name="item_name" class="form-control" placeholder="e.g. Blue Wallet" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="">Select Category</option>
                    <option>Electronics</option>
                    <option>Books</option>
                    <option>Clothes</option>
                    <option>ID Card</option>
                    <option>Wallet</option>
                    <option>Keys</option>
                    <option>Phone</option>
                    <option>Laptop</option>
                    <option>Bag</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="3"
                    placeholder="Describe the item in detail (colour, brand, size, etc.)" required></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Location Found <span class="text-danger">*</span></label>
                <input type="text" name="location_found" class="form-control" placeholder="e.g. Cafeteria, Ground Floor" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Date Found <span class="text-danger">*</span></label>
                <input type="date" name="date_found" class="form-control" max="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Upload Image (Optional)</label>
                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-send-fill me-1"></i> Report Found Item
                </button>
            </div>

        </form>
    </div>
</div>
