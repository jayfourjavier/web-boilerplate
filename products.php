<?php
// Load products from JSON file
$productsJson = file_get_contents('assets/data/products.json');
$products = json_decode($productsJson, true);
?>

<div class="container py-5">
    <div class="text-center">
        <h2 class="fw-bold">Our Products & Services</h2>
        <hr class="w-25 mx-auto border-primary">
        <p class="text-muted">Explore our high-quality water solutions for your home and business.</p>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['title']) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($product['title']) ?></h5>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="card-text"><strong><?= $product['currency'] . number_format($product['price'], 2) . ' ' . $product['unit'] ?></strong></p>
                        <button class="btn btn-primary mt-auto" data-bs-toggle="modal" data-bs-target="#productModal<?= md5($product['title']) ?>">
                            Show More
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="productModal<?= md5($product['title']) ?>" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= htmlspecialchars($product['title']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded mb-3" alt="<?= htmlspecialchars($product['title']) ?>">
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <p><strong><?= $product['currency'] . number_format($product['price'], 2) . ' ' . $product['unit'] ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
