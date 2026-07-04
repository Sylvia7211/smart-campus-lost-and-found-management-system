<?php
require_once "../config/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Found Item</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h3>Report Found Item</h3>
        </div>

        <div class="card-body">

            <form action="../api/found_api.php" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Item Name</label>
                    <input type="text" name="item_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
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

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location Found</label>
                    <input type="text" name="location_found" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date Found</label>
                    <input type="date" name="date_found" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
                </div>

                <button type="submit" class="btn btn-success">
                    Report Found Item
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>