<?php
$basePath = '/boilerplate/';
$productsFile = '../assets/data/products.json';
$imageDir = '../assets/images/products/';

// Ensure the image directory exists
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0777, true);
}

// Load products
$productsJson = file_get_contents($productsFile);
$products = json_decode($productsJson, true) ?? [];

// Handle CRUD actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add' || $action === 'edit') {
        $index = $_POST['index'] ?? null;
        $title = trim($_POST['title']);
        $filename = strtolower(str_replace(' ', '-', $title));
        $filename = preg_replace('/[^a-z0-9\-]/', '', $filename); // Remove invalid characters

        // Set default image path
        $imagePath = $products[$index]['image'] ?? $basePath . 'assets/images/products/default.png';
        $savedFilename = $products[$index]['filename'] ?? '';

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (in_array($fileExt, $allowedExtensions)) {
                // Generate a unique filename
                $newFilename = $filename . '-' . uniqid() . '.' . $fileExt;
                $uploadPath = "$imageDir/$newFilename";

                move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);

                // Delete old image if not default
                if ($action === 'edit' && !empty($savedFilename)) {
                    $oldImagePath = "$imageDir/$savedFilename";
                    if (file_exists($oldImagePath)) unlink($oldImagePath);
                }

                // Update the image path & filename
                $imagePath = $basePath . "assets/images/products/$newFilename";
                $savedFilename = $newFilename;
            }
        }

        // Add or Edit Product
        $productData = [
            'title' => $title,
            'description' => $_POST['description'],
            'price' => (float)$_POST['price'],
            'currency' => '₱',
            'unit' => $_POST['unit'],
            'image' => $imagePath,
            'filename' => $savedFilename // Store the actual filename
        ];

        if ($action === 'add') {
            $products[] = $productData;
        } elseif ($action === 'edit' && isset($products[$index])) {
            $products[$index] = $productData;
        }

        // Save to JSON
        file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    } elseif ($action === 'delete') {
        $index = $_POST['index'];
        if (isset($products[$index])) {
            // Delete image file if not default
            $imageFile = "$imageDir/" . $products[$index]['filename'];
            if (file_exists($imageFile) && !empty($products[$index]['filename'])) {
                unlink($imageFile);
            }

            unset($products[$index]);
            $products = array_values($products);

            // Save updated JSON
            file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }

    header("Location: products.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Products</h2>

    <!-- Add/Edit Product Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Add / Edit Product</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" id="productForm">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="index" id="productIndex">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="productTitle" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" id="productPrice" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="productDescription" class="form-control" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" id="productUnit" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <img id="imagePreview" class="img-fluid mt-2 rounded" style="max-width: 100px; display: none;">
                    </div>
                </div>

                <button type="button" class="btn btn-success w-100" onclick="confirmSave()">
                    <i class="bi bi-save"></i> Save Product
                </button>
            </form>
        </div>
    </div>

    <!-- Product List -->
    <div class="card">
        <div class="card-header bg-secondary text-white">Products List</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $product): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded" style="max-width: 50px;"></td>
                            <td><?= htmlspecialchars($product['title']) ?></td>
                            <td><?= htmlspecialchars($product['description']) ?></td>
                            <td><?= $product['currency'] . number_format($product['price'], 2) ?></td>
                            <td><?= htmlspecialchars($product['unit']) ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editProduct(<?= $index ?>)">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($products)): ?>
                        <tr><td colspan="6" class="text-center text-muted">No products available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-labelledby="confirmSaveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmSaveLabel">Confirm Changes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to save the changes to this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSaveBtn">Yes, Save</button>
            </div>
        </div>
    </div>
</div>


<script>
function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function() {
        let preview = document.getElementById('imagePreview');
        preview.src = reader.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}

function editProduct(index) {
    let products = <?= json_encode($products) ?>;
    let product = products[index];

    document.getElementById('formAction').value = 'edit';
    document.getElementById('productIndex').value = index;
    document.getElementById('productTitle').value = product.title;
    document.getElementById('productPrice').value = product.price;
    document.getElementById('productDescription').value = product.description;
    document.getElementById('productUnit').value = product.unit;

    // Show the existing image in the preview
    let preview = document.getElementById('imagePreview');
    preview.src = product.image;
    preview.style.display = 'block';
}
</script>

<script>
function confirmSave() {
    // Show the confirmation modal
    let confirmModal = new bootstrap.Modal(document.getElementById('confirmSaveModal'));
    confirmModal.show();

    // On confirmation, submit the form
    document.getElementById('confirmSaveBtn').onclick = function () {
        document.getElementById('productForm').submit();
    };
}
</script>


</body>
</html>
