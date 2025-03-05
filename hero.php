<?php
$jsonFile = $baseFilePath . "assets/data/heroConfig.json"; // Use baseFilePath
$heroItems = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

if (!is_array($heroItems)) {
    $heroItems = [];
}
?>

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">
        <?php foreach ($heroItems as $index => $item) : ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" 
                class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>

    <!-- Carousel Inner -->
    <div class="carousel-inner">
        <?php foreach ($heroItems as $index => $item) : ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <?php 
                    // Ensure absolute URL for images
                    $imagePath = $baseUrl . ltrim($item['image'], '/');
                    $link = !empty($item['link']) && $item['link'] !== "#" ? htmlspecialchars($item['link']) : "#";
                ?>
                <?php if ($link !== "#") : ?>
                    <a href="<?= $link ?>">
                        <img src="<?= htmlspecialchars($imagePath) ?>" class="d-block w-100" alt="Hero Image <?= $index + 1 ?>">
                    </a>
                <?php else : ?>
                    <img src="<?= htmlspecialchars($imagePath) ?>" class="d-block w-100" alt="Hero Image <?= $index + 1 ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
