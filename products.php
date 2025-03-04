<?php
// Load products from JSON file
$productsJson = file_get_contents('assets/data/products.json');
$products = json_decode($productsJson, true);
?>

<div class="container py-5">
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['title']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="card-text"><strong><?= $product['currency'] . number_format($product['price'], 2) . ' ' . $product['unit'] ?></strong></p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal<?= md5($product['title']) ?>">
                            Show More
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="productModal<?= md5($product['title']) ?>" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= htmlspecialchars($product['title']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($product['title']) ?>">
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <p><strong><?= $product['currency'] . number_format($product['price'], 2) . ' ' . $product['unit'] ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
